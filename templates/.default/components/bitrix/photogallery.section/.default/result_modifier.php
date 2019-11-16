<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if(count($arResult["SECTION"]["PATH"]) > 1){
    foreach ($arResult["SECTION"]["PATH"] AS $k=> $sect)
    {
        $arResult["PAGE_TITLE"] .= " ".$sect["NAME"];
    }
}
