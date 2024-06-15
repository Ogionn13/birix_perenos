<?php

namespace classes;

use CRest;
use cronClasses\LogChecking;

class BitrixApi
{
    private const
        UPDATE_LEAD = 'crm.lead.update',
        UPDATE_DEAL = 'crm.deal.update',
        CREATE_DEAL = 'crm.deal.add',
        GET_LEAD = 'crm.lead.get',
        GET_DEAL = 'crm.deal.get',
        GET_USER = 'user.get',
        START_BISNESS_PROCESS = 'bizproc.workflow.start',
        GET_DEAL_LIST = 'crm.deal.list',
        GET_COMMENT_ON_ENTITY = 'crm.timeline.comment.list',
        GET_ACTIVITY = "get_activity",
        GET_CATEGORY = "crm.category.get",
        GET_LEAD_FIELD ="crm.lead.fields",
        GET_DEAL_FIELD ="crm.deal.fields",
        GET_SMART_FIELDS ="crm.item.fields",
        GET_STATUS_LIST = "crm.status.list",
        USER_SEARCH = "user.search",
        GET_STATUS_ENTITY_TYPES_LIST = "crm.status.entity.types";
    const GET_SMART = "crm.item.get";
    const ADD_SMART = "crm.item.add";


    public static function getCategory(int $entityType, int $categoryID): array
    {
        $queryData = [
            "id" => $categoryID,
            "entityTypeId" => $entityType
        ];
        return CRest::call(self::GET_CATEGORY, $queryData);
    }

    public static function getStatusList($type_crest='old'): array
    {
        $queryData = [
        ];
    //    $queryData = [];
        if ($type_crest=='old'){
            return \CRest_OLD::call(self::GET_STATUS_LIST, $queryData);
        } else {
            return \CRest_NEW::call(self::GET_STATUS_LIST, $queryData);
        }
    }

    public static function getEntityTypes( $type_crest='old'): array
    {
        $queryData = [];
    //    $queryData = [];
        if ($type_crest == 'old'){
            return \CRest_OLD::call(self::GET_STATUS_ENTITY_TYPES_LIST, $queryData);
        } else {
            return \CRest_NEW::call(self::GET_STATUS_ENTITY_TYPES_LIST, $queryData);
        }
    }
    public static function getSmartFields( $smartTypeID, $type_crest='old'): array
    {
        $queryData = [
            'entityTypeId' => $smartTypeID
        ];
    //    $queryData = [];
        if ($type_crest == 'old'){
            return \CRest_OLD::call(self::GET_SMART_FIELDS, $queryData);
        } else {
            return \CRest_NEW::call(self::GET_SMART_FIELDS, $queryData);
        }
    }
    public static function updateLeadResponsible(int $leadId, int $newResp): void
    {
        $queryData = [
            "id" => $leadId,
            "fields" => [
                "ASSIGNED_BY_ID" => $newResp
            ]
        ];
        CRest::call(self::UPDATE_LEAD, $queryData);
    }

    public static function updateDealResponsible(int $dealId, int $newResp): void
    {
        $queryData = [
            "id" => $dealId,
            "fields" => [
                "ASSIGNED_BY_ID" => $newResp
            ]
        ];
        CRest::call(self::UPDATE_DEAL, $queryData);
    }

    public static function updateTest(int $dealId, array $doc)
    {
        $queryData = [
            "id" => $dealId,
            "fields" => [
                "UF_CRM_1675936875131" => $doc
            ]
        ];
        return CRest::call(self::UPDATE_DEAL, $queryData);
    }

    public static function updateFile(int $dealId, array $doc)
    {
        $queryData = [
            "id" => 1,
            "data" => [
                "NAME" => "ttt"
            ],

            "fileContent" => [
                "UF_CRM_1675936875131" => $doc
            ]
        ];
        return CRest::call("disk.storage.uploadFile", $queryData);
    }

    public static function addDeal(array $fields)
    {
        $queryData = [
            "fields" => $fields
        ];
        return CRest::call(self::CREATE_DEAL, $queryData);
    }

    public static function updateLeadResponsibleAND_UF_CRM_1699952864(int $leadId, int $newResp): void
    {
        $leadData = self::getLead($leadId);
        $valueUF_CRM_1699952864 = $leadData['result']['UF_CRM_1699952864'];
        if (!is_array($valueUF_CRM_1699952864)) {
            $valueUF_CRM_1699952864 = [];
        }
        $valueUF_CRM_1699952864[] = 1396782;
        $queryData = [
            "id" => $leadId,
            "fields" => [
                "ASSIGNED_BY_ID" => $newResp,
                "UF_CRM_1699952864" => $valueUF_CRM_1699952864
            ]
        ];
        CRest::call(self::UPDATE_LEAD, $queryData);
    }


    public static function getLeadField(){
        return CRest::call(self::GET_LEAD_FIELD, []);
    }

    public static function getDEALField(){
        return CRest::call(self::GET_DEAL_FIELD, []);
    }
    public static function getUserByEmail(string $email): array
    {
        $queryData = [
            "EMAIL" => $email,
        ];
        return CRest::call(self::GET_USER, $queryData);
    }

    public static function createLeadURL($leadId)
    {
        return "https://bitrix.avagroup.ru/crm/lead/details/" . $leadId . '/';
    }

    public static function createDealURL($dealId)
    {
        return "https://bitrix.avagroup.ru/crm/deal/details/" . $dealId . '/';
    }

    public static function getStatus()
    {

        $queryData = [
            "order" => ["SORT" => "ASC"],
            "filter" => ["ENTITY_ID" => "STATUS"],
        ];
        $result = CRest::call('crm.status.list', $queryData);
        return $result['result'];

    }

    public static function getUserByID(int $id): array
    {
        $queryData = [
            "ID" => $id,
        ];
        return CRest::call(self::GET_USER, $queryData);
    }

    public static function getNameUserByID(int $id): string
    {
        $res = self::getUserByID($id);

        $user = $res['result'][0];

        return trim($user['NAME'] . ' ' . $user['LAST_NAME']);
    }

    public static function getUserByLastName($lastName, $type_crest='old'){
        $queryData = [
            "FILTER" =>[
                "LAST_NAME" => $lastName
            ],
        ];
        if ($type_crest=='old'){
            return \CRest_OLD::call(self::USER_SEARCH, $queryData);
        } else {
            return \CRest_NEW::call(self::USER_SEARCH, $queryData);
        }
    }

    public static function getLead(int $leadId): array
    {
        $queryData = [
            "id" => $leadId,
        ];
        return CRest::call(self::GET_LEAD, $queryData);
    }

    public static function getDeal(int $dealId, $type_crest='old'): array
    {
        $queryData = [
            "id" => $dealId,
        ];
        if ($type_crest=='old'){
            return \CRest_OLD::call(self::GET_DEAL, $queryData);
        } else {
            return \CRest_NEW::call(self::GET_DEAL, $queryData);
        }
    }
    public static function getFile(int $dealId): array
    {
        $queryData = [
            "id" => $dealId,
        ];
        return CRest::call('disk.file.get', $queryData);
    }

    public static function getActivity($typeId, $entityId)
    {

        $queryData = [
            'order' => ['ID', 'DESC'],
            "filter" => [
                "OWNER_TYPE_ID" => $typeId,
                "OWNER_ID" => $entityId
            ],
            "select" => ["*", "COMMUNICATIONS"]

        ];
        $result = CRest::call('crm.activity.list', $queryData);
        return $result;
    }

    public static function checkCallActivityOnDeal($dealId, LogChecking $log): bool
    {
        $arAcivity = self::getActivity(2, $dealId);
        $arAcivity = $arAcivity['result'];
        foreach ($arAcivity as $activity) {
            if ($activity['PROVIDER_TYPE_ID'] == 'CALL') {
                $log->addLeadInfo($dealId, "есть звонок в сделке");
                $start = $activity['START_TIME'];
                $finish = $activity['END_TIME'];

                if (!empty($start) and !empty($finish)) {
                    $lenCall = strtotime($finish) - strtotime($start);
                    $log->addLeadInfo($dealId, "Продолжительность звонка $lenCall");
                    if ($lenCall > 10) {
                        return true;
                    }

                } else {
                    $log->addLeadInfo($dealId, "данных о начале/окончании звонка нет");
                }


            }
        }
        $log->addLeadInfo($dealId, "Валидного звонка нет");
        return false;
    }

    public static function getDealByLeadID(int $leadId): array
    {
        $queryData = [
            'order' => ["STATUS_ID" => "ASC"],
            'filter' => ["LEAD_ID" => $leadId],
            'select' => ["*"]
        ];
        $out = CRest::call(self::GET_DEAL_LIST, $queryData);
        return $out['result'];


    }

    public static function startLeadBusinessProcess(int $leadId, int $businessProcId): void
    {

        $queryData = [
            'TEMPLATE_ID' => $businessProcId,
            'DOCUMENT_ID' => ['crm', 'CCrmDocumentLead', "LEAD_" . $leadId],
            'PARAMETERS' => null
        ];
        CRest::call(self::START_BISNESS_PROCESS, $queryData);

    }


    public static function getComment(int $entityId, string $entityType): array
    {
        $queryData =
            [
                'select' => ["ID", "COMMENT"],
                'filter' => ["ENTITY_ID" => $entityId,
                    "ENTITY_TYPE" => $entityType,]
            ];

        return CRest::call(self::GET_COMMENT_ON_ENTITY, $queryData);
    }

    public static function checkNewLiveCommentDeal($dealId, LogChecking $log): bool
    {
        $needl = "лид переведен в сделку";
        $comment = self::getComment($dealId, 'deal');
        $comment = $comment['result'];

        if ((!is_array($comment)) or empty($comment) or ((count($comment) == 1) and (strpos($comment[0]['COMMENT'], $needl) !== false))) {
            $log->addLeadInfo($dealId, "Валидного комментария в живой ленте нет");
            return false;
        }
        $log->addLeadInfo($dealId, "есть комментарий в живой ленте");
        return true;
    }
//       public static function checkNewLiveCommentDeal_t($dealId):bool{
//        $needl = "лид переведен в сделку";
//        $comment =  self::getComment($dealId, 'deal');
//        $comment = $comment['result'];
//
//        if ((!is_array($comment)) or empty($comment) or ((count($comment) ==1) and (strpos($comment[0]['COMMENT'], $needl) !==false))){
//         //   $log->addLeadInfo($dealId, "Валидного комментария в живой ленте нет");
//            return false;
//        }
//      //  $log->addLeadInfo($dealId, "есть комментарий в живой ленте");
//        return true;
//    }


    public static function checkCommentInDeal($dealId, LogChecking $log): bool
    {

        $deal = self::getDeal($dealId);
        $deal = $deal['result'];
        if (empty($deal['COMMENTS'])) {
            $log->addLeadInfo($dealId, "Комментария в сделке нет");
            return false;
        }
        $log->addLeadInfo($dealId, "есть комментарий в сделке");
        return true;
    }

    public static function getSmart(int $id_smart, $id_entity, $type_crest='old')
    {
        $queryData = [
            "entityTypeId" => $id_smart,
            "id" => $id_entity,
        ];
        if ($type_crest=='old'){
            return \CRest_OLD::call(self::GET_SMART, $queryData);
        } else {
            return \CRest_NEW::call(self::GET_SMART, $queryData);
        }

    }

    public static function addSmart(int $id_smart, $field, $type_crest='old')
    {
        $queryData = [
            "entityTypeId" => $id_smart,
            "fields" => $field,
        ];
        if ($type_crest=='old'){
            return \CRest_OLD::call(self::ADD_SMART, $queryData);
        } else {
            return \CRest_NEW::call(self::ADD_SMART, $queryData);
        }
    }


}