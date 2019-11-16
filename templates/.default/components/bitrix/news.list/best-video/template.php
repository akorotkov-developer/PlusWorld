<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?//if ($_REQUEST["rt"]==1) {
$code_video = $arResult["ITEMS"][0]["PROPERTIES"]["VIDEO"]["~VALUE"]["TEXT"];
$text_video = $arResult["ITEMS"][0]["DETAIL_TEXT"];
$obElement = CIBlockElement::GetByID($arResult["ITEMS"][0]["PROPERTIES"]["VIDEO_SELECT"]["VALUE"]);
$arEl = $obElement->GetNext();
$url_video = $arEl["DETAIL_PAGE_URL"];?>
<?=$code_video;?>
<div>
<?
echo substr(strip_tags($text_video),0,500).' <a href="'.$url_video.'" target="_blank">...</a>';
?>
</div>
<?/*
<?} else {?>
<?=$arResult["ITEMS"][0]["PROPERTIES"]["VIDEO"]["~VALUE"]["TEXT"]?>
<div>
<?if (strlen(strip_tags($arResult["ITEMS"][0]["DETAIL_TEXT"]))<500) {
echo $arResult["ITEMS"][0]["DETAIL_TEXT"];
} else {
echo substr(strip_tags($arResult["ITEMS"][0]["DETAIL_TEXT"]),0,500).'...';
}?>
</div>

<? } */?>