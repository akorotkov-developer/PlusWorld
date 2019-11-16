<?php
/**
* модуль user_vars Пользовательские переменные
*/

global $DB, $MESS, $APPLICATION;

IncludeModuleLangFile(__FILE__);

$DBType = strtolower($DB->type);

$arClassesList = array();

CModule::AddAutoloadClasses(
  "stat_emails",
  $arClassesList
);