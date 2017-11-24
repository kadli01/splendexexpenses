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
    $email->execute([$_SESSION['user_id']]);
    $emailItem = $email->fetch();

    echo ($emailItem[0]);
}
//get the username of the user from the db
function returnName(){
	include('connection.php');

	$userName = $db->prepare("SELECT user_name FROM users WHERE user_id = ?");
    $userName->execute([$_SESSION['user_id']]);
    $userNameItem = $userName->fetch();

    echo ($userNameItem[0]);


}

// update the Basic Info of the user
function updateBasicInfo(){
	if(isset($_POST['updateBasicBtn'])) {
		include('connection.php');
		$emails = $db->prepare("SELECT email FROM users");
    	$emails->execute([$_SESSION['user_id']]);
    	$emailItems = $emails->fetchAll();

		if(empty($_POST['name'])){
			echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">The name field must be filled out!</div>';	
		}else{
			$updateBasic = $db->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
			$updateBasic->execute([$_POST['name'], $_POST['email'], $_SESSION['user_id']]);

			echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success">Basic Info updated successfully!</div>';
		}
	}
}
if(isset($_POST['updateBasicBtn'])) updateBasicInfo();

//update the password of the user
function updatePassword() {
	include('connection.php');
	$password = $db->prepare("SELECT password FROM users WHERE user_id = ?");
    $password->execute([$_SESSION['user_id']]);
    $passwordItem = $password->fetch();

    //check if the given password is correct and the new passwords match
    if($_POST['oldPwd'] == password_verify($_POST['oldPwd'], $passwordItem[0]) && $_POST['newPwd'] == $_POST['newPwdAgain']) {

    	$pwd = password_hash($_POST['newPwd'], PASSWORD_BCRYPT);

    	//passwords match, initiate update
    	$updatePass = $db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
		$updatePass->execute([$pwd, $_SESSION['user_id']]);

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

//get the last expense the user paid for
function getLastPaid($userId, $accId){
	include('connection.php');
	$selectLast = $db->prepare("SELECT * FROM expenses 
								WHERE paid_by = ? && account_id = ?
								ORDER BY created_at DESC 
								LIMIT 1");
    $selectLast->execute([$userId, $accId]);
    $lastPaid = $selectLast->fetch(PDO::FETCH_ASSOC);
    return $lastPaid;
}

function getDebt($accId = null){
	include('connection.php');
	$selecDebt = $db->prepare("SELECT e.account_id, p.expense_id, p.paid_by, p.paid_for, p.debt
								FROM paid_for p 
								JOIN expenses e ON p.expense_id = e.expense_id
								WHERE e.account_id = ?");
    $selecDebt->execute([$accId]);
    $debt = $selecDebt->fetchAll(PDO::FETCH_ASSOC);
    $total = array();
    foreach ($debt as $d) {
    	//var_dump($d);
    }
    //var_dump($debt);
    return $members;
}
//get details of expenses
function getExpenseDetails($expenseId){
	include('connection.php');
	$selectDetails = $db->prepare("SELECT * FROM expenses WHERE expense_id = ?");
    $selectDetails->execute([$expenseId]);
    $details = $selectDetails->fetch(PDO::FETCH_ASSOC);
   // var_dump($details);
    return $details;
}
// get the currency of the account
function getCurrency() {
	include('connection.php');
	$currency = $db->prepare("SELECT currency FROM accounts WHERE account_id = ?");
	$currency->execute([$_GET['accountId']]);
	$currencyItem = $currency->fetch();
	return $currencyItem;
}
// insert new expense in the db
function newExpense() {
	include('connection.php');
	$paidBy = $_POST['paidBy'];
	$members = getMembers($_GET['accountId']);

		$expense = $db->prepare("INSERT INTO expenses(account_id, expense_name, amount, paid_by, created_at, updated_at) VALUES(?, ?, ?, ?, NOW(), NOW())");
		$expense->execute([$_GET['accountId'], $_POST['expenseName'], $_POST['amount'], $_POST['paidBy']]);
		$expenseId = $db->lastInsertId();
		foreach ($_POST['paidFor'] as $key => $value) {
			$paidFor = $db->prepare("INSERT INTO paid_for(expense_id, paid_for, debt, paid_by) VALUES(?, ?, ?, ?)");
			$paidFor->execute([$expenseId, $key, $value, $_POST['paidBy']]);
		}

}

function getBalance($userId){
	include('connection.php');
	$selectPaid = $db->prepare("SELECT sum(amount) FROM expenses WHERE account_id = ? && paid_by = ?");
	$selectPaid->execute([$_GET['accountId'], $userId]);
	$paid = $selectPaid->fetchAll(PDO::FETCH_ASSOC);
	$selectDebt = $db->prepare("SELECT u.user_name, sum(p.debt) FROM paid_for p
								LEFT JOIN expenses e
								ON p.expense_id = e.expense_id 
								LEFT JOIN users u
								ON p.paid_for = u.user_id
								WHERE e.account_id = ? && p.paid_for = ?
								GROUP BY p.paid_for");
	$selectDebt->execute([$_GET['accountId'], $userId]);
	$debt = $selectDebt->fetchAll(PDO::FETCH_ASSOC);
	$debt['paid'] = $paid[0]['sum(amount)'];
	return $debt;
}

if(isset($_POST['createExpenseBtn'])) newExpense();

function getPaidFor($expenseId) {
	include('connection.php');
	$details = $db->prepare("SELECT pf.paid_for, u.user_name, pf.debt FROM paid_for pf LEFT JOIN users u ON pf.paid_for = u.user_id WHERE expense_id = ?");
	$details->execute([$expenseId]);
	$detailsItems = $details->fetchAll();

	return $detailsItems;
}