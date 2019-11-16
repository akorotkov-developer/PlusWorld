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
<div class="cell large-18">


    <?foreach($arResult["ITEMS"] as $arItem):?>

        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="grid-x grid-padding-x events" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="cell large-6 medium-5">
                <?
                $date = new DateTime($arItem["PROPERTIES"]["DATE"]["VALUE"]);
                $date = $date->format('m/d');
                ?>
                <div class="events__date"><?=$date?></div>
                <div class="events__time"><?=$arItem["PROPERTIES"]["TIME"]["VALUE"]?></div>
                <div class="events__city"><?=$arItem["PROPERTIES"]["PLACE"]["VALUE"]?></div>
            </div>
            <div class="cell large-18 medium-19">
                <a class="events__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>" >
                    <h6><?=$arItem["NAME"]?></h6>
                    <?
                    $preview_text = substr($arItem["PREVIEW_TEXT"], 0, 200);
                    ?>
                    <p class="events__preview"><?=$preview_text?>...</p>
                </a>
            </div>
        </div>

    <?endforeach;?>

</div>




