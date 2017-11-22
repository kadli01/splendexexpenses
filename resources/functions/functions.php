<?php
session_start();
function isLoggedIn(){
    if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
        header('location: index.php');
        exit();
    }
}

function returnEmail(){
	include('connection.php');

	$email = $db->prepare("SELECT email FROM users WHERE user_id = ?");
    $email->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $email->execute();
    $email_item = $email->fetch();

    echo $email_item[0];
}

function returnName(){
	include('connection.php');

	$user_name = $db->prepare("SELECT user_name FROM users WHERE user_id = ?");
    $user_name->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $user_name->execute();
    $user_name_item = $user_name->fetch();

    echo $user_name_item[0];
}

// update the Basic Info of the user
if(isset($_POST['updateBasicBtn'])) {
	include('connection.php');

	$updateBasic = $db->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
	$updateBasic->bindParam(1, $_POST['name'], PDO::PARAM_STR);
	$updateBasic->bindParam(2, $_POST['email'], PDO::PARAM_STR);
	$updateBasic->bindParam(3, $_SESSION['user_id'], PDO::PARAM_INT);
	$updateBasic->execute();

	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success alert-dismissable">Basic Info updated successfully!</div>';
}

//update the password of the user
if(isset($_POST['updatePwdBtn'])){
	include('connection.php');

	$password = $db->prepare("SELECT password FROM users WHERE user_id = ?");
    $password->bindParam(1, $_SESSION['user_id'], PDO::PARAM_STR);
    $password->execute();
    $password_item = $password->fetch();

    if($_POST['oldPwd'] == password_verify($_POST['oldPwd'], $password_item[0]) && $_POST['newPwd'] == $_POST['newPwdAgain']) {
    	//passwords match, initiate update
    	$updatePass = $db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
		$updatePass->bindParam(1, password_hash($_POST['newPwd'], PASSWORD_BCRYPT), PDO::PARAM_STR);
		$updatePass->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
		$updatePass->execute();

		echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success alert-dismissable">Password updated successfully!</div>';
		
    }else{
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">The given data dosen\'t match!</div>';	
    }
}

function getAccounts(){
	include('connection.php');
	//$user_id = ($_SESSION['user_id']);
	//$accountResult = $db->prepare("SELECT * FROM accounts a INNER JOIN users_accounts ua
	// 								ON a.account_id = ua.account_id
	// 								WHERE ua.user_id = ?" );
	//$accountResult->bindParam(1, $user_id, PDO::PARAM_INT);
	$accountResult = $db->prepare("SELECT a.*, SUM(e.amount) FROM accounts a LEFT JOIN expenses e
									ON e.account_id = a.account_id
									GROUP BY a.account_id");
	$accountResult->execute();
	$accounts = $accountResult->fetchAll(PDO::FETCH_ASSOC);
	//$expenses = getExpenses($accounts);	
	return $accounts;
}


function getExpenses($accounts){
	include('connection.php');
	$expenses = array();
	foreach ($accounts as $account) {
		$expenseResult = $db->prepare("SELECT * FROM expenses 
										WHERE account_id = ?" );
		$expenseResult->bindParam(1, $account['account_id'], PDO::PARAM_INT);
		$expenseResult->execute();
		$expenses += $expenseResult->fetchAll(PDO::FETCH_ASSOC);	
		$account['expenses'] = 	$expenseResult->fetchAll(PDO::FETCH_ASSOC);
		var_dump($account);
	}
	return $expenses;
}

function getPeoples(){
	include('connection.php');
	$peoplesResult = $db->prepare("SELECT user_name FROM users");
    $peoplesResult->execute();
    $peoples = $peoplesResult->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($people);
    return $peoples;
}
