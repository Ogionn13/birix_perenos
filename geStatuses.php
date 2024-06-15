<?php

use classes\BitrixApi;

const ROOT = __DIR__;
require ROOT."/classes/BitrixApi.php";
require ROOT."/crest/crest.php";
require ROOT."/classes/constants.php";

const C_REST_WEB_HOOK_URL ="https://b24-rhwin3.bitrix24.ru/rest/71/g3cld0zzgu2dv2ki/";
//const C_REST_WEB_HOOK_URL ="https://bitrix.ksmk.ru/rest/1/qd3jcfar8n465sh3/";

$bitApi = new BitrixApi();
$categoryID = 0;
//$d = BitrixApi::getCategory(\classes\EntityTypeID::DEAL, 35);
$d = BitrixApi::getStatusList(\classes\EntityTypeID::DEAL);
$result = [];
$d = $d['result'];

//$entityId = 'DEAL_STAGE';
$entityId = 'DEAL_STAGE_35';
//$entityId = 'DEAL_STAGE_41';
//$fname = "statusNEW.json";
$fname = "statusOLD_35.json";
//$fname = "statusOLD_41.json";

$r2 = [];
foreach ($d as $elem) {
    if ($elem['ENTITY_ID'] == $entityId){
        foreach (['SORT', 'SYSTEM', 'COLOR', 'EXTRA'] as $key){
            unset($elem[$key]);
        }
        $result[$elem['STATUS_ID']] = $elem;
        $r2[$elem['STATUS_ID']] = $elem['NAME'];
    }
    $result['total'] = $r2;
}

file_put_contents("data/example/$fname", json_encode($result, JSON_UNESCAPED_UNICODE));

