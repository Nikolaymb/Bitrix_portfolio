<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);

class my_tools extends CModule
{
    public $MODULE_ID = "my.tools";
    // ... прочие свойства ...

    function __construct()
    {
        $this->MODULE_VERSION = "1.0.0";
        $this->MODULE_VERSION_DATE = "2024-11-18 10:00:00";
        $this->MODULE_NAME = Loc::getMessage("MY_TOOLS_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MY_TOOLS_MODULE_DESC");
    }

    function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
        
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandler(
            "main",
            "OnProlog",
            $this->MODULE_ID,
            "\MyTools\Core",
            "onPrologHandler"
        );
        
        return true;
    }

    function DoUninstall()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler(
            "main",
            "OnProlog",
            $this->MODULE_ID,
            "\MyTools\Core", 
            "onPrologHandler"
        );
        
        UnRegisterModule($this->MODULE_ID);
        
        return true;
    }
}