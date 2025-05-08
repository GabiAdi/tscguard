<?php
session_start();
include_once "../includes/connection.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") { // Request mora biti POST
	die("Invalid request");
}

$email = trim($_POST["email"]);
$username = trim($_POST["username"]);
$password = trim($_POST["password"]);

if (empty($email) || empty($username) || empty($password)) {
    die("Email, username and password are required.");
}

$db = new MySQLDB();

$hash = password_hash($password, PASSWORD_BCRYPT);	

if($db->create_user($email, $username, $hash)) { // Stavljamo hashani password u bazu
	header("Location: /index.php");	
} else {
	header("Location: /login.php");
}

?>
