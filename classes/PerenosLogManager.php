<?php

namespace classes;

class PerenosLogManager
{
    protected string $fileLog;
    protected array $dataLog;

    public function __construct($fileLog)
    {
        $this->fileLog = $fileLog;
        $this->leadDataLog();
    }

    public function updateFileLog($idOld, $data, $result)
    {
        $this->dataLog[$idOld] = [
            'data' => $data,
            'result' => $result
        ];
        $this->saveDataLog();
    }

    private function leadDataLog()
    {
        $this->dataLog = json_decode(file_get_contents($this->fileLog), true);
    }

    private function saveDataLog()
    {
        file_put_contents($this->fileLog, json_encode($this->dataLog, JSON_UNESCAPED_UNICODE));
    }

}