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
