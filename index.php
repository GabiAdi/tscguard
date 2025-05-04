<!DOCTYPE html>
<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TSCGuard Homepage</title>
    <link rel="stylesheet" href="public/homepage.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
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

    <script>
        function toggleMenu() 
        {
            const menu = document.getElementById('nav-menu');
            menu.classList.toggle('active');
        }
        function closeMenu()
        {
            const menu = document.getElementById('nav-menu');
            const menuIcon = document.querySelector('.menu-icon');
            if(!menu.contains(event.target) && !menuIcon.contains(event.target))
            {
                menu.classList.remove('active');
            }
        }
        document.addEventListener('click', closeMenu);
    </script>
</body>
</html>

