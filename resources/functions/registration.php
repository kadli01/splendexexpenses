<?php
include "connection.php";
session_start();

foreach($_POST as $key=>$value) {
	if(empty($_POST[$key])) {
	$error_message = "All Fields are required";
	break;
	}
}

//if(!isset($error_message) && !empty($_POST["reg_email"])){
//	if(!filter_var($_POST["reg_email"], FILTER_VALIDATE_EMAIL )){
//		$error_message = "Invalid email format";
//	} else {
//		$reg_email = trim(filter_input(INPUT_POST,"reg_email",FILTER_SANITIZE_STRING));
//	}
//}

if(/*!isset($error_message) &&*/ !empty($_POST["reg_email"])){
	$reg_email = trim(filter_input(INPUT_POST,"reg_email",FILTER_SANITIZE_STRING));
}

if(!filter_var($reg_email, FILTER_VALIDATE_EMAIL )){
	$error_message = "Invalid email format";
}

if(!empty($_POST["reg_password"])){
	$reg_password = trim(filter_input(INPUT_POST,"reg_password",FILTER_SANITIZE_STRING));
}
if(!empty($_POST["reg_password_again"])){
	$reg_password_again = trim(filter_input(INPUT_POST,"reg_password_again",FILTER_SANITIZE_STRING));
}
if ($reg_password !== $reg_password_again) {
	$error_message = "The passwords are not matching";
}
//if(!isset($error_message)) {
	if(!isset($_POST["terms"])) {
		$error_message = "Accept Terms and Conditions to Register";
	}
//}


try{
	$result = $db->prepare("SELECT email FROM users 
		WHERE email = ?");
	$result->bindParam(1, $reg_email, PDO::PARAM_STR);
	$result->execute();
	$item = $result->fetch();
	if ($item[0] == $reg_email) {
		$error_message = "This email address is already registerd.";
		header('location: ../views/index.php');
	} elseif(isset($error_message)) {
		header('location: ../views/index.php');
	} else {
		$pw_hash = password_hash($reg_password, PASSWORD_BCRYPT);
		$insert = $db->prepare("INSERT INTO users(email, password, created_at, updated_at) 
			VALUES(?, ?, NOW(), NOW())");
		$insert->bindParam(1, $reg_email, PDO::PARAM_STR);
		$insert->bindParam(2, $pw_hash, PDO::PARAM_STR);
		$new_user = $insert->execute();
		var_dump($new_user);
		if ($new_user) {
			var_dump($new_user);
			echo "siker";
			$error_message = "Succcessfully registered.";
			header('location: ../views/account.php');
		} else {
			var_dump($new_user);
			echo "fail";
			$error_message = "Failed to register";
			header('location: ../views/index.php');
		}
	}
	$_SESSION['error_message'] = $error_message;
} catch (Exception $e){
	echo $e->getMessage();
}



