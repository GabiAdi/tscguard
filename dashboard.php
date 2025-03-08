<?php
session_start();
if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");	
}

echo "<p>Hello, " . $_SESSION["username"] . "</p><br>";
//if($_SESSION["admin"] == "1") {
//	echo "<a href=\"admin_dashboard.php\">Admin dashboard</a>";
//}
?>
<html>
	<body>
			
		<a href="logout.php">Logout</a>
	</body>
</html>
