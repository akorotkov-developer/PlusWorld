<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$count = 1;
$elements = floor(count($arResult["SECTIONS"]) / 3);
?>
<div class="cell">
<?foreach($arResult["SECTIONS"] as $arSection){?>
    <?if ($count % $elements == 0 and $count != count($arResult["SECTION"])) {?>
        </div>
        <div class="cell drop__line">
    <?}?>
        <a class="drop__link" href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
    <?$count++;?>
<?}?>


