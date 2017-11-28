<?php 
$config['host'] = 'localhost';
$config['dbname'] = 'splendex_expenses';
$config['user'] = 'root';
$config['pass'] = '123456';
$config['maxFileSize'] = 5000000; 
$config = (object) $config;

// function settings($index){
// 	if ($config[$index]) {
// 		return $config[$index];
// 	} else {
// 		return false;
// 	}
// }


 $GLOBALS['config'] =  $config;
// $host = 'localhost';
// $dbname = 'splendex_expenses';
// $user = 'root';
// $pass = 'admin';

?>