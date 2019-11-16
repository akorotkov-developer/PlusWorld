<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
<?$APPLICATION->SetTitle($arResult["SECTION"]["PATH"]["0"]["NAME"]);?>



<div class="clear"></div>

<div class="firm-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>

<?$sectionID = $arResult['SECTION']['PATH']['0']['ID'];
$resArticles = CIBlockElement::GetList(array("DATE_ACTIVE_FROM"=>"DESC"), array("IBLOCK_ID"=>$arParams["ARTICLES_IBLOCK_ID"],"PROPERTY_KNOW_BASE"=>$sectionID), false, false, array("ID","IBLOCK_ID","NAME","PREVIEW_PICTURE","DETAIL_PAGE_URL"));
$i = 0;
while($obArticle = $resArticles->GetNextElement()){$i++;}?>

<?$countAll = count($arResult["ITEMS"]) + $i?>
<p>Всего статей: <?=$countAll?></p>

<?$count = count($arResult["ITEMS"])-1;?>
<?foreach($arResult["ITEMS"] as $k => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="firm-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="firm-logo">
            <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
    		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"  /></a>

    		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
		  <br /><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
		<?endif;?>
        </div>

		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?/*echo strip_tags($arItem["PREVIEW_TEXT"]);*/?>
			<?$text = TruncateText($arItem["PREVIEW_TEXT"],110);
				$text = iconv("UTF-8", "Windows-1251", $text);
				$text = iconv("Windows-1251", "UTF-8",  $text);
				?>
				<?echo $text;?>
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
<br /><br />
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<br />
<hr />

<?

$resArticles->NavStart(20);
            while($obArticle = $resArticles->GetNextElement())
    		{
    			$arArticle = $obArticle->GetFields();
                $arItem["ARTICLES"][] = $arArticle;
            }

//if(isset($_REQUEST['dd']))var_dump($arItem["ARTICLES"]);
?>


<?if($arItem["ARTICLES"]):?>
	<h3>Статьи в тему:</h3>
	<?foreach($arItem["ARTICLES"] as $k => $arArticle):?>
		<?$file = CFile::ResizeImageGet($arArticle["PREVIEW_PICTURE"], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_EXACT, true);?>
		<div class="kb_attach_article_item">
			<div class="kb_attach_article"><a href="<?=$arArticle['DETAIL_PAGE_URL']?>"><?if($file['src']):?><img class="kb_article_picture" src="<?=$file['src']?>" /><?endif;?><?=$arArticle['NAME']?></a></div>
		<div class="clear"></div>
		</div>
	<?endforeach;?>
	<hr />
	<?echo $resArticles->NavPrint(GetMessage("PAGES"));?>
<?endif;?>
</div>
<?$frame->end(); // Конец фрейма?>