<?php
	try {
		$db = new PDO('mysql:host=localhost;dbname=splendex_expenses', 'root', '123456');
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // all errors should be handled as an exception
	}catch(Exception $e)
	{
		echo $e->getMessage();
	    exit;
	}

?>
