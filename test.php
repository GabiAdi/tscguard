<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

if(!isset($_SESSION["user_id"])) {
	header("Location: /index.php");
	die();
}

if(!isset($_SESSION["test"])) {
	header("Location: /index.php");
	die();
}

$query = "SELECT tg_pitanje.ID, tg_pitanje.tekstPitanje, tg_korisnik.kime, tg_pitanje.brojBodova, tg_pitanje.hint, tg_testovi.testIme FROM tg_pitanjenatestu JOIN tg_pitanje ON tg_pitanje.ID = tg_pitanjenatestu.pitanjeID JOIN tg_korisnik ON tg_pitanje.korisnikID = tg_korisnik.ID JOIN tg_testovi ON tg_testovi.ID = tg_pitanjenatestu.testID WHERE tg_testovi.ID = ?; ";
$params = array($_SESSION["test"]["test_id"]);

$questions = $db->query($query, $params);

$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

$appended = $doc->createElement("h1", $questions[0]["testIme"]);
$body->appendChild($appended);

$form = $doc->createElement("form");
$form->id = "form";
$form->setAttribute("action", "/api/check_test.php");
$form->setAttribute("method", "post");
$body->appendChild($form);

foreach ($questions as $question) {	
	$appended = $doc->createElement("h2", $question["tekstPitanje"]);
	$form->appendChild($appended);
	
	$appended = $doc->createElement("p", "by " . $question["kime"]);
	$form->appendChild($appended);
	
	$appended = $doc->createElement("p", "bodovi: " . $question["brojBodova"]);
	$form->appendChild($appended);
	
	$appended = $doc->createElement("p", "hint: " . $question["hint"]);
	$form->appendChild($appended);

	$query = "SELECT ID,tekst FROM tg_odgovori WHERE pitanjeID = ?";
	$params = array($question["ID"]);

	$answers = $db->query($query, $params);	
	foreach ($answers as $answer) {
		$appended = $doc->createElement("input");
		$appended->setAttribute("name", "answers[" . $question["ID"] . "]");
		$appended->setAttribute("id", $question["ID"]);
		$appended->setAttribute("value", $answer["ID"]);
		$appended->setAttribute("type", "radio");
		$appended->id = $answer["ID"];
		$form->appendChild($appended);

		$appended = $doc->createElement("label", $answer["tekst"]);
		$appended->setAttribute("for", $answer["ID"]);
		$form->appendChild($appended);

		$appended = $doc->createElement("br");
		$form->appendChild($appended);
	}
}

$appended = $doc->createElement("input");
$appended->setAttribute("type", "submit");
$form->appendChild($appended);

$appended = $doc->createElement("br");
$body->appendChild($appended);

echo "<a href=\"/index.php\">Nazad</a><br><br>";
echo "<p>Start: " . $_SESSION["test"]["start_time"] . "</p>";
echo "<p>End: " . $_SESSION["test"]["end_time"] . "</p>";
echo $doc->saveHTML();
?>
