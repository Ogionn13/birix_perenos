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

//$csvFile = ROOT."/dataoldBitrix/логисты.csv";
//$fileLogPerenos = ROOT . "/process/smarts_add.json";
//
//$logPerenos =new \classes\PerenosLogManager($fileLogPerenos);
//
//
//$handle = fopen($csvFile, "r");
//$headers = fgetcsv($handle, 0, ";");

const ID_SMART_OLD = 136;
const ID_SMART_LOGISTIC_NEW = 163;

$csvFileLeadNew = ROOT."/dataBitrixCSV/сделки из коробки.csv";
$csvDataNewLead = new CsvData($csvFileLeadNew, ROOT."/dataBitrixCSV/leadNewHead.json");

$csvFileLeadOld = ROOT."/dataBitrixCSV/сделки из облака 1.csv";
$csvDataOldLead = new CsvData($csvFileLeadOld, ROOT."/dataBitrixCSV/leadOldHead.json");

$csvFileOldSmartLogists = ROOT."/dataBitrixCSV/логисты.csv";
$csvDataOldSmartLogists = new CsvData($csvFileOldSmartLogists,ROOT."/dataBitrixCSV/logistHead.json");

$smartLead = new \classes\InfoFileManager(ROOT."/process/OldSmartLead.json");
$smartProcess = new \classes\InfoFileManager(ROOT."/process/NEWsmarts.json");

$translater = new \classes\TranslaterIDs();
//$smartDealOld_New = new \classes\InfoFileManager(ROOT."/process/SMART_DEAL_OLD_NEW.json");


//получаем из коробки массив сделок которые упомянуты в смарт процессох для работы только с ним
echo $csvDataOldLead->count() ."\r\n";
$csvDataOldLead->cleanDealWithoutSmart($smartLead->getData());
echo $csvDataOldLead->count() ."\r\n";

$smartsIds_lg = $smartLead->getData();

$smartsIds_lg = [1329=>30877];
//$dealNew = $csvDataOldSmartLogists->findIDNewLeadBy(
//
//);

$count_zero= 0;
$count_one =0;

foreach ($smartsIds_lg as $smartId=>$dealOldId) {
    $smartRow = $csvDataOldSmartLogists->getRowByID($smartId);
    $dealOldRows = $csvDataOldLead->getAllRowByID($dealOldId);

    $dealNew = $csvDataNewLead->findIDNewLead($smartId,  $dealOldId);
    if ($dealNew) {
        $smartData =  BitrixApi::getSmart(ID_SMART_OLD, $smartId);

        $smart =  $smartData['result']['item'];

    $fName = $csvDataOldSmartLogists->getValueByIDAndPos($smartId, CsvData::INDEX_SMART_LG_FILE);

    $field = [
    'title' => $smart['title'],
    'assigned_by_id' =>$translater->getNewUserId($smart['assigned_by_id']),
    'parentId2' => $dealNew,
    "stageId"=> $translater->getNewSTAGE_LG($smart['stageId']),
    ];
    if ($smart['opportunity']){
        $field['opportunity'] =  $smart['opportunity'];
    }

    if ($fName) {
        $file = file_get_contents($fName);
        $base64_f = base64_encode($file);
        $arFile = [
            "fileData" => [
                basename($fName),
                $base64_f
            ]
        ];
        $field['ufCrm5_1691762747'] =  $arFile;
    }
    if ($smart['ufCrm5_1691762774']){
        $field['ufCrm5_1691762774'] =  $translater->getNew1691762774($smart['ufCrm5_1691762774']);
    }

    if ($smart['ufCrm5_1691762801']){
        $field['ufCrm5_1691762801'] =  $smart['ufCrm5_1691762801'];
    }

    if ($smart['ufCrm5_1691762813']){
        $field['ufCrm5_1691762813'] =  $smart['ufCrm5_1691762813'];
    }

    if ($smart['ufCrm5_1695287612']){
        $field['ufCrm5_1695287612'] =  $smart['ufCrm5_1695287612'];
    }

    if ($smart['ufCrm5_1695287840325']){
        $field['ufCrm5_1695287840325'] =  $smart['ufCrm5_1695287840325'];
    }

    if ($smart['ufCrm5_1695287856171']){
        $field['ufCrm5_1695287856171'] =  $smart['ufCrm5_1695287856171'];
    }

    if ($smart['ufCrm5_1695375918259']){
        $field['ufCrm5_1695375918259'] =  $smart['ufCrm5_1695375918259'];
    }

    if ($smart['ufCrm5_1695375991470']){
        $field['ufCrm5_1695375991470'] =  $translater->getNew1695375991470($smart['ufCrm5_1695375991470']);
    }

    if ($smart['ufCrm5_1695376009181']){
        $field['ufCrm5_1695376009181'] =  $smart['ufCrm5_1695376009181'];
    }

    if ($smart['ufCrm5_1695376063512']){
        $field['ufCrm5_1695376063512'] =  $smart['ufCrm5_1695376063512'];
    }
    if ($smart['ufCrm5_1699342506']){
        $field['ufCrm5_1699342506'] =  $translater->getNew1699342506($smart['ufCrm5_1699342506']);
    }
    if ($smart['ufCrm5_1700472447']){
        $field['ufCrm5_1700472447'] =  $smart['ufCrm5_1700472447'];
    }
    $d = BitrixApi::addSmart(ID_SMART_LOGISTIC_NEW, $field, "new");
    echo "smart = $smartId DealOLD = $dealOldId , dealNew = $dealNew\r\n";
    $smartNew =  $d['result']['item'];
   $smartNewId = $smartNew['id']??'NOT_NEW_ID';

    } else {
        $dealNew = "NOT_NEW_DEAL_ID";
        $smartNewId="NOT_ATTEMP";
    }
    $smartProcess->updateFileSmartDataLead($smartId, [
        'dealOld' => $dealOldId,
        'dealNew' => $dealNew,
        'newsmartID' => $smartNewId
    ]);
}

echo "RESULT ZERO_ID = $count_zero";



//echo $smart['title'];
////$d = BitrixApi::addSmart(ID_SMART_LOGISTIC_NEW, $field, "new");
//file_put_contents('smart2_created.json', json_encode($d, JSON_UNESCAPED_UNICODE));
////    $c = count($dealOldRows);
//    echo "$samrtId  = количество $c \r\n";
//    if ($c>=4) {
//        file_put_contents("deal$samrtId.json", json_encode($dealOldRows, JSON_UNESCAPED_UNICODE));
//    }
//}




//$dealNew = $csvDataOldSmartLogists->findIDNewLeadBy(
//
//);

//создаем массив:
// ключ название компании,

//$oldCompanyID = $csvDataOldLead->getColumnUnicOnlyDealSmart(CsvData::INDEX_LEAD_COMPANY_ID_OLD, $smartLead->getData());
//$oldCompanyName = $csvDataOldLead->getColumnUnicOnlyDealSmart(CsvData::INDEX_LEAD_COMPANY_OLD, $smartLead->getData());
//$newCompanyID = $csvDataNewLead->getColumnUnic(CsvData::INDEX_LEAD_COMPANY_ID_NEW);
//$newCompanyName = $csvDataNewLead->getColumnUnic(CsvData::INDEX_LEAD_COMPANY_NEW);
//
//
//$cont1 = count($oldCompanyID);
//echo "IDCOMPOLD = {$cont1}\r\n";
//var_dump($oldCompanyID);
//
//
//$cont2 = count($oldCompanyName);
//echo "IDCOMPOLD = {$cont2}\r\n";
//
//$namesIds = [];
//foreach ($oldCompanyName as $name) {
//    $namesIds[$name] = $csvDataOldLead->getCompanyIDArrByName($name, CsvData::INDEX_LEAD_COMPANY_OLD, CsvData::INDEX_LEAD_COMPANY_ID_OLD);
//}
//file_put_contents("process/companyOldNameIds.json", json_encode($namesIds, JSON_UNESCAPED_UNICODE));

//$idsSmart = $csvDataOldSmartLogists->getIdsArr();
//$k = 0;
//foreach ($idsSmart as $id) {
////    $smart = BitrixApi::getSmart(ID_SMART_OLD, $id);
////    $smart = $smart['result']['item'];
////    $dealSmartId = $smart['parentId2'];
////    $smartLead->updateFileSmartLead($id, $dealSmartId);
////    sleep(1);
////    ++$k;
////    echo "$k  = idSamt = $id, iDlead = $dealSmartId \r\n";
//    $dealID = $smartLead->getValueByKey($id);
//    $row = $csvDataOldLead->getRowByID($dealID);
//    if (!$row){
//        echo "!!!!!!!!! smart = $id, DEAL = $dealID  FALSE \r\n";
//        continue;
//    }
//     $csvDataNewLead->findIDNewLeadByRow($row, $id, $smartDealOld_New);
//}

//$i =  0;
//
//
//$saveDir = "smartFiles/";
//
//while (($row = fgetcsv($handle, 0, ";")) !== false) {
//    var_dump($row);
//    // Получение ID из CSV
//    $idSamrtOld = $row[0];
//    echo $idSamrtOld;
//    $smart = BitrixApi::getSmart(136, $idSamrtOld);
//    $smart = $smart['result']['item'];
//    $dealSmartId = $smart['parentId2'];
//    $dealSmart = BitrixApi::getDeal($dealSmartId);
//    $dealSmart = $dealSmart['result'];
//    $titleDeal = $dealSmart['TITLE'];
//    $newLeadId = $csvDataNewLead->findIdDeal($titleDeal);
//    var_dump($newLeadId);
//
////    if (isset($smart['ufCrm5_1691762747']) && isset($smart['ufCrm5_1691762747']['urlMachine'])){
////        $fileUrl = $smart['ufCrm5_1691762747']['urlMachine'];
////        $fileContent =  file_get_contents($fileUrl);
////        echo "ok";
////        var_dump($fileContent);
////        file_put_contents("test.doc", $fileContent);
////    }
////
////  //  var_dump($smart);
////    file_put_contents('smart_logist.json', json_encode($smart, JSON_UNESCAPED_UNICODE));
////    echo $id;
////    ++$i;
//    //if ($i>5)
//    break;
//}