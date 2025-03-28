<?php
session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] != "admin" && $_SESSION["role"] != "author") { 
	header("Location: /dashboard.php");
}
$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$answer = trim($_POST["answer"]);
	$id = trim($_POST["id"]);
	$user_id = $_SESSION["user_id"];
	$correct = trim($_POST["correct"]) == "on";
	$explanation = trim($_POST["explanation"]);
	if($db->add_answer($id, $user_id, $answer, $correct, $explanation)) { 
		echo "Success";
	} else {
		echo "Failed to add question";
	}
	header("Location: /dashboard.php");
} else {
	die("Invalid request");
}
?>
