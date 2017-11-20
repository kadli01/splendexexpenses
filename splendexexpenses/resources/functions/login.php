<?php
include 'connection.php';

if(!empty($_POST)['email']){
	$email = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
}

function login(){


}