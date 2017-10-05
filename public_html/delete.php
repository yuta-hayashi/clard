<?php
//データーベース設定
require_once dirname(__FILE__) . './dsn.php';
$param = "mysql:dbname=".$dsn['dbname'].";host=".$dsn['host'];
$pdo = new PDO($param, $dsn['user'], $dsn['pass']);
$pdo->query('SET NAMES utf8;');

 if($_GET['id']){
  $stmt = $pdo->prepare("DELETE FROM reminder WHERE id = :id");
  $stmt->bindValue(":id", $_GET['id']);
  $flag = $stmt->execute();
 }

 unset($pdo);
 header("Location: index.php");
 exit;
?>
