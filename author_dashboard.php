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

$lastKey = array_key_last($result);

?>

<script src="public/author_script.js"></script>
<script id="categories" type="application/json">
{
   	"categories": [<?php
		$items = [];
		foreach ($result as $category) {
			$items[] = json_encode([
				"id" => $category["ID"],
				"name" => $category["naziv"]
			]);
		}
		echo implode(",", $items);
	?>]
}
</script>
<html>
	<body>
		<a href="/index.php">Nazad</a>
		<h1>Napravi test</h1>
		<button id="add_question_btn" onClick="add_question()">Dodaj pitanje</button>
		<form id="test_form" action="api/add_test.php" method="post">
			<label for="test_name">Ime testa</label>
			<input name="test[name]" type="text" id="test_name" required><br>
			<select id="test_category" name="test[category]" required>
				<?php
					foreach ($result as $category) {
						echo "<option value=" . $category["ID"] . ">" . $category["naziv"] . "</option>";
					}
				?>
			</select>
			<br><br>

			<!--<label for="question">Question</label>
			<textarea name="question" type="text" id="question" rows="10" cols="30" required></textarea><br>

			<label for="points">Points</label>
			<input name="points" type="number" id="points" required><br>

			<label for="hint">Hint</label>
			<textarea name="hint" type="text" id="hint" rows="10" cols="30" required></textarea><br>
			
			<select id="category" name="category" required>
				<?php
					//foreach ($result as $category) {
					//	echo "<option value=" . $category["ID"] . ">" . $category["naziv"] . "</option>";
					//}
				?>
			</select>-->

			<br>
			<input id="submitBtn" type="submit" value="Submit">
		</form>
		<br>
	</body>
</html>
