<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult["ITEMS"] as $k=>$arItem):?>
    <a href="<?echo $arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>" target="_blank"><?echo $arItem["NAME"]?></a><br />
<?endforeach;?>
