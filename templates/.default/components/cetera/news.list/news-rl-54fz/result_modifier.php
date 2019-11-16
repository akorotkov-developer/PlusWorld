<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["SECT_NAME"] = $arParams["SECT_NAME"];
$i = 0;
foreach ($arResult["ITEMS"] as $key => $arItem) {
    if ($i != 0) {
        $arPhotoSmall = CFile::ResizeImageGet(
            $arItem["DETAIL_PICTURE"]["ID"],
            array("width" => 279, "height" => 200),
            BX_RESIZE_IMAGE_EXACT, true
        );

        $arResult["ITEMS"][$key]["PICTURE"] = $arPhotoSmall["src"];
    }
    $i++;
}

//выборка только активных разделов из инфоблока $IBLOCK_ID
$arFilter = Array('IBLOCK_ID'=>118, 'GLOBAL_ACTIVE'=>'Y');
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
while($ar_result = $db_list->GetNext())
{
    $sections[] = $ar_result;
}

//TODO надо найти способ узнать если активные элементы в разделе
//Проверяем есть ли элемент в данном разделе
$sect = 0;
foreach ($sections as $key=>$section) {
    if (mb_strtolower($section["NAME"]) == mb_strtolower($arResult["SECT_NAME"]) and $section["ELEMENT_CNT"] > 0) {
        $sect = $section["ID"];
    }
}

$important_news = false;
if ($sect > 0) {
    $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PROPERTY_URL_TYPE", "PROPERTY_URL_NEWS", "PROPERTY_TYPE");
    $arFilter = Array("IBLOCK_ID" => 118, "SECTION_ID" => $sect, "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 1), $arSelect);
    while ($ob = $res->Fetch()) {
        $important_news = $ob;
    }
}

if ($important_news) {
    $arPhotoSmall = CFile::ResizeImageGet(
        $important_news["PREVIEW_PICTURE"],
        array("width" => 148, "height" => 148),
        BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true
    );
    $important_news["PREVIEW_PICTURE_SRC"] = $arPhotoSmall["src"];
}

$arFileTmp = CFile::ResizeImageGet(
    $arResult["ITEMS"][0]["DETAIL_PICTURE"]["ID"],
    array("width" => 148, "height" => 148),
    BX_RESIZE_IMAGE_EXACT ,
    true,
    false,
    false,
    75
);
$arResult["ITEMS"][0]["DETAIL_PICTURE_RIGHT"]["SRC"] = $arFileTmp["src"];

$arResult["IMPORTANT_NEWS"] = $important_news;