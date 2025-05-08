<?php
session_start();
include_once "includes/connection.php"; 

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

if(!isset($_GET["id"])) {
    header('Location: /index.php');
    exit;
}

$db = new MySQLDB();

$query = "
        SELECT 
            k.kime AS username,
            p.opis AS role_name
        FROM tg_korisnik k
        INNER JOIN tg_prava pr ON k.ID = pr.korisnikID
        INNER JOIN tg_pravo p ON pr.pravoID = p.ID
        WHERE k.ID = ?
        LIMIT 1
    ";
$user_id = $_GET["id"];
$params = array($user_id);

$user = $db->query($query, $params)[0];

if (!$user) {
    header('Location: /index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>	
	<a href="/index.php">Nazad</a>
	<div style="display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center;">
        <div>
            <h2>User Profile</h2>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($user['role_name']) ?></p>
        </div>
    </div>
</body>
</html>
