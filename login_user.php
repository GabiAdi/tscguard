<?php
include_once "includes/connection.php";

$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);

	if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }
	
	if($db->validate_user($username, $password)) {
		echo "Success";
	} else {
		echo "Failed";
	}
} else {
	die("Invalid request");
}

?>
