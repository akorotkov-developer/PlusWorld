<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


foreach($arResult["ITEMS"] as $arItemId=>$arItem){

    if($arItem['PROPERTIES']["enclosure"]['VALUE']){
        $arFile = CFile::GetFileArray($arItem['PROPERTIES']["enclosure"]['VALUE']);
        $arEncl["url"] = "https://".SITE_SERVER_NAME.$arFile['SRC'];
        $arEncl["length"] = $arFile['FILE_SIZE'];
        $arEncl["type"] = $arFile['CONTENT_TYPE'];


        $arResult["ITEMS"][$arItemId]["enclosure"] = $arEncl;
    }


    $authorText = htmlspecialcharsbx(htmlspecialcharsback($arItem['PROPERTIES']["author"]["VALUE"]));
    if ($authorText)
        $arResult["ITEMS"][$arItemId]["author-text"] = $authorText;
    $fullText = htmlspecialcharsbx(htmlspecialcharsback($arItem['PROPERTIES']["full_text"]["VALUE"]["TEXT"]));
    if ($fullText)
        $arResult["ITEMS"][$arItemId]["full-text"] = $fullText;
}