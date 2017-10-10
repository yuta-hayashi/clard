<?php

 $id = "";

 $title = "";

 $remind_date = "";

 //index.phpで渡されたidの値
 if($_GET['id']){

  $host = "localhost";

  $user = "root";

  $pass = "clardpass555";

  $db = "reminder";


  $param = "mysql:dbname=".$db.";host=".$host;

  $pdo = new PDO($param, $user, $pass);

  $pdo->query('SET NAMES utf8;');


  $stmt = $pdo->prepare("SELECT * FROM reminder where id= :id");

  $stmt->bindValue(':id', $_GET["id"], PDO::PARAM_INT);

  $flag = $stmt->execute();


  $row = $stmt->fetch();

  $id = $row['id'];

  $title = $row['title'];

  $remind_date = $row['remind_date'];

  unset($pdo);


 }

?>


<html lang="ja">

  <head>

    <title>登録画面 | リマインダー</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  </head>

  <body>

    <h1>登録画面</h1>

    <form action="register.php" method="post">

      <input type="hidden" name="id" value="<?php echo $id ?>" />

      <table>

        <tr><td>タイトル</td><td><input type="text" name="title" value="<?php echo $title ?>" /></td></tr>

        <tr><td>期日</td><td><input type="text" name="remind_date" value="<?php echo $remind_date ?>" /></td></tr>

      </table>
      <p>*期日はYYYY-MM-DDの形で入力してください。(例:2016-07-22)</p>
      <input type="submit" value="登録" />

    </form>

  </body>

</html>
