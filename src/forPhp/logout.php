<?php
session_start();
unset($_SESSION['Username']);
//header("Location: ".$_SERVER['HTTP_REFERER']);
header("Location:../php/login.php");
?>