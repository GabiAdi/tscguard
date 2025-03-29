<?php
session_start();
include_once "../includes/connection.php";

$db = new MySQLDB();

if(isset($_SESSION["user_id"])) {
	header("Location: /dashboard.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);

	if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }
	
	if($db->validate_user($email, $password)) {
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
