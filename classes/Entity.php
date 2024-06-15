<?php

namespace classes;

class Entity
{
    protected array $data;
    protected array $fields;


    public function __constrict($data){
        $this->data = $data;
        $this->setFields();
    }

    private function setFields()
    {
        $this->fields = [
          ""
        ];
    }


}