<?php

use classes\BitrixApi;

const ROOT = __DIR__;
require ROOT."/classes/BitrixApi.php";
require ROOT."/crest/crest.php";
require ROOT."/classes/constants.php";
//const C_REST_WEB_HOOK_URL ="https://bitrix.ksmk.ru/rest/1/qd3jcfar8n465sh3/";
const C_REST_WEB_HOOK_URL = "https://b24-rhwin3.bitrix24.ru/rest/71/g3cld0zzgu2dv2ki/";

$bitApi = new BitrixApi();
$id_smart = 180;
//$entity = 343;
//$d = BitrixApi::getSmart($id_smart, $entity);

$field = [
    'title' => 'Тест смарт продаж',
    'assigned_by_id' => 21,
    'parentId2' => 36309, // тип - список, 57 - ID одного из вариантов списка
    "categoryId"=>13,
      "opened" => "Y",
      "stageId"=>"DT180_13:SUCCESS",
];
$d = BitrixApi::addSmart($id_smart, $field);
file_put_contents('smart2.json', json_encode($d, JSON_UNESCAPED_UNICODE));


var_dump($d);