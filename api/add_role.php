<?php
session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] != "admin") { // Ako korisnik nije admin redirektamo ga na dashboard
	header("Location: /dashboard.php");
	die();
}
$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	$role = trim($_POST["role"]);
	if($db->add_role($username, $role)) { // Poziva funkciju iz klase MySQLDB
		echo "Success";
	} else {
		echo "Failed to add admin to " . $username;
	}
} else {
	die("Invalid request");
}
?>
