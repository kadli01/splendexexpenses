<?php
	require('config.php');
	try {
		//$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
		$GLOBALS['db'] = $db = new PDO('mysql:host=' . $config->host . ';dbname=' . $config->dbname, $config->user, $config->pass);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // all errors should be handled as an exception
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}catch(Exception $e)
	{
		throw new Exception("Error Processing Request");		
		echo $e->getMessage();
	    exit;
	}

?>
