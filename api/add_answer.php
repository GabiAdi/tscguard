<?php
session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "author") { 
	header("Location: /index.php");
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}

$db = new MySQLDB();

$answer = trim($_POST["answer"]);
$id = trim($_POST["id"]);
$user_id = $_SESSION["user_id"];
$correct = trim($_POST["correct"]) === "on" ? 1 : 0;
$explanation = trim($_POST["explanation"]);
$location = trim($_POST["location"]);

if($db->add_answer($id, $user_id, $answer, $correct, $explanation)) { 
	echo "Success";
} else {
	echo "Failed to add question";
}
header("Location: ../" . $location);
?>
