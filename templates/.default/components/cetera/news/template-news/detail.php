<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true); ?>
<div class="grid-container">
    <div class="grid-x grid-padding-x">

        <div class="cell medium-9 large-6">
            <?$APPLICATION->IncludeComponent(
                "cetera:news.list",
                "index-rl",
                array(
                    "IBLOCK_TYPE" => "news",
                    "IBLOCK_ID" => "23",
                    "NEWS_COUNT" => "10",
                    "SORT_BY1" => "DATE_ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FIELD_CODE" => array(),
                    "PROPERTY_CODE" => array(),
                    "CHECK_DATES" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                ),
                false
            );?>

            <div class="blank text-center">
                <?$APPLICATION->IncludeComponent("bitrix:news.list","day-number",Array(
                        "FIELD_CODE" => Array("ID"),
                        "IBLOCK_ID" => GetIDByCode('day_number'),
                        "PROPERTY_CODE" => Array("DESCRIPTION","NUMBER_COMMENT"),
                        "IBLOCK_TYPE" => "services_ip",
                        "SET_TITLE" => "N",
                    )
                );?>
            </div>
        </div>

        <div class="cell auto">
            <?$ElementID = $APPLICATION->IncludeComponent(
                "cetera:news.detail",
                "",
                Array(
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
                    "DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
                    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                    "SET_TITLE" => "Y",
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                    "ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
                    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
                    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                    "USE_SHARE" 			=> $arParams["USE_SHARE"],
                    "SHARE_HIDE" 			=> $arParams["SHARE_HIDE"],
                    "SHARE_TEMPLATE" 		=> $arParams["SHARE_TEMPLATE"],
                    "SHARE_HANDLERS" 		=> $arParams["SHARE_HANDLERS"],
                    "SHARE_SHORTEN_URL_LOGIN"	=> $arParams["SHARE_SHORTEN_URL_LOGIN"],
                    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                    "DISPLAY_IMG_DETAIL_WIDTH"	=>	$arParams["DISPLAY_IMG_DETAIL_WIDTH"],
                    "DISPLAY_IMG_DETAIL_HEIGHT"	=>	$arParams["DISPLAY_IMG_DETAIL_HEIGHT"],
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                ),
                $component
            );?>


            <?
            //Новости по теме
            $frame = $this->createFrame()->begin("");//Начало динамической области
            $arFilter = Array("IBLOCK_ID"=>23, "ID"=>$ElementID);
            $res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, $arSelect);
            $arResult["TAGS"] = array();
            while($ob = $res->GetNextElement())
            {
                $arRes=$ob->GetFields();
                $arResult["TAGS"] = $arRes["TAGS"];
                $idSect = $arRes["IBLOCK_SECTION_ID"];
            }

            $GLOBALS['themeFilter'] = array("!ID"=>$ElementID, "SECTION_ID"=>$idSect);

            $APPLICATION->IncludeComponent(
                "cetera:news.list",
                "theme-news",
                Array(
                    "IBLOCK_TYPE" => "NEWS_IP",
                    "IBLOCK_ID" => "23",
                    "NEWS_COUNT" => "3",
                    "SORT_BY1" => "DATE_ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "themeFilter",
                    "FIELD_CODE" => array(0 => "NAME", 1 => "PREVIEW_TEXT",2 => "DATE_ACTIVE_FROM", 3 => "PREVIEW_PICTURE",4 => "SHOW_COUNTER", 5=> "DETAIL_PICTURE"),
                    "PROPERTY_CODE" => array(0 => "", 1 => "",),
                    "CHECK_DATES" => "Y",
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
                    "AJAX_OPTION_ADDITIONAL" => "",
                )
            );
            ?>
            <?$frame->end(); // Конец фрейма?>

        </div>

        <div class="cell large-6">
            <div class="margin-bottom-10">
                <?
                $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/include/journal.php");
                ?>
            </div>
            <div class="margin-bottom-10">
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
            <div class="margin-bottom-10">
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
        </div>

    </div>
</div>