<?php

namespace classes;

class TranslaterIDs
{

    const USERS = [
        19=>32,
        39=>43,
        13=>33,
//        63=>,
//        15=>,
//        17=>

    ];

    const STAGES_LG =[
        "DT136_11:NEW" => "DT163_7:NEW",
        "DT136_11:PREPARATION" => "DT163_7:PREPARATION",
        "DT136_11:CLIENT" => "DT163_7:CLIENT",
        "DT136_11:SUCCESS" => "DT163_7:SUCCESS",
        "DT136_11:FAIL" => "DT163_7:FAIL"
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

    const ID_UF_CRM_5_1699342506= [
        227 => 48,
        229 => 49,
        231 => 50,
        233 => 51
    ];

    public function getNewUserId($oldId){
        return self::USERS[$oldId] ?? 32;
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

}