
<?php 
session_start();
require('connection.php');
if (isset($_POST['create'])) {
	$targetDir = "../../public/uploads";
	$targetFile = $targetDir . "/" . $_FILES['image']['name'];
	if (empty($_POST['name'])) {
		$errorMessage = "Account Name is required.";
	} else { 
		$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
	}
	if (!empty($_POST['currency'])) {
		$currency = $_POST['currency'];
	}
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
		        //echo "The file ". basename( $_FILES['image']['name']). " has been uploaded.";
		    } else {
		        $errorMessage = "Sorry, there was an error uploading your file.";
		    }
  		}
	}
	if (!isset($errorMessage)) {
		try {
			$insert = $db->prepare("INSERT INTO accounts(account_name, currency, image, created_at, updated_at)
									VALUES(?, ?, ?, NOW(), NOW())");
			$account = $insert->execute([$name, $currency, $image]);
			$accId = $db->lastInsertId();	
			var_dump($_POST['people']) ;
			if($_POST['people']) {		
				if(addPeople($accId)){
					echo "ok";
				} 
			} else {
				$errorMessage = "Please select people"; 
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	if (!isset($errorMessage)) {
		$_SESSION['createError'] = "Successfully added new account.";
		//var_dump($_SESSION);
		header('location: /splendexexpenses/account.php');
	} else {
		$_SESSION['createError'] = $errorMessage;
		//var_dump($_SESSION);
		header('location: /splendexexpenses/new-account.php');
	}

}

function addPeople($accId){
	require('connection.php');
	$result = array();
	foreach ($_POST['people'] as $person) {
		$selectUserId = $db->prepare("SELECT user_id FROM users WHERE user_name = ?");
		$selectUserId->execute([$person]);
		$userId = $selectUserId->fetch();

		$insert = $db->prepare("INSERT INTO users_accounts(user_id, account_id) VALUES(?, ?)");
		array_push($result, $insert->execute([$userId[0], $accId]));
	}
	if (in_array(false, $result)) {
		return false;
	} else { 
		return true;
	}
}
?>