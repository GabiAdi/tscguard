<?php
session_start();

if($_SESSION["role"] != "admin") { // Redirekcija ako korisnik nije admin
	header("Location: /index.php");
	die();
}
?>

<html>
	<body>
		<a href="/index.php">Nazad</a>
		<h1>Add role</h1>
		<form action="api/add_role.php" method="post">
			<label for="username">Username</label>
			<input name="username" type="text" id="username" required><br>
			<label for="role">Role</label>
			<select id="role" name="role" required>
				<option value="user">Korisnik</option>
				<option value="author">Autor</option>
				<option value="admin">Admin</option>
			</select>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>
