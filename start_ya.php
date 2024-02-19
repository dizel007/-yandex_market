<?php 

require_once "token/ya_tok.php";
require_once "token/ya_const.php";
require_once "functions/functions_yandex.php";
require_once "functions/functions.php";
require_once "functions/functions.php";
require_once('libs/merge_pdf/fpdf_merge.php');
// Подключаем PHPExcel

require_once 'libs/PHPExcel-1.8/Classes/PHPExcel.php';
require_once 'libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
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
    $box_count = 0; // сдвиг номера грузометса, если несколько товаров в заказке
    $item_number = 0; // порядквый номер товаров, если их несколько
    $need_ship_date = $order['delivery']['shipments'][$item_number]['shipmentDate'];
    $id_shipment = $order['delivery']['shipments'][$item_number]['id'];
  
        if ($need_date == $need_ship_date)  {    /// выбор даты дня отгрузки
          
            foreach ($order['items'] as $items) { // перебираем все товары из выбранного заказа

                for ($i = 0; $i < $items['count'] ; $i++) { // перебираем все количество этого артикула, и разбиваем по грузоместам
                    $box_number = $box_count + $i;
                    $id_box = $order['delivery']['shipments'][$item_number]['boxes'][$box_number]['id']; // берем порядковый номер грузоместа

                    $arr_boxes_all[] =  
                        array ( "id_order" => $orderId,
                                "offerId" => $items['offerId'],
                                "itemsId" => $items['id'],
                                "offerName" => $items['offerName'],
                                "priceBeforeDiscount" => $items['priceBeforeDiscount'],
                                "id_shipment" => $id_shipment,
                                
                                "boxe" => $id_box,
                                "date_ship" => $need_ship_date,
                                "fullCount"=> 1,
                        );
                
                }
                $box_count=$box_number;
                $item_number ++; // добавляем следующий товар
            }
        }

}
foreach ($arr_boxes_all as $razbor_article) {
    $new_box_array [$razbor_article['offerId']][] = $razbor_article;
}


$arr_dir = make_all_dir (date('Y-m-d'), "007777") ;
print_r($new_box_array);

// Формируем папку с ярлыками 
// foreach ($new_box_array as $items) {

//    $count_pdf_file =  get_yarliki_odnogo_artikula ($ya_token, $items, $arr_dir['yarliki']);
   
// }

// Формируем ексель файл 

if (isset($new_box_array)) {
    // Создаем файл для 1С
    $xls = new PHPExcel();
    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    $i=1;
   //  echo "<pre>";
        foreach ($new_box_array as $key => $items) {
    // print_r($items);	
            $price = 0; // 
            foreach ($items as $item) {
                $price = $price +  $item['priceBeforeDiscount'];
            }
        $sheet->setCellValue("A".$i, $key);
        $sheet->setCellValue("C".$i, count($items));
        $sheet->setCellValue("D".$i, $price/count($items));
        $i++; // смешение по строкам
    
    }
    
    $objWriter = new PHPExcel_Writer_Excel2007($xls);
    $file_name_1c_list =  "3333_file_1C.xlsx";
   //  $objWriter->save("../EXCEL/".$file_name_1c_list);
    $objWriter->save($file_name_1c_list);
          
    } 


