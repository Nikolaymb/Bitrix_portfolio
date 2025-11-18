<?php
namespace Custom\Property;

use Bitrix\Main\Localization\Loc;

class JsonField
{
    public static function GetUserTypeDescription()
    {
        return [
            "PROPERTY_TYPE" => "S", 
            "USER_TYPE" => "json_data", 
            "DESCRIPTION" => "JSON-поле (структура)",
            "GetPropertyFieldHtml" => [__CLASS__, "GetPropertyFieldHtml"],
            "ConvertToDB" => [__CLASS__, "ConvertToDB"],
            "ConvertFromDB" => [__CLASS__, "ConvertFromDB"],
        ];
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $jsonValue = $value["VALUE"];
        $displayValue = is_string($jsonValue) ? $jsonValue : json_encode($jsonValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        return '<textarea name="' . $strHTMLControlName["VALUE"] . '" rows="10" style="width:100%;">' . htmlspecialchars($displayValue) . '</textarea>';
    }

    public static function ConvertToDB($arProperty, $value)
    {
        if (!empty($value["VALUE"])) {
            json_decode($value["VALUE"]);
            if (json_last_error() === JSON_ERROR_NONE) {
                 return ["VALUE" => $value["VALUE"]];
            } else {
                 return ["VALUE" => "{\"error\":\"Invalid JSON format\"}"];
            }
        }
        return ["VALUE" => null];
    }
    
    public static function ConvertFromDB($arProperty, $value)
    {
        $jsonArray = json_decode($value["VALUE"], true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return ["VALUE" => $jsonArray];
        }
        return ["VALUE" => $value["VALUE"]];
    }
}