<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

if(isset($_SESSION["user_id"])) {
	header("Location: /dashboard.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);

	if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }
	
	if($db->validate_user($username, $password)) {
		echo "Hello " . $_SESSION["username"] . " with id " . $_SESSION["user_id"];	
		header("Location: /index.php");
	} else {
		echo "Failed";
		header("Location: /login.php");
	}
} else {
	die("Invalid request");
}

?>
