<?php
	$config = array(
		'client_id' => '798142411471-g4lgirfnv77i16tm0g28u0km37nf0nj5.apps.googleusercontent.com',
		'client_secret' => 'xgJZKbkUYNgnQ6Abn3otGsYZ',
		'redirect_uri' => 'https://clard.ml/callback.php'
	);

	$test = array(
		'client_id' => '798142411471-g4lgirfnv77i16tm0g28u0km37nf0nj5.apps.googleusercontent.com',
		'client_secret' => 'xgJZKbkUYNgnQ6Abn3otGsYZ',
		'redirect_uri' => 'http://localhost/clard/callback.php'
	);

	if($_SERVER['SERVER_NAME']=='localhost'){
		return $test;
	}

	return $config;
?>
