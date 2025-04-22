<?php
session_start();
include_once "../includes/connection.php";

if(!isset($_SESSION["user_id"])) {
	header("Location: /index.php");
	die();
}

if(isset($_SESSION["test"])) {
	header("Location: /test.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}


$db = new MySQLDB();

$category = $_POST["category"];

$query = "SELECT tg_testovi.ID FROM tg_testovi JOIN tg_testkategorija ON tg_testkategorija.testID = tg_testovi.ID WHERE tg_testkategorija.kategorijaID = ? ORDER BY RAND();";
$params = array($category);

$result = $db->query($query, $params);

if(empty($result)) {
	header("/test_browser.php");
	die();
}

$test_id = $result[0]["ID"];

$now = date("Y-m-d H:i:s");
$future = date("Y-m-d H:i:s", strtotime("+10 minutes"));

$query = "INSERT INTO tg_testvrijeme(korisnikID, testID, vrijemePocetka, vremenskoOgranicenje, vrijemeKraja) VALUES (?, ?, ?, ?, ?)";
$params = array($_SESSION["user_id"], $test_id, $now, $future, NULL);

$id = $db->id_insert($query, $params);

$_SESSION["test"]["test_id"] = $test_id;
$_SESSION["test"]["start_time"] = $now;
$_SESSION["test"]["end_time"] = $future;
$_SESSION["test"]["testtime_id"] = $id;

header("Location: /test.php");

?>
