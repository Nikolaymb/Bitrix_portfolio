<?php
require_once(__DIR__ . '/include/CleanupAgent.php');

if (!defined('CLEANUP_AGENT_REGISTERED')) {
    \CAgent::AddAgent(
        '\MyProject\CleanupAgent::cleanOldNews(3);', 
        "iblock", 
        "N", 
        86400, // 24 часа
        "", 
        "Y" 
    );
    define('CLEANUP_AGENT_REGISTERED', true);
}