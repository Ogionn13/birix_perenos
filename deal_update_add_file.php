<?php

use classes\BitrixApi;

const ROOT = __DIR__;
require ROOT . "/classes/BitrixApi.php";
require ROOT . "/Bitrix_Crest/crest_new/crest.php";
require ROOT . "/Bitrix_Crest/crest_old/crest.php";
require ROOT . "/classes/constants.php";
require ROOT . "/classes/PerenosLogManager.php";
require ROOT . "/classes/InfoFileManager.php";
require ROOT . "/classes/TranslaterIDs.php";
require ROOT . "/classes/CsvData.php";


//$csvFileLeadNew = ROOT . "/dataBitrixCSV/сделки из коробки.csv";
$csvFileLeadNew = ROOT . "/dataBitrixCSV/DEAL_20240619_df267572_667286c10b85b.csv";
$csvDataNewLead = new CsvData($csvFileLeadNew, ROOT . "/dataBitrixCSV/leadNewHead2.json");

$csvFileLeadOld = ROOT . "/dataBitrixCSV/сделки из облака 1.csv";
$csvDataOldLead = new CsvData($csvFileLeadOld, ROOT . "/dataBitrixCSV/leadOldHead.json");

$csvFileOldSmartUr = ROOT . "/dataBitrixCSV/юр.отдел.csv";
$csvDataOldSmartUr = new CsvData($csvFileOldSmartUr, ROOT . "/dataBitrixCSV/urHead.json");

$dealupdateAddFileProcess = new \classes\InfoFileManager(ROOT . "/process/AddFile.json");


$leadsId = $csvDataOldLead->getIdsArr();
$k=0;
$d = [];

//42 - 317
//43- 37
//49-1
//51-0
//55-309
//57-293
//68-0
foreach ($leadsId as $id) {
    $val1 = $csvDataOldLead->getValueByIDAndPos($id, 42);
    $val2 = $csvDataOldLead->getValueByIDAndPos($id, 43);
    $val3 = $csvDataOldLead->getValueByIDAndPos($id, 49);
    $val4 = $csvDataOldLead->getValueByIDAndPos($id, 55);
    $val5 = $csvDataOldLead->getValueByIDAndPos($id, 57);

    if ($val1 || $val2 || $val3 || $val4 || $val5){
        if (!in_array($id, $d)){
            $d[] = $id;
            ++$k;
            echo "$k = id = $id . $val1\r\n";
            echo "ВСЕГО $k!";
        }
    }
}