<?php
require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$orderId = 400201828;

$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/status-update';

echo "<br>";

$order_arr = 
    array(
            "id" => $orderId,
            "status" => "PROCESSING",
            "substatus" => "READY_TO_SHIP"
        );

$ya_data = array (
    "orders" => array ($order_arr)
    );



echo (json_encode($ya_data, JSON_UNESCAPED_UNICODE));


echo "<br><br>";

$result = post_query_with_data($ya_token, $ya_link, $ya_data);

echo "<br><br>";

$date_time = date (DATE_RFC3339);
$date_time = str_replace(':', '-',$date_time);
$rand = rand(1,10000);
$file_link = 'json/'.$date_time.'_put_oreder_in_ship('.$rand.').json';


file_put_contents($file_link , json_encode($result, JSON_UNESCAPED_UNICODE));
echo "<pre>";
print_r($result);


