<?php
session_start();
if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();	
}

include_once "includes/connection.php";

$db = new MySQLDB();

$questions = $db->query("SELECT ID,tekstPitanje FROM tg_pitanje", array());

$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

foreach ($questions as $question) {
	$appended = $doc->createElement("a", $question["tekstPitanje"]);
	$appended->setAttribute("href", "question.php?id=".$question["ID"]);	
	$body->appendChild($appended);
	$appended = $doc->createElement("br");
	$body->appendChild($appended);
}


echo "<a href=\"/dashboard.php\">Nazad</a><br><br>";
echo $doc->saveHTML();

?>
