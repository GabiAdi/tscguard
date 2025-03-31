<?php
session_start();
if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();	
}

echo "<p>Hello, " . $_SESSION["username"] . " of role " . $_SESSION["role"] . "</p><br>";
if($_SESSION["role"] == "admin" || $_SESSION["role"] == "author") {
	echo "<a href=\"author_dashboard.php\">Author dashboard</a> ";
}
if($_SESSION["role"] == "admin") {
	echo "<a href=\"admin_dashboard.php\">Admin dashboard</a>";
}
?>
<html>
	<body>	
		<a href="/question_browser.php">Question browser</a>
		<a href="/test.php">Test</a>
		<a href="api/logout.php">Logout</a>
	</body>
</html>
