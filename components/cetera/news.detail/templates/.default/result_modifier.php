<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$prevText = strip_tags(TruncateText($arResult["PREVIEW_TEXT"], 100));
/*$this->SetViewTarget('OG_DESCRIPTION');
echo '<meta property="og:description" content="'.$prevText.'" />';
$this->EndViewTarget();*/

//Задаем текст в отложенной функции
$arSelect = array(
    "ID",
    "NAME",
    "IBLOCK_ID",
    "IBLOCK_SECTION_ID",
    "DETAIL_TEXT",
    "DETAIL_TEXT_TYPE",
    "PREVIEW_TEXT",
    "PREVIEW_TEXT_TYPE",
    "DETAIL_PICTURE",
    "LIST_PAGE_URL",
    "DETAIL_PAGE_URL",
);
$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "IBLOCK_LID" => SITE_ID,
    "IBLOCK_ACTIVE" => "Y",
    "ACTIVE" => "Y",
    "CHECK_PERMISSIONS" => "Y",
);
if($arResult["IBLOCK_SECTION_ID"]) $arFilter["SECTION_ID"] = $arResult["IBLOCK_SECTION_ID"];
$arFilter[">ID"] = $arResult['ID'];
$rsEl = CIBlockElement::GetList(array("id" => "asc"), $arFilter, false, Array ("nTopCount" => 1), $arSelect);
$rsEl->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);
if($obEl = $rsEl->GetNextElement())
{
    $arRes=$obEl->GetFields();
    $arResult["NEXTT"] = $arRes;
}
unset($arFilter[">ID"]);
$arFilter['<ID'] = $arResult['ID'];
$rsEl = CIBlockElement::GetList(array("id" => "desc"), $arFilter, false, Array ("nTopCount" => 1), $arSelect);
$rsEl->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);
if($obEl = $rsEl->GetNextElement())
{
    $arRes=$obEl->GetFields();
    $arResult["PREV"] = $arRes;
    $arResult["PREVV"] = $arRes;
}

$obGroups = CIBlockElement::GetElementGroups($arResult['ID'], true);


while($m_group = $obGroups->Fetch())
{
    $groups[] = $m_group["CODE"];
}

$GLOBALS["SECTION_CODE"] = $groups;

$arResult['ITEMS_THEME'] = array();
if(!empty($arResult["DISPLAY_PROPERTIES"]["THEME"]["VALUE"]))
{
	$rsElementTheme = CIBlockElement::GetList(
		array(
			"active_from" => "DESC"
		),
		array(
			"PROPERTY_THEME" => $arResult["DISPLAY_PROPERTIES"]["THEME"]["VALUE"],
			"ACTIVE" => "Y",
			"CHECK_PERMISSIONS" => "Y",
			"IBLOCK_ID" => $arResult["IBLOCK_ID"],
			"!ID" => $arResult["ID"]
		),
		false,
		Array ("nTopCount" => 5),
		array("ID", "NAME", "DETAIL_PAGE_URL")
	);

	while($obElementTheme = $rsElementTheme->GetNextElement())
	{
		$arItemTheme = $obElementTheme->GetFields();
		$arResult['ITEMS_THEME'][] = $arItemTheme;
	}
}

global $APPLICATION;

$cp = $this->__component;

if (is_object($cp))
{
    $cp->arResult['FB_DESCRIPTION'] = $arResult["PREVIEW_TEXT"];
    $cp->arResult['FB_IMAGE'] = 'http://'.SITE_SERVER_NAME.$arResult["DETAIL_PICTURE"]["SRC"];
    $cp->SetResultCacheKeys(array('FB_DESCRIPTION','FB_IMAGE'));
    $arResult['FB_DESCRIPTION'] = $cp->arResult['FB_DESCRIPTION'];
    $arResult['FB_IMAGE'] = $cp->arResult['FB_IMAGE'];

}

$detailPictureSrc = $arResult["DETAIL_PICTURE"]["SRC"];
$detailPictureWidth = $arResult["DETAIL_PICTURE"]["WIDTH"];
$detailPictureHeight = $arResult["DETAIL_PICTURE"]["HEIGHT"];

foreach($arResult["FIELDS"] as $code=>$value)
{
	if ($code == 'PREVIEW_PICTURE')
	{
		if(is_array($value))
		{
			$arFileTmp = CFile::ResizeImageGet(
				$value,
				array("width" => $arParams["DISPLAY_IMG_DETAIL_WIDTH"], "height" => $arParams["DISPLAY_IMG_DETAIL_HEIGHT"]),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);

			$arResult["DETAIL_PICTURE"] = array(
				"SRC" => $arFileTmp["src"],
				"WIDTH" => $arFileTmp["width"],
				"HEIGHT" => $arFileTmp["height"],
			);
		}
	}
}

if(!empty($arResult["DISPLAY_PROPERTIES"]["PEBG_COMPANY"]))
{
    foreach($arResult["DISPLAY_PROPERTIES"]["PEBG_COMPANY"]["VALUE"] AS $firm) {
        $firmFilter = array(
            "IBLOCK_ID" => $arResult["DISPLAY_PROPERTIES"]["PEBG_COMPANY"]["LINK_IBLOCK_ID"],
            "ID" => $firm
        );
        $rsEl = CIBlockElement::GetList(array("id" => "desc"), $firmFilter, false, false, array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"));
        //$rsEl->SetUrlTemplates("/eurasia/cat_#SECTION_CODE#/#ELEMENT_CODE#/");
        if ($arRes = $rsEl->GetNext()) {
            if ($arRes["PREVIEW_PICTURE"]) {
                $photo = CFile::GetFileArray($arRes["PREVIEW_PICTURE"]);

                $arFileTmp = CFile::ResizeImageGet(
                    $arRes["PREVIEW_PICTURE"],
                    array("width" => 120, 'height' => 120),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    false
                );
            }

            $arResult["COMPANY"][] = array(
                "NAME" => $arRes["NAME"],
                "PREVIEW_PICTURE" => $arFileTmp,
                "DETAIL_PAGE_URL" => $arRes["DETAIL_PAGE_URL"],
            );
        }
    }
}

//Получить тэги статьи
$arrfilter = array(
    "IBLOCK_ID" => $arResult["IBLOCK_ID"],
    "ID" => $arResult["ID"]
);
$rsEl = CIBlockElement::GetList(array("id" => "desc"), $arrfilter, false, false, array("TAGS"));
if ($arRes = $rsEl->GetNext()) {
    $tags = explode(",",$arRes["TAGS"]);
}

$metaDescription = \Bitrix\Main\Type\Collection::firstNotEmpty(
	$arResult["PROPERTIES"], array($arParams["META_DESCRIPTION"], "VALUE")
	,$arResult["IPROPERTY_VALUES"], "ELEMENT_META_DESCRIPTION"
);
if (is_array($metaDescription)) {
	$APPLICATION->SetPageProperty("description", implode(" ", $metaDescription), $arTitleOptions);
	$APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . implode(" ", $metaDescription) . "'>");
} elseif ($metaDescription != "") {
	$APPLICATION->SetPageProperty("description", $metaDescription, $arTitleOptions);
	$APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . $metaDescription . "'>");
} elseif ($arResult["PREVIEW_TEXT"] != "") {
	$APPLICATION->SetPageProperty("description", $arResult["PREVIEW_TEXT"]);
	$APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . $arResult["PREVIEW_TEXT"] . "'>");
}

$arResult["TAGS"] = $tags;

$this->SetViewTarget('OG_PICTURE');
echo '<meta property="og:image" content="http://'.$_SERVER['HTTP_HOST'].$detailPictureSrc.'" />';
echo '<meta property="og:image:secure_url" content="https://'.$_SERVER['HTTP_HOST'].$detailPictureSrc.'" />';
echo '<meta property="og:image:type" content="'.$arResult["DETAIL_PICTURE"]["CONTENT_TYPE"].'" />';
echo '<meta property="og:image:width" content="'.$detailPictureWidth.'">';
echo '<meta property="og:image:height" content="'.$detailPictureHeight.'">';
$this->EndViewTarget();

?>
