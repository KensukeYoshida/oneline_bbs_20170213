<?php
// ここにDBに登録する処理を記述する
$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

// echo $_POST['nickname'];

if (!empty($_POST)) { // 送信ボタンが押されたとき
		// 送信されたデータを登録する
		$sql = 'INSERT INTO `posts` SET `id`=NULL,
																		`nickname`=?,
																		`comment`=?,
																		`created`=NOW()
																		';
		$data = array($_POST['nickname'], $_POST['comment']);

		$stmt = $dbh->prepare($sql);
		$stmt->execute($data); // object型

		// ページのリロード処理
		header('Location: bbs_no_css.php');
		exit();
}

$sql = 'SELECT * FROM `posts` ORDER BY `created` DESC';
// ORDER BY句
// 指定したカラムの昇順(ASC)もしくは降順(DESC)でデータ取得順を指定する(初期設定ではidのASC)
$stmt = $dbh->prepare($sql);
$stmt->execute(); // object型

// 繰り返し処理
while (true) {
		$record = $stmt->fetch(PDO::FETCH_ASSOC); // array型
		if ($record == false) {
				break;
		}
		echo $record['nickname'] . ' - ' . $record['created'];
		echo '<br>';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->

</body>
</html>