<?php
namespace MyProject;

use CIBlockElement;
use CEventLog;

class CleanupAgent 
{
    public static function cleanOldNews(int $iBlockId) 
    {
        if (!\CModule::IncludeModule("iblock")) {
            return __METHOD__ . '(' . $iBlockId . ');';
        }
        
        $daysToKeep = 90;

        $dateLimit = new \Bitrix\Main\Type\DateTime();
        $dateLimit->add("-$daysToKeep days");
        $dateFormatted = $dateLimit->format("d.m.Y H:i:s");

        $deletedCount = 0;

        $res = CIBlockElement::GetList(
            [],
            [
                "IBLOCK_ID" => $iBlockId,
                "<DATE_CREATE" => $dateFormatted, 
            ],
            false,
            false,
            ["ID"]
        );

        while ($el = $res->Fetch()) {
            if (CIBlockElement::Delete($el["ID"])) {
                $deletedCount++;
            }
        }
        
        CEventLog::Add([
            "SEVERITY" => "NOTICE",
            "AUDIT_TYPE_ID" => "IBLOCK_CLEANUP",
            "MODULE_ID" => "iblock",
            "DESCRIPTION" => "Агент очистки: удалено $deletedCount элементов из ИБ #$iBlockId."
        ]);

        return __METHOD__ . '(' . $iBlockId . ');';
    }
}