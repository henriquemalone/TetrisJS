<?php   
if(isset($_GET['button_logout'])) {
session_destroy();
unset($_SESSION['login']);
header('location:../html/login.html');}
?>