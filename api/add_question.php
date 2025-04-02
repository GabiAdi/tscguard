<?php
session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "author") { 
	header("Location: /index.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}

$db = new MySQLDB();

$username = $_SESSION["username"];
$text = trim($_POST["question"]);
$points = trim($_POST["points"]);
$hint = trim($_POST["hint"]);
$category = trim($_POST["category"]);
if($db->add_question($username, $text, $points, $hint, $category)) { 
	echo "Success";
} else {
	echo "Failed to add question";
}
header("Location: /index.php");
?>
