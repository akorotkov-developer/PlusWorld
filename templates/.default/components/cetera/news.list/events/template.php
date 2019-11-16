<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>
<div class="event-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
<div class="rubric-navigation top">
	<?=$arResult["NAV_STRING"]?>
    <div class="clear"></div>
</div>
<?endif;?>
<?
$i = 1;$bannerPosition = 3;$countRes = count($arResult["ITEMS"]);
if ($countRes < 3) $bannerPosition = $countRes;
foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="event-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <?if ($arItem["DISPLAY_PROPERTIES"]["PARTNER"]):
?>
        <div class="event-sponsor">

        <?=$arItem["DISPLAY_PROPERTIES"]["PARTNER_STATUS"]["VALUE"]?>
            <?if ($arItem["DISPLAY_PROPERTIES"]["PARTNER_URL"]["VALUE"]):?>
            <a href="<?=$arItem["DISPLAY_PROPERTIES"]["PARTNER_URL"]["VALUE"]?>" target="_blank">
            <?endif;?>
            <?
            $logo = CFile::GetFileArray($arItem["DISPLAY_PROPERTIES"]["PARTNER"]["VALUE"]);
            $arFileTmp = CFile::ResizeImageGet(
              $logo,
              array("width" => 80, 'height' => 40),
              BX_RESIZE_IMAGE_PROPORTIONAL,
              false
           );
           //rint_r($arFileTmp);
            ?>
            <img src="<?=$logo["SRC"]?>"  alt="<?=$arItem["DISPLAY_PROPERTIES"]["PARTNER_STATUS"]["VALUE"]?>" title="<?=$arItem["DISPLAY_PROPERTIES"]["PARTNER_STATUS"]["VALUE"]?>"/>
            <?if ($arItem["DISPLAY_PROPERTIES"]["PARTNER_URL"]["VALUE"]):?>
            </a>
            <?endif;?>
        <div class="clear"></div>
        </div>
    <?endif;?>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<a href="<?=$arItem["DETAIL_PAGE_URL"];?>"><img  src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" class="preview_picture" /></a>
		<?endif?>

        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["PROPERTY_DATE_START_VALUE"]):?><span class="date"><?echo ConvertDateTime($arItem["PROPERTY_DATE_START_VALUE"], "DD.MM.YYYY")?><?if (MakeTimeStamp($arItem["PROPERTY_DATE_END_VALUE"]) > MakeTimeStamp($arItem["PROPERTY_DATE_START_VALUE"])+86400):?> &ndash; <?echo ConvertDateTime($arItem["PROPERTY_DATE_END_VALUE"], "DD.MM.YYYY")?><?endif;?></span><?endif?>
        <?$APPLICATION->IncludeComponent(
        	"cetera:comments.count",
        	"right",
        	Array(
            "IBLOCK_ID" => $arItem["IBLOCK_ID"],
            "ELEMENT_ID" => $arItem["ID"],
            "COMMENTS_IBLOCK_ID" => 20,
        	),
            false
        );?>
        <br />
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="link" ><?echo $arItem["NAME"]?></a><br />
        <?endif;?>
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?>

        <div class="clear"></div>

	</div>
	<?if ($i == $bannerPosition){?>
        <div class="rubric-banner">
        <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
	"TYPE" => "EVENTS_BANNER_468",
	"NOINDEX" => "Y",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "360"
	),
	false
);?>
        </div>
    <?}?>
<?$i++;?>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<div class="rubric-navigation bot">
	<?=$arResult["NAV_STRING"]?>
</div>
<?endif;?>
</div>
