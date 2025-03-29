<?php
session_start();

if(isset($_SESSION["username"])) {
	header("Location: /dashboard.php");
	die();
}	
?>

<html>
	<body>
		<a href="register.php">Register</a><br>
		<a href="login.php">Login</a>
	</body>
</html>
