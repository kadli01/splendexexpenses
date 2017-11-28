<?php
session_start();
include('connection.php');

//check if user is logged in
function isLoggedIn(){
    if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
        header('location:' . $config->app_url . '/index.php');
        exit();
    }
}
//get the users email adress from the db
function returnEmail(){
	$email = $GLOBALS['db']->prepare("SELECT email FROM users WHERE user_id = ?");
    $email->execute([$_SESSION['user_id']]);
    $emailItem = $email->fetch();

    if(isset($emailItem)){
    	return ($emailItem[0]);
    }else{
    	return false;
    }

}
//get the username of the user from the db
function returnName(){
	$userName = $GLOBALS['db']->prepare("SELECT user_name FROM users WHERE user_id = ?");
    $userName->execute([$_SESSION['user_id']]);
    $userNameItem = $userName->fetch();

   if(isset($userNameItem)){
    	return $userNameItem[0];
    }else{
    	return false;
    }
    
}

// update the Basic Info of the user
function updateBasicInfo(){
	if(isset($_POST['updateBasicBtn'])) {
		//get all users information
		$userData = $GLOBALS['db']->prepare("SELECT user_id, email FROM users WHERE user_id = ?");
    	$userData->execute([$_SESSION['user_id']]);
    	$userDataItems = $userData->fetchAll(PDO::FETCH_ASSOC);

    	foreach ($userDataItems as $ud) {
			if(!empty($_POST['name']) && $_POST['email'] == $ud['email']){
				$updateBasic = $GLOBALS['db']->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
				$updateBasic->execute([$_POST['name'], $_POST['email'], $_SESSION['user_id']]);

				echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success">Basic Info updated successfully!</div>';
					
			}elseif(empty($_POST['name'])){
				echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">The name field must be filled out!</div>';
			}else{
				echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">The email address you provided is already in use!</div>';
			}
		}
	}
}
if(isset($_POST['updateBasicBtn'])) updateBasicInfo();

//update the password of the user
function updatePassword() {
	$password = $GLOBALS['db']->prepare("SELECT password FROM users WHERE user_id = ?");
    $password->execute([$_SESSION['user_id']]);
    $passwordItem = $password->fetch();

    //check if the given password is correct and the new passwords match
    if($_POST['oldPwd'] == password_verify($_POST['oldPwd'], $passwordItem[0]) && $_POST['newPwd'] == $_POST['newPwdAgain']) {

    	$pwd = password_hash($_POST['newPwd'], PASSWORD_BCRYPT);

    	//passwords match, initiate update
    	$updatePass = $GLOBALS['db']->prepare("UPDATE users SET password = ? WHERE user_id = ?");
		$updatePass->execute([$pwd, $_SESSION['user_id']]);

		echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success">Password updated successfully!</div>';
		
    }elseif($_POST['oldPwd'] != password_verify($_POST['oldPwd'], $passwordItem[0])){
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">You entered your old password incorrectly. Please try again!</div>';
    } else {
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">The given data dosen\'t match!</div>';
    }
}

if(isset($_POST['updatePwdBtn'])) updatePassword();

//get the accounts from the db
function getAccounts($accId = null){
	$accountResult = $GLOBALS['db']->prepare("SELECT a.*, SUM(e.amount) FROM accounts a LEFT JOIN expenses e
									ON e.account_id = a.account_id
									GROUP BY a.account_id
									/*HAVING a.account_id = ?*/");
	$accountResult->execute(/*[$accId]*/);
	$accounts = $accountResult->fetchAll(PDO::FETCH_ASSOC);
	foreach ($accounts as $key => $value) {
		unset($accounts[$key]);
		$new_key = $value['account_id'];
		$accounts[$new_key] = $value;
	}
	if(isset($accounts)){
		return $accounts;
	}else{
    	return false;
    }

}

//get the expenses for the accounts
function getExpenses($accountId){
	$expense = $GLOBALS['db']->prepare("SELECT e.*, u.user_name FROM expenses e LEFT JOIN users u ON e.paid_by = u.user_id WHERE account_id = ? ORDER BY e.created_at DESC");
	$expense->execute([$accountId]);
	$expenseResult = $expense->fetchAll(PDO::FETCH_ASSOC);	

	if(isset($expenseResult)){
		return $expenseResult;
	}else{
    	return false;
    }

}

function getPeoples($accId = null){
	$peoplesResult = $GLOBALS['db']->prepare("SELECT user_id ,user_name, email FROM users");
    $peoplesResult->execute();
    $peoples = $peoplesResult->fetchAll(PDO::FETCH_ASSOC);
    
    if(isset($peoples)){
    	return $peoples;
    }else{
    	return false;
    }
}

//get the members of the account from the db
function getMembers($accId){
	$selectMembers = $GLOBALS['db']->prepare("SELECT * FROM users u JOIN users_accounts ua ON u.user_id = ua.user_id WHERE ua.account_id = ?");
    $selectMembers->execute([$accId]);
    $members = $selectMembers->fetchAll(PDO::FETCH_ASSOC);
    $result = array();
    foreach ($members as $member) {
    	if (!$member['user_name']) {
    		$member['user_name']= ("Unknown - " . $member['email']);
    		array_push($result, $member);
    	}else{
    		array_push($result, $member);
    	}
    }

    if(isset($result)){
    	return $result;
    }else{
    	return false;
    }
}

//get the last expense the user paid for
function getLastPaid($userId, $accId){
	$selectLast = $GLOBALS['db']->prepare("SELECT * FROM expenses 
								WHERE paid_by = ? && account_id = ?
								ORDER BY created_at DESC 
								LIMIT 1");
    $selectLast->execute([$userId, $accId]);
    $lastPaid = $selectLast->fetch(PDO::FETCH_ASSOC);

    if(isset($lastPaid)) {
    	return $lastPaid;
    }else{
    	return false;
    }

}

function getDebt($accId = null){
	$selecDebt = $GLOBALS['db']->prepare("SELECT e.account_id, p.expense_id, p.paid_by, p.paid_for, p.debt
								FROM paid_for p 
								JOIN expenses e ON p.expense_id = e.expense_id
								WHERE e.account_id = ?");
    $selecDebt->execute([$accId]);
    $debt = $selecDebt->fetchAll(PDO::FETCH_ASSOC);
    $total = array();

    if(isset($members)){
    	return $members;
    }else{
    	return false;
    }
}
//get details of expenses
function getExpenseDetails($expenseId){
	$selectDetails = $GLOBALS['db']->prepare("SELECT * FROM expenses WHERE expense_id = ?");
    $selectDetails->execute([$expenseId]);
    $details = $selectDetails->fetch(PDO::FETCH_ASSOC);

    if(isset($details)){
    	return $details;
    }else{
    	return false;
    }
}

// get the currency of the account
function getCurrency() {
	$currency = $GLOBALS['db']->prepare("SELECT currency FROM accounts WHERE account_id = ?");
	$currency->execute([$_GET['accountId']]);
	$currencyItem = $currency->fetch();

	if(isset($currencyItem)){
		return $currencyItem;
	}else{
    	return false;
    }
}
// insert new expense in the db
function newExpense() {
	$paidBy = $_POST['paidBy'];
	$members = getMembers($_GET['accountId']);
	$total = 0;
	foreach ($_POST['paidFor'] as $key => $value) {
		$total += $value;
	}

	foreach ($_POST['paidFor'] as $key => $value) {
		if($value == null){
			$_POST['paidFor'][$key] = 0;
		}
	}	
	if($_POST['amount'] && $_POST['paidBy'] && $_POST['expenseName'] && $_POST['datepicker']) {
		$createdAt = $_POST['datepicker'];
		if ($total == $_POST['amount']) {
			$expense = $GLOBALS['db']->prepare("INSERT INTO expenses(account_id, expense_name, amount, paid_by, expense_date, created_at, updated_at) VALUES(?, ?, ?, ?, ?, NOW(), NOW())");
			$expense->execute([$_GET['accountId'], $_POST['expenseName'], $_POST['amount'], $_POST['paidBy'], $createdAt]);
			$expenseId = $GLOBALS['db']->lastInsertId();
			foreach ($_POST['paidFor'] as $key => $value) {
				$paidFor = $GLOBALS['db']->prepare("INSERT INTO paid_for(expense_id, paid_for, debt, paid_by) VALUES(?, ?, ?, ?)");
				$paidFor->execute([$expenseId, $key, $value, $_POST['paidBy']]);
				header('Location:' . $config->app_url . '/show.php?accountId=' . $_GET["accountId"] . '');
				$_SESSION['successMessage'] = 'Expense successfully added to account!';
			}

		} else {	$expenseError = "Numbers don't add up!";

				$_SESSION['expenseError'] = $expenseError;
				return false;
		}	

	} else {
		$expenseError = "You need to fill out all fields!";
		$_SESSION['expenseError'] = $expenseError;
		return false;
	}
}
if(isset($_POST['createExpenseBtn'])) newExpense();

function getBalance($userId){
	$selectPaid = $GLOBALS['db']->prepare("SELECT sum(pf.debt) FROM expenses e
								LEFT JOIN paid_for pf
								ON e.expense_id = pf.expense_id
								WHERE e.account_id = ? && pf.paid_by = ? && pf.paid_by<>pf.paid_for");
	$selectPaid->execute([$_GET['accountId'], $userId]);
	$paid = $selectPaid->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($paid);
	$selectDebt = $GLOBALS['db']->prepare("SELECT u.user_name, sum(p.debt) FROM paid_for p
								LEFT JOIN expenses e
								ON p.expense_id = e.expense_id 
								LEFT JOIN users u
								ON p.paid_for = u.user_id
								WHERE e.account_id = ? && p.paid_for = ? && p.paid_by<>p.paid_for
								GROUP BY p.paid_for");
	$selectDebt->execute([$_GET['accountId'], $userId]);
	$debt = $selectDebt->fetchAll(PDO::FETCH_ASSOC);
	$debt['paid'] = $paid[0]['sum(pf.debt)'];
	$paid = null;

	if ($debt) {
		return $debt;
	} else { return 0; }
}
	

function getPaidFor($expenseId) {
	$details = $GLOBALS['db']->prepare("SELECT pf.paid_for, u.user_name, pf.debt FROM paid_for pf LEFT JOIN users u ON pf.paid_for = u.user_id WHERE expense_id = ?");
	$details->execute([$expenseId]);
	$detailsItems = $details->fetchAll();

	if(isset($detailsItems)){
		return $detailsItems;
	}else{
    	return false;
    }
}

function whoOwesWhat(){
	$selectWow = $GLOBALS['db']->prepare("SELECT u.email, u.user_name, pf.paid_by, pf.paid_for ,sum(pf.debt) 
                                FROM paid_for pf 
                                LEFT JOIN users u 
                                ON pf.paid_for = u.user_id 
                                LEFT JOIN expenses e
                                ON pf.expense_id = e.expense_id
                                WHERE pf.debt > 0 && e.account_id = ? && pf.paid_by <> pf.paid_for
                                GROUP BY u.user_name, pf.paid_by, pf.paid_for");
    $selectWow->execute([$_GET['accountId']]);
    $wow = $selectWow->fetchAll(PDO::FETCH_ASSOC);  
    $result = array();
    foreach ($wow as $w) {
        $userName = $GLOBALS['db']->prepare("SELECT user_name FROM users WHERE user_id = ?");
        $userName->execute([$w['paid_by']]);
        $userNameItem = $userName->fetch(PDO::FETCH_ASSOC);
        if (!$w['user_name']) {
        	$w['user_name'] = "Unknown - " . $w['email']; 
        }
        array_push($w, $userNameItem);
        $result[] = $w;
    }

    if(isset($result)){
    	return $result;
    }else{
    	return false;
    }
}

function settleDebt(){
	$sql = $GLOBALS['db']->prepare("DELETE FROM paid_for WHERE paid_for = ? AND paid_by = ?");
	$sql->execute([$_POST['paidFor'], $_POST['paidBy']]);

	$sql = $GLOBALS['db']->prepare("DELETE FROM paid_for WHERE paid_by = paid_for AND expense_id = ?");
	$sql->execute([$_POST['expense_id']]);	
}

if(isset($_POST['settleYesBtn'])) settleDebt();