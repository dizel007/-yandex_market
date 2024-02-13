<?php
require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$orderId = 400376589;


/// Получаем информацию по заказу

$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId;
$result = get_query_without_data($ya_token, $ya_link);

$items_order = $result['order']['items']; // взяли перечень товаров из заказа
$item = $items_order[0];


////////////////////////////////////////////


$arr_one_gruz = array( "items" => array(
                                    array (
                                    "id" => 530277643,
                                    "fullCount"=> 1,
                                    )
                                  ));


$arr_boxes =  array ("boxes" => 
        array ($arr_one_gruz, 
                $arr_one_gruz,
                $arr_one_gruz, 
                $arr_one_gruz),

        "allowRemove" => false

 
);




echo "<pre>";
print_r($arr_boxes);


// die();


$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId.'/boxes';

$result = put_query_with_data($ya_token, $ya_link, $arr_boxes) ;





echo "<br><br>";

// $date_time = date (DATE_RFC3339);
// $date_time = str_replace(':', '-',$date_time);
// $rand = rand(1,10000);
// $file_link = 'json/'.$date_time.'_put_razbivaem_na_gruzomesta('.$rand.').json';
// file_put_contents($file_link , json_encode($result, JSON_UNESCAPED_UNICODE));

echo "<pre>";
print_r($result);


