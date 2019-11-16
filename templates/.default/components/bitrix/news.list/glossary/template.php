<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); 
//$APPLICATION->SetPageProperty("title", "НСПК | Национальная система платежных карт | Купюры России | СКБ банк на диване | Visa payWave");
$APPLICATION->SetTitle("Все термины");?>
<div class="firm-list">
<?//if ($_REQUEST["rt"]==1) {echo "<pre>"; print_r($arResult); echo "</pre>"; }?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?$count = count($arResult["ITEMS"])-1;?>
<?foreach($arResult["ITEMS"] as $k => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="firm-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a>
        <div class="clear"></div>
	</div>
    <?if ($k == '5' || $k == $count):?>
    <div class="clear"></div>
        <div class="ban-468x60">
        <?$APPLICATION->IncludeComponent(
        	"bitrix:advertising.banner",
        	"",
        	Array(
        		"TYPE" => "BANNER_468X60_PEBG",
        		"NOINDEX" => "N",
        		"CACHE_TYPE" => "A",
        		"CACHE_TIME" => "0",
        		"CACHE_NOTES" => ""
        	),
        false
        );?>
        </div>
    <?endif;?>
<?endforeach;?>
<div class="rubric-navigation bot">
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
    <div class="clear"></div>
</div>

</div>
