<?php
session_start();
if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();	
}

include_once "includes/connection.php";

$db = new MySQLDB();

$tests = $db->query("SELECT * FROM tg_testovi WHERE korisnikID = ?", array($_SESSION["user_id"]));

$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

$form = $doc->createElement("form");
$form->id = "form";
$form->setAttribute("action", "test_editor.php");
$form->setAttribute("method", "get");
$body->appendChild($form);

foreach ($tests as $test) {	
	$appended = $doc->createElement("button", $test["testIme"]);
	$appended->setAttribute("name", "test");
	$appended->setAttribute("type", "submit");
	$appended->setAttribute("value", $test["ID"]);
	$form->appendChild($appended);
	$appended = $doc->createElement("br");
	$form->appendChild($appended);
}

echo "<a href=\"/index.php\">Nazad</a><br><br>";
echo $doc->saveHTML();

?>
