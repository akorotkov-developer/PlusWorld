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
<div class="grid-x grid-padding-x medium-up-2">

    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="cell" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <a class="art" href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>">
                <div class="art__img text-center"><img src="<?=$arItem["IMPORTANT_ARTICLE"]["PREVIEW_PICTURE_SRC"]?>"></div>
                <div class="art__title"><?=$arItem["NAME"]?></div>
                <div class="art__business"><?=$arItem["PREVIEW_TEXT"]?>
                </div>
            </a>
        </div>

    <?endforeach;?>

</div>





