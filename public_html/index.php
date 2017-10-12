<?php
		require_once(dirname(__FILE__).'/GoogleOAuth.php');
		
		$auth = new GoogleOAuth();
		date_default_timezone_set('Asia/Tokyo');

		$weekdays = array('日','月','火','水','木','金','土');

		$query = null;
		
		//デフォルトは3I
		$classname = '3I';


		if(isset($_COOKIE['class'])){
			$classname = $_COOKIE['class'];
		}

		if(isset($_POST['class'])){
			$classname = $_POST['class'];
		}
		
		if(!empty($classname)){
			if(preg_match_all('/^([12])(EM|AC)$/', $classname, $matches)){
				$query = '/^'.$matches[0][0].'|^'.$matches[1][0].'年専攻科$/';
			}else if(preg_match_all('/^([1-5])[MEICA]$/', $classname, $matches)){
				$query = '/^'.$matches[0][0].'|^'.$matches[1][0].'年全学科$/';
			}else if($classname=='ALL'){
				$query = '/.+/';
			}else{
				$classname = '';
			}
		}

		//データーベース設定
		$host = "localhost";
		$user = "root";
		$pass = "clardpass555";
		$db = "reminder";

	 $param = "mysql:dbname=".$db.";host=".$host;
	 $pdo = new PDO($param, $user, $pass);
	 $pdo->query('SET NAMES utf8;');
	 
	 $stmt = $pdo->prepare("SELECT * FROM reminder_".$classname);
	 $flag = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Clard&#32;&#946;</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.8/semantic.min.js"></script>

	<link rel="apple-touch-icon" size="152x152" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/favicon.png">

</head>

<body>

	<h1>
		<i class="green checked calendar icon"></i>
	Clard&#32;&#946;v2</h1>
	</h1>

	<div class="ui warning message">
  <div class="header">
	このウェブサービスは電子情報工学科のみ利用できます。
  </div>
  なお、ベータ版につき不具合が生じる場合があります。
</div>

<?php if($auth->is_logged_in()): ?>
	<div class="ui top attached tabular menu">
		 <a class="item active" data-tab="reminder">課題一覧</a>
	  <a class="item" data-tab="container">授業変更</a>
	  <a class="item" data-tab="time_table">授業時間割</a>

	</div>
	<div class="ui bottom attached tab segment" data-tab="container">
		<div id="container">


				<?php
					$email = $auth->get_email();

					$url = "./data.json";

					$json = file_get_contents($url,true);

					if($json==false){
						error("load error");
						return;
					}

					$obj = json_decode($json,true);

					$count = 0;
				?>

				<?php if(is_null($query)): ?>
					<div class="page-header">
							<h1>授業変更</h1>
							<h3>下のメニューからクラスを選択してください</h3>
						</div>

				 <?php else: ?>
					<div class="ui visible message">
							<div class="header">授業変更 <?php print empty($classname)?'':'('.$classname.')'; ?></div>
							<p><?php echo date($obj['update'])." 更新"; ?></p>
						</div>

					<div>
						<ul class="ui cards">
							<?php foreach ($obj['changes'] as $key => $value): ?>
								<?php if(is_null($query) || preg_match($query, $value['class'])): ?>
									<li class="card">
										<div class="content">
											<div class="header">
												<?php echo htmlspecialchars($value['date']).' ('.$weekdays[date("w",strtotime($value['date']))].')'; ?>
											</div>
											<div class="meta">
												<?php echo htmlspecialchars($value['time']) ?>限
												<?php echo htmlspecialchars($value['class']) ?>
											</div>
											<h3 class="description">
												<?php if(time()-$value['create']<60*60*24): ?>
													<span class="label label-default">New</span>
												<?php endif; ?>
											</h3>
											<p>
												<span class="subject"><?php $tmp = $value['from']; echo htmlspecialchars($tmp); ?></span>
												<span>→</span>
												<span class="subject"><?php $tmp = $value['to']; echo htmlspecialchars($tmp); ?></span>
											</p>
											<?php
												$tmp = $value['note'];
												if(!empty($tmp)): ?>
												<p><?php echo htmlspecialchars($value['note']); ?></p>
											<?php endif; ?>
										</div>
									</li>
									<?php $count++; ?>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php if($count==0): ?>

								  <div class="card">
								    <div class="content">
								      <div class="description">授業変更がありません</div>
								    </div>
								  </div>

							<?php endif; ?>
						</ul>
					</div>
				<?php endif; ?>



		</div>
	</div>


	<div class="ui bottom attached tab segment active" data-tab="reminder">
		<div id="reminder">
		  <button class="ui button" onclick="location.href='./edit.php?class=<?php echo $classname; ?>'">新規登録</button>
		  <div style="width:100%;text-align:left;">
		  </div>
			<br />
		<?php
		$kadai=0;
				echo "  <div class='ui cards'>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		    echo "<div class='card'>";
		      echo "<div class='content'>";
		        echo "<div class='header'>".
		          $row['subject'].
		        "</div>";

		        echo "<div class='meta'>"
		          .$row['remind_date'].
		        "</div>";
		        echo "<div class='meta'>最終更新者: ".$row['_user']."</div>";
		        echo "<div class='description'>"
		          .$row['title'].
		        "</div>
		      </div>";
		      echo "最終更新者: ".$row['_user'];
		      
		      echo "<div class='extra content'>
		        <div class='ui two buttons'>
		          <div class='ui basic green button' onclick='location.href=\"edit.php?id=".$row['id']."&class=".$classname."\"'>変更</div>
		          <div class='ui basic red button'
		          onclick=\"return confirm('削除してよろしいですか？') && (location.href='delete.php?id=".$row['id']."&class=".$classname."') || false\">削除</div>";
		      }

		echo "
		      </div>
		    </div>
		    </div>";
				$kadai++;
		
		if ($kadai==0) {
			echo "<h4>課題は登録されていません。</h4>";
		}
		?>
	  </div>
	</div>
</div>
<div class="ui bottom attached tab segment" data-tab="time_table">
		<div id="time_table">
			<?php
				 
				include($classname.".html"); 
			?>
		</div>
	</div>
<!--<span>クラス</span>
			<select name="class" id="changeclass">
				<?php
					foreach(array('1M','1E','1I','1C','1A','2M','2E','2I','2C','2A','3M','3E','3I','3C','3A','4M','4E','4I','4C','4A','5M','5E','5I','5C','5A','1EM','1AC','2EM','2AC','ALL') as $name){
							echo "<option value=\"".$name."\">".$name."</option>";
					}
				?>-->
			</select>

	<!--タブの動作-->
		<script type="text/javascript">
		$('.menu .item').tab() ;
	</script>


	<?php if($auth->is_logged_in()): ?>
		<footer class="ui  vertical footer segment">
		  <div class="container">
		    <div class="ui form">
		    	<div class="field">
		   		<span>クラス</span>
				<select name="class" id="changeclass">
					<option selected>選択してください</option>
					<?php
						foreach(array('1I','2I','3I','4I','5I') as $name){
							echo "<option value=\"".$name."\">".$name."</option>";
						}
					?>
					<!--'1M','1E','1I','1C','1A','2M','2E','2I','2C','2A','3M','3E','3I','3C','3A','4M','4E','4I','4C','4A','5M','5E','5I','5C','5A','1EM','1AC','2EM','2AC','ALL' -->
				</select>
				<span class="login_info">
					<span class="hidden-xs"><?php $tmp=explode('@', $email); print $tmp[0]; ?> でログイン中</span>
					<a href="./logout.php">ログアウト</a>
				</span>
			</div>
			</div>
		  </div>
		</footer>
		<script src="./js/jquery.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./js/main.js"></script>
	<?php endif;  ?>

<?php else: ?>

	<php header( "Location: http://localhost/timetable/logout.php" ) ;
	exit ; ?>

<div class="ui middle aligned center aligned grid">
	<h2>ログイン</h2>
	<h3>学校のGmailアカウントを使ってログインしてください</h3>


	<a href="<?php print $auth->create_oauth_url(); ?>"><button class="ui green button">ログインする</button></a>
</div>

<?php endif;  ?>

<script type="text/javascript" src="./js/changeclass.js"></script>
</body>
</html>
