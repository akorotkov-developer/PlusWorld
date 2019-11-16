<?/*$APPLICATION->AddHeadString('<meta property="og:image" content="http://www.plusworld.ru'.$arResult["FIELDS"]["PREVIEW_PICTURE"]['SRC'].'" />',true)?>
<?$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult["NAME"].'" />',true)?>
<?$APPLICATION->AddHeadString('<meta property="og:description" content="'.$arResult["FIELDS"]["PREVIEW_TEXT"].'" />',true)*/?>

<?
    $arTAgs = array();
    $arTAgs = explode(',',$arResult["TAGS"]);

$arFilter = Array(
    "IBLOCK_ID" => array(90,65,39),
    "!ID"       => $arResult["ID"],
    "ACTIVE"    => "Y",
    "?TAGS"     => $arResult["TAGS"]
);

    $arIdElement = array();

$res = CIBlockElement::GetList(Array("ACTIVE_FROM"=>"DESC", "SORT"=>"ASC"), $arFilter, false, Array("nTopCount" => 5));
while($ar_fields = $res->GetNext()) {
    array_push($arIdElement,$ar_fields["ID"]);
}
    $arIdElement = array_unique($arIdElement);

    $arListElement = array();
    foreach($arIdElement AS $elementID) {
        $res = CIBlockElement::GetByID($elementID);
        $arDetElement = array();
        if ($ar_res = $res->GetNext());
            $arDetElement['NAME'] = $ar_res['NAME'];
            $arDetElement['PREVIEW_PICTURE'] = $ar_res['PREVIEW_PICTURE'];
            $arDetElement['PREVIEW_TEXT'] = $ar_res['PREVIEW_TEXT'];
            $arDetElement['DETAIL_PAGE_URL'] = $ar_res['DETAIL_PAGE_URL'];

        array_push($arListElement,$arDetElement);
    }

    $arResult["ListElement"] = $arListElement;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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


if(!empty($arResult["DISPLAY_PROPERTIES"]["PEBG_COMPANY"]))
{
    foreach($arResult["DISPLAY_PROPERTIES"]["PEBG_COMPANY"]["VALUE"] AS $firm):
        $firmFilter = array(
            "IBLOCK_ID"=>$arResult["DISPLAY_PROPERTIES"]["PEBG_COMPANY"]["LINK_IBLOCK_ID"],
            "ID" => $firm
            );
        $rsEl = CIBlockElement::GetList(array("id" => "desc"), $firmFilter, false, false, array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"));
        //$rsEl->SetUrlTemplates("/eurasia/cat_#SECTION_CODE#/#ELEMENT_CODE#/");
        if($arRes = $rsEl->GetNext())
        {
            if ($arRes["PREVIEW_PICTURE"]):
                $photo = CFile::GetFileArray($arRes["PREVIEW_PICTURE"]);

               $arFileTmp = CFile::ResizeImageGet(
                  $arRes["PREVIEW_PICTURE"],
                  array("width" => 120, 'height' => 120),
                  BX_RESIZE_IMAGE_PROPORTIONAL,
                  false
               );
            endif;

        	$arResult["COMPANY"][] = array(
                "NAME" => $arRes["NAME"],
                "PREVIEW_PICTURE" => $arFileTmp,
                "DETAIL_PAGE_URL" => $arRes["DETAIL_PAGE_URL"],
            );
         }
    endforeach;


}
if(!empty($arResult["DISPLAY_PROPERTIES"]["PHOTO"]))
{
    $PHOTOFilter = array(
        "IBLOCK_ID"=>$arResult["DISPLAY_PROPERTIES"]["PHOTO"]["LINK_IBLOCK_ID"],
        "ID" => $arResult["DISPLAY_PROPERTIES"]["PHOTO"]["VALUE"]
        );
    $rsEl = CIBlockSection::GetList(array("id" => "desc"), $PHOTOFilter, false, false, array("NAME", "DETAIL_PICTURE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID"));
    $rsEl->SetUrlTemplates("/photo/#SECTION_ID#/");
    if($arRes = $rsEl->GetNext())
    {
        if ($arRes["IBLOCK_SECTION_ID"] > 0)
        {
            $rsEl2 = CIBlockSection::GetList(array("id" => "desc"), array("ID" => $arRes["IBLOCK_SECTION_ID"]), false, false, array("NAME"));
            if($arRes2 = $rsEl2->GetNext())
            {
                $arRes["NAME"] = $arRes["NAME"]." &raquo; ".$arRes2["NAME"];
            }
        }
        if ($arRes["DETAIL_PICTURE"]):
            $photo = CFile::GetFileArray($arRes["DETAIL_PICTURE"]);

           $arFileTmp = CFile::ResizeImageGet(
              $arRes["DETAIL_PICTURE"],
              array("width" => 120, 'height' => 120),
              BX_RESIZE_IMAGE_PROPORTIONAL,
              false
           );
        endif;

    	$arResult["PHOTO"] = array(
            "NAME" => $arRes["NAME"],
            "DETAIL_PICTURE" => $arFileTmp,
            "DETAIL_PAGE_URL" => $arRes["DETAIL_PAGE_URL"],
        );
     }
}

if(!empty($arResult["DISPLAY_PROPERTIES"]["PHOTOS"]))
{
    $PHOTOFilter = array(
        "IBLOCK_ID"=>$arResult["DISPLAY_PROPERTIES"]["PHOTOS"]["LINK_IBLOCK_ID"],
        array(
            "LOGIC" => "OR",
        ),

    );
    foreach($arResult["DISPLAY_PROPERTIES"]["PHOTOS"]["VALUE"] AS $PHOTO):
        $PHOTOFilter[0][] = array("ID" => $PHOTO);
    endforeach;

    $rsEl = CIBlockElement::GetList(array("id" => "desc"), $PHOTOFilter, false, false, array("NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"));
    $rsEl->SetUrlTemplates("/photo/#SECTION_ID#/#ELEMENT_ID#/");
    while($arRes = $rsEl->GetNext())
    {
        if ($arRes["PREVIEW_PICTURE"]):
            $photo = CFile::GetFileArray($arRes["PREVIEW_PICTURE"]);

           $arFileTmp = CFile::ResizeImageGet(
              $arRes["PREVIEW_PICTURE"],
              array("width" => 120, 'height' => 120),
              BX_RESIZE_IMAGE_PROPORTIONAL,
              false
           );
        endif;

    	$arResult["PHOTOS"][] = array(
            "NAME" => $arRes["NAME"],
            "PREVIEW_PICTURE" => $arFileTmp,
            "DETAIL_PAGE_URL" => $arRes["DETAIL_PAGE_URL"],
        );
     }
}
$arResult["DETAIL_TEXT"] = str_replace ('href="www', 'target="_blank" href="http://www', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('\"\\', '&', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('&\\', '&', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('&\\"', '', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('\\&"', '&', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('\\&', '', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('\\"/\\"', '', $arResult["DETAIL_TEXT"]);
$arResult["DETAIL_TEXT"] = str_replace ('/&"', '', $arResult["DETAIL_TEXT"]);

$arResult["PREVIEW_TEXT"] = str_replace ('href="www', 'target="_blank" href="http://www', $arResult["PREVIEW_TEXT"]);
$arResult["FIELDS"]["PREVIEW_TEXT"] = str_replace ('href="www', 'target="_blank" href="http://www', $arResult["FIELDS"]["PREVIEW_TEXT"]);
?>

<?/*
$APPLICATION->AddHeadString('<meta property="og:type" content="news" />',true);
if ($arResult["DETAIL_PICTURE"]["SRC"]) {
    $APPLICATION->AddHeadString('<meta property="og:image" content="http://'.$_SERVER['SERVER_NAME'].$arResult["DETAIL_PICTURE"]["SRC"].'" />',true);
}
else
{
    $APPLICATION->AddHeadString('<meta property="og:image" content="http://www.plusworld.ru/upload/templates/logo_plus_ru.png" />',true);
}
$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult["NAME"].'" />',true);
$APPLICATION->AddHeadString('<meta property="og:url" content="http://'.$_SERVER['SERVER_NAME'].$arResult["DETAIL_PAGE_URL"].'" />',true);
//echo "111-".$arResult["DETAIL_TEXT"];
$APPLICATION->AddHeadString('<meta property="og:description" content="'.substr($arResult["PREVIEW_TEXT"],0,300).'" />',true);
*/?>
<?global $APPLICATION;

$cp = $this->__component;

if (is_object($cp))
{
$cp->arResult['FB_DESCRIPTION'] = $arResult["PREVIEW_TEXT"];
$cp->arResult['FB_IMAGE'] = 'http://'.SITE_SERVER_NAME.$arResult["DETAIL_PICTURE"]["SRC"];
$cp->SetResultCacheKeys(array('FB_DESCRIPTION','FB_IMAGE'));
$arResult['FB_DESCRIPTION'] = $cp->arResult['FB_DESCRIPTION'];
$arResult['FB_IMAGE'] = $cp->arResult['FB_IMAGE'];

}
?>
