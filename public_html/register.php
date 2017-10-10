<?php
	require_once(dirname(__FILE__).'/GoogleOAuth.php');
	
	$auth = new GoogleOAuth();

	if(!$auth->is_logged_in()){
		if($auth->has_refresh_token()){
			$auth->re_oauth();
		}
	}

  $host = "localhost";

  $user = "root";

  $pass = "clardpass555";

  $db = "reminder";


 $param = "mysql:dbname=".$db.";host=".$host;

 $pdo = new PDO($param, $user, $pass);

 $pdo->query('SET NAMES utf8;');

 $classname = $_POST['class'];
 
 if($_POST['id']){
  
  $stmt = $pdo->prepare("UPDATE reminder_".$classname." SET title = :title, subject=:subject, remind_date = :remind_date WHERE id = :id");

  $stmt->bindValue(':id', $_POST["id"]);

  $stmt->bindValue(':title', $_POST["title"]);

  $stmt->bindValue(':subject', $_POST["subject"]);

  $stmt->bindValue(':remind_date', $_POST["remind_date"]);

 }else{
  
  $stmt = $pdo->prepare("INSERT INTO reminder_".$classname."(title, subject, remind_date) VALUES (:title, :subject, :remind_date)");

  $stmt->bindValue(':title', $_POST["title"]);
  $stmt->bindValue(':subject', $_POST["subject"]);

  $stmt->bindValue(':remind_date', $_POST["remind_date"]);

 }

 $flag = $stmt->execute();

 unset($pdo);


 header("Location: index.php");

 exit;

?>
