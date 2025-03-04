<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);

	if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }
	
	$hash = password_hash($password, PASSWORD_BCRYPT);	

	if($db->create_user($username, $hash)) {
		header("Location: /index.php");	
	} else {
		header("Location: /register.php?failed=true");
	}
} else {
	die("Invalid request");
}

?>
