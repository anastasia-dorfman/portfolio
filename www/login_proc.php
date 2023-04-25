<?php
//verify the user's login credentials. if they are valid redirect them to index.php/
//if they are invalid send them back to login.php
session_start();
include "includes/functions.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
	try{
		if (isset($_SESSION["USERNAME"])){
			setFeedbackAndRedirect("You are already logged in", "info", "index.php");
			return;
		}

		if (!empty($_POST["username"]) && !empty($_POST["password"])) {
			$username = $_POST['username'];
			$formPassword = $_POST['password'];
		
			login($username, $formPassword);
		} else {
			setFeedbackAndRedirect("Fields cannot be empty", "error", "Login.php");
		}
	} catch(Exception $ex){
		setFeedbackAndRedirect("Something went wrong:\n".$ex->getMessage(), "error", "login.php");
	}
}