<?php
// Регистрация обработчика события, которое подключает пользовательские типы свойств
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
    "iblock",
    "OnIBlockPropertyBuildList",
    ["\Custom\Property\JsonField", "GetUserTypeDescription"]
);

require_once(__DIR__ . '/include/JsonField.php');