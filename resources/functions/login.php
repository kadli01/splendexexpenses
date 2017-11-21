<?php 
	if(isset($_POST["bttLogin"]))
		{
			require('connection.php');

			$email = $_POST["email"];
			$password = $_POST["password"];


			$email_result = $db->prepare("SELECT email FROM users WHERE email = ?");
		    $email_result->bindParam(1, $email, PDO::PARAM_STR);
		    $email_result->execute();
		    $email_item = $email_result->fetch();

		    $password_result = $db->prepare("SELECT password FROM users WHERE email = ?");
		    $password_result->bindParam(1, $email, PDO::PARAM_STR);
		    $password_result->execute();
		    $password_item = $password_result->fetch();

			
			
			if($email_item[0] == $email && password_verify($password, $password_item[0]))
			{

				header('Location: ../views/account.html');
			}else {
					header('Location: ../views/index.php');
			}

		}
?>
