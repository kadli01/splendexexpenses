<?php
include "connection.php";
session_start();
if (isset($_POST['signup'])) {
	var_dump($_POST);
	if (!$_POST["regEmail"] && !$_POST["regPassword"] && !$_POST["regPasswordAgain"]) {
		$errorMessage = "All Fields are required";
	}
	
	if(!isset($errorMessage) && !empty($_POST["regEmail"])){
		$regEmail = trim(filter_input(INPUT_POST,"regEmail",FILTER_SANITIZE_STRING));
	} elseif(!isset($errorMessage) && empty($_POST["regEmail"])){
		$errorMessage = "Fill in the email field to register."; 
	}
	if(!filter_var($regEmail, FILTER_VALIDATE_EMAIL ) && !isset($errorMessage)){
		$errorMessage = "Invalid email format";
	}

	if(!isset($errorMessage) && !empty($_POST["regPassword"])){
		$regPassword = trim(filter_input(INPUT_POST,"regPassword",FILTER_SANITIZE_STRING));
	} elseif (!isset($errorMessage) && empty($_POST["regPassword"])) {
		$errorMessage = "Password is required";
	}
	if(!isset($errorMessage) && !empty($_POST["regPasswordAgain"])){
		$regPasswordAgain = trim(filter_input(INPUT_POST,"regPasswordAgain",FILTER_SANITIZE_STRING));
	} elseif (!isset($errorMessage) && empty($_POST["regPasswordAgain"])){
		$errorMessage = "Password again is required";
	}

	if ($regPassword !== $regPasswordAgain) {
		$errorMessage = "The passwords are not matching";
	}
		if(!isset($errorMessage) && !isset($_POST["terms"])) {
			$errorMessage = "Accept Terms and Conditions to Register";
		}
	try{
		$result = $db->prepare("SELECT email FROM users 
								WHERE email = ?");
		$result->execute([$regEmail]);
		$item = $result->fetch();
		if ($item[0] == $regEmail && $regEmail) {
			$errorMessage = "This email address is already registered.";
			header('location:'  . $config->app_url . '/index.php');
		} elseif(isset($errorMessage)) {
			header('location:' . $config->app_url . '/index.php');
		} else {
			$pwHash = password_hash($regPassword, PASSWORD_BCRYPT);
			$insert = $db->prepare("INSERT INTO users(email, password, created_at, updated_at) 
									VALUES(?, ?, NOW(), NOW())");
			$newUser = $insert->execute([$regEmail, $pwHash]);
			if ($newUser) {
				$errorMessage = "Succcessfully registered.";	
				$idResult = $db->prepare("SELECT user_id FROM users WHERE email = ?");
				$idResult->execute([$regEmail]);
				$userId = $idResult->fetch();
				$_SESSION['user_id'] = $userId[0];
				$_SESSION['is_logged_in'] = true;
				header('location:' . $config->app_url . '/account.php');
			} else {
				$_SESSION['is_logged_in'] = false;
				$errorMessage = "Failed to register";
				header('location:' . $config->app_url . '/index.php');
			}
		}
		$_SESSION['errorMessage'] = $errorMessage;
	} catch (Exception $e){
		echo $e->getMessage();
	}
}