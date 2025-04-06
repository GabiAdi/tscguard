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

$now = date("Y-m-d H:i:s");
$future = date("Y-m-d H:i:s", strtotime("+10 minutes"));

$query = "INSERT INTO tg_test(korisnikID, vrijemePocetka, vremenskoOgranicenje, vrijemeKraja) VALUES (?, ?, ?, ?)";
$params = array($_SESSION["user_id"], $now, $future, NULL);

$id = $db->id_insert($query, $params);

error_log("ID: " . $id);

$_SESSION["test"]["category"] = $category;
$_SESSION["test"]["start_time"] = $now;
$_SESSION["test"]["end_time"] = $future;
$_SESSION["test"]["test_id"] = $id;

header("Location: /test.php");

?>
