<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$aMenu = array (
	"parent_menu" 	=> "global_menu_services",
	"sort" 			=> 800,
	"icon" 			=> "wi-csv-ico",
	"text" 			=> Loc::getMessage("PLUS_CSV"),
	"title" 		=> Loc::getMessage("PLUS_CSV"),
	"module_id" 	=> "plus.csv",
	"items_id" 		=> "menu_plus_import_csv",
    "url" 			=> "plus_csv_import.php?lang=".LANGUAGE_ID,
);
 
return $aMenu;
?>