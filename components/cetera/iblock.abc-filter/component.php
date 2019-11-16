<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);

if(strlen($arParams["IBLOCK_TYPE"])<=0)
 	$arParams["IBLOCK_TYPE"] = "news";

$arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);

$arParams["LIST_URL"]=trim($arParams["LIST_URL"]);

if(strlen($arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
{
	$arrFilter = array();
}
else
{
	$arrFilter = $GLOBALS[$arParams["FILTER_NAME"]];
	if(!is_array($arrFilter))
		$arrFilter = array();
}

$arParams["alphabet_en"] = Array('A', 'B', 'C', 'D', 'E', 'F', 'J', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S',
            'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$arParams["alphabet_ru"]= Array ('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж',
            'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 'Ъ',
            'Ь', 'Э', 'Ю', 'Я');

$arParams["CACHE_FILTER"] = $arParams["CACHE_FILTER"]=="Y";
if(!$arParams["CACHE_FILTER"] && count($arrFilter)>0)
	$arParams["CACHE_TIME"] = 0;

if($this->StartResultCache($arParams["CACHE_TIME"], $arrFilter, $_REQUEST['letter']))
{
    if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}

    if ($arParams["SHOW_RUS"])
    {
        foreach ($arParams["alphabet_ru"] AS $k=>$v)
        {
            $arSort = array("SORT"=>"ASC");
            $arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "NAME" => $v."%");

            $arResult["ru"][$v] = CIBlockElement::GetList($arSort, array_merge($arFilter, $arrFilter), array());
        }
    }
    if ($arParams["SHOW_ENG"])
    {
        foreach ($arParams["alphabet_en"] AS $k=>$v)
        {
            $arSort = array("SORT"=>"ASC");
            $arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "NAME" => $v."%");

            $arResult["en"][$v] = CIBlockElement::GetList($arSort, array_merge($arFilter, $arrFilter), array());
        }
    }
    if ($arParams["SHOW_NUM"])
    {
        $i = 0;
        while ($i <= 9)
        {
            $arSort = array("SORT"=>"ASC");
            $arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "NAME" => $i."%");

            $arResult["num"][$i] = CIBlockElement::GetList($arSort, array_merge($arFilter, $arrFilter), array());
            $i++;
        }
    }
	if(!empty($arResult))
	{

    	$this->IncludeComponentTemplate();
    }
	else
	{
		$this->AbortResultCache();
		ShowError(GetMessage("T_NEWS_NEWS_NA"));
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}