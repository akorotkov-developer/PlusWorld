<?
if(($_SERVER["HTTP_HOST"])=="www.plusworld.ru") {$iblockId="39";} elseif(($_SERVER["HTTP_HOST"])=="www.plusworld.org") {$iblockId="44";}

CModule::IncludeModule("iblock");
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","PREVIEW_PICTURE","PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>$iblockId, "ID"=>$arParams["ELEMENT_ID"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
  $arFields = $ob->GetFields();
  //print_r($arFields);
  $path = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
}

//echo $arFields["PREVIEW_TEXT"];


$APPLICATION->AddHeadString('<meta property="og:image" content="http://www.plusworld.ru'.$path.'" />',true);
$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arFields["NAME"].'" />',true);
$APPLICATION->AddHeadString('<meta property="og:description" content="'.strip_tags($arFields["PREVIEW_TEXT"]).'" />',true);
?>
