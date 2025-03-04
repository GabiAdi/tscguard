<?php
session_start();
if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");	
}

echo "<p>Hello, " . $_SESSION["username"] . "</p><br>";
?>
<html>
	<body>
		<a href="logout.php">Logout</a>
	</body>
</html>
