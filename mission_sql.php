<meta charset="UTF-8">


<?php

/* �f�[�^�x�[�X�ڑ� */
$user = '���[�U�[�l�[��';
$password = '�p�X���[�h';
$dsn = '�f�[�^�x�[�X��';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

/* �e�[�u���쐬 */
$sql = "CREATE TABLE IF NOT EXISTS auto"
."("
."POST_ID INT AUTO_INCREMENT PRIMARY KEY,"
."NAME TEXT,"
."CLASS TEXT,"
."RESERVATION_DATE TEXT,"
."PASSWORD TEXT"
.");";
$stmt = $pdo->query($sql);

/* �e�[�u���̒��g�̊m�F */
$sql = 'SHOW CREATE TABLE auto';
$result = $pdo->query($sql);
foreach($result as $row){
echo $row[1];
}
echo "<hr>";

/* ���͂����f�[�^�̕\�� */
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
