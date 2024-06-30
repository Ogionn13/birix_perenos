<?php

namespace classes;

class TranslaterIDs
{

    const USERS = [
        19=>32,
        39=>43,
        13=>33,
        21=>37,
        37=>47
    ];

    const STAGES_LG =[
        "DT136_11:NEW" => "DT163_7:NEW",
        "DT136_11:PREPARATION" => "DT163_7:PREPARATION",
        "DT136_11:CLIENT" => "DT163_7:CLIENT",
        "DT136_11:SUCCESS" => "DT163_7:SUCCESS",
        "DT136_11:FAIL" => "DT163_7:FAIL",
        "DT180_13:SUCCESS" => "DT134_8:SUCCESS",
        "DT180_13:NEW" => "DT134_8:NEW",
        "DT180_13:FAIL" => "DT134_8:FAIL",
        "DT180_13:PREPARATION" => "DT134_8:PREPARATION"
    ];

    const ID_UF_CRM_5_1691762774 = [
        127 => 52,
        129 => 53
    ];
    const ID_UF_CRM_5_1695375991470 = [
        201 => 54,
        203 => 55,
        205 => 56
    ];

    const ufCrm7_1691762588 = [   //тип договора юр
        123 => 70, // наша ф
        125 => 71  //ф. клиента
    ];

    const ID_UF_CRM_5_1699342506= [
        227 => 48,
        229 => 49,
        231 => 50,
        233 => 51
    ];
    const ufCrm7_1700731725= [
        237 => 66,
        239 => 67,
        241 => 68,
        243 => 69
    ];

    public function getNewUserId($oldId){
        return self::USERS[$oldId] ?? 32;
    }
    public function getNewUserId2($oldId){
        return self::USERS[$oldId] ?? 37;
    }
    public function getNewSTAGE_LG($oldStage){
        return self::STAGES_LG[$oldStage] ?? "";
    }

    public function getNew1691762774($oldID){
        return self::ID_UF_CRM_5_1691762774[$oldID] ?? 52;
    }
    public function getNew1695375991470($oldID){
        return self::ID_UF_CRM_5_1695375991470[$oldID] ?? 54;
    }
    public function getNew1699342506($oldID){
        return self::ID_UF_CRM_5_1699342506[$oldID] ?? 48;
    }
    public function getNew1700731725($oldID){
        return self::ufCrm7_1700731725[$oldID] ?? 66;
    }
    public function getNew1691762588_ur($oldID){
        return self::ufCrm7_1691762588[$oldID] ?? 70;
    }

}