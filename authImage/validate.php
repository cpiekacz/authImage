<?
	require('class.authImage.php');
	$ai = new authImage();

	if ($ai->validateAuthCode($_POST[auth_code])) {
		echo 'Entered code is correct.';
	}
	
	else {
		echo 'Entered code is incorrect.';
	}
?>