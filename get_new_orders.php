<?php

require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$orderId = 400201828;


$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId;

$result = get_query_without_data($ya_token, $ya_link);

$date_time = date (DATE_RFC3339);
$date_time = str_replace(':', '-',$date_time);

$rand = rand(1,10000);
$file_link = 'json/'.$date_time.'_get_orders('.$rand.').json';
file_put_contents($file_link , json_encode($result, JSON_UNESCAPED_UNICODE));
echo "<pre>";
print_r($result);

echo "<br>kfkdofkdofkd";
die('DIE');

