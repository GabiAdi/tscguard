<?php
session_start();
include_once "includes/connection.php";

if(!isset($_SESSION["answers"]) || !isset($_SESSION["user_id"])) {
	header("Location: /index.php");
	die();
}


$db = new MySQLDB();


$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

$points = 0;
$full = 0;

foreach ($_SESSION["answers"] as $answer) {
	$query = "SELECT tg_pitanje.tekstPitanje,tg_odgovori.tekst,tg_odgovori.opisNetocnog FROM tg_odgovori JOIN tg_pitanje ON tg_pitanje.ID = tg_odgovori.pitanjeID WHERE tg_odgovori.ID = ? AND tg_odgovori.pitanjeID = ?;";
	$params = array($answer["answerID"], $answer["questionID"]);
	$results = $db->query($query, $params);

	$appended = $doc->createElement("h2", $results[0]["tekstPitanje"] . " " . ($answer["correct"] == 1 ? $answer["points"] : 0) . "/". $answer["points"] . " " . ($answer["correct"] == 1 ? "✔" : "❌"));
	$body->appendChild($appended);
	
	$appended = $doc->createElement("p", "Odgovor: " . $results[0]["tekst"]);
	$body->appendChild($appended);
	
	$appended = $doc->createElement("p", "Opis: " . $results[0]["opisNetocnog"]);
	$body->appendChild($appended);

	$points += $answer["correct"] == 1 ? $answer["points"] : 0;
	$full += $answer["points"];
}

//$appended = $doc->createElement("p", $points . "/" . $full);
//$body->appendChild($appended);

$appended = $doc->createElement("br");
$body->appendChild($appended);

echo "<a href=\"/test.php\">Nazad</a><br><br>";
echo "<h1>". $points . "/" . $full ."</h1>";
echo $doc->saveHTML();

unset($_SESSION["answers"]);

?>
