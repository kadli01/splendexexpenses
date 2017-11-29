<?php
session_start();
include('connection.php');

/**
 * check if the user is logged in
 * @return boolean
 */
function isLoggedIn(){
    if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
        header('location:' . $config->app_url . '/index.php');
        exit();
    }
}

/**
 * get the email of the user
 * @return array
 */
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

/**
 * get the name of the user
 * @return array
 */
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

/**
 * update the users basic info
 *
 */
function updateBasicInfo(){
	if(isset($_POST['updateBasicBtn'])) {
		//get all users information
		$userData = $GLOBALS['db']->prepare("SELECT user_id, email FROM users WHERE user_id = ?");
    	$userData->execute([$_SESSION['user_id']]);
    	$userDataItems = $userData->fetchAll(PDO::FETCH_ASSOC);

    	foreach ($userDataItems as $ud) {
			if(!empty(trim($_POST['name'])) && $_POST['email'] == $ud['email']){
				$updateBasic = $GLOBALS['db']->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
				$updateBasic->execute([$_POST['name'], $_POST['email'], $_SESSION['user_id']]);

				echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-success alert-dismissable">Basic Info updated successfully!<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';
					
			}elseif(empty(trim($_POST['name']))){
				echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">The name field must be filled out!<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';
			}else{
				echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">The email address you provided is already in use!<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';
			}
		}
	}
}
if(isset($_POST['updateBasicBtn'])) updateBasicInfo();//run updateBasicInfo function on button click

/**
 * update the users password
 *
 */
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
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">You entered your old password incorrectly. Please try again!<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';
    } else {
    	echo '<div style="margin-bottom: 0px; text-align: center;" class="alert alert-danger alert-dismissable">The given data dosen\'t match!<a href="" class="close" data-dismiss="alert" aria-label="close">×</a></div>';
    }
}

if(isset($_POST['updatePwdBtn'])) updatePassword(); //run updatePassword function on button click


/**
 * get accounts from db
 * @param  int $accId
 * @return array
 */
function getAccounts($accId = null){
	$accountResult = $GLOBALS['db']->prepare("SELECT a.*, SUM(e.amount) FROM accounts a LEFT JOIN expenses e
									ON e.account_id = a.account_id
									GROUP BY a.account_id");
	$accountResult->execute();
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

/**
 * get the expenses for the accounts
 * @param  int $accountId
 * @return array
 */
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

/**
 * 
 *get all users' id username email from the db
 * @return array
 */
function getPeoples(){
	$peoplesResult = $GLOBALS['db']->prepare("SELECT user_id ,user_name, email FROM users");
    $peoplesResult->execute();
    $peoples = $peoplesResult->fetchAll(PDO::FETCH_ASSOC);
    
    if(isset($peoples)){
    	return $peoples;
    }else{
    	return false;
    }
}

/**
 * get the members of the account from the db
 * 
 * @param  int $accId
 * @return array 
 */
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

/**
 * get the last expense the user paid for
 * 
 * @param  int $userId
 * @param  int $accId
 * @return array
 */
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
/**
 * get the debts for certain expenses
 * 
 * @param  int $accId
 * @return array
 */
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
/**
 * get details of expenses
 * 
 * @param  int $expenseId
 * @return array
 */
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

/**
 * get the currency of the account
 * 
 * @return array ($ or HUF)
 */
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
/**
 * insert new expense in the db
 * 
 */
function newExpense() {
	$paidBy = $_POST['paidBy'];
	$members = getMembers($_GET['accountId']);
	$total = 0;
	foreach ($_POST['paidFor'] as $key => $value) {
		$total += $value;
	}

	foreach ($_POST['paidFor'] as $key => $value) {
		if($value == null ){
			$_POST['paidFor'][$key] = 0;
		}
		if ($value < 0) {
			$expenseError = "All numbers must be greater than 0";
		}
	}	
	if ($_POST['amount'] <= 0 ) {
		$expenseError = "All numbers must be greater than 0";
	}
	if($_POST['amount'] && $_POST['paidBy'] && !empty(trim($_POST['expenseName'])) && $_POST['datepicker'] && !isset($expenseError)) {
		$createdAt = $_POST['datepicker'];
		if ($total == $_POST['amount']) {
			$expense = $GLOBALS['db']->prepare("INSERT INTO expenses(account_id, expense_name, amount, paid_by, expense_date, created_at, updated_at) VALUES(?, ?, ?, ?, ?, NOW(), NOW())");
			$expense->execute([$_GET['accountId'], $_POST['expenseName'], $_POST['amount'], $_POST['paidBy'], $createdAt]);
			$expenseId = $GLOBALS['db']->lastInsertId();
			foreach ($_POST['paidFor'] as $key => $value) {
				$paidFor = $GLOBALS['db']->prepare("INSERT INTO paid_for(expense_id, paid_for, debt, paid_by) VALUES(?, ?, ?, ?)");
				$paidFor->execute([$expenseId, $key, $value, $_POST['paidBy']]);
				header('Location:' . $config->app_url . 'show.php?accountId=' . $_GET["accountId"] . '');
				$_SESSION['successMessage'] = 'Expense successfully added to account!';
			}

		} elseif(!isset($expenseError) ){	$expenseError = "Numbers don't add up!";

				$_SESSION['expenseError'] = $expenseError;
				return false;
		}	

	} elseif(!isset($expenseError) ) {
		$expenseError = "You need to fill out all fields!";
		$_SESSION['expenseError'] = $expenseError;
		return false;
	} else { 
		$_SESSION['expenseError'] = $expenseError;
		return false;
	}
}
if(isset($_POST['createExpenseBtn'])) newExpense(); //run newExpense function on button click

/**
 * get the balance of the user
 * 
 * @param  int $userId
 * @return $debt int
 */
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
	
/*
*
*get data for the paid for section in expense-show.php
*
*@param int $expenseId
*@ return array with data required in expense-show.php
*
*/
function getPaidFor($expenseId) {
	$details = $GLOBALS['db']->prepare("SELECT pf.paid_for, u.user_name, pf.debt, u.email FROM paid_for pf LEFT JOIN users u ON pf.paid_for = u.user_id WHERE expense_id = ?");
	$details->execute([$expenseId]);
	$detailsItems = $details->fetchAll(PDO::FETCH_ASSOC);

	if(isset($detailsItems)){
		return $detailsItems;
	}else{
    	return false;
    }
}


/**
*
*get data for the who owes what section on show.php
*@return array with the data required for the who owes what section of show.php
*/
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
        $selectPaidBy = $GLOBALS['db']->prepare("SELECT user_name, email FROM users WHERE user_id = ?");
        $selectPaidBy->execute([$w['paid_by']]);
        $paidBy = $selectPaidBy->fetch(PDO::FETCH_ASSOC);
        
        if (!$w['user_name']) {
        	$w['user_name'] = "Unknown - " . $w['email']; 
        } 
        if (!$paidBy['user_name']) {
        	$w['pb_name'] = "Unknown - " . $paidBy['email']; 
        } else {
        	$w['pb_name'] = $paidBy['user_name'];
        }

        $result[] = $w;
    }
    if(isset($result)){
    	return $result;
    }else{
    	return false;
    }
}

/*
*
*Remove debts from paid_for table
*
*/
function settleDebt(){
	$sql = $GLOBALS['db']->prepare("DELETE FROM paid_for WHERE paid_for = ? AND paid_by = ?");
	$sql->execute([$_POST['paidFor'], $_POST['paidBy']]);

	$sql = $GLOBALS['db']->prepare("DELETE FROM paid_for WHERE paid_by = paid_for AND expense_id = ?");
	$sql->execute([$_POST['expense_id']]);	
}

if(isset($_POST['settleYesBtn'])) settleDebt(); //run settleDebt function on button click

/*
*
*Get the account's name to show on update page
*
*/
function getAccountforUpdate(){
	$account = $GLOBALS['db']->prepare("SELECT account_name FROM accounts WHERE account_id = ?");
	$account->execute([$_GET['accountId']]);
	$accountName = $account->fetch(PDO::FETCH_ASSOC);
	if(isset($accountName)){
		return $accountName;
	}else{ return false; }
}

/*
*
*gets the members of the account - shown in edit-account.php
*
*/
function getAccountMembersForUpdate(){
	$members = $GLOBALS['db']->prepare("SELECT ua.user_id, u.user_name, u.email FROM users_accounts ua LEFT JOIN users u ON ua.user_id = u.user_id  WHERE account_id = ?");
	$members->execute([$_GET['accountId']]);
	$membersItems = $members->fetchAll(PDO::FETCH_ASSOC);
	if(isset($membersItems)){
		return $membersItems;
	}else{ return false; }
}

/*
*
*update the members for the account
*
*/
function updateAccountPeople(){
	if(isset($_POST['people'])){
		$sql = $GLOBALS['db']->prepare("DELETE FROM users_accounts WHERE account_id = ?");
				$sql->execute([$_GET['accountId']]);
		foreach ($_POST['people'] as $person) {	
			$sql = $GLOBALS['db']->prepare("INSERT INTO users_accounts(user_id, account_id) VALUES(?, ?)");
			$sql->execute([$person, $_GET['accountId']]);
		}
	}else {
		$_SESSION['accUpdatePeopleError'] = "Please choose people you want to be in this account!";
		return false;
	}
}
/**
*Uploads the the new image file to the uploads folder and updates the database
*/
function updateAccountImage(){
	include('config.php');
	$targetDir = "public/uploads";
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
  		} elseif ($_FILES['image']['size'] > $config->maxFileSize) {
  			$errorMessage = "Sorry, your file is too large.";
  		} else {
  			if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
		        $updateAccount = $GLOBALS['db']->prepare("UPDATE accounts SET image = ? WHERE account_id = ?");
				$updateAccount->execute([$image, $_GET['accountId']]);
		    } else {
		        $errorMessage = "Sorry, there was an error uploading your file.";
		        return false;
		    }
  		}
	}
}
/*
*
*update accounts table
*
*/
function updateAccount(){
	include('config.php');
	if(!empty(trim($_POST['name']))){
		$updateAccount = $GLOBALS['db']->prepare("UPDATE accounts SET account_name = ?, currency = ?, updated_at = NOW() WHERE account_id = ?");
		$updateAccount->execute([trim($_POST['name']), $_POST['currency'], $_GET['accountId']]);

		updateAccountPeople();//
		updateAccountImage();
		$_SESSION['successMessage'] = "Successfully updated account!";
		header('location:' . $config->app_url . '/show.php?accountId=' . $_GET['accountId']);
	}else {
		$_SESSION['accUpdateNameError'] = "Account Name is required!";
		return false;
	}
}
if(isset($_POST['updateAccBtn'])) updateAccount();
