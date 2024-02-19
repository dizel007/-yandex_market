<?php 
require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$orderId = 406532368;
$shipmentId = 401256724;
$boxId = 546260294;

$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId.
            '/delivery/shipments/'.$shipmentId.'/boxes/'.$boxId.'/label';



$result = get_shrih_code($ya_token, $ya_link);

$date_time = date (DATE_RFC3339);
$date_time = str_replace(':', '-',$date_time);

$rand = rand(1,10000);
$file_link = 'pdf/'.$date_time.'_take_gruz_nakleyka('.$rand.').pdf';

file_put_contents($file_link, $result);
echo "<pre>";
// print_r($result);

echo "<br>kfkdofkdofkd";
die('DIE');


