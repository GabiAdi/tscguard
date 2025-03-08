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
		$query = "SELECT ID FROM tg_korisnik WHERE email = ?";
		$params = array($email);

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

		$query = "SELECT ID FROM tg_pravo WHERE opis = ?";
		$params = array("user");

		$pravoId = $this->query($query, $params);

		error_log($pravoId);
		

		return true;
	}

	function validate_user($email, $password): bool 
	{
		$query = "SELECT * FROM tg_korisnik WHERE email = ?";
		$params = array($email);

		$result = $this->query($query, $params);

		if(!($result && count($result) > 0)) {
			return false;
		}
		$user = $result;
		error_log("User" . $user);
		if(password_verify($password, $user["lozinka"])) {
			$_SESSION["user_id"] = $user["ID"];
			$_SESSION["username"] = $user["kime"];
			//$_SESSION["admin"] = $user["razinaID"];
			return true;
		}
		return false;
	}

	function add_admin($username) {
		$query = "SELECT ID FROM tg_korisnik WHERE kime = ?";
		$params = array($username);

		$result = $this->query($query, $params);

		return false; // Temporary

		if(!($result && count($result) > 0)) {
			return false;
		}

		$query = "UPDATE tg_prava SET pravoID=1 WHERE korisnikID = ?";
		$params = array($result["ID"]);

		if($this->query($query, $params) == 1) {
			return true;
		}
		return false;
		
	}
}

?>
