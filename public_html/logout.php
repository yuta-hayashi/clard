<?php
	require_once('./GoogleOAuth.php');

	$auth = new GoogleOAuth();

	$auth->logout();
	
	header("Location: ./index.php");
 ?>