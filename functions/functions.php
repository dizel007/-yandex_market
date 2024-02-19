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


/********************************************************************************************
 ******************* Получаем все этикетки одного артикула 
 *************************************************************************************************/
function get_yarliki_odnogo_artikula ($ya_token, $arr_one_article, $dir) {
    $campaignId = 22076999;

    echo "<br> ЗАШЛИ В ФУНКЦИю<br>";

    // $orderId = 406532368;
    // $shipmentId = 401256724;
    // $boxId = 546260294;
  $count_items=0; 
  

    foreach ($arr_one_article as $items) {
        
        make_new_dir_z($dir."/".$items['offerId'],0); // создали директорию для временных файлов

        $orderId =  $items['id_order'];
        $shipmentId =  $items['id_shipment'];
        $boxId =  $items['boxe'];

    $ya_link = 'https://api.partner.market.yandex.ru/campaigns/'.$campaignId.'/orders/'.$orderId.
                '/delivery/shipments/'.$shipmentId.'/boxes/'.$boxId.'/label?PageFormatType=A4';
    
    $result = get_shrih_code($ya_token, $ya_link);
   
    $file_link = $dir."/".$items['offerId']."/".$items['offerId']."(".$count_items.').pdf';
     file_put_contents($file_link, $result);
    $count_items++;
 }


 echo "<br> ЗАКОНЧИЛИ РАЗБОР ШТРИХОК <br>";

  
 
    return $count_items;
}



/********************************************************************************************
 ******************* Формируем директории в папке для этикеток екселей зипов ****************************
 *************************************************************************************************/

 function make_all_dir ($date_query_yandex, $zakaz_1c_number) {
 $date_query_yandex = date('Y-m-d');
 $zakaz_1c_number = "3921";
 $new_path = 'reports/'.$date_query_yandex."/".$zakaz_1c_number."/";
 make_new_dir_z($new_path,0); // создаем папку с датой
 $path_etiketki = $new_path.'yarliki';
 make_new_dir_z($path_etiketki,0); // создаем папку с датой
 $path_excel_docs = $new_path.'excel_docs';
 make_new_dir_z($path_excel_docs,0); // создаем папку с датой
 $path_zip_archives = $new_path.'zip_archives';
 make_new_dir_z($path_zip_archives,0); // создаем папку с датой

 $arr_dir = array ("order_dir" =>  $new_path,
                    "yarliki" =>  $path_etiketki,
                    "excel_docs" =>  $path_excel_docs,
                    "zip_archives" =>  $path_zip_archives
 );
 return  $arr_dir;
 }
  

 function make_new_dir_z($dir, $append) {
     //    echo "<br>Создаем папку: $dir";
         if (!is_dir($dir)) {
             mkdir($dir, 0777, True);
         } 
     }        
     