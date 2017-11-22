<?php 
session_start();
require('connection.php');
if (isset($_POST['create'])) {
	$targetDir = "../../public/uploads";
	$targetFile = $targetDir . "/" . $_FILES['image']['name'];
	var_dump($targetFile);
	if (empty($_POST['name'])) {
		$errorMessage = "Account Name is required.";
	} else { 
		$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
	}
	if (!empty($_POST['currency'])) {
		$currency = $_POST['currency'];
	}
	var_dump($_FILES);
	if (!empty($_FILES['image']) && $_FILES['image']['size'] > 0) {
		$image = $_FILES['image']['name'];
		$fileExt=strtolower(end(explode('.',$image)));
 		$extensions= array("jpg", "jpeg", "png", "gif");
  		if(!in_array($fileExt,$extensions)){
     		$errorMessage = "Extension not allowed, please choose a JPG, JPEG, GIF or PNG file.";
  		} elseif ($_FILES['image']['size'] > 5000000) {
  			$errorMessage = "Sorry, your file is too large.";
  		} else {
  			if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
		        echo "The file ". basename( $_FILES['image']['name']). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
  		}
	}
	var_dump($errorMessage);
	if (!isset($errorMessage)) {
		try {
		$insert = $db->prepare("INSERT INTO accounts(account_name, currency, image, created_at, updated_at)
								VALUES(?, ?, ?, NOW(), NOW())");
		$account = $insert->execute([$name, $currency, $image]);
		if ($account) {
			$_SESSION['createError'] = "Successfully added new account.";
			header('location: /splendexexpenses/account.php');
		}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	} else {
		$_SESSION['createError'] = $errorMessage;
		header('location: /splendexexpenses/new-account.php');
	}
	var_dump($name, $currency, $image);
	var_dump($_FILES['image']);
}
?>