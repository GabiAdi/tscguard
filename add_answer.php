<?php
session_start();
include_once "includes/connection.php";

if($_SESSION["role"] != "admin" && $_SESSION["role"] != "author") { 
	header("Location: /dashboard.php");
}
$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$text = trim($_POST["question"]);
	$answer = trim($_POST["answer"]);
	$id = $_SESSION["user_id"];
	$correct = trim($_POST["correct"]) == "on";
	$explanation = trim($_POST["explanation"]);
	if($db->add_answer($id, $text, $answer, $correct, $explanation)) { 
		echo "Success";
	} else {
		echo "Failed to add question";
	}
	header("Location: /dashboard.php");
} else {
	die("Invalid request");
}
?>
