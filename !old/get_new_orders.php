<?php

require_once "token/ya_tok.php";
require_once "functions/functions_yandex.php";

$campaignId = 22076999;
$substatus = 'substatus=STARTED';
$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/?'.$substatus ;

$result = get_query_without_data($ya_token, $ya_link);

// $result = json_decode(file_get_contents('json/xxxx.json'),true);
echo "<pre>";


foreach ($result['orders'] as $orders) {

    $arr_all_orders[] = $orders['id'];
    foreach ($orders['items'] as $items) {
        $arr_all_items[] = $items;

        $arr_sum_items[$items['offerId']]['id'] = $items['id'];

        $arr_sum_items[$items['offerId']]['count'] = @$arr_sum_items[$items['offerId']]['count'] + $items['count']; // количество
        $arr_sum_items[$items['offerId']]['offerName'] = $items['offerName'];

        $arr_sum_items[$items['offerId']]['buyerPriceBeforeDiscount'] = @$arr_sum_items[$items['offerId']]['buyerPriceBeforeDiscount'] + 
        $items['count']* $items['buyerPriceBeforeDiscount']; // сумма по артикулу
    }
    

}





print_r($arr_sum_items);






// $date_time = date (DATE_RFC3339);
// $date_time = str_replace(':', '-',$date_time);
// $rand = rand(1,10000);
// $file_link = 'json/'.$date_time.'_get_orders('.$rand.').json';
// // $file_link = 'json/xxxx.json';
 
// file_put_contents($file_link , json_encode($result, JSON_UNESCAPED_UNICODE));
// echo "<pre>";
print_r($result);

echo "<br>kfkdofkdofkd";
die('DIE');

