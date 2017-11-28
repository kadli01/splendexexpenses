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
		//get all users information
		$userData = $db->prepare("SELECT user_id, email FROM users WHERE user_id = ?");
    	$userData->execute([$_SESSION['user_id']]);
    	$userDataItems = $userData->fetchAll(PDO::FETCH_ASSOC);

    	foreach ($userDataItems as $ud) {
			if(!empty($_POST['name']) && $_POST['email'] == $ud['email']){
				$updateBasic = $db->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
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
		
    }elseif($_POST['oldPwd'] != password_verify($_POST['oldPwd'], $passwordItem[0])){
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger">You entered your old password incorrectly. Please try again!</div>';
    } else {
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
									/*HAVING a.account_id = ?*/");
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

	$expense = $db->prepare("SELECT e.*, u.user_name FROM expenses e LEFT JOIN users u ON e.paid_by = u.user_id WHERE account_id = ? ORDER BY e.created_at DESC");
	$expense->execute([$accountId]);
	$expenseResult = $expense->fetchAll(PDO::FETCH_ASSOC);	

	return $expenseResult;
}

function getPeoples($accId = null){
	include('connection.php');
	$peoplesResult = $db->prepare("SELECT user_id ,user_name, email FROM users");
    $peoplesResult->execute();
    $peoples = $peoplesResult->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($people);
    return $peoples;
}

//get the members of the account from the db
function getMembers($accId){
	include('connection.php');
	$selectMembers = $db->prepare("SELECT * FROM users u JOIN users_accounts ua ON u.user_id = ua.user_id WHERE ua.account_id = ?");
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
    //var_dump($result);
    return $result;
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
	$total = 0;
	foreach ($_POST['paidFor'] as $key => $value) {
		$total += $value;
	}

	if(!in_array(null, $_POST['paidFor']) && $_POST['amount'] && $_POST['paidBy'] && $_POST['expenseName'] && $_POST['datepicker']) {
		$createdAt = $_POST['datepicker'];
		if ($total == $_POST['amount']) {
			$expense = $db->prepare("INSERT INTO expenses(account_id, expense_name, amount, paid_by, expense_date, created_at, updated_at) VALUES(?, ?, ?, ?, ?, NOW(), NOW())");
			$expense->execute([$_GET['accountId'], $_POST['expenseName'], $_POST['amount'], $_POST['paidBy'], $createdAt]);
			$expenseId = $db->lastInsertId();
			foreach ($_POST['paidFor'] as $key => $value) {
				$paidFor = $db->prepare("INSERT INTO paid_for(expense_id, paid_for, debt, paid_by) VALUES(?, ?, ?, ?)");
				$paidFor->execute([$expenseId, $key, $value, $_POST['paidBy']]);
				header('Location: show.php?accountId=' . $_GET["accountId"] . '');
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
	include('connection.php');
	// $selectPaid = $db->prepare("SELECT sum(amount) FROM expenses e
	// 							LEFT JOIN paid_for pf
	// 							ON e.expense_id = pf.expense_id
	// 							WHERE e.account_id = ? && e.paid_by = ? && pf.paid_by<>pf.paid_for");

	$selectPaid = $db->prepare("SELECT sum(pf.debt) FROM expenses e
								LEFT JOIN paid_for pf
								ON e.expense_id = pf.expense_id
								WHERE e.account_id = ? && pf.paid_by = ? && pf.paid_by<>pf.paid_for");
	$selectPaid->execute([$_GET['accountId'], $userId]);
	$paid = $selectPaid->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($paid);
	$selectDebt = $db->prepare("SELECT u.user_name, sum(p.debt) FROM paid_for p
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
	//	var_dump($debt);
		return $debt;
	} else { return 0; }
}
	

function getPaidFor($expenseId) {
	include('connection.php');
	$details = $db->prepare("SELECT pf.paid_for, u.user_name, pf.debt FROM paid_for pf LEFT JOIN users u ON pf.paid_for = u.user_id WHERE expense_id = ?");
	$details->execute([$expenseId]);
	$detailsItems = $details->fetchAll();

	return $detailsItems;
}

function whoOwesWhat(){
	include('connection.php');
	// $selectWow = $db->prepare("SELECT u.email, e.expense_id, u.user_name, pf.paid_by, pf.paid_for ,sum(pf.debt) 
 //                                FROM paid_for pf 
 //                                LEFT JOIN users u 
 //                                ON pf.paid_for = u.user_id 
 //                                LEFT JOIN expenses e
 //                                ON pf.expense_id = e.expense_id
 //                                WHERE pf.debt > 0 && e.account_id = ? && pf.paid_by <> pf.paid_for
 //                                GROUP BY u.user_name, pf.paid_by, pf.paid_for, e.expense_id");

	$selectWow = $db->prepare("SELECT u.email, u.user_name, pf.paid_by, pf.paid_for ,sum(pf.debt) 
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
        $userName = $db->prepare("SELECT user_name FROM users WHERE user_id = ?");
        $userName->execute([$w['paid_by']]);
        $userNameItem = $userName->fetch(PDO::FETCH_ASSOC);
        if (!$w['user_name']) {
        	$w['user_name'] = "Unknown - " . $w['email']; 
        }
        array_push($w, $userNameItem);
        $result[] = $w;
    }

    return $result;
}

function settleDebt(){
	include('connection.php');
	$sql = $db->prepare("DELETE FROM paid_for WHERE paid_for = ? AND paid_by = ?");
	$sql->execute([$_POST['paidFor'], $_POST['paidBy']]);

	$sql = $db->prepare("DELETE FROM paid_for WHERE paid_by = paid_for AND expense_id = ?");
	$sql->execute([$_POST['expense_id']]);	
	
}

if(isset($_POST['settleYesBtn'])) settleDebt();