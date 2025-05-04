<?php
session_start();
include_once "includes/connection.php";

$db = new MySQLDB();

?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tehnička škola Čakovec - Projekt</title>
    <link rel="stylesheet" href="public/about.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
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
            <li><a href="leaderboard.php">Ljestvica</a></li> 
            <li><a href="about.php">O nama</a></li>
        </ul>
    </nav>
  <div class="top-nav">  
    <a href="#school"><i class="fas fa-school"></i> Škola</a>
    <a href="https://www.facebook.com/knjiznicatsc#" target="_blank"><i class="fab fa-facebook"></i> Knjižnica</a>
  <a href="https://www.facebook.com/tehnickaskolacakovec/" target="_blank"><i class="fab fa-facebook"></i> Škola</a>
  <a href="https://www.instagram.com/tehnickaskolacakovec/" target="_blank"><i class="fab fa-instagram"></i>  Škola</a>

  </div>
<header>
    <div class="header-content">
        <div class="text">
            <h1>Tehnička škola Čakovec - Projekt</h1>
            <p>Inovacije u obrazovanju i tehnologiji</p>
        </div>
        <div class="logo">
            <a href="https://www.tsck.hr" target="_blank">
                <img src="https://tsck.hr/wp-content/uploads/2021/11/TSCk-logo.png" alt="TŠČ Logo">
            </a>
        </div>
    </div>
</header>
<div class="juhu">
    <section id="about">
        <h2>O projektu</h2>
        <p>Projekt Tehničke škole Čakovec usmjeren je na unapređenje obrazovanja kroz inovativne metode, rješavanja kvizova i interaktivnih zadataka čija je svrha unapređenje i osvještavanja znanja učenika o prijetnjama na internetu.</p>
    </section>

    <section id="school">
        <h2>O Tehničkoj školi Čakovec</h2>
        <p>Tehnička škola Čakovec najveća je srednja škola u Međimurskoj županiji. U školskoj godini 2024./2025. u njoj se obrazuje 826 učenika u područjima elektrotehnike, mehatronike, računalstva i strojarstva te gimnazijskom programu. U 39 razrednih odjela učenici su pod budnim okom više od 80 nastavnika.</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <img src="https://tsck.hr/wp-content/uploads/2021/10/TSCK-header-65-1.jpg" alt="Tehnička škola Čakovec" style="width: 70%; max-width: 800px; border-radius: 15px; margin-top: 20px;">
        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="https://tsck.hr/skola/o-skoli/" target="_blank" style="display: inline-block; padding: 10px 20px; background-color: #6d99c7; color: white; text-decoration: none; font-size: 16px; border-radius: 5px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#4a749b';" onmouseout="this.style.backgroundColor='#6d99c7';">Više o školi</a>
        </div>
    </section>
    
    <div id="map" style="width: 80%; height: 200px;"></div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([46.388679574656294, 16.420160676378984], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            subdomains: ['a', 'b', 'c']
        }).addTo(map);

        L.marker([46.388679574656294, 16.420160676378984]).addTo(map).bindPopup('Tehnička škola Čakovec');
    </script>

    <table>
        <caption>Učenici</caption>
        <thead>
           
            <tr>
                <th>Ime učenika</th>
                <th>Uloga učenika</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gabrijel Murk</td>
                <td>Vođa projekta</td>
            </tr>
            <tr>
                <td>Velimir Tota</td>
                <td>Frontend</td>
            </tr>
            <tr>
                <td>Rafael Šimunić</td>
                <td>Frontend</td>
            </tr>
            <tr>
                <td>Dino Zadravec</td>
                <td>Frontend</td>
            </tr>
            <tr>
                <td>Karlo Mesarić</td>
                <td>Frontend</td>
            </tr>
            <tr>
                <td>Emil Švenda</td>
                <td></td>
            </tr>
            <tr>
                <td>David Jambrošić</td>
                <td></td>
            </tr>
            <tr>
                <td>Matija Hampamer</td>
                <td></td>
            </tr>
            <tr>
                <td>Arsen Munđar</td>
                <td></td>
            </tr>
            <tr>
                <td>Leon Bistrović</td>
                <td></td>
            </tr>
            <tr>
                <td>Mihael Želežnjak</td>
                <td></td>
            </tr>
        </tbody>
    </table>
       
    <section id="contact">
        <h2>Kontakt</h2>
        <p>Športska 5, 40 000 Čakovec</p>
        <p>Email: <a href="mailto:info@tsc.hr">info@tsc.hr</a></p>
        <p>Telefon: +385 40 123 456</p>
    </section>
    
</div>
    <footer>
        <p>&copy; 2025 Tehnička škola Čakovec</p>
        <div class="social-media">
          <a href="#login"><i class="fas fa-user"></i> Prijava</a>
          <a href="https://www.tsck.hr" target="_blank"><i class="fas fa-school"></i> Škola</a>
          <a href="https://www.facebook.com/knjiznicatsc#" target="_blank"><i class="fab fa-facebook"></i> Knjižnica</a>
          <a href="https://www.facebook.com/tehnickaskolacakovec/" target="_blank"><i class="fab fa-facebook"></i> Škola</a>
          <a href="https://www.instagram.com/tehnickaskolacakovec/" target="_blank"><i class="fab fa-instagram"></i> Škola</a>
      </div>   
     
    </footer>
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

