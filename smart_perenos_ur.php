<?php
use classes\BitrixApi;

const ROOT = __DIR__;
require ROOT . "/classes/BitrixApi.php";
require ROOT . "/Bitrix_Crest/crest_new/crest.php";
require ROOT . "/Bitrix_Crest/crest_old/crest.php";
require ROOT . "/classes/constants.php";
require ROOT. "/classes/PerenosLogManager.php";
require ROOT. "/classes/InfoFileManager.php";
require ROOT. "/classes/TranslaterIDs.php";
require ROOT . "/classes/CsvData.php";

$csvFile = ROOT."/dataoldBitrix/юр.отдел.csv";
$fileLogPerenos = ROOT . "/process/smarts_add.json";

$logPerenos =new \classes\PerenosLogManager($fileLogPerenos);


$handle = fopen($csvFile, "r");
$headers = fgetcsv($handle, 0, ";");

//const ID_SMART_OLD = 136;
//const ID_SMART_LOGISTIC_NEW = 163;
//
$csvFileLeadNew = ROOT."/dataBitrixCSV/сделки из коробки.csv";
$csvDataNewLead = new CsvData($csvFileLeadNew, ROOT."/dataBitrixCSV/leadNewHead.json");

$csvFileLeadOld = ROOT."/dataBitrixCSV/сделки из облака 1.csv";
$csvDataOldLead = new CsvData($csvFileLeadOld, ROOT."/dataBitrixCSV/leadOldHead.json");
//
//$csvFileOldSmartLogists = ROOT."/dataBitrixCSV/логисты.csv";
//$csvDataOldSmartLogists = new CsvData($csvFileOldSmartLogists,ROOT."/dataBitrixCSV/logistHead.json");
//
//$smartLead = new \classes\InfoFileManager(ROOT."/process/OldSmartLead.json");
//$smartProcess = new \classes\InfoFileManager(ROOT."/process/NEWsmarts.json");
//
//$translater = new \classes\TranslaterIDs();
////$smartDealOld_New = new \classes\InfoFileManager(ROOT."/process/SMART_DEAL_OLD_NEW.json");
//
//
////получаем из коробки массив сделок которые упомянуты в смарт процессох для работы только с ним
//echo $csvDataOldLead->count() ."\r\n";
//$csvDataOldLead->cleanDealWithoutSmart($smartLead->getData());
//echo $csvDataOldLead->count() ."\r\n";
//
//$smartsIds_lg = $smartLead->getData();
//
//$smartsIds_lg = [1329=>30877];
////$dealNew = $csvDataOldSmartLogists->findIDNewLeadBy(
////
////);
//
//$count_zero= 0;
//$count_one =0;
//
//foreach ($smartsIds_lg as $smartId=>$dealOldId) {
//    $smartRow = $csvDataOldSmartLogists->getRowByID($smartId);
//    $dealOldRows = $csvDataOldLead->getAllRowByID($dealOldId);
//
//    $dealNew = $csvDataNewLead->findIDNewLead($smartId,  $dealOldId);
//    if ($dealNew) {
//        $smartData =  BitrixApi::getSmart(ID_SMART_OLD, $smartId);
//
//        $smart =  $smartData['result']['item'];
//
//    $fName = $csvDataOldSmartLogists->getValueByIDAndPos($smartId, CsvData::INDEX_SMART_LG_FILE);
//
//    $field = [
//    'title' => $smart['title'],
//    'assigned_by_id' =>$translater->getNewUserId($smart['assigned_by_id']),
//    'parentId2' => $dealNew,
//    "stageId"=> $translater->getNewSTAGE_LG($smart['stageId']),
//    ];
//    if ($smart['opportunity']){
//        $field['opportunity'] =  $smart['opportunity'];
//    }
//
//    if ($fName) {
//        $file = file_get_contents($fName);
//        $base64_f = base64_encode($file);
//        $arFile = [
//            "fileData" => [
//                basename($fName),
//                $base64_f
//            ]
//        ];
//        $field['ufCrm5_1691762747'] =  $arFile;
//    }
//    if ($smart['ufCrm5_1691762774']){
//        $field['ufCrm5_1691762774'] =  $translater->getNew1691762774($smart['ufCrm5_1691762774']);
//    }
//
//    if ($smart['ufCrm5_1691762801']){
//        $field['ufCrm5_1691762801'] =  $smart['ufCrm5_1691762801'];
//    }
//
//    if ($smart['ufCrm5_1691762813']){
//        $field['ufCrm5_1691762813'] =  $smart['ufCrm5_1691762813'];
//    }
//
//    if ($smart['ufCrm5_1695287612']){
//        $field['ufCrm5_1695287612'] =  $smart['ufCrm5_1695287612'];
//    }
//
//    if ($smart['ufCrm5_1695287840325']){
//        $field['ufCrm5_1695287840325'] =  $smart['ufCrm5_1695287840325'];
//    }
//
//    if ($smart['ufCrm5_1695287856171']){
//        $field['ufCrm5_1695287856171'] =  $smart['ufCrm5_1695287856171'];
//    }
//
//    if ($smart['ufCrm5_1695375918259']){
//        $field['ufCrm5_1695375918259'] =  $smart['ufCrm5_1695375918259'];
//    }
//
//    if ($smart['ufCrm5_1695375991470']){
//        $field['ufCrm5_1695375991470'] =  $translater->getNew1695375991470($smart['ufCrm5_1695375991470']);
//    }
//
//    if ($smart['ufCrm5_1695376009181']){
//        $field['ufCrm5_1695376009181'] =  $smart['ufCrm5_1695376009181'];
//    }
//
//    if ($smart['ufCrm5_1695376063512']){
//        $field['ufCrm5_1695376063512'] =  $smart['ufCrm5_1695376063512'];
//    }
//    if ($smart['ufCrm5_1699342506']){
//        $field['ufCrm5_1699342506'] =  $translater->getNew1699342506($smart['ufCrm5_1699342506']);
//    }
//    if ($smart['ufCrm5_1700472447']){
//        $field['ufCrm5_1700472447'] =  $smart['ufCrm5_1700472447'];
//    }
//    $d = BitrixApi::addSmart(ID_SMART_LOGISTIC_NEW, $field, "new");
//    echo "smart = $smartId DealOLD = $dealOldId , dealNew = $dealNew\r\n";
//    $smartNew =  $d['result']['item'];
//   $smartNewId = $smartNew['id']??'NOT_NEW_ID';
//
//    } else {
//        $dealNew = "NOT_NEW_DEAL_ID";
//        $smartNewId="NOT_ATTEMP";
//    }
//    $smartProcess->updateFileSmartDataLead($smartId, [
//        'dealOld' => $dealOldId,
//        'dealNew' => $dealNew,
//        'newsmartID' => $smartNewId
//    ]);
//}
//
//echo "RESULT ZERO_ID = $count_zero";
//
