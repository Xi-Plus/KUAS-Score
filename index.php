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

$post = array(
	"arg01" => $C["year"],
	"arg02" => $C["semester"]
);
$res = cURL($C["url2"], $post, $C["cookiepath"]);
$res = html_entity_decode($res);
preg_match_all("/<td align=left>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)<\/td><td>([^<]+)/", $res, $m);

$data = file_get_contents($C["datapath"]);
$data = json_decode($data, true);
$message = "";
foreach ($m[0] as $key => $value) {
	$class = trim($m[1][$key]);
	$score = (int)(trim($m[7][$key]));
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

if ($message != "") {
	$post = array(
		"message" => $message,
		"access_token" => $C['FBtoken']
	);
	$res = cURL($C['FBAPI']."me/feed", $post);
	file_put_contents($C["datapath"], json_encode($data, 256));
}
