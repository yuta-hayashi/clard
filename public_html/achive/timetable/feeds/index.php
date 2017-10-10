<?php 	
		require_once(dirname(__FILE__) .'/../GoogleOAuth.php');
		date_default_timezone_set('Asia/Tokyo');

		$weekdays = array('日','月','火','水','木','金','土');

		$auth = new GoogleOAuth();

		if(!$auth->is_logged_in()){
			if($auth->has_refresh_token()){
				$auth->re_oauth();
			}
		}

		$query = null;
		$classname = '';

		
		if(isset($_COOKIE['class'])){
			$classname = $_COOKIE['class'];
		}
		
		if(isset($_GET['class'])){
			$classname = $_GET['class'];
		}

		if(!empty($classname)){
			if(preg_match_all('/^([12])(EM|AC)$/', $classname, $matches)){
				$query = '/^'.$matches[0][0].'|^'.$matches[1][0].'年専攻科$/';
			}else if(preg_match_all('/^([1-5])[MEICA]$/', $classname, $matches)){
				$query = '/^'.$matches[0][0].'|^'.$matches[1][0].'年全学科$/';
			}else{
				$classname == 'ALL';
				$query = '/.+/';
			}
		}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>授業変更確認システム フィード</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/sticky-footer.css" rel="stylesheet">
</head>

<body>

	<div class="container">

		<?php if($auth->is_logged_in()): ?>
			<?php
				$email = $auth->get_email();

				echo $email."でログイン中";


			?>

			<a href="./timetable.rss.php">RSS</a>

		<?php else: ?>
			<div class="page-header">
		   		<h1>授業変更確認システム </h1>
		  	</div>
			<h2>ログイン</h2>

			<p>学校のGmailアカウントを使ってログインしてください</p>

			<a href="<?php print $auth->create_oauth_url(); ?>"><button class="btn btn-primary">ログインする</button></a>
			
		<?php endif;  ?>
	
	</div>

	<?php if($auth->is_logged_in()): ?>
		<footer class="footer">
		  <div class="container">
		    <div class="text-muted">
		   		<span>クラス</span>
				<select name="class" class="class">
					<option selected>選択してください</option>
					<?php 
						foreach(array('1M','1E','1I','1C','1A','2M','2E','2I','2C','2A','3M','3E','3I','3C','3A','4M','4E','4I','4C','4A','5M','5E','5I','5C','5A','1EM','1AC','2EM','2AC','ALL') as $name){
							echo "<option value=\"".$name."\">".$name."</option>";
						} 
					?>
				</select>
				<span class="login_info">
					<span class="hidden-xs"><?php $tmp=explode('@', $email); print $tmp[0]; ?> でログイン中</span>
					<a href="./logout.php">ログアウト</a>
				</span>
			</div>
		  </div>
		</footer>
		<script src="./js/jquery.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./js/main.js"></script>
	<?php endif;  ?>

</body>
</html>