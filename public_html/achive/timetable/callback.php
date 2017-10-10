<?php
  require_once('./GoogleOAuth.php');

  $auth = new GoogleOAuth();

  $error = "";

  if(isset($_GET['code'])){
    $result = $auth->auth();
    if($result==0){
      header("Location: ./");
    }else{
      switch ($result) {
        case 1:
          $error = "無効なURLです。";
          break;
        case 2:
          $error = "無効なURLです。";
          break;
        case 3:
          $error = "認証に失敗しました";
        break;
        case 4:
          $error = "認証に失敗しました";
          break;
        case 5:
          $error = "このメールアドレスは許可されていません";
          break;
        default:
          $error = "何らかのエラーが発生しました";
          break;
      }
    }
  }else{
    $error = "無効なURLです。";
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>授業変更確認システム</title>
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <link href="./css/sticky-footer.css" rel="stylesheet">
</head>

<body>

  <div class="container">
    <p><?php print $error; ?></p>
    <p>再度ログインしてください</p>
    <p><a href="<?php print $auth->create_oauth_url(); ?>"><button class="btn btn-primary">ログインする</button></a></p>
  </div>
</body>
</html>
