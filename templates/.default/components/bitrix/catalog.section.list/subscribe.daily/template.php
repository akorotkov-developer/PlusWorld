<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul style="list-style-type:none;margin: 0;padding:0;">
<?
$site_url = "http://www.plusworld.ru";
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):
?>
	<li><a href="<?=$site_url.$arSection["SECTION_PAGE_URL"]?>" style="color:#333;"><?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?>&nbsp;(<?=$arSection["ELEMENT_CNT"]?>)<?endif;?></a></li>
<?endforeach?>
</ul>

