<?php 
session_start();
unset($_SESSION['user_id']);
session_destroy();
header('Location:../../' . $config->app_url . '/index.php');
 ?>