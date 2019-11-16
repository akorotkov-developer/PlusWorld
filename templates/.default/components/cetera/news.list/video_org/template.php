<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?//if(isset($_REQUEST["dd"])) print_r($arResult);
$sectionID = $arResult['SECTION']['PATH']['0']['ID'];
?>
<?
global $USER;
$arFilter = array("ID" => $USER->GetID());
$arParams["SELECT"] = array("UF_CLOSE_GALLERY");
$arUser = CUser::GetList($by,$desc,$arFilter,$arParams);
if ($user = $arUser->Fetch()) {
	$arUserId[] = $user["ID"];
}

$ar_result=CIBlockSection::GetList(Array("SORT"=>"DESC"), Array("IBLOCK_ID"=>"33", "ID"=>$sectionID),false, Array("UF_CLOSE_GALLERY"));
$res=$ar_result->GetNext();
?>

<?if($res["UF_CLOSE_GALLERY"] != "1" || ($res["UF_CLOSE_GALLERY"] == "1" and ($USER->IsAdmin() or in_array($USER->GetID(), $arUserId)))):?>
	<div class="video-list">
	<?/*$APPLICATION->IncludeComponent("cetera:news.list", "new-video", array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "67",
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
		"ELEMENT_SORT_FIELD" => "ACTIVE_FROM",
		"ELEMENT_SORT_ORDER" => "desc",
		"FILTER_NAME" => "",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "VIDEO",
			1 => "",
		),
		"SECTION_COUNT" => "1",
		"ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "4",
		"SECTION_URL" => $arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["URL_TEMPLATES"]["detail"],
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PHOTO_SIZE"	=> 140,
		),
		$component
	);*/?>

	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<div class="rubric-navigation top">
		<?=$arResult["NAV_STRING"]?>
	</div>
	<?endif;?>
	<?$k = 1;
	$i = 1;$bannerPosition = 4;$countRes = count($arResult["ITEMS"]);
	if ($countRes < 4) $bannerPosition = $countRes;?>
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="video-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"];?>"><img  src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" class="preview_picture" /></a>
	<br />
			<?endif?>
			<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?><span class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span><?endif?>
			<div class="news-comments">
	 <?/*$APPLICATION->IncludeComponent(
		"cetera:comments.count",
		"right",
		Array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"COMMENTS_IBLOCK_ID" => 20,
		),
		false
	);*/?>
	</div>
			<br />
			<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="link" ><?echo $arItem["NAME"]?></a><br />
			<?endif;?>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<?echo $arItem["PREVIEW_TEXT"];?>
			<?endif;?>

			<div class="clear"></div>

		</div>

	<?
	if ($k % 2 == 0):?>
	<div class="clear"></div>
	<?endif;?>
	<?if ($k == $bannerPosition):?>
			<div class="ban-468x60">
			<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "", Array(
				"TYPE" => "BANNER_468X60_VIDEO",	// Тип баннера
				"CACHE_TYPE" => "A",	// Тип кеширования
				"NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
				"CACHE_TIME" => "3600",	// Время кеширования (сек.)
				),
				false
			);?>
			</div>
		<?elseif ($k == '6'):?>
		<div class="clear"></div>
			<div>
		<?$GLOBALS["popFilter"] = array(">SHOW_COUNTER_START" => date("d-m-Y H:i:s",time()-86400*900));?>

		<?$APPLICATION->IncludeComponent("cetera:news.list", "pop-video", array(
		"IBLOCK_TYPE" => "services_org",
		"IBLOCK_ID" => "33",
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
		"FILTER_NAME" => "popFilter",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "VIDEO",
			1 => "",
		),
		"SECTION_COUNT" => "1",
		"ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "4",
		"SECTION_URL" => $arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["URL_TEMPLATES"]["detail"],
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PHOTO_SIZE"	=> 140,
		),
		$component
	);?></div>
	<?endif;?>
	<?$k++;?>
	<?endforeach;?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<div class="rubric-navigation bot">
		<?=$arResult["NAV_STRING"]?>
	</div>
	<?endif;?>
	</div>
<?else:?>
	<h1 style="color:red;">The gallery is closed from public viewing</h1>
<?endif;?>
