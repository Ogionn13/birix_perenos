<?php
use classes\BitrixApi;

const ROOT = __DIR__;
require ROOT . "/classes/BitrixApi.php";
require ROOT . "/crest/crest.php";
require ROOT . "/classes/constants.php";


//old
//const C_REST_WEB_HOOK_URL = "https://b24-rhwin3.bitrix24.ru/rest/71/g3cld0zzgu2dv2ki/";
//$fname = 'dealFieldOld.json';

//new
const C_REST_WEB_HOOK_URL ="https://bitrix.ksmk.ru/rest/1/qd3jcfar8n465sh3/";
$fname = 'dealFieldNEW.json';

$bitApi = new BitrixApi();
$r = $bitApi::getDealField();

file_put_contents('data/example/'.$fname, json_encode($r, JSON_UNESCAPED_UNICODE));
