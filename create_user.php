<?php
include_once "includes/connection.php";

$db = new MySQLDB();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);

	if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }
	
	$hash = password_hash($password, PASSWORD_BCRYPT);	

	if($db->create_user($username, $hash)) {
		echo "Success";
	} else {
		echo "Failed";
	}
} else {
	die("Invalid request");
}

?>

<html>
	<body>
		<form action="/index.php">
			<input type="submit">
		</form>
	</body>
</html>
