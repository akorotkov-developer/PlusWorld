<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult["TAGS_CHAIN"] = array();
if($arResult["REQUEST"]["~TAGS"])
{
	$res = array_unique(explode(",", $arResult["REQUEST"]["~TAGS"]));
	$url = array();
	foreach ($res as $key => $tags)
	{
		$tags = trim($tags);
		if(!empty($tags))
		{
			$url_without = $res;
			unset($url_without[$key]);
			$url[$tags] = $tags;
			$result = array(
				"TAG_NAME" => htmlspecialcharsex($tags),
				"TAG_PATH" => $APPLICATION->GetCurPageParam("tags=".urlencode(implode(",", $url)), array("tags")),
				"TAG_WITHOUT" => $APPLICATION->GetCurPageParam((count($url_without) > 0 ? "tags=".urlencode(implode(",", $url_without)) : ""), array("tags")),
			);
			$arResult["TAGS_CHAIN"][] = $result;
		}
	}
}

//Получаем рубрику поискового результата
foreach ($arResult["SEARCH"] as $key => $searchItem) {
    \CModule::IncludeModule('iblock');

    $sectID = false;
    $rs = CIBlockElement::GetList(
        array("SORT"=>"ASC"), //Сортировка
        array("ID"=>$searchItem["ITEM_ID"] ), //Фильтр значению полей
        false, //Массив полей группировка
        false, //Параметр для постраничной навигации
        array("ID", "IBLOCK_SECTION_ID") //Массив возвращаемых полей
    );

    while($ar = $rs->GetNext()) {
        $sectID = $ar["IBLOCK_SECTION_ID"];
    }

    if ($sectID) {
        $rubric = getRubric($sectID);
        $arResult["SEARCH"][$key]["RUBRIC"] = $rubric;
    }
}
?>