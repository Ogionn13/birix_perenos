<?php

use classes\BitrixApi;

const ROOT = __DIR__;
require ROOT . "/classes/BitrixApi.php";
require ROOT . "/Bitrix_Crest/crest_new/crest.php";
require ROOT . "/Bitrix_Crest/crest_old/crest.php";
require ROOT . "/classes/constants.php";
require ROOT. "/classes/PerenosLogManager.php";
require ROOT. "/classes/InfoFileManager.php";
require ROOT . "/classes/CsvData.php";



$bitApi = new BitrixApi();

//получение сущностей (сделки , смартпроцессы и тп)
//$entityTypes_Old = $bitApi::getEntityTypes();
//$entityTypes_NEW = $bitApi::getEntityTypes('new');
//$fname_old = "data/structure/entity_types_old.json";
//$fname_new = "data/structure/entity_types_new.json";
//file_put_contents($fname_old, json_encode($entityTypes_Old, JSON_UNESCAPED_UNICODE));
//file_put_contents($fname_new, json_encode($entityTypes_NEW, JSON_UNESCAPED_UNICODE));


//получение стадий NB! не зависимо от констаты получает стадии всех сущностей
//$fname_logist_old = "data/structure/stages_old.json";
//$fname_logist_new = "data/structure/stages_new.json";
//
//$stages_lg_old = BitrixApi::getStatusList();
//$stages_lg_new = BitrixApi::getStatusList( "new");
//file_put_contents($fname_logist_old, json_encode($stages_lg_old, JSON_UNESCAPED_UNICODE));
//file_put_contents($fname_logist_new, json_encode($stages_lg_new, JSON_UNESCAPED_UNICODE));


//получение полей сущности
//$fname_logist_fields_old = "data/structure/fields_smart_lg_old.json";
//$fname_logist_fields_new = "data/structure/fields_smart_lg_new.json";
//
//$fname_urist_fields_old = "data/structure/fields_smart_ur_old.json";
//$fname_urist_fields_new = "data/structure/fields_smart_ur_new.json";
//
//$stages_lg_old_fields = BitrixApi::getSmartFields(\classes\EntityTypeID::LOGIST_OLD);
//$stages_lg_new_fields = BitrixApi::getSmartFields(\classes\EntityTypeID::LOGIST_NEW, 'new');
//
//$stages_ur_old_fields = BitrixApi::getSmartFields(\classes\EntityTypeID::URIST_OLD);
//$stages_ur_new_fields = BitrixApi::getSmartFields(\classes\EntityTypeID::URIST_NEW, 'new');
//
//file_put_contents($fname_logist_fields_old, json_encode($stages_lg_old_fields, JSON_UNESCAPED_UNICODE));
//file_put_contents($fname_logist_fields_new, json_encode($stages_lg_new_fields, JSON_UNESCAPED_UNICODE));
//file_put_contents($fname_urist_fields_old, json_encode($stages_ur_old_fields, JSON_UNESCAPED_UNICODE));
//file_put_contents($fname_urist_fields_new, json_encode($stages_ur_new_fields, JSON_UNESCAPED_UNICODE));


//получение пользователей
//
//$lastName = ['Кондратенко', 'Чернобровкина', 'Бакланов', 'Дьяченко', 'Павлова', 'Подрезова', "Павлов", "Снежко", "Евремова"];
//$lastName2 = ["Павлов", "Снежко", "Евремова"];
//$ind = 0;
//foreach ($lastName2 as $name) {
//    $userData = $bitApi::getUserByLastName($name);
//    $user2Data = $bitApi::getUserByLastName($name, "new");
//    $u = $userData['result'];
//    $u2 = $user2Data['result'];
//    foreach ($u as $user){
//        echo "Name = {$user['NAME']}, surname = {$user['LAST_NAME']} ID == {$user['ID']}\r\n";
//    }
//
//    foreach ($u2 as $user){
//        echo "NEW = Name = {$user['NAME']}, surname = {$user['LAST_NAME']} ID == {$user['ID']}\r\n";
//    }
//
//}

$user2Data = $bitApi::getProduct();
file_put_contents('datapr22.json', json_encode($user2Data, JSON_UNESCAPED_UNICODE));
var_dump($user2Data);