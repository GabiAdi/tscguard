<?php
class MySQLDB // Klasa za spajanje na MySQL bazu 
{
	var $host = "localhost"; // Ip adresa servera s bazom
	var $username = "root";
	var $password = "";
	var $database = "tscguard";

	protected $db;

	function __construct()
	{
		$this->connect();
	}

	function get_db()  // Ako postoji konekcija s bazom vraca konekcuju ako ne onda se spaja s bazom
	{
		if(!isset($this->db)) {
			$this->connect();
		}
		return $this->db;
	}

	function connect(): void
   	{
		try {
			$this->db = new mysqli($this->host, $this->username, $this->password, $this->database);
			if($this->db->connect_error) {
				throw new Exception("Connection failed: " . $this->db->connect_error);
			}
		} catch (Exception $e) {
			die("Database connection error: " . $e->getMessage());
		}
	}

	function query($query, $params = array()) // query funkcija koristena samo u klasi 
	{
		$db = $this->get_db();	
		
		try {
			$stmt = $db->prepare($query); // Priprema upit 
			if ($stmt === false) {
                throw new Exception("Prepare failed: " . $db->error);
			}

			if (!empty($params)) {
                $types = str_repeat('s', count($params)); 
                $stmt->bind_param($types, ...$params);
			}

			$stmt->execute(); // Izvrsava upit s parametrima (Mijenja ? s parametrom)
			$result = $stmt->get_result();
			
			if($result) { // Ako postoji rezultat vraca ga
				return $result->fetch_all(MYSQLI_ASSOC);
			}
			
			return true;
		} catch (Exception $e) {	
			error_log($e->getMessage());
			echo "Something went wrong, please try again later.";
			return false;
		}
		return false;
	}

	function create_user($email, $username, $hash): bool {
		$query = "SELECT ID FROM tg_korisnik WHERE email = ? OR kime = ?";
		$params = array($email, $username);

		if($this->query($query, $params)) { // Zovemo funkciju query koja salje upit bazi, ako korisnik postoji onda vracamo false za neuspjesno kreiranje
			error_log("User already exists");
			return false;
		}
		// Ako ne postoji nastavlja se
		
		$query = "INSERT INTO tg_korisnik (email, kime, lozinka) VALUES (?,?,?)";
		$params = array($email, $username, $hash); 		

		if(!$this->query($query, $params)) { // Dodaje korisnika u bazu
			error_log("Failed to create user");
			return false;
		}
		$query = "INSERT INTO tg_prava (korisnikID, pravoID) SELECT tg_korisnik.ID, tg_pravo.ID FROM tg_korisnik JOIN tg_pravo ON tg_pravo.opis = ? WHERE tg_korisnik.kime = ?;"; 
		$params = array("user", $username);	
		$this->query($query, $params); // Dodaje korisniku pravo USER
		return true;
	}

	function validate_user($email, $password): bool 
	{
		$query = "SELECT * FROM tg_korisnik WHERE email = ? OR kime = ?";
		$params = array($email, $email);

		$result = $this->query($query, $params);

		if(!($result && count($result) > 0)) { // Trazimo korisnika
			return false;
		}
		$user = $result[0];
		if(password_verify($password, $user["lozinka"])) { // Provjerava ako je hash u bazi isti kao hash upisanog passworda 
			$_SESSION["user_id"] = $user["ID"]; // Postavlja varijable sesije kako bi znali je li korisnik admin, je li ulogiran ...
			$_SESSION["username"] = $user["kime"];
			$query = "SELECT tg_pravo.opis FROM tg_prava JOIN tg_korisnik ON tg_prava.korisnikID = tg_korisnik.ID JOIN tg_pravo ON tg_prava.pravoID = tg_pravo.ID WHERE kime = ?";
			$params = array($user["kime"]);
			$_SESSION["role"] = $this->query($query, $params)[0]["opis"];
			return true;
		}
		return false;
	}

	function add_role($username, $role) {	
		$query = "UPDATE tg_prava JOIN tg_korisnik ON tg_prava.korisnikID = tg_korisnik.ID JOIN tg_pravo ON tg_prava.pravoID = tg_pravo.ID SET tg_prava.pravoID = (SELECT ID FROM tg_pravo WHERE opis=?) WHERE tg_korisnik.kime = ?;"; 
		$params = array($role, $username); // Postavlja prava korisnika na admin
	
		if($this->query($query, $params) == 1) {
			return true;
		}
		return false;	
	}

	function add_question($username, $text, $points, $hint, $category) {
		$query = "SELECT * FROM tg_pitanje WHERE tekstPitanje = ?";
		$params = array($text);

		if($this->query($query, $params)) {
			return false;
		}

		$query = "INSERT INTO tg_pitanje (korisnikID, tekstPitanje, brojBodova, hint, brojPonudenih) SELECT tg_korisnik.ID, ?, ?, ?, ? FROM tg_korisnik WHERE tg_korisnik.kime = ?;"; 	
		$paramas = array($text, $points, $hint, "0", $username);

		if($this->query($query, $paramas) != 1) {
			return false;
		}

		$query = "INSERT INTO tg_kategorija (kategorijaID, pitanjeID) SELECT ?, tg_pitanje.ID FROM tg_pitanje WHERE tg_pitanje.tekstPitanje = ?"; ;
		$params = array($category, $text);
		if($this->query($query, $params) != 1) {
			return false;
		}
		return true;
	}

	function add_answer($id, $user_id, $answer, $correct, $explanation) {
		$query = "SELECT * FROM tg_pitanje WHERE ID = ?";
		$params = array($id);

		$result = $this->query($query, $params);

		if(!$result) {
			return false;
		}
		
		$query = "INSERT INTO tg_odgovori(pitanjeID, tekst, tocno, opisNetocnog, autorID) VALUES (?, ?, ?, ?, ?);";
		$params = array($id, $answer, $correct, $explanation, $user_id);

		if($this->query($query, $params)) {
			return true;
		}
		return false;
	}
}

?>
