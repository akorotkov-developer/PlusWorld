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

$arResult["SECTIONS"] = array_reverse($arResult["SECTIONS"]);
?>

<ul class="archive-menu">
    <?foreach ($arResult["SECTIONS"] as $arItem) {?>
        <?$page = $APPLICATION->GetCurPageParam("year=".$arItem["NAME"], array("year", "sect_id")); ?>
        <li class="archive-menu__item"><a class="archive-menu__link <?if ($_GET["year"] == (int)$arItem["NAME"]) {echo "archive-menu__link_active";}?>" href="<?=$page."&amp;sect_id=".$arItem["ID"]?>"><?=$arItem["NAME"]?></a></li>
    <?}?>
</ul>