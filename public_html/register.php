<?php

require_once dirname(__FILE__) . './dsn.php';
$param = "mysql:dbname=".$dsn['dbname'].";host=".$dsn['host'];
$pdo = new PDO($param, $dsn['user'], $dsn['pass']);


 $pdo->query('SET NAMES utf8;');


 if($_POST['id']){

  $stmt = $pdo->prepare("UPDATE reminder SET title = :title, subject=:subject, remind_date = :remind_date WHERE id = :id");

  $stmt->bindValue(':id', $_POST["id"]);

  $stmt->bindValue(':title', $_POST["title"]);

  $stmt->bindValue(':subject', $_POST["subject"]);

  $stmt->bindValue(':remind_date', $_POST["remind_date"]);

 }else{

  $stmt = $pdo->prepare("INSERT INTO reminder (title, subject, remind_date) VALUES (:title, :subject, :remind_date)");

  $stmt->bindValue(':title', $_POST["title"]);
  $stmt->bindValue(':subject', $_POST["subject"]);

  $stmt->bindValue(':remind_date', $_POST["remind_date"]);

 }

 $flag = $stmt->execute();

 unset($pdo);


 header("Location: index.php");

 exit;

?>
