<?php

declare(strict_types=1);

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$faqModuleDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
$faqModuleScriptHref = ($faqModuleDir === '' ? '' : $faqModuleDir) . '/script.js';
