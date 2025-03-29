<?php
// Unistava sesiju u redirektira na index.php
session_start();
session_destroy();
header("Location: /index.php");
?>
