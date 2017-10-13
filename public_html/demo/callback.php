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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.js"></script>
</head>

<body>

  <div class="container">
    <div class="ui red message"><?php print $error; ?>
    <p>[～@gm.ishikawa-nct.ac.jp]のアカウントをご利用ください。</p>
  </div>

    <p><a href="<?php print $auth->create_oauth_url(); ?>"><button class="ui green button">ログインする</button></a></p>
  </div>
</body>
</html>
