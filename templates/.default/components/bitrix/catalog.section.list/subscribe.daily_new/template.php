<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
// Метки для ссылок
$labelUrlDate = date('m').date('y');
$labelUrl = "?utm_source=mailing&utm_medium=".$labelUrlDate."&utm_campaign=plusdaily";
$labelUrlA = "&utm_source=mailing&utm_medium=".$labelUrlDate."&utm_campaign=plusdaily";
?>

<ul style="margin: 0;padding: 0;margin-left: 30px;">
<?
$site_url = "http://www.plusworld.ru";
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):
?>
	<li style="margin-left:0!important;">
        <a href="<?=$site_url.$arSection["SECTION_PAGE_URL"]?><?=$labelUrl?>" style="color:#000; text-decoration:none; font-size:12px; font-family:Arial,Helvetica,sans-serif;">
            <?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?>&nbsp;(<?=$arSection["ELEMENT_CNT"]?>)<?endif;?>
        </a></li>
<?endforeach?>
</ul>

