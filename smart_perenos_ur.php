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

const ID_SMART_UR_OLD = 180;
const ID_SMART_UR_NEW = 134;
//
$csvFileLeadNew = ROOT . "/dataBitrixCSV/сделки из коробки.csv";
$csvDataNewLead = new CsvData($csvFileLeadNew, ROOT . "/dataBitrixCSV/leadNewHead.json");

$csvFileLeadOld = ROOT . "/dataBitrixCSV/сделки из облака 1.csv";
$csvDataOldLead = new CsvData($csvFileLeadOld, ROOT . "/dataBitrixCSV/leadOldHead.json");

$csvFileOldSmartUr = ROOT . "/dataBitrixCSV/юр.отдел.csv";
$csvDataOldSmartUr = new CsvData($csvFileOldSmartUr, ROOT . "/dataBitrixCSV/urHead.json");

$smartProcessUR = new \classes\InfoFileManager(ROOT . "/process/NEWsmartsUr.json");
$smartUrIds = $csvDataOldSmartUr->getIdsArr();

$translater = new \classes\TranslaterIDs();

foreach ($smartUrIds as $smartUrId) {

    if ($smartUrId == 39 or $smartUrId == 189 or $smartUrId == 387) {
        continue;
    }
    $contFiles1=$contFiles2=$contFiles3=0;
    $leadIdOldFrFile = $csvDataOldLead->findIDByValue($smartUrId, CsvData::INDEX_LEAD_OLD_URID);
    $leadIdNew = $csvDataNewLead->findIDByValue($smartUrId, CsvData::INDEX_LEAD_NEW_URID);
    if ($leadIdNew) {

        $smartData = BitrixApi::getSmart(180, $smartUrId);
        $smart = $smartData['result']['item'];
        $leadIdOld = $smart['parentId2'];


        $field = [
            'title' => $smart['title'],
            'assigned_by_id' => $translater->getNewUserId2($smart['assigned_by_id']),
            'parentId2' => $leadIdNew,
            "stageId" => $translater->getNewSTAGE_LG($smart['stageId']),
        ];
        if ($smart['opportunity']) {
            $field['opportunity'] = $smart['opportunity'];
        }

        if ($smart['ufCrm7_1691762588']) {
            $field['ufCrm7_1691762588'] = $translater->getNew1691762588_ur($smart['ufCrm7_1691762588']);
        }

        $fNameDataDogovor = trim($csvDataOldSmartUr->getValueByIDAndPos($smartUrId, CsvData::INDEX_SMART_UR_DOGOVOR));
        if ($fNameDataDogovor) {
            $fnamesDogovor = explode(", ", $fNameDataDogovor);
        }
        if (count($fnamesDogovor)) {
            $res = [];
            foreach ($fnamesDogovor as $fname) {
                $fname = trim($fname);
                $parts = parse_url($fname);
                $filename = basename($parts['path']);
                $encodedFilename = urlencode($filename);
                $newUrl = $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
                $newUrl = str_replace($filename, $encodedFilename, $newUrl);
                $file = file_get_contents($newUrl);
                $base64_f = base64_encode($file);
                $arFile = [
                    "fileData" => [
                        basename($newUrl),
                                $base64_f
                    ]
                ];
                $res[] = $arFile;
            }
            $contFiles1 = count($fnamesDogovor);
            $field['ufCrm7_1691762616'] = $res[0];
        }

        $fNameDataObrasec = trim($csvDataOldSmartUr->getValueByIDAndPos($smartUrId, CsvData::INDEX_SMART_UR_OBRAZEC));
        if ($fNameDataObrasec) {
            $fnames = explode(", ", $fNameDataObrasec);
        }
        if (count($fnames)) {
            $res = [];
            foreach ($fnames as $fname) {
                $fname = trim($fname);
                $parts = parse_url($fname);
                $filename = basename($parts['path']);
                $encodedFilename = urlencode($filename);
                $newUrl = $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
                $newUrl = str_replace($filename, $encodedFilename, $newUrl);
                $file = file_get_contents($newUrl);
                $base64_f = base64_encode($file);
                $arFile = [
                    "fileData" => [
                        basename($newUrl),
                          $base64_f
                    ]
                ];
                $res[] = $arFile;
            }
            $contFiles2 = count($fnames);
            $field['ufCrm7_1691762638'] = $res[0];
        }
        $fNameDataPoket = trim($csvDataOldSmartUr->getValueByIDAndPos($smartUrId, CsvData::INDEX_SMART_UR_POKET));
        if ($fNameDataPoket) {
            $fnames = explode(", ", $fNameDataPoket);
        }
        if (count($fnames)) {

            foreach ($fnames as $fname) {
                $fname = trim($fname);
                $parts = parse_url($fname);
                $filename = basename($parts['path']);
                $encodedFilename = urlencode($filename);
                $newUrl = $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
                $newUrl = str_replace($filename, $encodedFilename, $newUrl);
                echo $newUrl;
                $file = file_get_contents($newUrl);
                $base64_f = base64_encode($file);
                $arFiles[] = [
                    "fileData" => [
                        basename($newUrl),
                          $base64_f
                    ]
                ];

            }
            $contFiles3 = count($fnames);
            $field['ufCrm7_1693474061'] = $arFiles[0];
        }

        if ($smart['ufCrm7_1700731725']) {
            $field['ufCrm7_1700731725'] = $translater->getNew1700731725($smart['ufCrm7_1700731725']);
        }

        if ($smart['ufCrm7_1693474138']) {
            $field['ufCrm7_1693474138'] = $smart['ufCrm7_1693474138'];
        }

   //     var_dump($field);

        echo "$smartUrId leadOld  $leadIdOldFrFile leadOldBTX  $leadIdOld leadNew $leadIdNew" . PHP_EOL;

          $d = BitrixApi::addSmart(ID_SMART_UR_NEW, $field, "new");

             $smartNew =  $d['result']['item'];
        $smartNewId = $smartNew['id'] ?? 'NOT_NEW_ID';

    } else {
        $leadIdNew = "NOT_NEW_DEAL_ID";
        $smartNewId = "NOT_ATTEMP";
    }
    $smartProcessUR->updateFileSmartDataLead($smartUrId, [
        'dealOld' => $smart['parentId2'] ?? $leadIdOldFrFile ?? "",
        'dealNew' => $leadIdNew,
        'newsmartID' => $smartNewId,
        "contFiles" => ['p1'=>$contFiles1,
            'p2'=>$contFiles2,
            'p3'=>$contFiles3
        ]
    ]);

}

