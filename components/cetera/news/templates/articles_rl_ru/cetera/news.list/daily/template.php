<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
<div class="rubric-navigation top">
	<?=$arResult["NAV_STRING"]?>
    <div class="clear"></div>
</div>
<?endif;?>

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

<?
$i = 1;$bannerPosition = 3;$countRes = count($arResult["ITEMS"]);
if ($countRes < 3) $bannerPosition = $countRes;
foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
			<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
	<div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div class="preview_picture_link"><a href="<?=$arItem["DETAIL_PAGE_URL"].'?id='.$arItem["ID"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" class="preview_picture" /></a></div>
		<?endif?>

		<?
		$res = CIBlockElement::GetByID($arItem['ID']);
		if($ar_res = $res->GetNext())
		  $counter = $ar_res['SHOW_COUNTER'];
		if($counter < 1)
			$counter = 0;
		$counter = intval($counter);
		$text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
		if($_SERVER["SERVER_NAME"] == "www.plusworld.org")
			$text_counter = "views";
		?>
		
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<span class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>
			<img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
			<span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>
		<?endif?>
				<?/*$APPLICATION->IncludeComponent(
        	"cetera:comments.count",
        	"",
        	Array(
            "IBLOCK_ID" => $arItem["IBLOCK_ID"],
            "ELEMENT_ID" => $arItem["ID"],
            "COMMENTS_IBLOCK_ID" => 20,
        	),
            false
        );*/?><br />
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="link" ><?echo $arItem["NAME"]?></a><br />
        <?endif;?>
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?>

        <div class="clear"></div>

	</div>
	<?$frame->end(); // Конец фрейма?>
	<?if ($i == $bannerPosition){?>
        <div class="rubric-banner">
        <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "", Array(
        	"TYPE" => "NEWS_BANNER_468",	// Тип баннера
        	"CACHE_TYPE" => "A",	// Тип кеширования
        	"NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
        	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
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
