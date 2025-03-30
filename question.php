<?php
session_start();

if(!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();	
}

include_once "includes/connection.php";
$db = new MySQLDB();

echo "<a href=\"question_browser.php\">Nazad</a>";

if(!isset($_GET["id"])) {
	echo "Nema";
} else {
	$question_id = $_GET["id"];
	$query = "SELECT tg_pitanje.ID,tekstPitanje,tg_korisnik.kime,brojBodova,hint FROM tg_pitanje JOIN tg_korisnik ON tg_korisnik.ID = korisnikID WHERE tg_pitanje.ID = ?; ";
	$params = array($question_id);
	$result = $db->query($query, $params);

	if(!$result) {
		echo "Nema pitanja";
	} else {
		echo "<h1>" . $result[0]["tekstPitanje"] . "</h1>";
		echo "<h2>By " . $result[0]["kime"] . "</h2>";
		echo "<p>Bodovi: " . $result[0]["brojBodova"] . "</p>";
		echo "<p>Hint: " . $result[0]["hint"] . "</p>";
		
		$query = "SELECT tekst,tocno,opisNetocnog,tg_korisnik.kime FROM tg_odgovori JOIN tg_korisnik ON tg_korisnik.ID = autorID WHERE pitanjeID = ?;";
		$params = array($question_id);

		$result = $db->query($query, $params);
		
		echo "<h2>Odgovori: </h2>";
		if($result) {
			foreach ($result as $question) {
				echo "<p>". $question["tekst"] . " by " . $question["kime"] . ($question["tocno"] == 1 ? ", tocno" : ", netocno") . " jer " . $question["opisNetocnog"] ."</p>";
			}
		}
		?>
		<h1>Add answer</h1>
		<form action="api/add_answer.php" method="post">
			<input type="hidden" name="id" value="<?php echo $question_id ?>">		
			<input type="hidden" name="location" value="<?php echo "question.php?id=" . $question_id ?>">	
			<input type="hidden" name="correct" value="off">			

			<label for="answer">Answer</label>
			<textarea name="answer" type="text" id="answer" rows="10" cols="30" required></textarea><br>
			<label for="correct">Correct?</label>
			<input type="checkbox" name="correct" id="correct"><br>

			<label for="explanation">explanation</label>
			<textarea name="explanation" type="text" id="explanation" rows="10" cols="30" required></textarea><br>
			<input type="submit" value="Submit">
		</form>
		<?php
	}
}
?>
