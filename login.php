<?php
session_start();

if(isset($_SESSION["username"])) {
	header("Location: /index.php");
	die();
}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>TSCGuard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="overlay" id="overlay" onclick="closeForm()"></div>
    <div class="header">
        <img class="logo" src="logo.png">
        <div class="block">
            <a class="block_text" href="home.html">Home</a>
        </div>
        <div class="block">
            <a class="block_text" href="about.html">O nama</a>
        </div>
        <div class="block">
            <a class="block_text" href="leaderboard.html">Leaderboard</a>
        </div>
    </div>
    <div class="mid">
        <div class="login_container">
        
            <h1 class="welc_text">Welcome!</h1><br>
            <div class="outer_register"><button class="register" onclick="openRegisterForm()">Register</button></div>
            <div class="outer_login"><button class="login" onclick="openLoginForm()">Login</button></div>
        </div>
        <div class="form" id="form_register">
            <form action="/register.php" class="form_container">
                <h1>Register</h1>
                <label for="username" class="input_label"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required class="input_field"> <br>
                <label for="email" class="input_label"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required class="input_field"> <br>
                <label for="passwd" class="input_label"><b>Password</b> </label>
                <input type="password" placeholder="Enter Password" name="passwd" required class="input_field"> <br>
                <button type="submit" class="button_submit">Register</button>
                <button type="cancel" class="button_cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
        <div class="form" id="form_login">
            <form action="/login.php" class="form_container">
                <h1>Login</h1>
                <label for="email" class="input_label"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required class="input_field"> <br>
                <label for="passwd" class="input_label"><b>Password</b> </label>
                <input type="password" placeholder="Enter Password" name="passwd" required class="input_field"> <br>
                <button type="submit" class="button_submit">Login</button>
                <button type="cancel" class="button_cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
    <script>
        function openLoginForm() {
            document.getElementById("form_login").style.display = "block";
            document.getElementById("overlay").style.display = "block";

            setTimeout(() => {
                document.getElementById("form_login").style.opacity = "1";
                document.getElementById("overlay").style.opacity = "1";
            }, 10);
        }
        function openRegisterForm() {
            document.getElementById("form_register").style.display = "block";
            document.getElementById("overlay").style.display = "block";

            setTimeout(() => {
                document.getElementById("form_register").style.opacity = "1";
                document.getElementById("overlay").style.opacity = "1";
            }, 10);
        }

        function closeForm() {
            document.getElementById("form_register").style.opacity="0";
            document.getElementById("form_login").style.opacity = "0";
            document.getElementById("overlay").style.opacity = "0";

            setTimeout(() => {
                document.getElementById("form_login").style.display = "none";
                document.getElementById("form_register").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            }, 500);
        }

    </script>
</body>
</html>

