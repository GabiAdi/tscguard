<!DOCTYPE html>
<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

$query = "SELECT kime,bodovi FROM tg_korisnik WHERE bodovi > 0 LIMIT 100";
$params = array();

$results = $db->query($query, $params);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="public/leaderboard.css">
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <ul id="nav-menu" class="nav-menu">
            
            <li class="prvi"><a href="index.php">Home</a></li>
            <li><a href="leaderboard.php">Ljestvica</a></li> 
            <li><a href="about.php">O nama</a></li>
            
<?php
			if(!isset($_SESSION["user_id"])) { ?>
				<li><a href="login.php">Prijava</a></li>
				<li><a href="login.php">Registracija</a></li>
<?php		} 
			if(isset($_SESSION["user_id"])) {
				if($_SESSION["role"] == "admin" || $_SESSION["role"] == "author") { ?>	
					<li><a href="author_dashboard.php">Autor dashboard</a></li>
					<li><a href="test_list.php">Vasi testovi</a></li>
<?php			}
				if($_SESSION["role"] == "admin") { ?>
					<li><a href="admin_dashboard.php">Admin panel</a></li>
<?php			} ?>
					<li><a href="test_browser.php">Lista testova</a></li>
<?php			if(isset($_SESSION["test"])) { ?>
					<li><a href="test.php">Test</a></li>
<?php			}?>
					<li><a href="user_profile.php?id=<?= $_SESSION["user_id"]; ?>">Profil</a></li>
					<li><a href="api/logout.php">Logout</a></li>
<?php		} ?>
        </ul>
    </nav>
    <!-- Leaderboard Container -->
    <div class="container">
        <h1>Leaderboard</h1>
   
        <div class="pretrazi-container">
            <input type="text" id="searchInput" oninput="searchLeaderboard()" placeholder="Search by player name">
        </div>
   
        <div class="tablica-container">
            <table id="leaderboardTable">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Score</th>
                        <!--<th>Time</th>-->
                    </tr>
                </thead>
                <tbody id="leaderboardBody">
                    <!-- Player data rows (rank will be automatically set in JS) -->
                    <!--<tr>
                        <td></td>
                        <td>Karlo</td>
                        <td>200</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Maks</td>
                        <td>150</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Gork</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Luka</td>
                        <td>200</td>
</tr>-->
<?php 
				foreach ($results as $result) {
					echo "<tr><td></td>\n<td>" . $result["kime"] . "</td>\n<td>" . $result["bodovi"] . "</td></tr>";  
				}	
?>
                    <!-- More rows can be added as needed -->
                </tbody>
            </table>
        </div>
        <div id="noResults" class="no-results" style="display: none;">No results found</div>
    </div>

    <script>
        // Function to handle the search
        function searchLeaderboard() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#leaderboardTable tbody tr');
            let noResults = true;
   
            rows.forEach(row => {
                const playerName = row.cells[1].innerText.toLowerCase();
                // Check if the player's name starts with the search term
                if (playerName.startsWith(input)) {
                    row.style.display = '';
                    noResults = false;
                } else {
                    row.style.display = 'none';
                }
            });
   
            const noResultsMessage = document.getElementById('noResults');
            if (noResults) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
   
            // After filtering, highlight the top 3 places
            highlightTopThree();
        }
   
        // Function to highlight the top 3 places
        function highlightTopThree() {
            const rows = document.querySelectorAll('#leaderboardTable tbody tr');
            // Remove any existing highlights
            rows.forEach(row => row.classList.remove('top1', 'top2', 'top3'));
   
            // Apply new highlights based on the current order
            if (rows[0]) rows[0].classList.add('top1'); // 1st place
            if (rows[1]) rows[1].classList.add('top2'); // 2nd place
            if (rows[2]) rows[2].classList.add('top3'); // 3rd place
        }

        // Function to convert time (mm:ss) to total seconds for sorting
        function timeToSeconds(time) {
            const parts = time.split(":");
            return parseInt(parts[0]) * 60 + parseInt(parts[1]);
        }

        // Function to sort the leaderboard by score and time
        function sortLeaderboard() {
            const rows = Array.from(document.querySelectorAll('#leaderboardTable tbody tr'));
           
            // Sort first by score (descending), then by time (ascending) for players with the same score
            rows.sort((a, b) => {
                const scoreA = parseInt(a.cells[2].innerText);
                const scoreB = parseInt(b.cells[2].innerText);
                //const timeA = timeToSeconds(a.cells[3].innerText);
                //const timeB = timeToSeconds(b.cells[3].innerText);

				return scoreB - scoreA;

                //if (scoreB !== scoreA) {
                //    return scoreB - scoreA; // Sort by score (descending)
                //} else {
                //    return timeA - timeB; // If scores are the same, sort by time (ascending)
                //}
            });

            // Reorder the rows in the table
            const tbody = document.getElementById('leaderboardBody');
            tbody.innerHTML = ''; // Clear current rows
            rows.forEach(row => tbody.appendChild(row));

            // Reapply highlights for top 3
            highlightTopThree();

            // Set the rank automatically based on the sorted order
            setRanks();
        }

        // Function to set the ranks automatically based on the sorted order
        function setRanks() {
            const rows = document.querySelectorAll('#leaderboardTable tbody tr');
            rows.forEach((row, index) => {
                const rankCell = row.cells[0]; // Rank is in the first cell
                rankCell.innerText = index + 1; // Set the rank based on the row position
            });
        }

        // Initial sort and highlight when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            sortLeaderboard();
        });

        // Function to toggle the menu visibility
        function toggleMenu() {
            document.getElementById('nav-menu').classList.toggle('active');
        }
    </script>
</body>
</html>

