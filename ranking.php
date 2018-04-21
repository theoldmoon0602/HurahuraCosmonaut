<?php
/*
 * RC4 symmetric cipher encryption/decryption
 *
 * @license Public Domain
 * @param string key - secret key for encryption/decryption
 * @param string str - string to be encrypted/decrypted
 * @return string
 */
function rc4($key, $str) {
	$s = array();
	for ($i = 0; $i < 256; $i++) {
		$s[$i] = $i;
	}
	$j = 0;
	for ($i = 0; $i < 256; $i++) {
		$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
	}
	$i = 0;
	$j = 0;
	$res = '';
	for ($y = 0; $y < strlen($str); $y++) {
		$i = ($i + 1) % 256;
		$j = ($j + $s[$i]) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
		$res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
	}
	return $res;
}

$pdo = new PDO('sqlite:data.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
if (isset($_POST['data'])) {
	$ary = explode("-", $_POST['data']);
	$len = intval($ary[0]);
	$a = substr($ary[1], 0, $len);
	$b = substr($ary[1], $len);

	$c = rc4('myon', base64_decode($b));
	$d = rc4('nyarn' . $b , base64_decode($a));

	if (is_numeric($d)) {
		$c = mb_convert_encoding($c, 'UTF-8', 'SJIS');

		$stmt = $pdo->prepare('INSERT INTO scores(name, score) values (?, ?)');
		$stmt->execute([$c, $d]);
	}
}
$data = $pdo->query('select * from scores order by score desc')->fetchAll();
$datas = [];
foreach ($data as $v) {
	$datas []= str_replace(",", "", $v['name']);
	$datas []= str_replace(",", "", $v['score']);
}


echo implode(',', $datas);
?>
