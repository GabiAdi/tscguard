<?php
if(isset($_SESSION["user_id"])) {
	header("Location: /dashboard.php");
}
?>

<html>
	<body>
		<h1>Register</h1>
		<form action="create_user.php" method="post">
			<label for="username">Username</label>
			<input name="username" type="text" id="username" required><br>

			<label for="password">Password</label>
			<input name="password" type="text" id="password" required><br>

			<input type="submit" value="Submit">
		</form>
		<?php
		if($_GET["failed"] == "true") {
		?>
		<p>User already exists</p>
		<?php
		}
		?>
	</body>
</html>
