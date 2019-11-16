<?
$arResNew = array();
foreach($arResult["ITEMS"] as $arItem){
    $arItemNew = $arItem;
    if (is_array($arItem["DETAIL_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["DETAIL_PICTURE"],
            array("width" => 70, "height" => 70),
            BX_RESIZE_IMAGE_EXACT ,
            true,
            false,
            false,
            75
        );
        $arItemNew["PREVIEW_PICTURE"]["SRC"] = $arFileTmp["src"];
    }
    elseif (is_array($arItem["PREVIEW_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            array("width" => 70, "height" => 70),
            BX_RESIZE_IMAGE_EXACT,
            true,
            false,
            false,
            75
        );
        $arItemNew["PREVIEW_PICTURE"]["SRC"] = $arFileTmp["src"];
    }
    //$arItemNew["DETAIL_PAGE_URL"] = strip_tags($arItem["PROPERTIES"]["LINK"]["VALUE"]);
    $arResNew[] = $arItemNew;
}
$arResult["ITEMS"] = $arResNew;
?>