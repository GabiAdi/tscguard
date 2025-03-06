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

	function create_user($username, $hash): bool {
		$query = "SELECT id FROM users WHERE username = ?";
		$params = array($username);

		if($this->query($query, $params)) {
			echo "User already exists";
			return false;
		}
		
		$query = "INSERT INTO users (username, password) VALUES (?,?)";	
		$params = array($username, $hash); 
		
		

		if(!$this->query($query, $params)) {
			echo "Failed to create user";
			return false;
		}
		return true;
	}

	function validate_user($username, $password): bool 
	{
		$query = "SELECT * FROM users WHERE username = ?";
		$params = array($username);

		$result = $this->query($query, $params);

		if(!($result && count($result) > 0)) {
			return false;
		}
		$user = $result;
		error_log("User" . $user);
		if(password_verify($password, $user["password"])) {
			$_SESSION["user_id"] = $user["id"];
			$_SESSION["username"] = $user["username"];
			$_SESSION["admin"] = $user["admin"];
			return true;
		}
		error_log("Hash" . $user["password"]);
		return false;
	}

	function add_admin($username) {
		$query = "SELECT id FROM users WHERE username = ?";
		$params = array($username);

		$result = $this->query($query, $params);

		if(!($result && count($result) > 0)) {
			return false;
		}
		return true;

		$id = $result["id"];
	}
}

?>
