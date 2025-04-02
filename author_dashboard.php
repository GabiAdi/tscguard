<?php
include_once "includes/connection.php";
session_start();
if($_SESSION["role"] != "admin" && $_SESSION["role"] != "author") {
	header("Location: /index.php");
	die();
}
$db = new MySQLDB();

$query = "SELECT ID,naziv FROM tg_kategorije";
$params = array();
$result = $db->query($query, $params);

?>

<html>
	<body>
		<a href="/index.php">Nazad</a>
		<h1>Add question</h1>
		<form action="api/add_question.php" method="post">
			<label for="question">Question</label>
			<textarea name="question" type="text" id="question" rows="10" cols="30" required></textarea><br>

			<label for="points">Points</label>
			<input name="points" type="number" id="points" required><br>

			<label for="hint">Hint</label>
			<textarea name="hint" type="text" id="hint" rows="10" cols="30" required></textarea><br>
			
			<select id="category" name="category" required>
				<?php
					foreach ($result as $category) {
						echo "<option value=" . $category["ID"] . ">" . $category["naziv"] . "</option>";
					}
				?>
			</select>

			<input type="submit" value="Submit">
		</form>
	</body>
</html>
