<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
function pluralForm($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}
?>

<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?$showHr = false;?>
<?$showHr = false; $q = RandString(5);?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID']."_".$q, $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID']."_".$q, $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"));
	?>
	<?$classPict = '';?>
	<?if(!$arItem["PROPERTIES"]["PARTMAIN"]["VALUE"] && $showHr): $showHr = false;?><div class="hr"></div><?endif;?>
	<?if($arItem["PROPERTIES"]["PARTMAIN"]["VALUE"]): $showHr = true;?><div class="main-news-list"><?endif;?>
	<div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']."_".$q);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="Y" && is_array($arItem["PREVIEW_IMG_SMALL"])):?>
			<?$classPict = 'news-text-pict';?>
			<div class="news-picture"><?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="preview_picture" border="0" src="<?=$arItem["PREVIEW_IMG_SMALL"]["SRC"]?>" width="<?=$arItem["PREVIEW_IMG_SMALL"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_IMG_SMALL"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
			<?else:?>
				<img class="preview_picture" border="0" src="<?=$arItem["PREVIEW_IMG_SMALL"]["SRC"]?>" width="<?=$arItem["PREVIEW_IMG_SMALL"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_IMG_SMALL"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
			<?endif;?>
			</div>
		<?endif?>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_IMG_MEDIUM"])):?>
			<?$classPict = 'news-text-pict';?>
			<div class="news-picture"><?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="preview_picture" border="0" src="<?=$arItem["PREVIEW_IMG_MEDIUM"]["SRC"]?>" width="<?=$arItem["PREVIEW_IMG_MEDIUM"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_IMG_MEDIUM"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
			<?else:?>
				<img class="preview_picture" border="0" src="<?=$arItem["PREVIEW_IMG_MEDIUM"]["SRC"]?>" width="<?=$arItem["PREVIEW_IMG_MEDIUM"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_IMG_MEDIUM"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
			<?endif;?>
			</div>
		<?endif?>
		<div class="news-text <?=$classPict?>"> 
		
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<div class="news-name">
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
			<?else:?>
				<b><?echo $arItem["NAME"]?></b><br />
			<?endif;?>
			</div>
		<?endif;?>
		<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
		<?
		$res = CIBlockElement::GetByID($arItem['ID']);
		if($ar_res = $res->GetNext())
		  $counter = $ar_res['SHOW_COUNTER'];
		if($counter < 1)
			$counter = 0;
		$counter = intval($counter);
		$text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
		?>
		
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<span class="news-date-time" style="color:#555;"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>

			<img src="<?=SITE_TEMPLATE_PATH?>/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
			<span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>

		<?endif?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<?if($code == 'SHOW_COUNTER' && empty($value)) $value = 0; ?>
			<span class="news-show-property"><?if($code == 'SHOW_COUNTER'):?><?=GetMessage("IBLOCK_REVIEWS")?><?else:?><?=GetMessage("IBLOCK_FIELD_".$code)?><?endif;?>:&nbsp;<?=$value;?></span>
		<?endforeach;?>
		
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		
			<span class="news-show-property"><?if($pid == 'FORUM_MESSAGE_CNT'):?><?=GetMessage("IBLOCK_COMMENT")?><?else:?><?=$arProperty["NAME"]?><?endif;?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</span>
		<?endforeach;?><br>
		<?$frame->end(); // Конец фрейма?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<span class="news-preview-text"><?echo $arItem["PREVIEW_TEXT"];?></span><br>
		<?endif;?>
		
		
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div style="clear:both"></div>
		<?endif?>		
		</div>
	</div>
	<?if($arItem["PROPERTIES"]["PARTMAIN"]["VALUE"]):?></div><?endif;?>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
