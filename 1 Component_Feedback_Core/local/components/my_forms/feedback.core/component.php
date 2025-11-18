<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$iBlockId = (int)($arParams['IBLOCK_ID'] ?? 7);

if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid()) {
    
    // 1. Проверка обязательных полей
    if (empty($_REQUEST["user_name"]) || empty($_REQUEST["user_email"])) {
        $arResult["ERROR_MESSAGE"][] = "Заполните имя и Email.";
    }

    // 2. Проверка CAPTCHA (если включена)
    global $APPLICATION;
    if ($arParams["USE_CAPTCHA"] == "Y" && !$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"])) {
        $arResult["ERROR_MESSAGE"][] = "Неверно введен код с картинки.";
    }

    // 3. Сохранение данных в Инфоблок
    if (empty($arResult["ERROR_MESSAGE"]) && CModule::IncludeModule("iblock")) {
        
        $el = new CIBlockElement;
        $arLoadArray = Array(
            "IBLOCK_ID"      => $iBlockId,
            "NAME"           => "Заявка от " . $_REQUEST["user_name"] . " (" . date("d.m.Y H:i:s") . ")",
            "ACTIVE"         => "Y",
            "PREVIEW_TEXT"   => $_REQUEST["user_message"],
            "PROPERTY_VALUES"=> array(
                "EMAIL" => $_REQUEST["user_email"],
                "PHONE" => $_REQUEST["user_phone"]
            )
        );

        if($el->Add($arLoadArray)) {
            $arResult["SUCCESS"] = true;
        } else {
            $arResult["ERROR_MESSAGE"][] = "Ошибка сохранения в БД: " . $el->LAST_ERROR;
        }
    }
}

// Подготовка CAPTCHA для вывода в шаблоне
if ($arParams["USE_CAPTCHA"] == "Y") {
    $arResult["CAPTCHA_CODE"] = $APPLICATION->CaptchaGetCode();
}

$this->IncludeComponentTemplate();