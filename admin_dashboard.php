<?php
include_once "includes/connection.php";
session_start();

if($_SESSION["role"] != "admin") { // Redirekcija ako korisnik nije admin
	header("Location: /index.php");
	die();
}

$db = new MySQLDB();

$roles = $db->query("SELECT ID,opis FROM tg_pravo", array());

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
			<?php
				foreach ($roles as $role) {
					echo "<option value=\"" . $role["ID"] . "\">" . $role["opis"] . "</option>";
				}
			?>
			</select>
			<input type="submit" value="Submit">
		</form>
		<h1>Add category</h1>
		<form action="api/add_category.php" method="post">
			<label for="category">Category name</label>
			<input name="category" type="text" id="category" required><br>
			<input type="submit" value="Submit">
		</form>
		<form action="api/refresh_leaderboard.php">
			<label for="refresh">Refresh leaderboard</label>
			<input type="submit" id="refresh">
		</form>
	</body>
</html>
