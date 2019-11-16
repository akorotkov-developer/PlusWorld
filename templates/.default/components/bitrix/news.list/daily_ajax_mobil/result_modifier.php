<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

$ITEMS = array();
foreach($arResult["ITEMS"] as $arItem) {
    if(strlen($arItem["ACTIVE_FROM"]) > 0) {
        $arResult["byDate"][ConvertDateTime($arItem["ACTIVE_FROM"],"YYYYMMDD")][] = $arItem;
    }

    $arItemTemp = $arItem;
    if(is_array($arItem["DETAIL_PICTURE"])) {
        $arPic = CFile::ResizeImageGet(
            $arItem['DETAIL_PICTURE'],
            array('width'=>300, 'height'=>250),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            false,
            false,
            75
        );
        $arItemTemp["DETAIL_PICTURE_NEW"] = $arPic["src"];
    }
    $ITEMS[] = $arItemTemp;
}
$arResult["ITEMS"] = $ITEMS;
?>

