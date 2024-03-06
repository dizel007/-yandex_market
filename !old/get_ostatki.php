<?php


require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$orderId = 400201828;


$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/offers/stocks';


$ya_data =array (
    "withTurnover" => false,
    "archived" => '',
    "offerIds"=> 
            array ("82400-к", 
                   "82402-ч",
                   )
);

$result = post_query_with_data($ya_token, $ya_link, $ya_data);

$date_time = date (DATE_RFC3339);
$date_time = str_replace(':', '-',$date_time);

$rand = rand(1,10000);
$file_link = 'json/'.$date_time.'_get_ostatki_na_sklade('.$rand.').json';
file_put_contents($file_link , json_encode($result, JSON_UNESCAPED_UNICODE));
echo "<pre>";
print_r($result);

echo "<br>OSTATKI";
die('DIE');
