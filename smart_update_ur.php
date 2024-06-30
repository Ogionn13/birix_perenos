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
//$csvFileLeadNew = ROOT . "/dataBitrixCSV/сделки из коробки.csv";
$csvFileLeadNew = ROOT . "/dataBitrixCSV/DEAL_20240619_df267572_667286c10b85b.csv";
$csvDataNewLead = new CsvData($csvFileLeadNew, ROOT . "/dataBitrixCSV/leadNewHead2.json");

$csvFileLeadOld = ROOT . "/dataBitrixCSV/сделки из облака 1.csv";
$csvDataOldLead = new CsvData($csvFileLeadOld, ROOT . "/dataBitrixCSV/leadOldHead.json");

$csvFileOldSmartUr = ROOT . "/dataBitrixCSV/юр.отдел.csv";
$csvDataOldSmartUr = new CsvData($csvFileOldSmartUr, ROOT . "/dataBitrixCSV/urHead.json");

$smartProcessUR = new \classes\InfoFileManager(ROOT . "/process/NEWsmartsUr.json");
$smartProcessUpdteUR = new \classes\InfoFileManager(ROOT . "/process/NEWsmartsUrUpdate2.json");
$smartUrIds = $csvDataOldSmartUr->getIdsArr();

//$translater = new \classes\TranslaterIDs();

$process = $smartProcessUR->getData();

foreach ($process as $oldSmartId=>$resultAdd){
    if (is_int($resultAdd['newsmartID'])) {
        continue;
    }
    if ($oldSmartId == 133){
        continue;
    }
    $leadIdNew = $csvDataNewLead->findIDByValue($oldSmartId, 42);
    echo "$oldSmartId  == $leadIdNew \r\n";
    continue;
    $newSmartId =$resultAdd['newsmartID'];
    $rData = [];
    $r1 = [];
    $r2 = [];
    $r3 = [];
    echo "$oldSmartId  -> {$resultAdd['newsmartID']} \r\n";
    $leadIdOldFrFile = $csvDataOldLead->findIDByValue($oldSmartId, CsvData::INDEX_LEAD_OLD_URID);
    $fNameDataDogovor = trim($csvDataOldSmartUr->getValueByIDAndPos($oldSmartId, CsvData::INDEX_SMART_UR_DOGOVOR));
    if ($fNameDataDogovor) {
        $fnamesDogovor = explode(", ", $fNameDataDogovor);

        foreach ($fnamesDogovor as $fname) {
            $fname = trim($fname);

            $parts = parse_url($fname);
            $filename11 = basename($fname);
            $filename = basename($parts['path']);
            $encodedFilename = urlencode($filename);
            $newUrl = $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
            $newUrl = str_replace($filename, $encodedFilename, $newUrl);
            $rData['dogovor'][] = $newUrl;
            $rData['dogovorN'][] = $filename11;
//            echo "      " . $fname . "\r\n";
//            echo "      " . $newUrl . "\r\n";
            echo "      " . $filename11 . "\r\n";

            $file1 = file_get_contents($newUrl);
            $base64_f1 = base64_encode($file1);
            $r1[] = [
                $filename11,
                $base64_f1
            ];

        };
    }
    $res1 = "";
   if (count($r1) >= 1) {
        $res1 = $r1;
    }
    $field['ufCrm7_1691762616'] = $res1;

    $fNameDataObrasec = trim($csvDataOldSmartUr->getValueByIDAndPos($oldSmartId, CsvData::INDEX_SMART_UR_OBRAZEC));
    if ($fNameDataObrasec) {
        $fnames2 = explode(", ", $fNameDataObrasec);
        foreach ($fnames2 as $fname2) {
            $fname2 = trim($fname2);
            $parts2 = parse_url($fname2);
            $filename21 = basename($parts2['path']);
            $filename22 = basename($fname2);
            $encodedFilename2 = urlencode($filename21);
            $newUrl2 = $parts2['scheme'] . '://' . $parts2['host'] . $parts2['path'];
            $newUrl2 = str_replace($filename21, $encodedFilename2, $newUrl2);
//            echo "      " . $fname2 . "\r\n";
//            echo "      " . $newUrl2 . "\r\n";
            echo "      " . $filename22 . "\r\n";
            $rData['obr'][] = $newUrl2;
            $rData['obrN'][] = $filename22;
            $file2 = file_get_contents($newUrl2);
            $base64_f2 = base64_encode($file2);

//        $contFiles2 = count($fnames);
//        $field['ufCrm7_1691762638'] = $res[0];
            $r2[] = [
                $filename22,
                $base64_f2
            ];
        }
    };

        $res2 = "";
       if (count($r2) >= 1) {
            $res2 = $r2;
        }
        $field['ufCrm7_1691762638'] = $res2;
    $fNameDataPoket = trim($csvDataOldSmartUr->getValueByIDAndPos($oldSmartId, CsvData::INDEX_SMART_UR_POKET));
    if ($fNameDataPoket) {
        $fnames3 = explode(", ", $fNameDataPoket);

        foreach ($fnames3 as $fname3) {
            $fname3 = trim($fname3);
            $parts3 = parse_url($fname3);
            $filename31 = basename($parts3['path']);
            $filename32 = basename($fname3);
            $encodedFilename3 = urlencode($filename31);
            $newUrl3 = $parts3['scheme'] . '://' . $parts3['host'] . $parts3['path'];
            $newUrl3 = str_replace($filename31, $encodedFilename3, $newUrl3);
//            echo "      " . $fname3 . "\r\n";
//            echo "      " . $newUrl3 . "\r\n";
            echo "      " . $filename32 . "\r\n";
            $rData['poket'][] = $newUrl3;
            $rData['poketN'][] = $filename32;
//            $file = file_get_contents($newUrl);
//            $base64_f = base64_encode($file);
            $file3 = file_get_contents($newUrl3);
            $base64_f3 = base64_encode($file3);

            $r3[] = [
                $filename32,
                $base64_f3
            ];
        }
    };

    $res3 = "";
    if (count($r3) >= 1) {
        $res3 = $r3;
    }
    $field['ufCrm7_1693474061'] = $res3;
    $smartProcessUpdteUR->updateFileSmartDataLead($oldSmartId, $rData);
     $d = BitrixApi::updateSmart(ID_SMART_UR_NEW, $newSmartId,  $field, 'new');
//     var_dump($d);
}

exit();
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
//    $smartProcessUR->updateFileSmartDataLead($smartUrId, [
//        'dealOld' => $smart['parentId2'] ?? $leadIdOldFrFile ?? "",
//        'dealNew' => $leadIdNew,
//        'newsmartID' => $smartNewId,
//        "contFiles" => ['p1'=>$contFiles1,
//            'p2'=>$contFiles2,
//            'p3'=>$contFiles3
//        ]
//    ]);

}

