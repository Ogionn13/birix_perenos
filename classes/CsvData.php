<?php

use classes\InfoFileManager;

class CsvData {
    private array $data;

    const INDEX_SMART_LG_FILE =5;
    const INDEX_LEAD_NAME_NEW = 11;
    const INDEX_LEAD_OLD_URID = 54;
    const INDEX_LEAD_NEW_URID = 44;
    const INDEX_LEAD_ID = 0;
    const INDEX_LEAD_LOGISTIC_ID = 43;
    const INDEX_LEAD_NAME_OLD = 11;
    const INDEX_LEAD_SUMM_OLD = 15;
    const INDEX_LEAD_SUMM_NEW = 15;
    const INDEX_LEAD_COMPANY_OLD = 126;
    const INDEX_LEAD_COMPANY_NEW = 127;
    const INDEX_DATE_OUTLOAD_OLD = 60;
    const INDEX_DATE_OUTLOAD_NEW = 47;
    const INDEX_DATE_START_OLD = 24;
    const INDEX_DATE_START_NEW = 24;
    const INDEX_DEAL_STAGE_OLD = 4;
    const INDEX_DEAL_STAGE_NEW = 4;
    public function __construct($csvFile, $headfileName = "") {
        $this->data = [];
        $file = fopen($csvFile, 'r');
        $head  = fgetcsv($file, 0, ';');
        if ($headfileName){
            file_put_contents($headfileName, json_encode($head,JSON_UNESCAPED_UNICODE));
        }
        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $this->data[] = $row;
        }
        fclose($file);
    }

    public function findIdDeal($searchString) {
        foreach ($this->data as $row) {
            if ($row[3] === $searchString) {
                return $row[0];
            }
        }
        return null;
    }

    public function getIdsArr():array{
        $result = [];
        foreach ($this->data as $row)
        {
            if ($row[0]){
                $result[] = $row[0];
            }
        }
        return $result;
    }

    public function getRowByID($id){
        foreach ($this->data as $row)
        {
            if ($row[0] ==$id){
                return $row;
            }
        }
        return false;
    }
    public function getValueByIDAndPos($id, $index){
        foreach ($this->data as $row)
        {
            if ($row[0] ==$id){
                return $row[$index];
            }
        }
        return false;
    }

    public function getColumnUnic($index){
        $result = [];
        foreach ($this->data as $row)
        {

            if ($row[$index]){
                $val  = trim($row[$index]);
                if ($val and !in_array($val, $result)){
                    $result[] = $val;
                }
            }
        }
        return $result;
    }
    public function getColumnUnicOnlyDealSmart($index, $arrSmartDeal){
        $result = [];
        foreach ($this->data as $row)
        {
            $dealId = $row[0];
            if (!$dealId or !in_array($dealId, $arrSmartDeal)){
                continue;
            }
            if ($row[$index]){
                $val  = trim($row[$index]);
                if ($val and !in_array($val, $result)){
                    $result[] = $val;
                }
            }
        }
        return $result;
    }
    public function findIDNewLeadByRow(array $inputRow, $smartID, InfoFileManager $file){
        $result = [];

        $lead_arr = [];
        $lead_double = [];
        // ищем по названию сделки
        foreach ($this->data as $row)
        {
            $leadIdRow = $row[self::INDEX_LEAD_ID];
            if (!$leadIdRow or in_array($leadIdRow, $lead_double)){
                continue;
            }
            if ($inputRow && trim($row[self::INDEX_LEAD_NAME_NEW]) == trim($inputRow[self::INDEX_LEAD_NAME_OLD])){
                $lead_arr[$leadIdRow] = $row;
                $lead_double[] = $leadIdRow;
            }
        }


        //название компании
        $lead_arr2 = [];
        foreach ($lead_arr as $leadIdNew =>$rowNew) {
            if (!$rowNew[self::INDEX_LEAD_COMPANY_NEW] && !$inputRow[self::INDEX_LEAD_COMPANY_OLD]) {
                $lead_arr2[$leadIdNew] = $rowNew;
                continue;
            }
            if ( trim($rowNew[self::INDEX_LEAD_COMPANY_NEW]) ==  trim($inputRow[self::INDEX_LEAD_COMPANY_OLD])) {
                $lead_arr2[$leadIdNew] = $rowNew;
            }
        }

        //Дата выгрузки

        $lead_arr3 = [];
        foreach ($lead_arr2 as $leadIdNew =>$rowNew) {
            if (!$rowNew[self::INDEX_DATE_OUTLOAD_NEW] && !$inputRow[self::INDEX_DATE_OUTLOAD_OLD]) {
                $lead_arr3[$leadIdNew] = $rowNew;
                continue;
            }
            if ($rowNew[self::INDEX_DATE_OUTLOAD_NEW] ==  $inputRow[self::INDEX_DATE_OUTLOAD_OLD]) {
                $lead_arr3[$leadIdNew] = $rowNew;
            }
        }
        //сумма

        $lead_arr4= [];
        foreach ($lead_arr3 as $leadIdNew =>$rowNew) {
            if (!$rowNew[self::INDEX_LEAD_SUMM_NEW] && !$inputRow[self::INDEX_LEAD_SUMM_OLD]) {
                $lead_arr4[$leadIdNew] = $rowNew;
                continue;
            }
            if ($rowNew[self::INDEX_LEAD_SUMM_NEW] ==  $inputRow[self::INDEX_LEAD_SUMM_OLD]) {
                $lead_arr4[$leadIdNew] = $rowNew;
            }
        }
        $result = [
            "oldDealID" => $inputRow[0],
          "byDealName" => array_keys($lead_arr),
          "byCompanyId" =>  array_keys($lead_arr2),
          "byUPLOADDeal" => array_keys($lead_arr3),
          "bySummaDeal" => array_keys($lead_arr4)
        ];
        $c0 = count($lead_arr);
        $c1 = count($lead_arr2);
        $c2 = count($lead_arr3);
        $c3 = count($lead_arr4);
        echo "смарт $smartID dealOld {$inputRow[0]}, cont = $c0 - $c1 - $c2 - $c3 \r\n";
        $file->updateFileSmartDataLead($smartID, $result);
    }

    public function getCompanyIDArrByName($name, $indName, $indId){
        $result =  [];
        foreach ($this->data as $row){
            if (trim($row[$indName]) == trim($name) and !in_array(trim($row[$indId]), $result)){
                $result[] = trim($row[$indId]);
            }
        }
        return $result;
    }

    public function cleanDealWithoutSmart($smartDealArr){
        $result = [];
        foreach ($this->data as $elem) {
            $id = $elem[0];
            if ($id and in_array($id, $smartDealArr)){
                $result[] = $elem;
            }
        }
        $this->data = $result;
    }

    public function getAllRowByID($id) {
        $result = [];
        foreach ($this->data as $elem){
            if ($elem[0] == $id) {
                $result[] = $elem;
            }
        }
        return $result;
    }

    public function count(){
        return count($this->data);
    }

    public function findIDNewLeadBy(array $data, InfoFileManager $file):array
    {
        $lead_arr = [];
        $lead_double = [];
        // ищем по названию сделки
        $leadName = trim($data['LeadName']);
        $companyName =  trim($data['CompanyName']);
        $startDate =  trim($data['startDate']);
        $stageName =  trim($data['dealStage']);
        if ($leadName) {
            foreach ($this->data as $row)
            {
                $leadIdRow = $row[self::INDEX_LEAD_ID];
                if (in_array($leadIdRow, $lead_double)){
                    continue;
                }
                if (!$leadIdRow or in_array($leadIdRow, $lead_double)){
                    continue;
                }
                if (trim($row[self::INDEX_LEAD_NAME_NEW]) == $leadName){
                    $lead_arr[$leadIdRow] = $row;
                    $lead_double[] = $leadIdRow;
                }
            }
        }

        //название компании
        $lead_arr2 = [];
        foreach ($lead_arr as $leadIdNew =>$rowNew) {
            if (!$rowNew[self::INDEX_LEAD_COMPANY_NEW] && !$companyName) {
                $lead_arr2[$leadIdNew] = $rowNew;
                continue;
            }
            if ( trim($rowNew[self::INDEX_LEAD_COMPANY_NEW]) ==  $companyName) {
                $lead_arr2[$leadIdNew] = $rowNew;
            }
        }

        $lead_arr3 = [];
        foreach ($lead_arr2 as $leadIdNew =>$rowNew) {
            if (!$rowNew[self::INDEX_DATE_START_NEW] && !$startDate) {
                $lead_arr3[$leadIdNew] = $rowNew;
                continue;
            }
            $startDate_new = $rowNew[self::INDEX_DATE_START_NEW];
            if ($startDate_new == $startDate) {
                $lead_arr3[$leadIdNew] = $rowNew;
            }
        }
        $lead_arr4 = [];
        if (count($lead_arr3) ===1){
            $lead_arr4 = $lead_arr3;
        } else {
            foreach ($lead_arr3 as $leadIdNew =>$rowNew) {
                if (!$rowNew[self::INDEX_DEAL_STAGE_NEW] && !$stageName) {
                    $lead_arr4[$leadIdNew] = $rowNew;
                    continue;
                }
                $stageName_new = $rowNew[self::INDEX_DEAL_STAGE_NEW];
                if ($stageName_new == $stageName) {
                    $lead_arr4[$leadIdNew] = $rowNew;
                }
            }
        }


        $c0 = count($lead_arr);
        $c1 = count($lead_arr2);
        $c2 = count($lead_arr3);
        $c3 = count($lead_arr4);

        $result = [
            "oldDealID" =>$data['dealIdOld'],
            "byDealName" => array_keys($lead_arr),
            "byCompanyId" =>  array_keys($lead_arr2),
            "byStartDeal" => array_keys($lead_arr3),
            "bySageDeal" => array_keys($lead_arr4),
            'c3' => $c3
        ];

        echo "смарт {$data['samrtId']} dealOld {$data['dealIdOld']}, cont = $c0 - $c1 - $c2 - $c3 \r\n";
        $file->updateFileSmartDataLead($data['samrtId'], $result);
        return $result;


    }

    public function findIDNewLead(int $smartId, $dealOldId)
    {
        foreach ($this->data as $row)
        {
            $leadIdRow = $row[self::INDEX_LEAD_ID];
            if (trim($row[self::INDEX_LEAD_LOGISTIC_ID]) == $smartId){
                return $leadIdRow;
            }
        }
        return 0;
    }
    public function findIDByValue(int $smartId, int $indexVal)
    {
        foreach ($this->data as $row)
        {
            $leadIdRow = $row[self::INDEX_LEAD_ID];
            if (trim($row[$indexVal]) == $smartId){
                return $leadIdRow;
            }
        }
        return 0;
    }
}