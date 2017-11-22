<?php
include "connection.php";
session_start();

if (isset($_POST['signup'])) {
	foreach($_POST as $key=>$value) {
		if(empty($_POST[$key])) {
		$errorMessage = "All Fields are required";
		break;
		}
	}

	//if(!isset($errorMessage) && !empty($_POST["regEmail"])){
	//	if(!filter_var($_POST["regEmail"], FILTER_VALIDATE_EMAIL )){
	//		$errorMessage = "Invalid email format";
	//	} else {
	//		$regEmail = trim(filter_input(INPUT_POST,"regEmail",FILTER_SANITIZE_STRING));
	//	}
	//}

	if(/*!isset($errorMessage) &&*/ !empty($_POST["regEmail"])){
		$regEmail = trim(filter_input(INPUT_POST,"regEmail",FILTER_SANITIZE_STRING));
	}

	if(!filter_var($regEmail, FILTER_VALIDATE_EMAIL )){
		$errorMessage = "Invalid email format";
	}

	if(!empty($_POST["regPassword"])){
		$regPassword = trim(filter_input(INPUT_POST,"regPassword",FILTER_SANITIZE_STRING));
	}
	if(!empty($_POST["regPasswordAgain"])){
		$regPasswordAgain = trim(filter_input(INPUT_POST,"regPasswordAgain",FILTER_SANITIZE_STRING));
	}
	if ($regPassword !== $regPasswordAgain) {
		$errorMessage = "The passwords are not matching";
	}
	//if(!isset($errorMessage)) {
		if(!isset($_POST["terms"])) {
			$errorMessage = "Accept Terms and Conditions to Register";
		}
	//}


	try{
		$result = $db->prepare("SELECT email FROM users 
								WHERE email = ?");
		$result->execute([$regEmail]);
		$item = $result->fetch();
		if ($item[0] == $regEmail) {
			$errorMessage = "This email address is already registerd.";
			header('location: ../../index.php');
		} elseif(isset($errorMessage)) {
			header('location: ../../index.php');
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
				var_dump($_SESSION['userId']);
				header('location: ../../account.php');
			} else {
				$_SESSION['is_logged_in'] = false;
				$errorMessage = "Failed to register";
				header('location: ../../index.php');
			}
		}
		$_SESSION['errorMessage'] = $errorMessage;
	} catch (Exception $e){
		echo $e->getMessage();
	}
}


