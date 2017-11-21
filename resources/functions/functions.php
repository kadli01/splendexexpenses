<?php
function isLoggedIn(){
	session_start();
	if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
		header('location: index.php');
		exit();
	}
}