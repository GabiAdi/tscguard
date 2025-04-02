<?php
session_start();
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
<?php
			if(!isset($_SESSION["user_id"])) { ?>
				<hr>
				<li><a href="login.php">Prijava</a></li>
								
				<hr>
				<li><a href="login.php">Registracija</a></li>
<?php		} ?>
			<hr>
			<li><a href="index.php">Home</a></li>
            <hr>
            <!--<li><a href="#">Rješenja</a></li>
            <hr>-->
            <!--<li><a href="tscguard_leaderboard.php">Ljestvica</a></li>
<hr>-->
            <li><a href="#">O nama</a></li>
            <hr>
<?php
			if($_SESSION["role"] == "admin" || $_SESSION["role"] == "author") { ?>	
				<li><a href="author_dashboard.php">Autor dashboard</a></li>
				<hr>
<?php		}
			if($_SESSION["role"] == "admin") { ?>
				<li><a href="admin_dashboard.php">Admin panel</a></li>
				<hr>
<?php		} 
			if(isset($_SESSION["user_id"])) { ?>	
				<li><a href="question_browser.php">Lista pitanja</a></li>
				<hr>
				<li><a href="test.php">Test</a></li>
				<hr>
				<li><a href="api/logout.php">Logout</a></li>
				<hr>
<?php		} ?>
        </ul>
    </nav>

    <div class="container">
        <header class="header">
            <div class="title">Dobro došli na našu stranicu</div>
            <div class="subtitle">Odaberite kategoriju koju želite odabrati:</div>
        </header>

        <section class="categories">
            <div class="category">Prva kategorija</div>
            <div class="category">Druga kategorija</div>
            <div class="category">Treća kategorija</div>
            <div class="category">Četvrta kategorija</div>
        </section>
    </div>

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
