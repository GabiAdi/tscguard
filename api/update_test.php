<?php

use function pcov\waiting;

session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "author") { 
	header("Location: /index.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}

if(!isset($_SESSION["test_edit"])) {
	header("Location: /index.php");
	die();
}

//unset($_SESSION["test_edit"]);
//die("test_edit cleared");

$test_id = $_POST["test"]["id"];

$db = new MySQLDB();

$query = "SELECT korisnikID FROM tg_testovi WHERE ID = ?";
$params = array($test_id);

$result = $db->query($query, $params);

if($result[0]["korisnikID"] != $_SESSION["user_id"]) {
	header("Location: /index.php");
	die("You do not own this test");
}

$test_name = $_POST["test"]["name"];
$test_category = $_POST["test"]["category"];
$user_id = $_SESSION["user_id"];

$query = "UPDATE tg_testovi SET testIme = ? WHERE ID = ?";
$params = array($test_name, $test_id);

$db->query($query, $params);

$query = "UPDATE tg_testkategorija SET kategorijaID = ? WHERE testID = ?";
$params = array($test_category, $test_id);

$db->query($query, $params);

if(!isset($_POST["questions"])) {
	header("Location: /author_dashboard.php");
	die("No questions!");
}

$questions = $_POST["questions"];

foreach ($questions as $question) {
	$question_id = $question["question_id"];
	$question_text = $question["question"];
	$question_hint = $question["hint"];
	$question_points = $question["points"];
	$question_category = $question["category"];

	$query = "UPDATE tg_pitanje SET tekstPitanje = ?, brojBodova = ?, hint = ? WHERE ID = ?";
	$params = array($question_text, $question_points, $question_hint, $question_id);

	$db->query($query, $params);

	$query = "UPDATE tg_kategorija SET kategorijaID = ? WHERE pitanjeID = ?";
	$params = array($question_category, $question_id);

	$db->query($query, $params);

	foreach($question["answers"] as $answer) {
		$answer_id = $answer["answer_id"];
		$answer_text = $answer["text"];
		$answer_correct = $answer["correct"] == "on" ? 1 : 0;
		$answer_explanation = $answer["explanation"];

		$query = "UPDATE tg_odgovori SET tekst = ?, tocno = ?, opisNetocnog = ? WHERE ID = ?";
		$params = array($answer_text, $answer_correct, $answer_explanation, $answer_id);	
		
		$db->query($query, $params);
	}
}

unset($_SESSION["test_edit"]);
header("Location: /index.php");

?>
