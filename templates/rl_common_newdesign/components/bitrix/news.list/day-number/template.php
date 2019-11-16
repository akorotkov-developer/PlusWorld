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

<div class="blank__back"></div>
<div class="blank__container">
    <div class="blank__triangle"></div>
</div>
<div class="blank__title">
    Цифра
    <span class="text-dark-gray">дня</span>
</div>
<div class="currency">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>


        <div class="currency__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <a href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>" class="buy">
                <div class="currency__big"><?=$arItem["NAME"];?></div>
                <div class="currency__percent"><?=$arItem["PROPERTIES"]["NUMBER_COMMENT"]["VALUE"]?></div>
                <p class="text-left"><?=$arItem["PREVIEW_TEXT"]?></p>
            </a>
        </div>


    <?endforeach;?>
</div>




