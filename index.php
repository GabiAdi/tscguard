<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

if(isset($_SESSION["username"])) {
	header("Location: /dashboard.php");
}	
?>

<html>
	<body>
		<a href="register.php">Register</a><br>
		<a href="login.php">Login</a>
<?php
?>
	</body>
</html>
