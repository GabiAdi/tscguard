<?php
session_start();
if($_SESSION["role"] != "admin" && $_SESSION["role"] != "author") {
	header("Location: /dashboard.php");
}
?>

<html>
	<body>
		<h1>Add question</h1>
		<form action="add_question.php" method="post">
			<label for="question">Question</label>
			<textarea name="question" type="text" id="question" rows="10" cols="30" required></textarea><br>

			<label for="points">Points</label>
			<input name="points" type="number" id="points" required><br>

			<label for="hint">Hint</label>
			<textarea name="hint" type="text" id="hint" rows="10" cols="30" required></textarea><br>
			<input type="submit" value="Submit">

			<select id="category" name="category" required>
				<option value="kategorija1">Kategorija1</option>
				<option value="kategorija2">Kategorija2</option>
				<option value="kategorija3">Kategorija3</option>
			</select>
		</form>
	</body>
</html>
