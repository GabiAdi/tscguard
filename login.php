<?php
if(isset($_SESSION["user_id"])) {
	header("Location: /dashboard.php");
}
?>

<html>
	<body>
		<h1>Login</h1>
		<form action="login_user.php" method="post">
			<label for="email">Email</label>
			<input name="email" type="text" id="email" required><br>

			<label for="password">Password</label>
			<input name="password" type="password" id="password" required><br>

			<input type="submit" value="Submit">
		</form>
	</body>
</html>
