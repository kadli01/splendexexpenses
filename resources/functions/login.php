<?php 
	if(isset($_POST["bttLogin"]))
		{
			require('connection.php');

			$email = $_POST["email"];
			$password = $_POST["password"];


			$emailResult = $db->prepare("SELECT email FROM users WHERE email = ?");
		    $emailResult->bindParam(1, $email, PDO::PARAM_STR);
		    $emailResult->execute();
		    $emailItem = $emailResult->fetch();

		    $passwordResult = $db->prepare("SELECT password FROM users WHERE email = ?");
		    $passwordResult->bindParam(1, $email, PDO::PARAM_STR);
		    $passwordResult->execute();
		    $passwordItem = $passwordResult->fetch();

			$idResult = $db->prepare("SELECT user_id FROM users WHERE email = ?");
			$idResult->bindParam(1, $email, PDO::PARAM_STR);
			$idResult->execute();
			$userId = $idResult->fetch();
			if(isset($userId[0])){
				$_SESSION['user_id'] = $userId[0];
			}
		

			
			
			if($emailItem[0] == $email && password_verify($password, $passwordItem[0]))
			{
				header('Location: account.php');
			}else {
				header('Location: index.php');
			}


		}
