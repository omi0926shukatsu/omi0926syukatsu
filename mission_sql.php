<meta charset="UTF-8">


<?php

/* データベース接続 */
$user = 'ユーザーネーム';
$password = 'パスワード';
$dsn = 'データベース名';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

/* テーブル作成 */
$sql = "CREATE TABLE IF NOT EXISTS auto"
."("
."POST_ID INT AUTO_INCREMENT PRIMARY KEY,"
."NAME TEXT,"
."CLASS TEXT,"
."RESERVATION_DATE TEXT,"
."PASSWORD TEXT"
.");";
$stmt = $pdo->query($sql);

/* テーブルの中身の確認 */
$sql = 'SHOW CREATE TABLE auto';
$result = $pdo->query($sql);
foreach($result as $row){
echo $row[1];
}
echo "<hr>";

/* 入力したデータの表示 */
$sql = 'SELECT * FROM auto';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach($results as $row){
	echo $row['POST_ID'].',';
	echo $row['NAME'].',';	
	echo $row['CLASS'].',';	
	echo $row['RESERVATION_DATE'].',';
	echo $row['PASSWORD'].'<br>';
}

?>
