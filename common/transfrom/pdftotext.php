<?php 
if(php_sapi_name() != 'cli') exit("need cli\r\n");

define('WEB_ROOT', dirname(dirname(__DIR__)));
//$conn = mysql_connect('127.0.0.1', 'root', 'admin') or die('Could not connect: ' . mysql_error());;
$conn = mysql_connect('58.221.47.226', 'cliuser', 'croad_jml') or die('Could not connect: ' . mysql_error());;
mysql_select_db('yos', $conn);
mysql_query("set names utf8");

$query = mysql_query("SELECT p.* FROM (SELECT * FROM yos_book_pdf WHERE status=0 ORDER BY id DESC) AS p GROUP BY p.bid");
$pdf = mysql_fetch_array($query, MYSQL_ASSOC);

if(!$pdf) exit("no pdf need change\r\n");
$filename = WEB_ROOT.'/data/pdf/'.$pdf['fileurl'];
$bid = $pdf['bid'];


$query = mysql_query("SELECT * FROM yos_book_chapter WHERE bid=".$bid." AND is_change=0 ORDER BY dis ASC");
while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {

	$qu = mysql_query("SELECT * FROM yos_book_chapter WHERE bid=".$bid." AND dis>".$row['dis']." ORDER BY dis ASC LIMIT 1");
	$lastRet = mysql_fetch_array($qu, MYSQL_ASSOC);
	$l = $lastRet ? ' -l '.($lastRet['start_change']-1) : '';

	$qi = mysql_query("SELECT * FROM yos_book_chapter WHERE bid=".$bid." AND dis<".$row['dis']." ORDER BY dis DESC LIMIT 1");
	$preRet = mysql_fetch_array($qi, MYSQL_ASSOC);
	$page = $preRet ? $preRet['page']+$preRet['pagenum'] : 0;	

	$content = shell_exec('/usr/local/bin/pdftotext -f '.$row['start_change'].$l.' -nopgbrk '.$filename.' -');
	$oldContent = $content = mysql_real_escape_string($content, $conn);

	$i = 0;
	while($content != '' && $i < 100) {
		$i++;
		$text = subwords($content, 400);
		mysql_query("INSERT INTO yos_book_pages (bid, cid, num, content, words) values (".$bid.", ".$row['id'].", ".$i.", '".($text)."', ".wordCount($text).")");
		$content = str_replace($text, "", $content);
	}

	echo $i."\r\n";
	//mysql_real_escape_string(unescaped_string)
	//echo "UPDATE yos_book_chapter SET is_change=1, pagenum=".$i.", page=".$page.", content='".$oldContent."', ctime=".time().", mtime=".time()." WHERE id=".$row['id']."\r\n";
	mysql_query("UPDATE yos_book_chapter SET is_change=1, pagenum=".$i.", page=".$page.", content='".$oldContent."', ctime=".time().", mtime=".time()." WHERE id=".$row['id']);
}

mysql_query('UPDATE yos_book_pdf SET status=1 WHERE id='.$pdf['id']);


function wordCount($str = ""){
	$chinese_pattern = "/[\x{4e00}-\x{9fff}\x{f900}-\x{faff}]/u";
    $str = preg_replace("/[\x{ff00}-\x{ffef}\x{2000}-\x{206F}]/u", "", $str);
    return preg_match_all($chinese_pattern, $str, $match) + str_word_count(preg_replace($chinese_pattern, "", $str));
}

//从 $words 字符串中 截取前 $num 个单词 
function subwords($words, $num){
	
	$total_num = str_word_count($words);
	if($total_num <= $num) {
		return $words;
	} else {
		$pattern = '/([\S]+?[ ]+){'.$num.'}/';
		preg_match($pattern, $words, $out);
		return $out[0];
	}
}

function debug($value, $type=1, $rr=0) {
	if(is_array($value) || is_object($value)) {
		if($rr) {
			return print_r($value, true);
		} else {
			echo "<pre>";
			print_r($value);
		}
	} else {
		echo $value;
	}

	if($type) {
		exit;
	}
}



///opt/lampp/bin/php /home/foo/yos/common/transfrom/pdftotext.php

?>