<?php
function isLoggedIn(){
    session_start();
    if(!isset($_SESSION['user_id']) && $_SESSION['is_logged_in'] == false){
        header('location: index.php');
        exit();
    }
}
function getAccounts(){
	include('connection.php');
	$user_id = ($_SESSION['user_id']);
	$account_result = $db->prepare("SELECT * FROM accounts a INNER JOIN users_accounts ua
									ON a.account_id = ua.account_id
									WHERE ua.user_id = ?" );
	$account_result->bindParam(1, $user_id, PDO::PARAM_INT);
	$account_result->execute();
	$accounts = $account_result->fetchAll(PDO::FETCH_ASSOC);
	$expenses = getExpenses($accounts);	
	var_dump($accounts);
	var_dump($expenses);
	return $accounts;
}


function getExpenses($accounts){
	include('connection.php');
	$expenses = array();
	foreach ($accounts as $account) {
		$expense_result = $db->prepare("SELECT * FROM expenses 
										WHERE account_id = ?" );
		$expense_result->bindParam(1, $account['account_id'], PDO::PARAM_INT);
		$expense_result->execute();
		$expenses += $expense_result->fetchAll(PDO::FETCH_ASSOC);		
	}
	return $expenses;
}