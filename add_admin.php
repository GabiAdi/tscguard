<?php
session_start();
include_once "includes/connection.php";

if($_SESSION["admin"] != "1") {
	header("Location: /dashboard.php");
}
$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	if($db->add_admin($username)) {
		echo "Success";
	} else {
		echo "Failed to add admin to " . $username;
	}
} else {
	die("Invalid request");
}
?>
