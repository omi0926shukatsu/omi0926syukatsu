<!DOCTYPE html>
<html lang="ja">


<head>

<meta charset="UTF-8">
<link rel="stylesheet" href="mission_4.css" />
<link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">
 <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" />
<title>EXCITE</title>

<style type="text/css">
body{
margin:0px 0px 0px 0px;
}
</style>

</head>


<?php

/* データベース接続 */
$user = 'ユーザー名';
$password = 'パスワード';
$dsn = 'データベース名';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

/* テキストファイルの作成と保存 */
$filename = 'mission_4.txt';

/* 変数の用意 */
$name = $_POST["name"];
$class = $_POST["class"];
$reservation_date =  $_POST["reservation_date"];
$delete_number = $_POST["delete_number"];
$edit_number = $_POST["edit_number"];
$receive_edit_number = $_POST["receive_edit_number"];
$password = $_POST["password"];
$password_delete = $_POST["password_delete"];
$password_edit = $_POST["password_edit"];

	/* 変更ボタンが押された場合 */
	if($_POST["edit"]){
		/* 入力した文字が数字だった場合 */
		if(ctype_digit($edit_number)) {
		$sql = 'SELECT * FROM auto WHERE POST_ID = '.$edit_number ;
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
			foreach ($results as $row) {
			$password = $row['PASSWORD'];
        			if($password == $password_edit){
          			$class_edit = $row['CLASS'];
				$reservation_date_edit = $row['RESERVATION_DATE'];
          			$name_edit = $row['NAME'];
				}
			}
		}
	}
?>


<body><div id="body"><div id="photo">
<div class="title">EXCITE</div><br>
<div class="subtitle">Sweets & Baking School<br></div></div>

<div id="contants"><div class="index">Event</div><br>
<div class="text">今週（3月1日 ~ 3月7日）開講される教室です。<br><br>
クラス A　<font color=#ffffff><i class="fas fa-heart"></i></font>　10:00 ~ 13:00　<font color=#ffffff><i class="fas fa-heart"></i></font>　スコーン<br>
クラス B　<font color=#ffffff><i class="fas fa-heart"></i></font>　14:00 ~ 17:00　<font color=#ffffff><i class="fas fa-heart"></i></font>　カヌレ<br>
クラス C　<font color=#ffffff><i class="fas fa-heart"></i></font>　18:00 ~ 21:00　<font color=#ffffff><i class="fas fa-heart"></i></font>　アップルパイ</div><br><br>
<div class="index">Reservation</div><br>
<div class="text">予約はこちらから。<br>

<form method="POST" action="mission_4.php">
名前：<input type='text' name='name' value="<?php echo "$name_edit";?>">　
パスワード：<input type='text' name='password'></br>
<div id="select">日付：<select name='reservation_date' value="<?php echo "$reservation_date_edit";?>">
<option>3月1日</option><option>3月2日</option><option>3月3日</option><option>3月4日</option>
<option>3月5日</option><option>3月6日</option><option>3月7日</option></select>　
クラス：<select name='class' value="<?php echo "$class_edit";?>">
<option>A</option><option>B</option><option>C</option></select></br></div>
<input type='text' name='receive_edit_number' value="<?php echo "$edit_number";?>"  hidden='hiddened' >
<input type='submit' value='送信' name='submit'></br></br>

予約内容を変更したい方は下記フォームから予約番号とパスワードを送信してください。<br>
予約番号：<input type='text' name='edit_number'>　パスワード：<input type='text' name='password_edit'></br>
<input type='submit' value='変更' name='edit'></br></br>

予約を取り消したい方は下記フォームから予約番号とパスワードを送信してください。<br>
予約番号：<input type='text' name='delete_number'>　パスワード：<input type='text' name='password_delete'></br>
<input type='submit' value='取消' name='delete'></br></br>
</form>


<?php

/* 送信ボタンを押したとき */
if ($_POST["submit"]) {
	/* 予約変更 */
	/* 名前とパスワードと隠しフォームに値が入力されていた場合 */
	if(!empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["receive_edit_number"])){
	echo "予約内容を変更しました。<br>";
		/* 入力した文字が数字だった場合 */
		if (ctype_digit($receive_edit_number)) {
      		$sql = 'UPDATE auto SET NAME=:NAME,CLASS=:CLASS,PASSWORD=:PASSWORD,RESERVATION_DATE=:RESERVATION_DATE WHERE POST_ID= ' .$receive_edit_number ;
      		$stmt = $pdo -> prepare($sql);
      		$stmt -> bindParam(':NAME',$name, PDO::PARAM_STR);
      		$stmt -> bindParam(':CLASS', $class, PDO::PARAM_STR);
      		$stmt -> bindParam(':PASSWORD', $password, PDO::PARAM_STR);
      		$stmt -> bindParam(':RESERVATION_DATE', $reservation_date, PDO::PARAM_STR);
		$stmt -> execute();
    		}
	}
	/* 予約 */
	/* 名前とパスワードに値が入力されていた場合 */
	elseif(!empty($_POST["name"]) && !empty($_POST["password"]) && empty($_POST["receive_edit_number"])){
	echo "予約が完了しました。<br>";
    		/* データベース格納 */
    		$sql = $pdo -> prepare("INSERT INTO auto(NAME,CLASS,PASSWORD,RESERVATION_DATE) VALUES (:NAME, :CLASS ,:PASSWORD,:RESERVATION_DATE)");
		$sql -> bindParam(':NAME', $name, PDO::PARAM_STR);
    		$sql -> bindParam(':CLASS', $class, PDO::PARAM_STR);
    		$sql -> bindParam(':PASSWORD', $password, PDO::PARAM_STR);
    		$sql -> bindParam(':RESERVATION_DATE', $reservation_date, PDO::PARAM_STR);
    		$sql -> execute();
	}
}

/* 予約取消 */
/* 取消ボタンが押された場合 */
elseif(isset($_POST["delete"])){
echo "予約を取り消しました。<br>";
	/* 入力した文字が数字だった場合 */
	if (ctype_digit($delete_number)) {
	$sql = 'SELECT * FROM auto WHERE POST_ID = '.$delete_number ;
      	$stmt = $pdo->query($sql);
      	$results = $stmt->fetchAll();
      		foreach ($results as $row) {
		$password = $row['PASSWORD'];
			if($password == $password_delete){
          		$sql = 'delete from auto where post_id=:POST_ID';
      			$stmt = $pdo->prepare($sql);
      			$stmt->bindParam(':POST_ID',$delete_number, PDO::PARAM_INT);
      			$stmt->execute();
			}
		}
	}
}

?>


<?php

 $sql = 'SELECT * FROM auto';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
    echo $row['POST_ID']."　<font color=ffffff>│</font>　".$row['NAME']."　<font color=ffffff>│</font>　".$row['RESERVATION_DATE']."　<font color=ffffff>│</font>　クラス".$row['CLASS']."<br>";
    }

?></div><br>
<br>

<div class="index">Information</div><br>
<div class="text">教室所在地　<font color=#ffffff><i class="fas fa-heart"></i></font>　神奈川県横浜市神奈川区東神奈川7-77エキサイトビル7F<br>
教室開始年　<font color=#ffffff><i class="fas fa-heart"></i></font>　2019年<br>
教室連絡先　<font color=#ffffff><i class="fas fa-heart"></i></font>　XXX-XXX-XXXX<br>
代表者名　　<font color=#ffffff><i class="fas fa-heart"></i></font>　大見奈々
</div><br>
</div></div>
</body></html>