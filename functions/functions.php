<?php

/********************************************************************************************
 * ****************** Вычитываем все новые заказы с ЯНДЕКСА
 *************************************************************************************************/
function get_new_orders($ya_token, $campaignId) {

$substatus = 'substatus=STARTED';
$ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/?'.$substatus ;

$result = get_query_without_data($ya_token, $ya_link);

return $result;
}



/********************************************************************************************
 ******************* Разбиваем заказы по грузоместаи 
 *************************************************************************************************/
function razbivaev_zakazi_po_gruzomestam ($ya_token, $campaignId, $orderId, $item_from_order) {
echo $orderId;
echo "<br>";
echo $campaignId;
echo "<br>";
echo "<pre>";
print_r ($item_from_order);

for ($i = 0; $i < $item_from_order['count'] ; $i++) { // перебираем все количество этого артикула, и разбиваем по грузоместам
$arr_one_gruz_place['items'][0] =  
    array ("id" => $item_from_order['id'],
           "fullCount"=> 1,
    );
$arr_boxes_all["boxes"][] = $arr_one_gruz_place;
}


$arr_boxes_all["allowRemove"] = false; // добавляем параметр, что мы ничего из поставки не удаляем.

print_r($arr_boxes_all);


    $ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId.'/boxes';
$res = put_query_with_data($ya_token, $ya_link, $arr_boxes_all) ;


    
    return $res;
    }
