<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); 
if (empty($arResult["ELEMENTS_LIST"]))
	return true;

if (!$this->__component->__parent || strpos($this->__component->__parent->__name, "photogallery") === false)
{
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/photogallery/templates/.default/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/photogallery/templates/.default/themes/gray/style.css');
}

// Javascript for iblock.vote component which used for rating
// file script1.js was special renamed from script.js for prevent auto-including this file to the body of the ajax requests
if ($arParams["USE_RATING"] == "Y")
	$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/components/bitrix/photogallery.detail.list.ex/templates/.default/bitrix/iblock.vote/ajax/script1.js');

/********************************************************************
				Input params
********************************************************************/
// PICTURE
$temp = array("STRING" => preg_replace("/[^0-9]/is", "/", $arParams["THUMBNAIL_SIZE"]));
list($temp["WIDTH"], $temp["HEIGHT"]) = explode("/", $temp["STRING"]);
$arParams["THUMBNAIL_SIZE"] = (intVal($temp["WIDTH"]) > 0 ? intVal($temp["WIDTH"]) : 120);

if ($arParams["PICTURES_SIGHT"] != "standart" && intVal($arParams["PICTURES"][$arParams["PICTURES_SIGHT"]]["size"]) > 0)
	$arParams["THUMBNAIL_SIZE"] = $arParams["PICTURES"][$arParams["PICTURES_SIGHT"]]["size"];

$arParams["ID"] = md5(serialize(array("default", $arParams["FILTER"], $arParams["SORTING"])));

$arParams["SHOW_RATING"] = ($arParams["SHOW_RATING"] == "Y" ? "Y" : "N");
$arParams["SHOW_SHOWS"] = ($arParams["SHOW_SHOWS"] == "Y" ? "Y" : "N");
$arParams["SHOW_COMMENTS"] = ($arParams["SHOW_COMMENTS"] == "Y" ? "Y" : "N");
$arParams["COMMENTS_TYPE"] = (strToLower($arParams["COMMENTS_TYPE"]) == "blog" ? "blog" : "forum");
$arParams["SHOW_DATETIME"] = ($arParams["SHOW_DATETIME"] == "Y" ? "Y" : "N");
$arParams["SHOW_DESCRIPTION"] = ($arParams["SHOW_DESCRIPTION"] == "Y" ? "Y" : "N");

// PAGE
$arParams["SHOW_PAGE_NAVIGATION"] = (in_array($arParams["SHOW_PAGE_NAVIGATION"], array("none", "top", "bottom", "both")) ?
		$arParams["SHOW_PAGE_NAVIGATION"] : "bottom");
$arParams["NEW_DATE_TIME_FORMAT"] = trim(!empty($arParams["NEW_DATE_TIME_FORMAT"]) ? $arParams["NEW_DATE_TIME_FORMAT"] :
	$DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")));

$arParams["GROUP_DATE"] = ($arParams["GROUP_DATE"] == "Y" ? "Y" : "N");
/********************************************************************
				Input params
********************************************************************/

if (!empty($arResult["ERROR_MESSAGE"])):
?>
<div class="photo-error">
	<?=ShowError($arResult["ERROR_MESSAGE"])?>
</div>
<?
endif;

if (in_array($arParams["SHOW_PAGE_NAVIGATION"], array("top", "both")) && !empty($arResult["NAV_STRING"])):
?>
<div class="photo-navigation photo-navigation-top">
	<?=$arResult["NAV_STRING"]?>
</div>
<?
endif;
$current_date = "";
?>

<div class="photo-items-list photo-photo-list www" id="photo_list_<?= htmlspecialcharsEx($arParams["~UNIQUE_COMPONENT_ID"])?>">
<?/* Used to show 'More photos' in js*/
if($_REQUEST['get_elements_html']){ob_start();}?>
<?
foreach ($arResult["ELEMENTS_LIST"] as $key => $arItem)
{
	if ($arParams["SHOW_DATE"] == "Y")
	{
		$this_date = PhotoFormatDate($arItem["~DATE_CREATE"], "DD.MM.YYYY HH:MI:SS", "d.m.Y");
		if ($this_date != $current_date)
		{
			$current_date = $this_date;
			?><div class="group-by-days photo-date"><?= PhotoDateFormat($arParams["NEW_DATE_TIME_FORMAT"], MakeTimeStamp($this_date, "DD.MM.YYYY"))?></div><?
		}
	}

	$arItem["TITLE"] = htmlspecialcharsEx($arItem["~PREVIEW_TEXT"]);

	if ($arParams['MODERATION'] == 'Y' && $arParams["PERMISSION"] >= "W")
	{
		$bNotActive = $arItem["ACTIVE"] != "Y";
		$arItem["TITLE"] .= '['.GetMessage("P_NOT_MODERATED").']';
	}

	if ($arParams["DRAG_SORT"] == "Y")
		$arItem["TITLE"] .= " - ".GetMessage("START_DRAG_TO_SORT");
	$arItem["TITLE"] = trim($arItem["TITLE"], " -");

	$src = $arItem["PREVIEW_PICTURE"]["SRC"];
	$w = intVal($arItem["PREVIEW_PICTURE"]["WIDTH"]);
	$h = intVal($arItem["PREVIEW_PICTURE"]["HEIGHT"]);
	if (!$w || !$h)
		continue;
	$r = $w / $h;

	if ($r > 1)
	{
		$item_w = 'width: '.($arParams['THUMBNAIL_SIZE'] * $r-30).'px;';
		$item_h = 'height: '.($arParams['THUMBNAIL_SIZE']-30)."px;";
		$item_left = 'left: '.round(($arParams['THUMBNAIL_SIZE'] - $arParams['THUMBNAIL_SIZE'] * $r /*width*/) / 2).'px;';
		$item_top = '';
	}
	else
	{
		$item_w = 'width: '.($arParams['THUMBNAIL_SIZE']-30).'px;';
		$item_h = 'height: '.round($arParams['THUMBNAIL_SIZE'] / $r-30).'px';
		$item_top = 'top: '.round(($arParams['THUMBNAIL_SIZE'] - $arParams['THUMBNAIL_SIZE'] / $r /*height*/) / 2).'px;';
		$item_left = '';
	}
?>
		<div id="photo_cont_<?=$arItem["ID"]?>" class="photo-item-cont <?if ($arParams["PERMISSION"] >= "X"){echo ' photo-item-cont-moder';}?>" title="<?= $arItem["TITLE"]?>">
			<a class="photo-item-inner" style="width: <?= $arParams['THUMBNAIL_SIZE']+20?>px; height: <?= $arParams['THUMBNAIL_SIZE']+20?>px;" href="<?=$arItem["URL"]?>" id="photo_<?=$arItem["ID"]?>">
				<img src="<?= $src?>" border="0" style="<?= $item_w?> <?= $item_h?> <?= $item_left?> <?= $item_top?>;" />
				<?if($bNotActive):?>
				<img class="bxph-warn-icon" src="/bitrix/components/bitrix/photogallery.detail.list.ex/templates/.default/images/not-approved.png" /><br />
					<?if ($arParams["PERMISSION"] >= "X" && false /* TODO : add buttons for fast approving a deleting for moderators*/):?>
						<span class="bxph-warn-link" style="top: <?= (round($arParams['THUMBNAIL_SIZE'] / 2) - 25)?>px; width: <?= $arParams['THUMBNAIL_SIZE']?>px;"><?= GetMessage("P_ACTIVATE")?></span>
						<span class="bxph-warn-link" style="top: <?= (round($arParams['THUMBNAIL_SIZE'] / 2) + 1)?>px; width: <?= $arParams['THUMBNAIL_SIZE']?>px"><?= GetMessage("P_DELETE")?></span>
					<?endif;?>
				<?endif;?></a>

		</div>
<?
};

if($_REQUEST['get_elements_html']){$elementsHTML = ob_get_clean();}
?>
</div>
<div class="empty-clear"></div>
<div align="center">Выводить по: <select id="per_page_count">
<option value="15" <?=($arParams['PAGE_ELEMENTS'] == 15 ? 'selected="selected"' : '');?>>15</option>
<option value="50" <?=($arParams['PAGE_ELEMENTS'] == 50 ? 'selected="selected"' : '');?>>50</option>
<option value="100" <?=($arParams['PAGE_ELEMENTS'] == 100 ? 'selected="selected"' : '');?>>100</option>
<option value="200" <?=($arParams['PAGE_ELEMENTS'] == 200 ? 'selected="selected"' : '');?>>200</option>
<option value="10000" <?=($arParams['PAGE_ELEMENTS'] == 10000 ? 'selected="selected"' : '');?>>Все</option>
</select></div>
<?if ($arResult["MORE_PHOTO_NAV"] == "Y"):?>
<div id="photo-more-photo-link-cont" class="photo-show-more">
	<img class="show-more-wait" src="/bitrix/components/bitrix/photogallery.detail.list.ex/templates/.default/images/wait.gif" />
	<a id="photo-more-photo-link" href="javascript:void(0);" title="<?= GetMessage("P_SLIDER_MORE_PHOTOS_TITLE")?>"><?= GetMessage("P_SLIDER_MORE_PHOTOS")?></a>
</div>
<?endif;?>

<?
if ($_REQUEST["return_array"] == "Y" && $_REQUEST["UCID"] == $arParams["~UNIQUE_COMPONENT_ID"])
{
	$APPLICATION->RestartBuffer();
	?><script>window.bxphres = {
		items: <?= CUtil::PhpToJSObject($arResult["ELEMENTS_LIST_JS"])?>,
		currentPage: '<?= intVal($arResult["NAV_RESULT_NavPageNomer"])?>',
		itemsPageSize: '<?= intVal($arResult["NAV_RESULT_NavPageSize"])?>',
		itemsCount: '<?= intVal($arResult["ALL_ELEMENTS_CNT"])?>',
		pageCount: '<?= intVal($arResult["NAV_RESULT_NavPageCount"])?>'
	};
	<?if($_REQUEST['get_elements_html']):?>
		window.bxphres.elementsHTML = '<?= CUtil::JSEscape(trim($elementsHTML))?>';
	<?endif;?>
	</script><?
	die();
}

$ucid = CUtil::JSEscape($arParams["~UNIQUE_COMPONENT_ID"]);
?>
<script>
BX.ready(function(){
	if (!top.oBXPhotoList)
	{
		top.oBXPhotoList = {};
		top.oBXPhotoSlider = {};
	}

	var pPhotoCont<?= $ucid?> = BX('photo_list_<?= $ucid?>');
	// Used for load more photos and also for drag'n'drop sorting
	top.oBXPhotoList['<?= $ucid?>'] = new window.BXPhotoList({
		uniqueId: '<?= $ucid?>',
		actionUrl: '<?= CUtil::JSEscape($arParams["ACTION_URL"])?>',
		actionPostUrl: <?= ($arParams['CHECK_ACTION_URL'] == 'Y' ? 'false' : 'true')?>,
		itemsCount: '<?= intVal($arResult["ALL_ELEMENTS_CNT"])?>',
		itemsPageSize: '<?= intVal($arResult["NAV_RESULT_NavPageSize"])?>',
		navName: 'PAGEN_<?= intVal($arResult["NAV_RESULT_NavNum"])?>',
		currentPage: '<?= intVal($arResult["NAV_RESULT_NavPageNomer"])?>',
		pageCount: '<?= intVal($arResult["NAV_RESULT_NavPageCount"])?>',
		items: <?= CUtil::PhpToJSObject($arResult["ELEMENTS_LIST_JS"])?>,
		pElementsCont: pPhotoCont<?= $ucid?>,
		initDragSorting: '<?= $arParams["DRAG_SORT"]?>',
		sortedBySort: '<?= $arParams["SORTED_BY_SORT"]?>',
		morePhotoNav: '<?= $arResult["MORE_PHOTO_NAV"]?>',
		thumbSize: '<?= $arParams["THUMBNAIL_SIZE"]?>',
		canModerate: <?= ($arParams['MODERATION'] == "Y" && $arParams["PERMISSION"] >= 'X' ? "true" : "false")?>
	});

	top.oBXPhotoSlider['<?= $ucid?>'] = new window.BXPhotoSlider({
		uniqueId: '<?= $ucid?>',
		currentItem: '<?= $arParams["CURRENT_ELEMENT_ID"]?>',
		id: '<?= $arParams["~JSID"]?>',
		userSettings: <?= CUtil::PhpToJSObject($arParams["USER_SETTINGS"])?>,
		actionUrl: '<?= CUtil::JSEscape($arParams["ACTION_URL"])?>',
		actionPostUrl: <?= ($arParams['CHECK_ACTION_URL'] == 'Y' ? 'false' : 'true')?>,
		sections: <?= CUtil::PhpToJSObject(array(array(
				"ID" => $arResult['SECTION']["ID"],
				"NAME" => $arResult['SECTION']['NAME']
			)))?>,
		items: <?= CUtil::PhpToJSObject($arResult["ELEMENTS_LIST_JS"])?>,
		itemsCount: '<?= intVal($arResult["ALL_ELEMENTS_CNT"])?>',
		itemsPageSize: '<?= intVal($arResult["NAV_RESULT_NavPageSize"])?>',
		currentPage: '<?= intVal($arResult["NAV_RESULT_NavPageNomer"])?>',
		useComments: '<?= $arParams["USE_COMMENTS"]?>',
		useRatings: '<?= $arParams["USE_RATING"]?>',
		commentsCount: '<?= $arParams["COMMENTS_COUNT"]?>',
		pElementsCont: pPhotoCont<?=$ucid?>,
		reloadItemsOnload: <?= ($arResult["MIN_ID"] > 0 ? $arResult["MIN_ID"] : 'false')?>,
		itemUrl: '<?= $arParams["DETAIL_ITEM_URL"]?>',
		itemUrlHash: 'photo_<?=$arParams['SECTION_ID']?>_#ELEMENT_ID#',
		sectionUrl: '<?= $arParams["ALBUM_URL"]?>',
		permissions:
			{
				view: '<?= $arParams["PERMISSION"] >= 'R'?>',
				edit:  '<?= $arParams["PERMISSION"] >= 'U'?>',
				moderate:  '<?= $arParams["PERMISSION"] >= 'X'?>',
				viewComment: <?= $arParams["COMMENTS_PERM_VIEW"] == "Y" ? 'true' : 'false'?>,
				addComment: <?= $arParams["COMMENTS_PERM_ADD"] == "Y" ? 'true' : 'false'?>
			},
		userUrl: '<?= $arParams["PATH_TO_USER"]?>',
		showTooltipOnUser: 'N',
		showSourceLink: 'Y',
		moderation: '<?= $arParams['MODERATION']?>',
		commentsType: '<?= $arParams["COMMENTS_TYPE"]?>',
		cacheRaitingReq: <?= ($arParams["DISPLAY_AS_RATING"] == "rating_main" ? 'true' : 'false')?>,
		MESS: {
			from: '<?= GetMessageJS("P_SLIDER_FROM")?>',
			slider: '<?= GetMessageJS("P_SLIDER_SLIDER")?>',
			slideshow: '<?= GetMessageJS("P_SLIDER_SLIDESHOW")?>',
			slideshowTitle: '<?= GetMessageJS("P_SLIDER_SLIDESHOW_TITLE")?>',
			addDesc: '<?= GetMessageJS("P_SLIDER_ADD_DESC")?>',
			addComment: '<?= GetMessageJS("P_SLIDER_ADD_COMMENT")?>',
			commentTitle: '<?= GetMessageJS("P_SLIDER_COMMENT_TITLE")?>',
			save: '<?= GetMessageJS("P_SLIDER_SAVE")?>',
			cancel: '<?= GetMessageJS("P_SLIDER_CANCEL")?>',
			commentsCount: '<?= GetMessageJS("P_SLIDER_COM_COUNT")?>',
			moreCom: '<?= GetMessageJS("P_SLIDER_MORE_COM")?>',
			moreCom2: '<?= GetMessageJS("P_SLIDER_MORE_COM2")?>',
			album: '<?= GetMessageJS("P_SLIDER_ALBUM")?>',
			author: '<?= GetMessageJS("P_SLIDER_AUTHOR")?>',
			added: '<?= GetMessageJS("P_SLIDER_ADDED")?>',
			edit: '<?= GetMessageJS("P_SLIDER_EDIT")?>',
			del: '<?= GetMessageJS("P_SLIDER_DEL")?>',
			bigPhoto: '<?= GetMessageJS("P_SLIDER_BIG_PHOTO")?>',
			smallPhoto: '<?= GetMessageJS("P_SLIDER_SMALL_PHOTO")?>',
			rotate: '<?= GetMessageJS("P_SLIDER_ROTATE")?>',
			saveDetailTitle: '<?= GetMessageJS("P_SLIDER_SAVE_DETAIL_TITLE")?>',
			DarkBG: '<?= GetMessageJS("P_SLIDER_DARK_BG")?>',
			LightBG: '<?= GetMessageJS("P_SLIDER_LIGHT_BG")?>',
			delItemConfirm: '<?= GetMessageJS("P_DELETE_ITEM_CONFIRM")?>',
			shortComError: '<?= GetMessageJS("P_SHORT_COMMENT_ERROR")?>',
			photoEditDialogTitle: '<?= GetMessageJS("P_EDIT_DIALOG_TITLE")?>',
			unknownError: '<?= GetMessageJS("P_UNKNOWN_ERROR")?>',
			sourceImage: '<?= GetMessageJS("P_SOURCE_IMAGE")?>',
			created: '<?= GetMessageJS("P_CREATED")?>',
			tags: '<?= GetMessageJS("P_SLIDER_TAGS")?>',
			clickToClose: '<?= GetMessageJS("P_SLIDER_CLICK_TO_CLOSE")?>',
			comAccessDenied: '<?= GetMessageJS("P_SLIDER_COMMENTS_ACCESS_DENIED")?>',
			views: '<?= GetMessageJS("P_SLIDER_VIEWS")?>',
			notModerated: '<?= GetMessageJS("P_NOT_MODERATED")?>',
			activateNow: '<?= GetMessageJS("P_ACTIVATE")?>',
			deleteNow: '<?= GetMessageJS("P_DELETE")?>',
			bigPhotoDisabled: '<?= GetMessageJS("P_SLIDER_BIG_PHOTO_DIS")?>'
		}
	});
});
</script>