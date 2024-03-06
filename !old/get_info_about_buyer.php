<?php

require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$orderId = 400201828;


$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId.'/business-buyer';
                  

            
$ya_data='';

// $result = get_query_without_data($ya_token, $ya_link);
$result = post_query_with_data_111($ya_token, $ya_link, '');

$date_time = date (DATE_RFC3339);
$date_time = str_replace(':', '-',$date_time);

$rand = rand(1,10000);
$file_link = 'json/'.$date_time.'_get_info_about_buyer('.$rand.').json';
file_put_contents($file_link , json_encode($result, JSON_UNESCAPED_UNICODE));
echo "<pre>";
print_r($result);

echo "<br>kfkdofkdofkd";
die('DIE');

/****************************************************************************************************************
**************************** Простой запрос на YANDEX с данными **************************************
****************************************************************************************************************/

function post_query_with_data_111($ya_token, $ya_link, $ya_data){
	$ch = curl_init($ya_link);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer '.$ya_token,
		'Content-Type:application/json'
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ya_data, JSON_UNESCAPED_UNICODE)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	
	$res = curl_exec($ch);
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код
	curl_close($ch);

	if (intdiv($http_code,100) > 2) {
		echo     'Результат обмена(with Data): '.$http_code. "<br>";
	
		}
	
	$res = json_decode($res, true);
	// var_dump($res);
	return $res;

}