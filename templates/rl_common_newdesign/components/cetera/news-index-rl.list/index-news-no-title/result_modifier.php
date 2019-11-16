<?
$arResNew = array();
foreach($arResult["ITEMS"] as $arItem){
    $arItemNew = $arItem;
    if (is_array($arItem["DETAIL_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["DETAIL_PICTURE"],
            array("width" => 79, "height" => 79),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            true,
            false,
            false,
            75
        );
        $arItemNew["PREVIEW_PICTURE"]["src"] = $arFileTmp;
    }
    elseif (is_array($arItem["PREVIEW_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            array("width" => 79, "height" => 79),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            true,
            false,
            false,
            75
        );
        $arItemNew["PREVIEW_PICTURE"]["SRC"] = $arFileTmp["src"] ;
    }
    //$arItemNew["DETAIL_PAGE_URL"] = strip_tags($arItem["PROPERTIES"]["LINK"]["VALUE"]);
    $arResNew[] = $arItemNew;
}
$arResult["ITEMS"] = $arResNew;
?>