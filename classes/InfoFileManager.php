<?php

namespace classes;

class InfoFileManager
{
    protected string $fileName;
    protected array $data;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->leadDataLog();
    }

    public function updateFileSmartLead($idSmart, int $idLead)
    {
        $this->data[$idSmart] = $idLead;
        $this->saveDataLog();
    }
    public function updateFileSmartDataLead($idSmart, array $dataLead)
    {
        $this->data[$idSmart] = $dataLead;
        $this->saveDataLog();
    }

    private function leadDataLog()
    {
        if (!file_exists($this->fileName)){
            file_put_contents($this->fileName, json_encode([]));
        }
        $this->data = json_decode(file_get_contents($this->fileName), true);
    }

    private function saveDataLog()
    {
        file_put_contents($this->fileName, json_encode($this->data, JSON_UNESCAPED_UNICODE));
    }
    public function getValueByKey($key)
    {
        return $this->data[$key];
    }
    public function getData()
    {
        return $this->data;
    }



}