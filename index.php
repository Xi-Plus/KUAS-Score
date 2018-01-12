<?php
require(__DIR__.'/config.php');
if (!in_array(PHP_SAPI, $C["allowsapi"])) {
	exit("No permission");
}

require(__DIR__.'/curl.php');

$post = array(
	"uid" => $C["uid"],
	"pwd" => $C["pwd"]
);
$res = cURL($C["url1"], $post, $C["cookiepath"]);
if ($res === false) {
	exit("fetch fail\n");
}

$post = array(
	"arg01" => $C["year"],
	"arg02" => $C["semester"]
);
$res = cURL($C["url2"], $post, $C["cookiepath"]);
if ($res === false) {
	exit("fetch fail\n");
}
$res = html_entity_decode($res);

$data = file_get_contents($C["datapath"]);
$data = json_decode($data, true);
$message = "";

if (preg_match_all("/<td align=left>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)/", $res, $m)) {
	foreach ($m[0] as $key => $value) {
		$class = trim($m[1][$key], " \t\n\r\0\x0B\xC2\xA0");
		$score = (int)(trim($m[7][$key], " \t\n\r\0\x0B\xC2\xA0"));
		if (!isset($data[$class])) {
			$data[$class] = $score;
		} else if ($data[$class] != $score) {
			echo $class." update to ".$score."\n";
			$data[$class] = $score;
			$message .= $class." 的成績已公布\n";
		} else {
			echo $class." is ".$score."\n";
		}
	}
} else {
	echo "match fail 1\n";
}

if (preg_match("/操行成績：(.*?)　　　　總平均：(.*?)　　　　班名次\/班人數：(.*?)\/.*?　　　　班名次百分比：(.*?)%/", $res, $m)) {
	$name = ["", "操行成績", "總平均", "班名次", "班名次百分比"];
	for ($i=1; $i <= 4; $i++) {
		$class = $name[$i];
		$score = $m[$i];
		if (!isset($data[$class])) {
			$data[$class] = $score;
		} else if ($data[$class] != $score) {
			echo $class." update to ".$score."\n";
			$data[$class] = $score;
			$message .= $class." 已公布\n";
		} else {
			echo $class." is ".$score."\n";
		}
	}
} else {
	echo "match fail 2\n";
}

file_put_contents($C["datapath"], json_encode($data, 256));

if ($message != "") {
	$message .= "\n本貼文是程式自動發送，由 https://github.com/Xi-Plus/KUAS-Score 驅動";
	$post = array(
		"message" => $message,
		"access_token" => $C['FBtoken']
	);
	$res = cURL($C['FBAPI']."me/feed", $post);
}
