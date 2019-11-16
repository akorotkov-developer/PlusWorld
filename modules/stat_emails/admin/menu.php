<?
IncludeModuleLangFile(__FILE__);
CModule::IncludeModule("iblock");


$aMenu[] = array(
		"parent_menu" => "global_menu_services",
		"section" => "stat_emails",
		"sort" => 200,
		"url" => "stat_emails.php",
		"text" => 'Статистика открытых писем',
		"title" => 'Статистика открытых писем',
		"icon" => "stat_emails_icon_16",
		"page_icon" => "stat_emails_icon_32",
		"module_id" => "stat_emails",
	);

return $aMenu;