<?php
try{
$db = new PDO('mysql:host=localhost;dbname=splendex_expenses', 'root', '123456');
}catch(Exception $e){
	echo "Connection to db failed";
}
