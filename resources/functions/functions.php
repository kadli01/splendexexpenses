<?php
session_start();
//check if user is logged in
function isLoggedIn(){
    if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
        header('location: index.php');
        exit();
    }
}
//get the users email adress from the db
function returnEmail(){
	include('connection.php');

	$email = $db->prepare("SELECT email FROM users WHERE user_id = ?");
    $email->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $email->execute();
    $emailItem = $email->fetch();

    echo ($emailItem[0]);
}
//get the username of the user from the db
function returnName(){
	include('connection.php');

	$userName = $db->prepare("SELECT user_name FROM users WHERE user_id = ?");
    $userName->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $userName->execute();
    $userNameItem = $userName->fetch();

    echo ($userNameItem[0]);


}

// update the Basic Info of the user
function updateBasicInfo(){
	if(isset($_POST['updateBasicBtn'])) {
		include('connection.php');
		$emails = $db->prepare("SELECT email FROM users");
    	$emails->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
    	$emails->execute();
    	$emailItems = $emails->fetchAll();

		if(empty($_POST['name'])){
			echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">The name field must be filled out!</div>';	
		}else{
			$updateBasic = $db->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
			$updateBasic->bindParam(1, $_POST['name'], PDO::PARAM_STR);
			$updateBasic->bindParam(2, $_POST['email'], PDO::PARAM_STR);
			$updateBasic->bindParam(3, $_SESSION['user_id'], PDO::PARAM_INT);
			$updateBasic->execute();

			echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success">Basic Info updated successfully!</div>';
		}
	}
}
if(isset($_POST['updateBasicBtn'])) updateBasicInfo();

//update the password of the user
function updatePassword() {
	include('connection.php');
	$password = $db->prepare("SELECT password FROM users WHERE user_id = ?");
    $password->bindParam(1, $_SESSION['user_id'], PDO::PARAM_STR);
    $password->execute();
    $passwordItem = $password->fetch();

    //check if the given password is correct and the new passwords match
    if($_POST['oldPwd'] == password_verify($_POST['oldPwd'], $passwordItem[0]) && $_POST['newPwd'] == $_POST['newPwdAgain']) {

    	$pwd = password_hash($_POST['newPwd'], PASSWORD_BCRYPT);

    	//passwords match, initiate update
    	$updatePass = $db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
		$updatePass->bindParam(1, $pwd, PDO::PARAM_STR);
		$updatePass->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
		$updatePass->execute();

		echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success">Password updated successfully!</div>';
		
    }else{
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">The given data dosen\'t match!</div>';	
    }
}

if(isset($_POST['updatePwdBtn'])) updatePassword();

//get the accounts from the db
function getAccounts($accId = null){
	include('connection.php');
	$accountResult = $db->prepare("SELECT a.*, SUM(e.amount) FROM accounts a LEFT JOIN expenses e
									ON e.account_id = a.account_id
									GROUP BY a.account_id
								/*	HAVING a.account_id = ?*/");
	$accountResult->execute(/*[$accId]*/);
	$accounts = $accountResult->fetchAll(PDO::FETCH_ASSOC);
	foreach ($accounts as $key => $value) {
		unset($accounts[$key]);
		$new_key = $value['account_id'];
		$accounts[$new_key] = $value;
	}
	return $accounts;
}

//get the expenses for the accounts
function getExpenses($accountId){
	include('connection.php');

	$expense = $db->prepare("SELECT e.*, u.user_name FROM expenses e LEFT JOIN users u ON e.paid_by = u.user_id WHERE account_id = ?");
	$expense->execute([$accountId]);
	$expenseResult = $expense->fetchAll(PDO::FETCH_ASSOC);	

	return $expenseResult;
}

function getPeoples($accId = null){
	include('connection.php');
	$peoplesResult = $db->prepare("SELECT user_name FROM users");
    $peoplesResult->execute();
    $peoples = $peoplesResult->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($people);
    return $peoples;
}
/*
function getAccountDetails($accId){
	include('connection.php');
	$selectDetails = $db->prepare("SELECT * FROM accounts WHERE account_id = ?");
    $selectDetails->execute([$accId]);
    $details = $selectDetails->fetch(PDO::FETCH_ASSOC);
    var_dump($details);
    return $details;
}
*/
//get the members of the account from the db
function getMembers($accId){
	include('connection.php');
	$selectMembers = $db->prepare("SELECT * FROM users u JOIN users_accounts ua ON u.user_id = ua.user_id WHERE ua.account_id = ?");
    $selectMembers->execute([$accId]);
    $members = $selectMembers->fetchAll(PDO::FETCH_ASSOC);
    return $members;
}

function getCurrency() {
	include('connection.php');
	$currency = $db->prepare("SELECT currency FROM accounts WHERE account_id = ?");
	$currency->execute([$_GET['accountId']]);
	$currencyItem = $currency->fetch();
	return $currencyItem;
}

function newExpense() {
	$paidBy = $_POST['paidBy'];
	try{
		$expense = $db->prepare("INSERT INTO expenses(account_id, expense_name) VALUES(?, ?)");
		$expense->execute([$_GET['accountId']], [$_POST['expenseName']]);
	}catch(Exception $e){
		echo $e->getMessage();
	}
}

if(isset($_POST['createExpenseBtn'])) updatePassword();

