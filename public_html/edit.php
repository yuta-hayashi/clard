<?php

 $id = "";

 $title = "";

 $subject = "";

 $remind_date = "";

 //index.phpで渡されたidの値
 if($_GET['id']){

//データーベース設定
  require_once dirname(__FILE__) . './dsn.php';
  $param = "mysql:dbname=".$dsn['dbname'].";host=".$dsn['host'];
  $pdo = new PDO($param, $dsn['user'], $dsn['pass']);
  $pdo->query('SET NAMES utf8;');

  $stmt = $pdo->prepare("SELECT * FROM reminder where id= :id");

  $stmt->bindValue(':id', $_GET["id"], PDO::PARAM_INT);

  $flag = $stmt->execute();

  $row = $stmt->fetch();

  $id = $row['id'];

  $title = $row['title'];

  $subject = $row['subject'];

  $remind_date = $row['remind_date'];

  unset($pdo);
 }

?>


<html lang="ja">

  <head>

    <title>登録画面 | リマインダー</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.js"></script>

  </head>

  <body>
    <h1>
  		<i class=" green checked calendar icon"></i>
  	Clard</h1>
    <h3>登録画面</h3>

    <form action="register.php" method="post" class="ui form">
      <input type="hidden" name="id" value="<?php echo $id ?>" />

      <dev class="field">
        <label>教科</label>
        <input type="text" name="subject" value="<?php echo $subject ?>" />
      </div>

      <dev class="field">
        <label>内容</label>
        <input type="text" name="title" value="<?php echo $title ?>" />
      </div>

      <dev class="field">
        <label>期日</label>
        <input type="text" name="remind_date" value="<?php echo $remind_date ?>" />
      </div>

      </div>
      <p>*期日はYYYY-MM-DDの形で入力してください。(例:2017-10-22)</p>
      <button class="ui green button" type="submit">登録</button>

    </form>
  </body>
</html>
