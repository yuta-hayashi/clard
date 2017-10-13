<?php

  $host = "localhost";
  $user = "root";
  $pass = "clardpass555";
  $db = "reminder_demo";

 $param = "mysql:dbname=".$db.";host=".$host;
 $pdo = new PDO($param, $user, $pass);
 $pdo->query('SET NAMES utf8;');

 $classname = $_GET['class'];

 if($_GET['id']){
  $stmt = $pdo->prepare("DELETE FROM reminder_".$classname." WHERE id = :id");
  $stmt->bindValue(":id", $_GET['id']);
  $flag = $stmt->execute();
 }

 unset($pdo);

 header("Location: index.php");
 
 exit;

?>
