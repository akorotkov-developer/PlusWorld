<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="firm-list_kb">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $k => $arItem):?>
	<div class="firm-item">
        <?if ($k <= 5):?>
		<div class="firm-logo">
            <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
    		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"  /></a>

    		<?endif?>
        </div>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
		  <br /><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a>
		<?endif;?>
        <?else:?>
    		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
    		  <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a>
    		<?endif;?>
        <?endif;?>
        <?if (!empty($arItem["SECTION"])):?>

        <?if ($k <= 5):?><br /><?endif;?><a href="<?=$arItem["SECTION"]["SECTION_PAGE_URL"];?>" class="cat-title"><?=$arItem["SECTION"]["NAME"];?></a>
        <?endif;;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo strip_tags($arItem["PREVIEW_TEXT"]);?>
		<?endif;?>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div style="clear:both"></div>
		<?endif?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<small>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</small><br />
		<?endforeach;?>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<small>
			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</small><br />
		<?endforeach;?>
        <div class="clear"></div>
        <?if ($k == '5'):?><br />
            <strong><?=GetMessage("AND_VIEW_MORE");?></strong><br />
        <?endif;?>
	</div>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>

<!--
<p class="txtc">
<a href="all/" class="black"><?//=GetMessage("VIEW_ALL_ARTICLES");?>&nbsp;&rarr;</a></p>
-->