<?php
session_start();

$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : "index.php";

$_SESSION = array();
$user = null;

#Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), "", time() - 42000, "/");
}

#Destroy the session
session_destroy();
// header('Location:login.php');
header("Location:$referer");