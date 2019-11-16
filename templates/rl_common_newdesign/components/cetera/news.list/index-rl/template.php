<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<h6>Лента новостей</h6><a class="info" href="#">

<?
$count = 0;
$last = "";
$countElements = count($arResult["ITEMS"]);
?>

<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

    <?$count++;?>

    <?
    if ($count == $countElements) {
        $last = "info_last";
    }
    ?>

    <a id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="info <?=$last?>" href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
            <div class="info__title"><?echo $arItem["NAME"]?></div>
        <?endif;?>
        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
            <div class="info__line">
                <div class="info__date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
            </div>
        <?endif?>
    </a>



<?endforeach;?>

<div class="grid-x grid-padding-x margin-bottom-7 align-center">
    <div class="cell large-18"><a class="button hollow expanded" href="/news/">все новости  </a></div>
</div>
