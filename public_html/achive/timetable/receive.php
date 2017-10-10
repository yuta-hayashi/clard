<?php 
		$filename = "./data.json";
		$data = urldecode($_POST['body']); 
		if($_POST['key']!="ishkawa9290392"){
			echo "Access denied";
			exit();
		}
		file_put_contents($filename, $data);
?>