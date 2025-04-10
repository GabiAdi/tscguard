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

$query = "SELECT tg_pitanje.ID, tg_pitanje.tekstPitanje, tg_korisnik.kime, tg_pitanje.brojBodova, tg_pitanje.hint, tg_pitanje.brojPonudenih FROM tg_kategorija JOIN tg_pitanje ON tg_pitanje.ID = tg_kategorija.pitanjeID JOIN tg_kategorije ON tg_kategorije.ID = tg_kategorija.kategorijaID JOIN tg_korisnik ON tg_korisnik.ID = tg_pitanje.korisnikID WHERE tg_kategorije.ID = ? AND tg_pitanje.brojPonudenih > 3;";
$params = array($_SESSION["test"]["category"]);
//$query = "SELECT tg_pitanje.ID,tekstPitanje,tg_korisnik.kime,brojBodova,hint,brojPonudenih FROM tg_pitanje JOIN tg_korisnik ON tg_korisnik.ID = tg_pitanje.korisnikID WHERE brojPonudenih > 2;";
//$params = array();

$questions = $db->query($query, $params);

$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

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
