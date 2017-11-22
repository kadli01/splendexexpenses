<?php 
if (isset($_POST['create'])) {
	$currency = $_POST['currency'];
	$image = $_POST['image'];

	if (empty($_POST['name'])) {
		$errorMessage = "Account Name is required.";
	} else { 
		$name = $_POST['name'];
	}
	if (!empty($_POST['currency'])) {
		$currency = $_POST['currency'];
	}
	if (!empty($_POST['image'])) {
		$image = $_POST['image'];
	}

	var_dump($name, $currency, $image);

	// try {
	// 	$insert = $db->prepare("INSERT INTO accounts(account_name, currency, image, created_at, updated_at)
	// 							VALUES(?, ?, ?, NOW(), NOW())");
	// 	$insert->execute([$regEmail]);
	// 	$item = $result->fetch();
	// } catch (Exception $e) {
		
	// }
}
?>