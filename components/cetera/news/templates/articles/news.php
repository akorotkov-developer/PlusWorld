<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?/*
<div class="rubric-sponsor"><div style="margin:-20px 0 3px 0; text-transform:none; color:#666;">Спонсор рубрики</div>
<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "", Array(
	"TYPE" => "DAILY_SPONSOR",	// Тип баннера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	),
	false
);?>
<div class="clear"></div>
</div>
*/?>

<h1 class="b-daily__title"><?$APPLICATION->ShowTitle()?>
<?if($arParams["USE_RSS"]=="Y"):?>
<?if(method_exists($APPLICATION, 'addheadstring')){
	$APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" title="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" href="'.$arResult["URL_TEMPLATES"]["rss"].'" />');
}?>
<a href="<?=$arResult["URL_TEMPLATES"]["rss"]?>" title="rss"class="rss-rubric"  target="_self">RSS</a>
<?endif?>
</h1>

<div class="clear"></div>
<div style="margin-bottom: 15px;">
    <span><b><i>Выбрать тему: </i></b></span>
    <?$APPLICATION->IncludeComponent("bitrix:search.tags.cloud","",Array(
            "FONT_MAX" => "50",
            "FONT_MIN" => "10",
            "COLOR_NEW" => "3E74E6",
            "COLOR_OLD" => "C0C0C0",
            "PERIOD_NEW_TAGS" => "",
            "SHOW_CHAIN" => "Y",
            "COLOR_TYPE" => "Y",
            "WIDTH" => "100%",
            "SORT" => "NAME",
            "PAGE_ELEMENTS" => "150",
            "PERIOD" => "",
            "URL_SEARCH" => "/articles/tags/",
            "TAGS_INHERIT" => "Y",
            "CHECK_DATES" => "Y",
            "FILTER_NAME"=> "",
            "arrFILTER" => Array("iblock_services"),
            "arrFILTER_iblock_services" => array(
                0 => "90",
            ),
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600"
        )
    );?>
</div>
<?if ($_REQUEST["rt"]==3) {?>
<div class="clear"></div>
<?if($arParams["USE_SEARCH"]=="Y"):?>
    <?=GetMessage("SEARCH_LABEL")?><?$APPLICATION->IncludeComponent(
        "bitrix:search.form",
        "flat",
        Array(
            "PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"]
        ),
        $component
    );?>
    <br />
<?endif?>
<? } ?>
<div class="clear"></div>
<?if($arParams["USE_FILTER"]=="Y"):?>
<div class="news_filter">
    <form method="get" action="">
        <?$APPLICATION->IncludeComponent(
	"bitrix:main.calendar",
	"",
	Array(
		"SHOW_INPUT" => "Y",
		"FORM_NAME" => "date_filter",
		"INPUT_NAME" => "date_start",
		"INPUT_NAME_FINISH" => "date_end",
		"INPUT_VALUE" => $_REQUEST["date_start"],
		"INPUT_VALUE_FINISH" => $_REQUEST["date_end"],
		"SHOW_TIME" => "N",
		"HIDE_TIMEBAR" => "Y"
	),
false
);?><input value="показать" type="submit"/></form>
    <div class="clear"></div>
    </div>
<br />


<?endif?>

<?if ($_REQUEST["rt"]==2) {?>

    <?
    $GLOBALS['popular_filter'] = array("!PROPERTY_INTRESTING"=>false);
    $APPLICATION->IncludeComponent(
        "cetera:news.list",
        "popular-articles",
        array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "NEWS_COUNT" => "3",
        "SORT_BY1" => "SHOW_COUNTER",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "DATE_ACTIVE_FROM",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "popular_filter",
        "FIELD_CODE" => array(
            0 => "DETAIL_PICTURE",
            1 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "H:i, j F Y",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
        "PAGER_SHOW_ALL" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "AJAX_OPTION_ADDITIONAL" => ""
    ),
        false
    );
    ?>
<? } ?>
    <?
    $dateFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");
    if (isset($_REQUEST['date_start']) || isset($_REQUEST['date_end'])) {

        if (isset($_REQUEST['date_start']))
            $date_start = ConvertDateTime($_REQUEST['date_start'], "DD.MM.YYYY");

        if (isset($_REQUEST['date_end']))
            $date_end = ConvertDateTime($_REQUEST['date_end'], "DD.MM.YYYY");

        if (!empty($date_start)) {
            $dateFilter[">=DATE_ACTIVE_FROM"] = $date_start;
        }
        if (!empty($date_end)) {
            $dateFilter["<=DATE_ACTIVE_FROM"] = $date_end;
        }
        $dateFilter = $dateFilter;
        //print_r($dateFilter);
    }
    $GLOBALS["dateFilter"] = $dateFilter;
    CModule::IncludeModule("iblock");
    $newsCounter = CIBlockElement::GetList(Array(), $dateFilter, Array());
    ?>

    <div class="news-block-articles" data-newscount="<?=$arParams['NEWS_COUNT']?>" data-count="<?= $newsCounter ?>">
        <div class="news-list-articles">
            <?$APPLICATION->IncludeComponent(
                "cetera:news.list",
                "daily",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "dateFilter",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "DATE_ACTIVE_FROM",
                        4 => "SHOW_COUNTER",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "",
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "N",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "H:i, j F Y",
                    "SET_TITLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => "�������",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "news",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => ""
                ),
                false
            );?>
        </div>
    </div>