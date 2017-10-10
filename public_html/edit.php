<?php

 $id = "";

 $title = "";

 $subject = "";

 $remind_date = "";

 //index.phpで渡されたidの値
 if(isset($_GET['id'])){

  $host = "localhost";

  $user = "root";

  $pass = "clardpass555";

  $db = "reminder";


  $param = "mysql:dbname=".$db.";host=".$host;

  $pdo = new PDO($param, $user, $pass);

  $pdo->query('SET NAMES utf8;');

  $classname = $_GET['class'];
  
  $stmt = $pdo->prepare("SELECT * FROM reminder_".$classname." where id= :id");

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

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Datepicker - Default functionality</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
$( function() {
  $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd' });
} );
</script>

  </head>

  <body>

    <h1 class="ui green ">
        <i class="green checked calendar icon"></i>
  	Clard</h1>

    <h3 class="ui dividing header">登録画面</h3>

    <div class="ui container">
      <div class="ui segments">
    <form action="register.php?>" method="post" class="ui form">
      
      <input type="hidden" name = "class" value = "<?php echo $_GET['class']; ?>" />
      
      <input type="hidden" name="id" value="<?php echo $id ?>" />

      <div class="field">
        <label>教科</label>
        <input type="text" name="subject" value="<?php echo $subject ?>" />
      </div>

      <div class="field">
        <label>内容</label>
        <input type="text" name="title" value="<?php echo $title ?>" />
      </div>

      <dev class="field">
        <label>期日</label>
        <input type="text" id="datepicker" name="remind_date" value="<?php echo $remind_date ?>"/>
      </div>
    </div>
    </div>

      <button class="ui green button" type="submit">登録</button>

    </form>

  </body>

</html>
