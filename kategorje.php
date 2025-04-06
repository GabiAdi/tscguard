<?php
session_start();

if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();	
}

include_once "includes/connection.php";

$db = new MySQLDB();

$categories = $db->query("SELECT ID,naziv FROM tg_kategorije", array());

$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

foreach ($categories as $category) {
	$appended = $doc->createElement("a", $category["naziv"]);
	$appended->setAttribute("href", "question.php?id=".$question["ID"]);	
	$body->appendChild($appended);
	$appended = $doc->createElement("br");
	$body->appendChild($appended);
}


echo "<a href=\"/index.php\">Nazad</a><br><br>";
echo $doc->saveHTML();
?>
