<?php
	try {
		require('config.php');
		$db = new PDO('mysql:host=' . $config->host . ';dbname=' . $config->dbname, $config->user, $config->pass);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // all errors should be handled as an exception
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}catch(Exception $e)
	{
		echo $e->getMessage();
	    exit;
	}

?>
