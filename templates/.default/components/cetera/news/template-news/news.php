<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
?>
<div class="grid-container">
    <div class="grid-x grid-padding-x">

        <div class="cell auto">
            <?$this->setFrameMode(true);?>

            <?if($arParams["USE_RSS"]=="Y"):?>
                <?
                if(method_exists($APPLICATION, 'addheadstring'))
                    $APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" title="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" href="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" />');
                ?>
                <a href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"]?>" title="rss" target="_self"><img alt="RSS" src="<?=$templateFolder?>/images/gif-light/feed-icon-16x16.gif" border="0" align="right" /></a>
            <?endif?>

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



            <?
            $GLOBALS["dateFilter"] = array();
            if (isset($_REQUEST['date_start']) || isset($_REQUEST['date_end']))
            {
                $dateFilter = array();
                if (isset($_REQUEST['date_start']))
                    $date_start = ConvertDateTime($_REQUEST['date_start'], "DD.MM.YYYY");

                if (isset($_REQUEST['date_end']))
                    $date_end   = ConvertDateTime($_REQUEST['date_end'], "DD.MM.YYYY");

                if (!empty($date_start)) {
                    $dateFilter[">=DATE_ACTIVE_FROM"] = $date_start;
                }
                if (!empty($date_end)) {
                    $dateFilter["<=DATE_ACTIVE_FROM"] = $date_end;
                }
                $GLOBALS["dateFilter"] = $dateFilter;
                // print_r($dateFilter);
            }
            ?>
            <?
            $GLOBALS["dateFilter"] = array_merge($GLOBALS["dateFilter"], array("?TAGS" => $_GET["tags"]));
            ?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "rl-news",
                array(
                    "IBLOCK_TYPE" => "NEWS_IP",
                    "IBLOCK_ID" => "23",
                    "NEWS_COUNT" => "7",
                    "SORT_BY1" => "PROPERTY_PARTMAIN",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "ACTIVE_FROM",
                    "SORT_ORDER2" => "DESC",
                    "FILTER_NAME" => "dateFilter",
                    "FIELD_CODE" => array(
                        0 => "SHOW_COUNTER",
                        0 => "DETAIL_PICTURE",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "FORUM_MESSAGE_CNT",
                        1 => "DETAIL_PICTURE",
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
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "news_nav",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "DISPLAY_IMG_WIDTH"	=>	"80",
                    "DISPLAY_IMG_HEIGHT"	=>	"56",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                ),
                false
            );?>
        </div>

        <div class="cell medium-9 large-6 subscribe-block-width">
            <div class="margin-bottom-10">
                <?
                $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/include/journal.php");
                ?>
            </div>
            <div class="margin-bottom-10 subcribe-block-width">
                <div class="blank text-center">
                    <div class="blank__back"></div>
                    <div class="blank__container">
                        <div class="blank__triangle"></div>
                    </div>
                    <?
                    $dateFilterExpert = array();
                    $dateFilterExpert = array(
                        "IBLOCK_ID" => array(23,91,41),
                        "PROPERTY_EXPERT_FORUM_VALUE" => '1'
                    );
                    $GLOBALS["dateFilterExpert"] = $dateFilterExpert;
                    ?>
                    <?$APPLICATION->IncludeComponent(
                        "cetera:news-index-rl.list",
                        "index-news-no-title",
                        array(
                            "IBLOCK_TYPE" => "",
                            "IBLOCK_ID" => "",
                            "NEWS_COUNT" => "3",
                            "SORT_BY1" => "DATE_ACTIVE_FROM",
                            "SORT_ORDER1" => "DESC",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER2" => "ASC",
                            "FILTER_NAME" => "dateFilterExpert",
                            "FIELD_CODE" => array("DETAIL_PICTURE"),
                            "PROPERTY_CODE" => array(),
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "3600",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "ACTIVE_DATE_FORMAT" => "H:i, j F",
                            "SET_TITLE" => "N",
                            "SET_STATUS_404" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "PAGER_TITLE" => "Новости",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "N",
                            "AJAX_OPTION_ADDITIONAL" => ""
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="margin-bottom-10 subscribe-block">
                <?$APPLICATION->IncludeComponent("bitrix:sender.subscribe","main-page-subscribe",Array(
                        "COMPONENT_TEMPLATE" => ".default",
                        "USE_PERSONALIZATION" => "Y",
                        "CONFIRMATION" => "Y",
                        "SHOW_HIDDEN" => "Y",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_JUMP" => "Y",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "SET_TITLE" => "N"
                    )
                );?>
            </div>
            <?
            // включаемая область для раздела
            $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/newslist_banner.php", Array(), Array());
            ?>
            <div class="margin-bottom-10">
                <div class="blank text-center lastblock_on_sidebar">
                    <?$APPLICATION->IncludeComponent("bitrix:news.list","day-number",Array(
                            "FIELD_CODE" => Array("ID"),
                            "IBLOCK_ID" => GetIDByCode('day_number'),
                            "PROPERTY_CODE" => Array("DESCRIPTION","NUMBER_COMMENT"),
                            "IBLOCK_TYPE" => "services_ip",
                            "SET_TITLE" => "N"
                        )
                    );?>
                </div>
            </div>
        </div>

    </div>
</div>