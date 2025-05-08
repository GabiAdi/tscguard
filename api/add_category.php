<?php
session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] !== "admin") { // Ako korisnik nije admin redirektamo ga na dashboard
	header("Location: /index.php");
	die();
}

if($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request");
}

echo "<a href=\"/admin_dashboard.php\">Nazad</a><br><br>";

$db = new MySQLDB();

$category = trim($_POST["category"]);

$query = "SELECT * FROM tg_kategorije WHERE naziv = ?";
$params = array($category);

$result = $db->query($query, $params); 

if($result) {
	die("Category " . $category . " already exists");
}

$query = "INSERT INTO tg_kategorije(naziv) VALUES (?)";
$params = array($category);

if($db->query($query, $params)) {
	echo "Success";
} else {
	echo "Failed";
}
?>
