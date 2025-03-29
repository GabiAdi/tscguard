<?php
session_start();

if($_SESSION["role"] != "admin") { // Redirekcija ako korisnik nije admin
	header("Location: /dashboard.php");
	die();
}
?>

<html>
	<body>
		<h1>Add role</h1>
		<form action="api/add_role.php" method="post">
			<label for="username">Username</label>
			<input name="username" type="text" id="username" required><br>
			<input type="submit" value="Submit">
			<label for="role">Role</label>
			<select id="role" name="role" required>
				<option value="user">Korisnik</option>
				<option value="author">Autor</option>
				<option value="admin">Admin</option>
			</select>
		</form>
	</body>
</html>
