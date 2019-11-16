<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="photo-page-main">
	<?if($APPLICATION->GetCurPage() == "/video/"):?>
		<div>
			<?$APPLICATION->IncludeComponent("cetera:news.list", "new-video", array(
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
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PHOTO_SIZE"	=> 140,
				),
				$component
			);?>
		<div class="clear"></div>
		</div>
	<?endif;?>
	<?
	global $USER;
	$arFilter = array("ID" => $USER->GetID());
	$arParams["SELECT"] = array("UF_CLOSE_GALLERY");
	$arUser = CUser::GetList($by,$desc,$arFilter,$arParams);
	if ($user = $arUser->Fetch()) {
		$arUserId[] = $user["ID"];
	}
	?>
	<div class="photo-items-list photo-album-list">
	<?
	foreach($arResult["SECTIONS"] as $arSection):
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		?>

		<?//if(isset($_REQUEST["dd"])) print_r($arSection);?>
		<?$ar_result=CIBlockSection::GetList(Array("SORT"=>"DESC"), Array("IBLOCK_ID"=>$arSection["IBLOCK_ID"], "ID"=>$arSection['ID']),false, Array("UF_CLOSE_GALLERY"));
		$res=$ar_result->GetNext();
		?>
		<?if($res["UF_CLOSE_GALLERY"] != "1" || ($res["UF_CLOSE_GALLERY"] == "1" and ($USER->IsAdmin() or in_array($USER->GetID(), $arUserId)))):?>
			<div id="photo_album_info_<?=$arSection['ID']?>" class="photo-album-item photo-album-active ">

				<div onmouseover="BX.addClass(this, 'photo-album-avatar-edit');" title="<?=$arSection["NAME"]?>" id="photo_album_cover_1233" class="photo-item-cover photo-album-avatar photo-album-avatar-empty" <?if ($arSection["PICTURE"]["SRC"]) {?>style="background-image: url('<?=$arSection["PICTURE"]["SRC"]?>');-moz-background-size: 100%; -webkit-background-size: 100%;-o-background-size: 100%;			background-size: 100%;"<?} else {?>style="background-image: url('/bitrix/templates/.default/components/bitrix/photogallery/photo/themes/gray/images/album/cover_empty.gif');"<?}?> >
					<div onclick="window.location='<?=$arSection["SECTION_PAGE_URL"]?>';" onmouseout="BX.removeClass(this.parentNode, 'photo-album-avatar-edit')" class="photo-album-menu">
					</div>
				</div>

				<div class="photo-item-info-block-inner" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
					<div class="photo-album-date"><span id="photo_album_date_<?=$arSection['ID']?>"><!--4 Июня 2013--></span></div>
					<div class="photo-album-photos"><?if($arParams["COUNT_ELEMENTS"]):?><?=$arSection["ELEMENT_CNT"]?> видео<?endif;?></div>
					<div class="photo-album-name">
						<a title="<?=$arSection["NAME"]?>" id="photo_album_name_<?=$arSection['ID']?>" href="<?=$arSection["SECTION_PAGE_URL"]?>">
						   <?=$arSection["NAME"]?>
						</a>
					</div>
					<div id="photo_album_description_<?=$arSection['ID']?>" class="photo-album-description">
						<?=$arSection['DESCRIPTION']?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		<?endif;?>
	<?endforeach;?>


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

	<div class="clear"></div>
	</div>
	<?if($APPLICATION->GetCurPage() != "/video/"):?>
	<div>

		<br />
		
		<?$APPLICATION->IncludeComponent("cetera:news.list", "pop-video", array(
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
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"PHOTO_SIZE"	=> 140,
			),
			$component
		);?>
	<div class="clear"></div>
	</div>
	<?endif;?>
</div>