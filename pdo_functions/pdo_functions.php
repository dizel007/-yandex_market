<?php
 /*************************************************
 * Получаем токен для МП
 ****************************************************/
 function get_token_yam($pdo) {
   $stmt = $pdo->prepare("SELECT * FROM `tokens` WHERE `name_market` = 'yandex_anmaks_fbs'");
   $stmt->execute();
   $ya_token_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   $ya_token =  $ya_token_info[0]['token'];
return $ya_token;
}

 /*************************************************
 * Получаем id company для МП
 ****************************************************/
function get_id_company_yam($pdo) {
   $stmt = $pdo->prepare("SELECT * FROM `tokens` WHERE `name_market` = 'yandex_anmaks_fbs'");
   $stmt->execute();
   $ya_token_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
   $id_company =  $ya_token_info[0]['id_market'];
return $id_company;
}