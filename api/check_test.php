<?php
session_start();
include_once "../includes/connection.php";

if(!isset($_SESSION["user_id"])) {
	header("Location: /index.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}

if(empty($_SESSION["test"])) {
	header("Location: /index.php");
	die();
}

if(empty($_POST["answers"])) {
	header("Location: /test.php");
	die("Answer all quesitons!");
}

$db = new MySQLDB();

$answers = $_POST["answers"];
$_SESSION["answers"] = [];
$brojBodova = 0;

foreach ($answers as $questionID => $answerID) {
	$query = "SELECT tocno,tg_pitanje.brojBodova FROM tg_odgovori JOIN tg_pitanje ON tg_pitanje.ID = pitanjeID WHERE pitanjeID = ? AND tg_odgovori.ID = ?;";
	$params = array($questionID, $answerID);
	$result = $db->query($query, $params);
	$_SESSION["answers"][] = [
		"correct" => $result[0]["tocno"] == 1 ? 1 : 0,
		"points" => $result[0]["brojBodova"],
		"answerID" => $answerID,
		"questionID" => $questionID
	];
	$brojBodova += $result[0]["tocno"] == 1 ? $result[0]["brojBodova"] : 0;
}

$now = date("Y-m-d H:i:s");

$query = "UPDATE tg_testvrijeme SET vrijemeKraja = ?, postignutiBodovi = ? WHERE ID = ?";
$params = array($now, $brojBodova, $_SESSION["test"]["testtime_id"]);
$db->query($query, $params);

unset($_SESSION["test"]);

header("Location: /rjesenja.php");
?>
