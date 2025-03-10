<?php
session_start();

if($_SESSION["role"] != "admin") { // Redirekcija ako korisnik nije admin
	header("Location: /dashboard.php");
}
?>

<html>
	<body>
		<h1>Add admin</h1>
		<form action="add_admin.php" method="post">
			<label for="username">Username</label>
			<input name="username" type="text" id="username" required><br>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>
