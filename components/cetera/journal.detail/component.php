<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"])<=0)
	$arParams["IBLOCK_TYPE"] = "news";


$arParams["ARTICLE_ID"] = intval($arParams["ARTICLE_ID"]);

$arParams["ELEMENT_ID"] = intval($arParams["~ELEMENT_ID"]);
if($arParams["ELEMENT_ID"] > 0 && $arParams["ELEMENT_ID"]."" != $arParams["~ELEMENT_ID"])
{
	ShowError(GetMessage("T_NEWS_DETAIL_NF"));
	@define("ERROR_404", "Y");
	if($arParams["SET_STATUS_404"]==="Y")
		CHTTP::SetStatus("404 Not Found");
	return;
}

$arParams["CHECK_DATES"] = $arParams["CHECK_DATES"]!="N";
if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = array();
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);
if(!is_array($arParams["PROPERTY_CODE"]))
	$arParams["PROPERTY_CODE"] = array();
foreach($arParams["PROPERTY_CODE"] as $k=>$v)
	if($v==="")
		unset($arParams["PROPERTY_CODE"][$k]);

$arParams["IBLOCK_URL"]=trim($arParams["IBLOCK_URL"]);

$arParams["META_KEYWORDS"]=trim($arParams["META_KEYWORDS"]);
if(strlen($arParams["META_KEYWORDS"])<=0)
	$arParams["META_KEYWORDS"] = "-";
$arParams["META_DESCRIPTION"]=trim($arParams["META_DESCRIPTION"]);
if(strlen($arParams["META_DESCRIPTION"])<=0)
	$arParams["META_DESCRIPTION"] = "-";
$arParams["BROWSER_TITLE"]=trim($arParams["BROWSER_TITLE"]);
if(strlen($arParams["BROWSER_TITLE"])<=0)
	$arParams["BROWSER_TITLE"] = "-";

$arParams["PREVIEW_TRUNCATE_LEN"] = intval($arParams["PREVIEW_TRUNCATE_LEN"]);

$arParams["INCLUDE_IBLOCK_INTO_CHAIN"] = $arParams["INCLUDE_IBLOCK_INTO_CHAIN"]!="N";
$arParams["ADD_SECTIONS_CHAIN"] = $arParams["ADD_SECTIONS_CHAIN"]!="N"; //Turn on by default
$arParams["SET_TITLE"]=$arParams["SET_TITLE"]!="N";
$arParams["ACTIVE_DATE_FORMAT"] = trim($arParams["ACTIVE_DATE_FORMAT"]);
if(strlen($arParams["ACTIVE_DATE_FORMAT"])<=0)
	$arParams["ACTIVE_DATE_FORMAT"] = $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));

$arParams["DISPLAY_TOP_PAGER"] = $arParams["DISPLAY_TOP_PAGER"]=="Y";
$arParams["DISPLAY_BOTTOM_PAGER"] = $arParams["DISPLAY_BOTTOM_PAGER"]!="N";
$arParams["PAGER_TITLE"] = trim($arParams["PAGER_TITLE"]);
$arParams["PAGER_SHOW_ALWAYS"] = $arParams["PAGER_SHOW_ALWAYS"]!="N";
$arParams["PAGER_TEMPLATE"] = trim($arParams["PAGER_TEMPLATE"]);
$arParams["PAGER_SHOW_ALL"] = $arParams["PAGER_SHOW_ALL"]!=="N";

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
if(strlen($arParams["ARTICLES_FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["ARTICLES_FILTER_NAME"]))
{
	$arrArtFilter = array();
}
else
{
	$arrArtFilter = $GLOBALS[$arParams["ARTICLES_FILTER_NAME"]];
	if(!is_array($arrArtFilter))
		$arrArtFilter = array();
}

$arParams["CACHE_FILTER"] = $arParams["CACHE_FILTER"]=="Y";
if(!$arParams["CACHE_FILTER"] && count($arrFilter)>0)
	$arParams["CACHE_TIME"] = 0;

if($arParams["DISPLAY_TOP_PAGER"] || $arParams["DISPLAY_BOTTOM_PAGER"])
{
	$arNavParams = array(
		"nPageSize" => 1,
		"bShowAll" => $arParams["PAGER_SHOW_ALL"],
	);
	$arNavigation = CDBResult::GetNavParams($arNavParams);
}
else
{
	$arNavigation = false;
}

$arParams["SHOW_WORKFLOW"] = $_REQUEST["show_workflow"]=="Y";

$arParams["USE_PERMISSIONS"] = $arParams["USE_PERMISSIONS"]=="Y";
if(!is_array($arParams["GROUP_PERMISSIONS"]))
	$arParams["GROUP_PERMISSIONS"] = array(1);

$bUSER_HAVE_ACCESS = !$arParams["USE_PERMISSIONS"];
if($arParams["USE_PERMISSIONS"] && isset($GLOBALS["USER"]) && is_object($GLOBALS["USER"]))
{
	$arUserGroupArray = $GLOBALS["USER"]->GetUserGroupArray();
	foreach($arParams["GROUP_PERMISSIONS"] as $PERM)
	{
		if(in_array($PERM, $arUserGroupArray))
		{
			$bUSER_HAVE_ACCESS = true;
			break;
		}
	}
}
if(!$bUSER_HAVE_ACCESS)
{
	ShowError(GetMessage("T_NEWS_DETAIL_PERM_DEN"));
	return 0;
}

if($arParams["SHOW_WORKFLOW"] || $this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()),$bUSER_HAVE_ACCESS, $arNavigation,$arrFilter)))
{

	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}


	$arFilter = array(
		"IBLOCK_LID" => SITE_ID,
		"IBLOCK_ACTIVE" => "Y",
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"SHOW_HISTORY" => $WF_SHOW_HISTORY,
	);
	if($arParams["CHECK_DATES"])
		$arFilter["ACTIVE_DATE"] = "Y";
	if(intval($arParams["IBLOCK_ID"]) > 0)
		$arFilter["IBLOCK_ID"] = $arParams["IBLOCK_ID"];

	//Handle case when ELEMENT_CODE used
	if($arParams["ELEMENT_ID"] <= 0)
		$arParams["ELEMENT_ID"] = CIBlockFindTools::GetElementID(
			$arParams["ELEMENT_ID"],
			$arParams["ELEMENT_CODE"],
			false,
			false,
			$arFilter
		);

	$WF_SHOW_HISTORY = "N";
	if ($arParams["SHOW_WORKFLOW"] && CModule::IncludeModule("workflow"))
	{
		$WF_ELEMENT_ID = CIBlockElement::WF_GetLast($arParams["ELEMENT_ID"]);

		$WF_STATUS_ID = CIBlockElement::WF_GetCurrentStatus($WF_ELEMENT_ID, $WF_STATUS_TITLE);
		$WF_STATUS_PERMISSION = CIBlockElement::WF_GetStatusPermission($WF_STATUS_ID);

		if ($WF_STATUS_ID == 1 || $WF_STATUS_PERMISSION < 1)
			$WF_ELEMENT_ID = $arParams["ELEMENT_ID"];
		else
			$WF_SHOW_HISTORY = "Y";

		$arParams["ELEMENT_ID"] = $WF_ELEMENT_ID;
	}

	$arSelect = array_merge($arParams["FIELD_CODE"], array(
		"ID",
		"NAME",
		"IBLOCK_ID",
		"IBLOCK_SECTION_ID",
		"DETAIL_TEXT",
		"DETAIL_TEXT_TYPE",
		"PREVIEW_TEXT",
		"PREVIEW_TEXT_TYPE",
		"PREVIEW_PICTURE",
		"DETAIL_PICTURE",
		"ACTIVE_FROM",
		"LIST_PAGE_URL",
		"DETAIL_PAGE_URL",
	));
	$bGetProperty = count($arParams["PROPERTY_CODE"]) > 0
		|| $arParams["BROWSER_TITLE"] != "-"
		|| $arParams["META_KEYWORDS"] != "-"
		|| $arParams["META_DESCRIPTION"] != "-";
	if($bGetProperty)
		$arSelect[]="PROPERTY_*";

	$arFilter["ID"] = $arParams["ELEMENT_ID"];
	$arFilter["SHOW_HISTORY"] = $WF_SHOW_HISTORY;

	$rsElement = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	$rsElement->SetUrlTemplates($arParams["DETAIL_URL"], "", $arParams["IBLOCK_URL"]);
	if($obElement = $rsElement->GetNextElement())
	{
		$arResult = $obElement->GetFields();

		$rsIBlock = CIBlock::GetByID($arParams["IBLOCK_ID"]);
		if ($arIBlock = $rsIBlock->GetNext())
		{
			$arResult["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
			$arResult["ARTICLES_IBLOCK_ID"] = $arParams["ARTICLES_IBLOCK_ID"];
			$arResult["IBLOCK_URL"] = str_replace("#SITE_DIR#","",$arIBlock["LIST_PAGE_URL"]);
			$arResult["IBLOCK_DESCRIPTION"] = $arIBlock["DESCRIPTION"];

		}

		$obParser = new CTextParser;

		$arResult["NAV_RESULT"] = new CDBResult;
		if(($arResult["DETAIL_TEXT_TYPE"]=="html") && (strstr($arResult["DETAIL_TEXT"], "<BREAK />")!==false))
			$arPages=explode("<BREAK />", $arResult["DETAIL_TEXT"]);
		elseif(($arResult["DETAIL_TEXT_TYPE"]!="html") && (strstr($arResult["DETAIL_TEXT"], "&lt;BREAK /&gt;")!==false))
			$arPages=explode("&lt;BREAK /&gt;", $arResult["DETAIL_TEXT"]);
		else
			$arPages=array();
		$arResult["NAV_RESULT"]->InitFromArray($arPages);
		$arResult["NAV_RESULT"]->NavStart($arNavParams);
		if(count($arPages)==0)
		{
			$arResult["NAV_RESULT"] = false;
		}
		else
		{
			$arResult["NAV_STRING"] = $arResult["NAV_RESULT"]->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], $arParams["PAGER_SHOW_ALWAYS"]);
			$arResult["NAV_CACHED_DATA"] = $navComponentObject->GetTemplateCachedData();

			$arResult["NAV_TEXT"] = "";
			while($ar = $arResult["NAV_RESULT"]->Fetch())
				$arResult["NAV_TEXT"].=$ar;
		}


		if(strlen($arResult["ACTIVE_FROM"])>0)
			$arResult["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arResult["ACTIVE_FROM"], CSite::GetDateFormat()));
		else
			$arResult["DISPLAY_ACTIVE_FROM"] = "";

		if(isset($arResult["PREVIEW_PICTURE"]))
			$arResult["PREVIEW_PICTURE"] = CFile::GetFileArray($arResult["PREVIEW_PICTURE"]);
		if(isset($arResult["DETAIL_PICTURE"]))
			$arResult["DETAIL_PICTURE"] = CFile::GetFileArray($arResult["DETAIL_PICTURE"]);

		$arResult["FIELDS"] = array();
		foreach($arParams["FIELD_CODE"] as $code)
			if(array_key_exists($code, $arResult))
				$arResult["FIELDS"][$code] = $arResult[$code];

		if($bGetProperty)
			$arResult["PROPERTIES"] = $obElement->GetProperties();
		$arResult["DISPLAY_PROPERTIES"]=array();
		foreach($arParams["PROPERTY_CODE"] as $pid)
		{
			$prop = &$arResult["PROPERTIES"][$pid];
			if((is_array($prop["VALUE"]) && count($prop["VALUE"])>0) ||
				(!is_array($prop["VALUE"]) && strlen($prop["VALUE"])>0))
			{
				$arResult["DISPLAY_PROPERTIES"][$pid] = CIBlockFormatProperties::GetDisplayValue($arResult, $prop, "news_out");
			}
		}

		$arResult["resMainArticle"] = CIBlockElement::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$arParams["ARTICLES_IBLOCK_ID"],"PROPERTY_JOURNAL"=>$arResult["ID"],"!PROPERTY_MAIN_VALUE"=>false), false, false, array("ID","NAME","PREVIEW_TEXT","PREVIEW_PICTURE","DETAIL_TEXT","DETAIL_PAGE_URL"));
		$i=0;
		while($obMainArticle = $arResult["resMainArticle"]->GetNextElement())
		{
			$arArticle = $obMainArticle->GetFields();

			if($arParams["PREVIEW_TRUNCATE_LEN"] > 0)
				$arArticle["PREVIEW_TEXT"] = $obParser->html_cut(($arArticle["PREVIEW_TEXT"] != '' ? $arArticle["PREVIEW_TEXT"] : $arArticle["DETAIL_TEXT"]),$arParams["PREVIEW_TRUNCATE_LEN"]);

			$arArticle["PREVIEW_TEXT"] = strip_tags(preg_replace("/(<img\s+.*\s+\/>).*/","",$arArticle["PREVIEW_TEXT"]));

			unset($arArticle["DETAIL_TEXT"], $arArticle["~DETAIL_TEXT"]);
			//$arArticle["DETAIL_PAGE_URL"] =  str_replace($arArticle['ID'], $arResult["ID"].'/'.$arArticle['ID'], $arArticle["DETAIL_PAGE_URL"]);
			$arResult["MAIN_ARTICLE"] = $arArticle;
			$i++;
		}
		$arFilter =  array("IBLOCK_ID"=>$arParams["ARTICLES_IBLOCK_ID"],"PROPERTY_JOURNAL"=>$arResult["ID"]);

		$arResult["resArticles"] = CIBlockElement::GetList(array("SORT"=>"ASC"),array_merge($arFilter, $arrArtFilter), false, false, array("ID","NAME","PREVIEW_TEXT","PREVIEW_PICTURE","DETAIL_TEXT","PROPERTY_MAIN","DETAIL_PAGE_URL"));
		$i=0;
		while($arArticle = $arResult["resArticles"]->GetNext())
		{
			//$arArticle = $obArticle->GetFields();
			$arArticle["DETAIL_TEXT"] = strip_tags(preg_replace("/(<img\s+.*\s+\/>).*/","",$arArticle["DETAIL_TEXT"]));
			if($arParams["PREVIEW_TRUNCATE_LEN"] > 0){
				$arArticle["PREVIEW_TEXT"] .= $arArticle["DETAIL_TEXT"];
				$arArticle["PREVIEW_TEXT"] = $obParser->html_cut(($arArticle["PREVIEW_TEXT"] != '' ? $arArticle["PREVIEW_TEXT"] : $arArticle["DETAIL_TEXT"]),$arParams["PREVIEW_TRUNCATE_LEN"]);
			}


			$arArticle["PREVIEW_TEXT"] = strip_tags(preg_replace("/(<img\s+.*\s+\/>).*/","",$arArticle["PREVIEW_TEXT"]));

			$arArticle["PREVIEW_PICTURE"] = CFile::GetFileArray($arArticle["PREVIEW_PICTURE"]);

			unset($arArticle["DETAIL_TEXT"], $arArticle["~DETAIL_TEXT"]);

			if (($arParams["ARTICLE_ID"] > '0' && $arParams["ARTICLE_ID"] == $arArticle["ID"]) || ($arParams["ARTICLE_ID"] == '0' && $i==0))
			{
				$arArticle["SELECTED"] = 1;
				$arResult["INDEX_SELECTED"] = $i;
			}
			$arArticle["INDEX"] = $i;

			$arResult["ARTICLES"][] = $arArticle;
			$i++;
		}

		$arResult["IBLOCK"] = GetIBlock($arResult["IBLOCK_ID"], $arResult["IBLOCK_TYPE"]);

		$arResult["SECTION"] = array("PATH" => array());
		$arResult["SECTION_URL"] = "";
		if($arParams["ADD_SECTIONS_CHAIN"] && $arResult["IBLOCK_SECTION_ID"]>0)
		{
			$rsPath = GetIBlockSectionPath($arResult["IBLOCK_ID"], $arResult["IBLOCK_SECTION_ID"]);
			$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
			while($arPath=$rsPath->GetNext())
			{
				$arResult["SECTION"]["PATH"][] = $arPath;
				$arResult["SECTION_URL"] = $arPath["~SECTION_PAGE_URL"];
			}
		}

		$this->SetResultCacheKeys(array(
			"ID",
			"IBLOCK_ID",
			"ARTICLES",
			"NAV_CACHED_DATA",
			"NAME",
			"IBLOCK_SECTION_ID",
			"IBLOCK",
			"LIST_PAGE_URL", "~LIST_PAGE_URL",
			"SECTION_URL",
			"SECTION",
			"PROPERTIES",
		));

		$this->IncludeComponentTemplate();
	}
	else
	{
		$this->AbortResultCache();
		ShowError(GetMessage("T_NEWS_DETAIL_NF"));
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}

if(isset($arResult["ID"]))
{
	$arTitleOptions = null;
	if(CModule::IncludeModule("iblock"))
	{
		CIBlockElement::CounterInc($arParams["ELEMENT_ID"]);

		if($USER->IsAuthorized())
		{
			if(
				$APPLICATION->GetShowIncludeAreas()
				|| $arParams["SET_TITLE"]
				|| isset($arResult[$arParams["BROWSER_TITLE"]])
			)
			{
				$arReturnUrl = array(
					"add_element" => CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "DETAIL_PAGE_URL"),
					"delete_element" => (
					empty($arResult["SECTION_URL"])?
						$arResult["LIST_PAGE_URL"]:
						$arResult["SECTION_URL"]
					),
				);

				$arButtons = CIBlock::GetPanelButtons(
					$arResult["IBLOCK_ID"],
					$arResult["ID"],
					$arResult["IBLOCK_SECTION_ID"],
					Array(
						"RETURN_URL" => $arReturnUrl,
						"SECTION_BUTTONS" => false,
					)
				);

				if($APPLICATION->GetShowIncludeAreas())
					$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

				if($arParams["SET_TITLE"] || isset($arResult[$arParams["BROWSER_TITLE"]]))
				{
					$arTitleOptions = array(
						'ADMIN_EDIT_LINK' => $arButtons["submenu"]["edit_element"]["ACTION"],
						'PUBLIC_EDIT_LINK' => $arButtons["edit"]["edit_element"]["ACTION"],
						'COMPONENT_NAME' => $this->GetName(),
					);
				}
			}
		}
	}

	$this->SetTemplateCachedData($arResult["NAV_CACHED_DATA"]);

	if($arParams["SET_TITLE"])
	{
		$APPLICATION->SetTitle($arResult["NAME"], $arTitleOptions);
	}

	if(isset($arResult["PROPERTIES"][$arParams["BROWSER_TITLE"]]))
	{
		$val = $arResult["PROPERTIES"][$arParams["BROWSER_TITLE"]]["VALUE"];
		if(is_array($val))
			$val = implode(" ", $val);
		$APPLICATION->SetPageProperty("title", $val);
	}
	elseif(isset($arResult[$arParams["BROWSER_TITLE"]]) && !is_array($arResult[$arParams["BROWSER_TITLE"]]))
	{
		$APPLICATION->SetPageProperty("title", $arResult[$arParams["BROWSER_TITLE"]], $arTitleOptions);
	}

	if($arParams["INCLUDE_IBLOCK_INTO_CHAIN"] && isset($arResult["IBLOCK"]["NAME"]))
	{
		$APPLICATION->AddChainItem($arResult["IBLOCK"]["NAME"], $arResult["~LIST_PAGE_URL"]);
	}

	if($arParams["ADD_SECTIONS_CHAIN"] && is_array($arResult["SECTION"]))
	{
		foreach($arResult["SECTION"]["PATH"] as $arPath)
		{
			$APPLICATION->AddChainItem($arPath["NAME"], $arPath["~SECTION_PAGE_URL"]);
		}
	}
	if($arParams["ADD_INTO_CHAIN"])
	{
		$APPLICATION->AddChainItem($arResult["NAME"]);
	}
	if(isset($arResult["PROPERTIES"][$arParams["META_KEYWORDS"]]))
	{
		$val = $arResult["PROPERTIES"][$arParams["META_KEYWORDS"]]["VALUE"];
		if(is_array($val))
			$val = implode(" ", $val);
		$APPLICATION->SetPageProperty("keywords", $val);
	}

	if($arParams["SET_META_DESCRIPTION"] == "Y")
	{
		$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arResult["IBLOCK_ID"],$arResult["ID"]);
		$IPROPERTY  = $ipropValues->getValues();

		if ($IPROPERTY["ELEMENT_META_DESCRIPTION"] != "") {
			$APPLICATION->SetPageProperty("description", strip_tags($IPROPERTY["ELEMENT_META_DESCRIPTION"]));
			$APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='".strip_tags($IPROPERTY["ELEMENT_META_DESCRIPTION"])."'>");
		} elseif ($arResult["FIELD_DESCRIPTION"] != "") {
			$APPLICATION->SetPageProperty("description", strip_tags($arResult["FIELD_DESCRIPTION"]));
			$APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='".strip_tags($arResult["FIELD_DESCRIPTION"])."'>");
		}
		if ($IPROPERTY["ELEMENT_META_TITLE"] != "") {
			$APPLICATION->SetPageProperty("title", $IPROPERTY["ELEMENT_META_TITLE"]);
		}
		if ($IPROPERTY["ELEMENT_META_KEYWORDS"] != "") {
			$APPLICATION->SetPageProperty("keywords", $IPROPERTY["ELEMENT_META_KEYWORDS"]);
		}
	}

	return $arResult["ID"];
}
else
{
	return 0;
}
?>
