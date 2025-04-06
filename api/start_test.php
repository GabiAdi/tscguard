<?php
session_start();
include_once "../includes/connection.php";


if(isset($_SESSION["user_id"])) {
	header("Location: /index.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}



?>
