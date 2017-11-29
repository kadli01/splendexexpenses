<?php 
$config['host'] = 'localhost';
$config['dbname'] = 'splendex_expenses';
$config['user'] = 'root';
$config['pass'] = 'admin';
$config['maxFileSize'] = 5000000; 
$config['app_url'] = '/splendexexpenses';
$config = (object) $config;

$GLOBALS['config'] =  $config;
?>