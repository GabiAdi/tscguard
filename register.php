<?php
if(isset($_SESSION["user_id"])) {
	header("Location: /dashboard.php");
	die();
}
?>

<html>
	<body>
		<a href="/index.php">Nazad</a>
		<h1>Register</h1>
		<form action="api/create_user.php" method="post">
			<label for="email">Email</label>
			<input name="email" type="text" id="email" required><br>

			<label for="username">Username</label>
			<input name="username" type="text" id="username" required><br>

			<label for="password">Password</label>
			<input name="password" type="password" id="password" required><br>

			<label for="password2">Confirm Password</label>
			<input name="password2" type="password" id="password2" required><br>

			<input type="submit" value="Submit">
		</form>
		<?php
		if(isset($_GET["failed"])) { // Ako je redirektiran s failed zastavicom prikazuje poruku
		?>
		<p>User already exists</p>
		<?php
		}
		?>
	</body>
</html>
