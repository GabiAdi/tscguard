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

//echo json_encode($_POST);
//die();

$test_name = $_POST["test"]["name"];
$test_category = $_POST["test"]["category"];
$user_id = $_SESSION["user_id"];

$query = "INSERT INTO tg_testovi(testIme, korisnikID) VALUES (?,?)";
$params = array($test_name, $user_id);

$test_id = $db->id_insert($query, $params);

$query = "INSERT INTO tg_testkategorija(testID, kategorijaID) VALUES (?,?)";
$params = array($test_id, $test_category);

$db->query($query, $params);

if(!isset($_POST["questions"])) {
	header("Location: /author_dashboard.php");
	die("No questions!");
}

$questions = $_POST["questions"];
foreach ($questions as $question) {
	$question_text = $question["question"];
	$question_hint = $question["hint"];
	$question_points = $question["points"];
	$question_category = $question["category"];

	$query = "INSERT INTO tg_pitanje(tekstPitanje, korisnikID, brojBodova, hint) VALUES (?,?,?,?)";
	$params = array($question_text, $user_id, $question_points, $question_hint);
	
	$question_id = $db->id_insert($query, $params);
	
	$query = "INSERT INTO tg_pitanjenatestu(testID, pitanjeID) VALUES (?,?)";
	$params = array($test_id, $question_id);

	$db->query($query, $params);

	foreach($question["answers"] as $answer) {
		$answer_text = $answer["text"];
		$answer_correct = $answer["correct"] == "on" ? 1 : 0;
		
		$query = "INSERT INTO tg_odgovori(tekst, pitanjeID, tocno, opisNetocnog, autorID) VALUES (?,?,?,?,?)";
		$params = array($answer_text, $question_id, $answer_correct, "PROMENITI!!!", $user_id);	
		
		$db->query($query, $params);
	}
}

header("Location: /index.php");

?>
