<?php
<<<<<<< HEAD
try{
$db = new PDO('mysql:host=localhost;dbname=splendex_expenses', 'root', '123456');
}catch(Exception $e){
	echo "Connection to db failed";
}
=======
	try {
		$db = new PDO('mysql:host=localhost;dbname=splendex_expenses', 'root', 'admin');
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // all errors should be handled as an exception
	}catch(Exception $e)
	{
		echo $e->getMessage();
	    exit;
	}

?>
>>>>>>> 768e0ecde0794bdaf915f44c31a18535e8777a81
