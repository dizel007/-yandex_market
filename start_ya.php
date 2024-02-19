<?php 

require_once "token/ya_tok.php";
require_once "token/ya_const.php";
require_once "functions/functions_yandex.php";
require_once "functions/functions.php";

echo "<pre>";
$arr_all_new_orders = get_new_orders($ya_token, $campaignId);

print_r($arr_all_new_orders);

// die();

// foreach ($arr_all_new_orders['orders'] as $order) { // перебираем все новые заказы

//     $orderId = $order['id']; // ID  выбранного заказа
//     foreach ($order['items'] as $items) { // перебираем все товары из выбранного заказа
//         $res[] = razbivaev_zakazi_po_gruzomestam ($ya_token, $campaignId, $orderId, $items);
//     }
// }



///////////////////////////////// Формируем перечень заказов //////////////////////////////////////
$need_date = '20-02-2024';
$need_date = date('d-m-Y' , strtotime($need_date)); 


 
foreach ($arr_all_new_orders['orders'] as $order) { // перебираем все новые заказы
    $orderId = $order['id']; // ID  выбранного заказа
    $need_ship_date = $order['delivery']['shipments'][0]['shipmentDate'];
        if ($need_date == $need_ship_date)  {   
           foreach ($order['items'] as $items) { // перебираем все товары из выбранного заказа
               $items_order[] = $items;
            }
        }

}



print_r($items_order);