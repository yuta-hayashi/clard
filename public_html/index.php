<?php
  
  $host = "localhost";
  
  $user = "root";
  
  $pass = "clardpass555";
  
  $db = "reminder";
 
 
 $param = "mysql:dbname=".$db.";host=".$host;
 
 $pdo = new PDO($param, $user, $pass);
 
 $pdo->query('SET NAMES utf8;');
 
 
 $sql = "SELECT * FROM reminder";
 
 $stmt = $pdo->query($sql);
 
?>

<html lang="ja">

 <head>
  
  <meta charset="UTF-8">
  
  <title>宿題一覧 | リマインダー</title>
 
 </head>
 
 
 <body>
  
  <h1>リマインダー | 宿題一覧</h1>
  
  <div style="width:100%;text-align:left;">
  
   <a href="edit.php">新規登録</a>
  
  </div>
  
  <table width="100%" border="1">
   
   <tr>
   
    <th>タイトル</th><th>期日</th><th></th>
   
   </tr>
   
   <?php
    
    //データがある分だけ一行ずつ取得しループ
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
     echo "<tr>";
     
     echo "<td>".$row['title']."</td>";
     
     echo "<td>".$row['remind_date']."</td>";
     
     echo "<td><a href=\"edit.php?id=".$row['id']."\">[変更]</a>&nbsp;<a href=\"delete.php?id=".$row['id']."\"
     onclick=\"return confirm('削除してもよろしいですか?')\">[削除]</a></td>";
     
     echo "</tr>";
    
    }
    
    //unset($pdo);
    
   ?>
  </table>
  
 </body>

</html>