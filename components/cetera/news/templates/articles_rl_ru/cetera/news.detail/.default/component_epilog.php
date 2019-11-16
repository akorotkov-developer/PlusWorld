<?
if(($_SERVER["HTTP_HOST"])=="www.plusworld.ru") {$iblockId="9";} elseif(($_SERVER["HTTP_HOST"])=="www.plusworld.org") {$iblockId="32";}
CModule::IncludeModule("iblock");

global $APPLICATION;


$APPLICATION->AddHeadString('<meta property="og:image" content="'.$arResult['FB_IMAGE'].'">', false);
$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult["NAME"].'"/>', false);
$APPLICATION->AddHeadString('<meta property="og:description" content="'.$arResult['FB_DESCRIPTION'].'"/>', false);
$APPLICATION->AddHeadString('<meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"/>', false);
$APPLICATION->AddHeadString('<meta property="og:type" content="news"/>', false);

//if(isset($_REQUEST['og'])) var_dump($arResult);
?>