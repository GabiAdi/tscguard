<?php

class MySQLDB 
{
	var $host = "localhost";
	var $username = "root";
	var $password = "";
	var $database = "tscguard";

	protected $db;

	function __construct()
	{
		$this->connect();
	}

	function get_db() 
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

	function query($query, $params = array()) 
	{
		$db = $this->get_db();	
		
		try {
			$stmt = $db->prepare($query);
			if ($stmt === false) {
                throw new Exception("Prepare failed: " . $db->error);
			}

			if (!empty($params)) {
                $types = str_repeat('s', count($params)); 
                $stmt->bind_param($types, ...$params);
			}

			$stmt->execute($params);
			$result = $stmt->get_result();
			
			if($result) {
				return $result->fetch_assoc();
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

		if($this->query($query, $params)) {
			error_log("User already exists");
			return false;
		}
		
		$query = "INSERT INTO tg_korisnik (email, kime, lozinka) VALUES (?,?,?)";	
		$params = array($email, $username, $hash); 		

		if(!$this->query($query, $params)) {
			error_log("Failed to create user");
			return false;
		}
		$query = "INSERT INTO tg_prava (korisnikID, pravoID) SELECT tg_korisnik.ID, tg_pravo.ID FROM tg_korisnik JOIN tg_pravo ON tg_pravo.opis = ? WHERE tg_korisnik.kime = ?;"; 
		$params = array("user", $username);	
		$this->query($query, $params);
		return true;
	}

	function validate_user($email, $password): bool 
	{
		$query = "SELECT * FROM tg_korisnik WHERE email = ? OR kime = ?";
		$params = array($email, $email);

		$result = $this->query($query, $params);

		if(!($result && count($result) > 0)) {
			return false;
		}
		$user = $result;
		error_log("User" . $user);
		if(password_verify($password, $user["lozinka"])) {
			$_SESSION["user_id"] = $user["ID"];
			$_SESSION["username"] = $user["kime"];
			$query = "SELECT tg_pravo.opis FROM tg_prava JOIN tg_korisnik ON tg_prava.korisnikID = tg_korisnik.ID JOIN tg_pravo ON tg_prava.pravoID = tg_pravo.ID WHERE kime = ?";
			$params = array($user["kime"]);
			$_SESSION["role"] = $this->query($query, $params)["opis"];
			return true;
		}
		return false;
	}

	function add_admin($username) {	
	$query = "UPDATE tg_prava JOIN tg_korisnik ON tg_prava.korisnikID = tg_korisnik.ID JOIN tg_pravo ON tg_prava.pravoID = tg_pravo.ID SET tg_prava.pravoID = (SELECT ID FROM tg_pravo WHERE opis=?) WHERE tg_korisnik.kime = ?;"; 
	$params = array("admin", $username);
	
		if($this->query($query, $params) == 1) {
		return true;
	}
	return false;	
	}
}

?>
