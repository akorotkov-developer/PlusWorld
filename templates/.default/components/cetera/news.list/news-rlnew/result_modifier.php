<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["ITEMS"] as $key => $arItem){
	if (isset($arItem["PROPERTIES"]["REDIRECT"]["VALUE"]) and (strlen($arItem["PROPERTIES"]["REDIRECT"]["VALUE"])>0)) {
        $showCounterRedirect = showCounterRedirect($arItem["PROPERTIES"]["REDIRECT"]["VALUE"]);
        if ($showCounterRedirect > 0) {
            $arResult["ITEMS"][$key]["SHOW_COUNTER"] = $showCounterRedirect;
        }
	}
}

$arResNew = array();
foreach($arResult["ITEMS"] as $arItem){
    $arItemNew = $arItem;
    if (is_array($arItem["DETAIL_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["DETAIL_PICTURE"],
            array("width" => 280, "height" => 197),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            true,
            false,
            false,
            75
        );
        $arItemNew["PREVIEW"]["SRC"] = $arFileTmp["src"];
    }
    elseif (is_array($arItem["PREVIEW_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            array("width" => 280, "height" => 197),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            true,
            false,
            false,
            75
        );
        $arItemNew["PREVIEW"]["SRC"] = $arFileTmp["src"] ;
    }
    //$arItemNew["DETAIL_PAGE_URL"] = strip_tags($arItem["PROPERTIES"]["LINK"]["VALUE"]);
    $arResNew[] = $arItemNew;
}
$arResult["ITEMS"] = $arResNew;

$this->SetViewTarget('OG_PICTURE');
echo '<meta property="og:image" content="http://'.$_SERVER['HTTP_HOST'].$arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:secure_url" content="https://'.$_SERVER['HTTP_HOST'].$arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:type" content="'.$arResult["ITEMS"][0]["DETAIL_PICTURE"]["CONTENT_TYPE"].'" />';
echo '<meta property="og:image:width" content="'.$arResult["ITEMS"][0]["DETAIL_PICTURE"]["WIDTH"].'">';
echo '<meta property="og:image:height" content="'.$arResult["ITEMS"][0]["DETAIL_PICTURE"]["HEIGHT"].'">';
$this->EndViewTarget();
?>
