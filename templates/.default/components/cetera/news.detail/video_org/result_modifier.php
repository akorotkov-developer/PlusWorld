
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arSelect = array(
	"ID",
	"NAME",
	"IBLOCK_ID",
	"PREVIEW_TEXT",
	"PREVIEW_TEXT_TYPE",
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

$arFilter[">ID"] = $arResult['ID'];
$rsEl = CIBlockElement::GetList(array("id" => "asc"), $arFilter, false, Array ("nTopCount" => 1), $arSelect);
$rsEl->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);
if($obEl = $rsEl->GetNextElement())
{
	$arRes=$obEl->GetFields();
	$arResult["NEXT"] = $arRes;
}
unset($arFilter[">ID"]);
$arFilter['<ID'] = $arResult['ID'];
$rsEl = CIBlockElement::GetList(array("id" => "desc"), $arFilter, false, Array ("nTopCount" => 1), $arSelect);
$rsEl->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);
if($obEl = $rsEl->GetNextElement())
{
	$arRes=$obEl->GetFields();
	$arResult["PREV"] = $arRes;
}


$res = CIBlockElement::GetByID($arResult["ID"]);
if($ar_res = $res->GetNext())
  $counter = $ar_res['SHOW_COUNTER'];
if($counter < 1)
	$counter = 0;
$counter = intval($counter);

function pluralForm($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}
$arResult["COUNTER"] = $counter;
$arResult["TEXT_COUNTER"]  =  pluralForm($counter, 'view', 'views', 'views');



?>
