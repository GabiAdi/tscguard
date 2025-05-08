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

$username = trim($_POST["username"]);
$role_id = trim($_POST["role"]);

$query = "SELECT ID FROM tg_korisnik WHERE kime = ?";
$params = array($username);

$result = $db->query($query, $params); 

if(empty($result)) {
	die("User " . $username . " doesn't exist");
}

$user_id = $result[0]["ID"];

$query = "SELECT tg_prava.ID, tg_prava.korisnikID FROM tg_prava JOIN tg_korisnik ON tg_korisnik.ID = tg_prava.korisnikID WHERE tg_korisnik.kime = ? AND tg_prava.pravoID = ?;";
$params = array($username, $role_id);

$result = $db->query($query, $params); 

if(!empty($result)) {
	die("User " . $username . ", already has this role");
}

$query = "UPDATE tg_prava SET pravoID = ? WHERE korisnikID = ?";
$params = array($role_id, $user_id);

if($db->query($query, $params)) {
	echo "Success";
} else {
	echo "Failed";
}
?>
