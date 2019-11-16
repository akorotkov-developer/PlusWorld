<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach ($arResult["ITEMS"] as $key => $arItem)
{
	if(is_array($arItem["FIELDS"]["DETAIL_PICTURE"]))
	{
		$arFileTmp = CFile::ResizeImageGet(
			$arItem["DETAIL_PICTURE"],
			array("width" => 280 , "height" => 197),
			BX_RESIZE_IMAGE_PROPORTIONAL,
			true
		);

		$arResult["ITEMS"][$key]['PREVIEW_IMG'] = array(
			"SRC" => $arFileTmp["src"],
			"WIDTH" => $arFileTmp["width"],
			"HEIGHT" => $arFileTmp["height"],
		);
	}
    if (isset($arItem["PROPERTIES"]["REDIRECT"]["VALUE"]) and (strlen($arItem["PROPERTIES"]["REDIRECT"]["VALUE"])>0)) {
	    $showCounterRedirect = showCounterRedirect($arItem["PROPERTIES"]["REDIRECT"]["VALUE"]);
        if ($showCounterRedirect > 0) {
            $arResult["ITEMS"][$key]["SHOW_COUNTER"] = $showCounterRedirect;
        }
    }
}

if($arParams["SET_META_DESCRIPTION"] == "Y")
{
    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arResult["ID"],$arResult["IBLOCK_SECTION_ID"]);
    $IPROPERTY  = $ipropValues->getValues();

    if ($IPROPERTY["SECTION_META_DESCRIPTION"] != "") {
        $APPLICATION->SetPageProperty("description", strip_tags($IPROPERTY["SECTION_META_DESCRIPTION"]));
        $APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='".strip_tags($IPROPERTY["SECTION_META_DESCRIPTION"])."'>");
    }
    if ($IPROPERTY["SECTION_META_TITLE"] != "") {
        $APPLICATION->SetPageProperty("title", $IPROPERTY["SECTION_META_TITLE"]);
        $APPLICATION->SetPageProperty("og:title", $IPROPERTY["SECTION_META_TITLE"]);
    }
    if ($IPROPERTY["SECTION_META_KEYWORDS"] != "") {
        $APPLICATION->SetPageProperty("keywords", $IPROPERTY["SECTION_META_KEYWORDS"]);
    }
}

$this->SetViewTarget('OG_PICTURE');
echo '<meta property="og:image" content="http://'.$_SERVER['HTTP_HOST'].$arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:secure_url" content="https://'.$_SERVER['HTTP_HOST'].$arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:type" content="'.$arResult["ITEMS"][0]["DETAIL_PICTURE"]["CONTENT_TYPE"].'" />';
echo '<meta property="og:image:width" content="'.$arResult["ITEMS"][0]["DETAIL_PICTURE"]["WIDTH"].'">';
echo '<meta property="og:image:height" content="'.$arResult["ITEMS"][0]["DETAIL_PICTURE"]["HEIGHT"].'">';
$this->EndViewTarget();
?>