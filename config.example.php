<?php

$C['sendFB'] = true;
$C['FBtoken'] = 'Facebook_User_Access_Token';
$C['FBAPI'] = 'https://graph.facebook.com/v2.8/';

$C['sendTG'] = false;
$C['TGtoken'] = 'Telegram_Access_Token';
$C['TGAPI'] = 'https://api.telegram.org/bot'.$C['TGtoken'].'/';
$C['TGchatid'] = 'Telegram_Chat_ID';

$C['allowsapi'] = array('cli');

$C['cookiepath'] = __DIR__.'/cookie.txt';
$C['datapath'] = __DIR__.'/data.json';

$C['url1'] = 'http://140.127.113.231/kuas/perchk.jsp';
$C['url2'] = 'http://140.127.113.231/kuas/ag_pro/ag008.jsp';

$C['uid'] = 'YOUR_USER_ID';
$C['pwd'] = 'YOUR_PASSWORD';
$C['year'] = 'YEAR';
$C['semester'] = 'SEMESTER';
