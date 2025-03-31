<?php
session_start();
if(isset($_SESSION["user_id"])) {
	header("Location: /dashboard.php");
	die();
}
?>

<html>
	<body>
		<a href="/index.php">Nazad</a>
		<h1>Login</h1>
		<form action="api/login_user.php" method="post">
			<label for="email">Email or Username</label>
			<input name="email" type="text" id="email" required><br>

			<label for="password">Password</label>
			<input name="password" type="password" id="password" required><br>

			<input type="submit" value="Submit">
		</form>
	</body>
</html>
