<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); 
/********************************************************************
				Input params
********************************************************************/
$arParams["ALBUM_PHOTO_SIZE"] = intVal($arParams["ALBUM_PHOTO_SIZE"]);

/********************************************************************
				/Input params
********************************************************************/

// TODO: get rid of this
CAjax::Init();
// TODO: get rid of this too
$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/js/main/utils.js');

$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/components/bitrix/photogallery/templates/.default/script.js');
if (!$this->__component->__parent || strpos($this->__component->__parent->__name, "photogallery") === false):
	//$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/photogallery/templates/.default/style.css');
	//$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/photogallery/templates/.default/themes/gray/style.css');
?>
<style>
.photo-album-list div.photo-item-cover-block-container,
.photo-album-list div.photo-item-cover-block-outer,
.photo-album-list div.photo-item-cover-block-inner{
	background-color: white;
	height:<?=($arParams["ALBUM_PHOTO_SIZE"])+40?>px;
	width:<?=($arParams["ALBUM_PHOTO_SIZE"] + 40)?>px;}
div.photo-album-avatar{
	width:<?=$arParams["ALBUM_PHOTO_SIZE"]?>px;
	height:<?=ceil($arParams["ALBUM_PHOTO_SIZE"]/7)*5?>px;}
ul.photo-album-list div.photo-item-info-block-outside {
	width: <?=($arParams["ALBUM_PHOTO_SIZE"] + 68)?>px;}
</style>
<?
endif;
if (!function_exists("__photo_cut_long_words"))
{
	function __photo_cut_long_words($str)
	{
		$MaxStringLen = 5;
		if (strLen($str) > $MaxStringLen)
			$str = preg_replace("/([^ \n\r\t\x01]{".$MaxStringLen."})/is".BX_UTF_PCRE_MODIFIER, "\\1<WBR/>&shy;", $str);
		return $str;
	}
}
if (!function_exists("__photo_part_long_words"))
{
	function __photo_part_long_words($str)
	{
		$word_separator = "\s.,;:!?\#\-\*\|\[\]\(\)\{\}";
		if (strLen(trim($str)) > 5)
		{
			$str = str_replace(
				array(chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8),
					"&amp;", "&lt;", "&gt;", "&quot;", "&nbsp;", "&copy;", "&reg;", "&trade;",
					chr(34), chr(39)),
				array("", "", "", "", "", "", "", "",
					chr(1), "<", ">", chr(2), chr(3), chr(4), chr(5), chr(6),
					chr(7), chr(8)),
				$str);
			$str = preg_replace("/(?<=[".$word_separator."]|^)(([^".$word_separator."]+))(?=[".$word_separator."]|$)/ise".BX_UTF_PCRE_MODIFIER,
				"__photo_cut_long_words('\\2')", $str);

			$str = str_replace(
				array(chr(1), "<", ">", chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), "&lt;WBR/&gt;", "&lt;WBR&gt;", "&amp;shy;"),
				array("&amp;", "&lt;", "&gt;", "&quot;", "&nbsp;", "&copy;", "&reg;", "&trade;", chr(34), chr(39), "<WBR/>", "<WBR/>", "&shy;"),
				$str);
		}
		return $str;
	}
}
?>

<?if (empty($arResult["SECTIONS"])):?>
<div class="photo-info-box photo-info-box-sections-list-empty">
	<div class="photo-info-box-inner"><?=GetMessage("P_EMPTY_DATA")?></div>
</div>
<?
return false;
endif;?>
<?
if (!empty($arResult["NAV_STRING"])):
?>
<div class="photo-navigation photo-navigation-bottom">
	<?=$arResult["NAV_STRING"]?>
</div>
<div class="clear"></div>
<?
endif;
?>
<div class="photo-items-list photo-album-list<?if($arParams['PHOTO_LIST_MODE'] == "Y"){echo " photo-album-list-first-photos";}?>">
	<?$k = 1;
    foreach($arResult["SECTIONS"] as  $res):?>
	<?
		$res["ORIG_NAME"] = $res["NAME"];
		$res["NAME"] = __photo_part_long_words($res["NAME"]);
	?>

	<div class="photo-album-item photo-album-<?=($res["ACTIVE"] != "Y" ? "nonactive" : "active")?> <?=(
		!empty($res["PASSWORD"]) ? "photo-album-password" : "")?>" id="photo_album_info_<?=$res["ID"]?>" <?
		if ($res["ACTIVE"] != "Y" || !empty($res["PASSWORD"]))
		{
			$sTitle = GetMessage("P_ALBUM_IS_NOT_ACTIVE");
			if ($res["ACTIVE"] != "Y" && !empty($res["PASSWORD"]))
				$sTitle = GetMessage("P_ALBUM_IS_NOT_ACTIVE_AND_PASSWORDED");
			elseif (!empty($res["PASSWORD"]))
				$sTitle = GetMessage("P_ALBUM_IS_PASSWORDED");
			?> title="<?=$sTitle?>" <?
		}
		?>>



		<div class="photo-item-cover photo-album-avatar <?=(empty($res["DETAIL_PICTURE"]["SRC"])? "photo-album-avatar-empty" : "")?>" id="photo_album_cover_<?=$res["ID"]?>" title="<?= htmlspecialchars($res["~NAME"])?>"
			<?if (!empty($res["DETAIL_PICTURE"]["SRC"])):?>
				style="background-image:url('<?=$res["DETAIL_PICTURE"]["SRC"]?>');"
			<?endif;?>
			<?if ($arParams["PERMISSION"] >= "W"):?>
				onmouseover="BX.addClass(this, 'photo-album-avatar-edit');"
			<?else:?>
				onclick="window.location='<?=CUtil::JSEscape(htmlspecialchars($res["~LINK"]))?>';"
			<?endif;?>
			>
			<?if ($arParams["PERMISSION"] >= "W"):?>
			<div class="photo-album-menu" onmouseout="BX.removeClass(this.parentNode, 'photo-album-avatar-edit')" onclick="window.location='<?=CUtil::JSEscape(htmlspecialchars($res["~LINK"]))?>';">
				<div class="photo-album-menu-substrate"></div>
					<div class="photo-album-menu-controls">
					<a rel="nofollow" href="<?=$res["EDIT_LINK"]?>" class="photo-control-edit photo-control-album-edit" title="<?=GetMessage("P_SECTION_EDIT_TITLE")?>"><span><?=GetMessage("P_SECTION_EDIT")?></span></a>
					<a rel="nofollow" href="<?= $res["DROP_LINK"]."&".bitrix_sessid_get()?>" class="photo-control-drop photo-control-album-drop" onclick="if (confirm('<?=GetMessage('P_SECTION_DELETE_ASK')?>')) {DropAlbum(this.href, parseInt('<?=$res["ID"]?>'));} return BX.PreventDefault(arguments[0]);" title="<?= GetMessage("P_SECTION_DELETE_TITLE")?>"><span><?=GetMessage("P_SECTION_DELETE")?></span></a>
				</div>
			</div>
			<?endif;?>
		</div>

<div class="photo-item-info-block-inner">

	<div class="photo-album-date"><span id="photo_album_date_<?=$res["ID"]?>"><?=$res["DATE"]?></span></div>
	<div class="photo-album-photos"><?=$res["ELEMENTS_CNT"]?> <?=GetMessage("P_SECT_PHOTOS")?></div>
	<div class="photo-album-name">
		<a href="<?=$res["LINK"]?>" id="photo_album_name_<?=$res["ID"]?>" title="<?=htmlspecialchars($res["~NAME"])?>" ><?=truncate($res["NAME"], 110 , "&hellip;")?></a>
        <?/*onmouseover="__photo_check_name_length(event, this);"*/?>
	</div>
	<div class="photo-album-description" id="photo_album_description_<?=$res["ID"]?>"><?=$res["DESCRIPTION"]?></div>
    <div class="clear"></div>
</div>

	</div>
    <?if ($k % 2 == "0"):?>
    <div class="clear"></div>

    <?endif;?>
    <?if ($k == '4'):?>
    <div class="clear"></div>
        <div class="ban-468x60">
        <?$APPLICATION->IncludeComponent(
        	"bitrix:advertising.banner",
        	"",
        	Array(
        		"TYPE" => "BANNER_468X60_PHOTO",
        		"NOINDEX" => "N",
        		"CACHE_TYPE" => "A",
        		"CACHE_TIME" => "0",
        		"CACHE_NOTES" => ""
        	),
        false
        );?>
        </div>
    <?elseif ($k == '8'):?>
    <div class="clear"></div>
        <div>
    <?
    //$GLOBALS["popphotoFilter"] = array(">SHOW_COUNTER_START" => date("d-m-Y H:i:s",time()-86400*90));

    $APPLICATION->IncludeComponent("cetera:photo.top", "pop", array(
	"IBLOCK_TYPE" => "services",
	"IBLOCK_ID" => "68",
	"SECTION_FIELDS" => array(
		0 => "",
		1 => "",
	),
	"SECTION_USER_FIELDS" => array(
		0 => "",
		1 => "",
	),
	"SECTION_SORT_FIELD" => "",
	"SECTION_SORT_ORDER" => "desc",
	"ELEMENT_SORT_FIELD" => "SHOW_COUNTER",
	"ELEMENT_SORT_ORDER" => "desc",
	"FILTER_NAME" => "popphotoFilter",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"SECTION_COUNT" => "1",
	"ELEMENT_COUNT" => "4",
	"LINE_ELEMENT_COUNT" => "4",
	"SECTION_URL" => $arResult["URL_TEMPLATES"]["section"],
	"DETAIL_URL" => $arResult["URL_TEMPLATES"]["detail"],
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
    "PHOTO_SIZE"	=> 140,
	),
	false
);?></div>
    <?endif;
    $k++;?>
<?endforeach;?>
</div>
<div class="empty-clear"></div>

<?
if (!empty($arResult["NAV_STRING"])):
?>
<div class="photo-navigation photo-navigation-bottom">
	<?=$arResult["NAV_STRING"]?>
</div>
<?
endif;
?>