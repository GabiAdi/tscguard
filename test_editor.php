<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

if(!isset($_SESSION["user_id"])) {
	header("Location: /index.php");
	die();
}

if($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "author") { 
	header("Location: /index.php");
	die();
}

if(!isset($_GET["test"])) {
    header('Location: /index.php');
    exit;
}

$test_id = $_GET["test"]; 

if(!isset($_SESSION["test_edit"])) {
	$_SESSION["test_edit"] = $test_id;
} else {
	$test_id = $_SESSION["test_edit"];
}

$query = "SELECT tg_pitanje.ID AS questionID, tg_pitanje.tekstPitanje, tg_korisnik.ID AS userID, tg_korisnik.kime, tg_pitanje.brojBodova, tg_pitanje.hint, tg_testovi.testIme, tg_kategorije.ID AS categoryID FROM tg_pitanjenatestu JOIN tg_pitanje ON tg_pitanje.ID = tg_pitanjenatestu.pitanjeID JOIN tg_testovi ON tg_testovi.ID = tg_pitanjenatestu.testID JOIN tg_korisnik ON tg_testovi.korisnikID = tg_korisnik.ID JOIN tg_testkategorija ON tg_testkategorija.testID = tg_testovi.ID JOIN tg_kategorije ON tg_kategorije.ID = tg_testkategorija.kategorijaID WHERE tg_testovi.ID = ?;";
$params = array($test_id);

$result = $db->query($query, $params);

$user_id = $result[0]["userID"];

if($_SESSION["user_id"] != $user_id) {
	unset($_SESSION["test_edit"]);
    header('Location: /index.php');
	die("You do not own this test");
}

$category_id = $result[0]["categoryID"];

$html = "<html><link rel=\"stylesheet\" href=\"/public/author_dasboard.css\"><body id=\"body\"></body></html>"; 

libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");

$form = $doc->createElement("form");
$form->setAttribute("id", "form");
$form->setAttribute("action", "/api/update_test.php");
$form->setAttribute("method", "post");
$body->appendChild($form);

$appended = $doc->createElement("input");
$appended->setAttribute("type", "text");
$appended->setAttribute("name", "test[name]");
$appended->setAttribute("value", $result[0]["testIme"]);
$form->appendChild($appended);

$hidden = $doc->createElement("input");
$hidden->setAttribute("type", "hidden");
$hidden->setAttribute("name", "test[id]");
$hidden->setAttribute("value", $test_id);
$form->appendChild($hidden);

$cat = $doc->createElement("select");
$cat->setAttribute("name", "test[category]");
$form->appendChild($cat);

$query = "SELECT ID,naziv FROM tg_kategorije";
$params = array();
$categories = $db->query($query, $params);

foreach ($categories as $category) {
	$option = $doc->createElement("option", $category["naziv"]);
	$option->setAttribute("value", $category["ID"]);
	
	if($category["ID"] == $category_id) {
		$option->setAttribute("selected", true);
	}

	$cat->appendChild($option);
}

$form->appendChild($doc->createElement("br"));	
$button = $doc->createElement("button", "Dodaj pitanje");
$button->setAttribute("onClick", "add_question()");
$button->setAttribute("type", "button");
$button->setAttribute("id", "add_question_button");
$form->appendChild($button);

$button = $doc->createElement("button", "Makni pitanje");
$button->setAttribute("onClick", "remove_question()");
$button->setAttribute("type", "button");
$button->setAttribute("id", "remove_question_button");
$form->appendChild($button);

$form->appendChild($doc->createElement("br"));	

$questionCounter = 0;

foreach ($result as $question) {
	$question_div = $doc->createElement("div");
	$question_div->setAttribute("id", "div_" . $questionCounter);
	$question_div->setAttribute("class", "question_div");

	$question_div->appendChild($doc->createElement("br"));

	// Skriveni
	$hidden = $doc->createElement("input");
	$hidden->setAttribute("type", "hidden");
	$hidden->setAttribute("name", "questions[" . $questionCounter . "][question_id]");
	$hidden->setAttribute("value", $question["questionID"]);
	$question_div->appendChild($hidden);
	
	// Delete
	$hidden = $doc->createElement("input");
	$hidden->setAttribute("type", "hidden");
	$hidden->setAttribute("name", "questions[" . $questionCounter . "][delete]");
	$hidden->setAttribute("value", "0");
	$question_div->appendChild($hidden);

	// Pitanje
	$label = $doc->createElement("label", "Pitanje");
	$question_div->appendChild($label);
	$question_div->appendChild($doc->createElement("br"));	
	$textArea = $doc->createElement("textArea", $question["tekstPitanje"]);
	$textArea->setAttribute("name", "questions[" . $questionCounter . "][question]");
	$question_div->appendChild($textArea);
	$question_div->appendChild($doc->createElement("br"));	

	// Hint
	$label = $doc->createElement("label", "Hint");
	$question_div->appendChild($label);
	$question_div->appendChild($doc->createElement("br"));	
	$textArea = $doc->createElement("textArea", $question["hint"]);
	$textArea->setAttribute("name", "questions[" . $questionCounter . "][hint]");
	$question_div->appendChild($textArea);
	$question_div->appendChild($doc->createElement("br"));

	// Bodovi
	$label = $doc->createElement("label", "Bodovi");
	$question_div->appendChild($label);
	$question_div->appendChild($doc->createElement("br"));	
	$input = $doc->createElement("input");
	$input->setAttribute("value", $question["brojBodova"]);
	$input->setAttribute("name", "questions[" . $questionCounter . "][points]");
	$input->setAttribute("type", "number");
	$question_div->appendChild($input);
	$question_div->appendChild($doc->createElement("br"));

	$cat = $doc->createElement("select");
	$cat->setAttribute("name", "questions[" . $questionCounter . "][category]");
	$question_div->appendChild($cat);

	foreach ($categories as $category) {
		$option = $doc->createElement("option", $category["naziv"]);
		$option->setAttribute("value", $category["ID"]);
		
		if($category["ID"] == $question["categoryID"]) {
			$option->setAttribute("selected", true);
		}

		$cat->appendChild($option);
	}
	
	$question_div->appendChild($doc->createElement("br"));
	$question_div->appendChild($doc->createElement("br"));
	
	$button = $doc->createElement("button", "Dodaj odgovor");
	$button->setAttribute("onClick", "add_answer(this)");
	$button->setAttribute("type", "button");
	$button->setAttribute("id", "add_answer_button" . $questionCounter);
	$question_div->appendChild($button);

	$button = $doc->createElement("button", "Makni odgovor");
	$button->setAttribute("onClick", "remove_answer(this)");
	$button->setAttribute("type", "button");
	$button->setAttribute("id", "remove_answer_button_" . $questionCounter);
	$question_div->appendChild($button);
	
	$question_div->appendChild($doc->createElement("br"));
	$question_div->appendChild($doc->createElement("br"));

	$answerCounter = 0;
	$answersDiv = $doc->createElement("div");
	$answersDiv->setAttribute("class", "answersDiv");
	$question_div->appendChild($answersDiv);

	$query = "SELECT ID,tekst,opisNetocnog,tocno FROM tg_odgovori WHERE pitanjeID = ?";
	$params = array($question["questionID"]);

	$answers = $db->query($query, $params);

	foreach ($answers as $answer) {
		$answerDiv = $doc->createElement("div");
		$answerDiv->setAttribute("class", "answerDiv");
		$answersDiv->appendChild($answerDiv);

		// Hidden
		$hidden = $doc->createElement("input");
		$hidden->setAttribute("type", "hidden");
		$hidden->setAttribute("name", "questions[" . $questionCounter . "][answers][" . $answerCounter . "][answer_id]");
		$hidden->setAttribute("value", $answer["ID"]);
		$answerDiv->appendChild($hidden);

		// Pitanje
		$label = $doc->createElement("label", "Odgovor");
		$answerDiv->appendChild($label);
		$textArea = $doc->createElement("textArea", $answer["tekst"]);
		$textArea->setAttribute("name", "questions[" . $questionCounter . "][answers][" . $answerCounter . "][text]");
		$answerDiv->appendChild($textArea);
		
		// Objasnjenje	
		$label = $doc->createElement("label", "Objasnjenje");
		$answerDiv->appendChild($label);
		$input = $doc->createElement("input");
		$input->setAttribute("value", $answer["opisNetocnog"]);
		$input->setAttribute("name", "questions[" . $questionCounter . "][answers][" . $answerCounter . "][explanation]");
		$input->setAttribute("type", "text");
		$answerDiv->appendChild($input);

		// Tocno
		$label = $doc->createElement("label", "Tocno");
		$answerDiv->appendChild($label);
		$input = $doc->createElement("input");
		$input->setAttribute("name",  "questions[" . $questionCounter . "][answers][" . $answerCounter . "][correct]");
		$input->setAttribute("type", "hidden");
		$input->setAttribute("value", "off");
		$answerDiv->appendChild($input);
		$input = $doc->createElement("input");
		$input->setAttribute("name",  "questions[" . $questionCounter . "][answers][" . $answerCounter . "][correct]");
		$input->setAttribute("type", "checkbox");
		if($answer["tocno"] == 1) {
			$input->setAttribute("checked", "checked");
		}
		$answerDiv->appendChild($input);

		$answerCounter++;
	}

	$questionCounter++;	
	$question_div->appendChild($doc->createElement("br"));	
	$form->appendChild($question_div);
}

$appended = $doc->createElement("input");
$appended->setAttribute("type", "submit");
$form->appendChild($appended);

$appended = $doc->createElement("br");
$body->appendChild($appended);

echo "<a href=\"/index.php\">Nazad</a><br><br>";
echo $doc->saveHTML();
echo "<script src=\"public/test_edit_script.js\"></script>";
?>
