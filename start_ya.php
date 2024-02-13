<?php 

require_once "token/ya_tok.php";
require_once "token/ya_const.php";
require_once "functions/functions_yandex.php";
require_once "functions/functions.php";

echo "<pre>";
$arr_all_new_orders = get_new_orders($ya_token, $campaignId);

// print_r($arr_all_new_orders);


foreach ($arr_all_new_orders['orders'] as $order) { // перебираем все новые заказы

    $orderId = $order['id']; // ID  выбранного заказа
    foreach ($order['items'] as $items) { // перебираем все товары из выбранного заказа
        $res[] = razbivaev_zakazi_po_gruzomestam ($ya_token, $campaignId, $orderId, $items);
    }
}


print_r($res);