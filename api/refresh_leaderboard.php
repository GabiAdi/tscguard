<?php
session_start();
include_once "../includes/connection.php";

if($_SESSION["role"] !== "admin") { // Ako korisnik nije admin redirektamo ga na dashboard
	header("Location: /index.php");
	die();
}

echo "<a href=\"/admin_dashboard.php\">Nazad</a><br><br>";

$db = new MySQLDB();

$query = "UPDATE tg_korisnik k JOIN ( SELECT korisnikID, SUM(maxBodovi) AS ukupniBodovi FROM ( SELECT korisnikID, testID, MAX(postignutiBodovi) AS maxBodovi FROM tg_testvrijeme GROUP BY korisnikID, testID ) AS najbolji GROUP BY korisnikID ) AS ukupno ON k.ID = ukupno.korisnikID SET k.bodovi = ukupno.ukupniBodovi";
$params = array();

if($db->query($query, $params)) {
	echo "Success";
} else {
	echo "Failure";
}
?>
