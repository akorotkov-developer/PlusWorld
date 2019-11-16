<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); 
?>

<ul class="term">
    <?
    $count = 1;
    $countItems = count($arResult["ITEMS"]);
    foreach ($arResult["ITEMS"] as $item) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?
            $detailText = TruncateText(strip_tags($item["DETAIL_TEXT"], '<b>'), 350). "...";
            $detailText = substr_replace($detailText, $rest, 0, $restPos)
            ?>
            <a class="term__item" href="<?=$item["DETAIL_PAGE_URL"]?>">
                <?=$detailText?>
            </a>
        </li>
        <?if ($count == 4) {?>
            </ul>

            <?
            $GLOBALS["kbFilter"] = array(
                "ACTIVE" =>"Y",
                array(
                    "LOGIC" => "OR",
                    array("IBLOCK_ID" => "70"),
                    array("IBLOCK_ID" => "73"),
                    array("IBLOCK_ID" => "41", "!PROPERTY_KNOW_BASE" => false),
                    array("IBLOCK_ID" => "69", "!PROPERTY_KNOW_BASE" => false),
                ),
            );
            ?>
            <?$APPLICATION->IncludeComponent(
                "cetera:news.list.kb",
                "kb-index",
                Array(
                    "DISPLAY_DATE" => "N",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "N",
                    "AJAX_MODE" => "N",
                    "IBLOCK_TYPE" => "",
                    "IBLOCK_ID" => "",
                    "NEWS_COUNT" => "8",
                    "SORT_BY1" => "DATE_ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "",
                    "SORT_ORDER2" => "",
                    "FILTER_NAME" => "kbFilter",
                    "FIELD_CODE" => array(),
                    "PROPERTY_CODE" => array(),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "130",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Страницы",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "news",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "DISPLAY_IMG_WIDTH" => 273,
                    "DISPLAY_IMG_HEIGHT" => 170,
                ),
                false
            );?>

            <ul class="term">
        <?}?>
    <?
        $count++;
    }
    ?>
</ul>

<?
if ($countItems < 4) {
    ?>
    <?
    $GLOBALS["kbFilter"] = array(
        "ACTIVE" =>"Y",
        array(
            "LOGIC" => "OR",
            array("IBLOCK_ID" => "70"),
            array("IBLOCK_ID" => "73"),
            array("IBLOCK_ID" => "41", "!PROPERTY_KNOW_BASE" => false),
            array("IBLOCK_ID" => "69", "!PROPERTY_KNOW_BASE" => false),
        ),
    );
    ?>
    <?$APPLICATION->IncludeComponent(
        "cetera:news.list.kb",
        "kb-index",
        Array(
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "AJAX_MODE" => "N",
            "IBLOCK_TYPE" => "",
            "IBLOCK_ID" => "",
            "NEWS_COUNT" => "8",
            "SORT_BY1" => "DATE_ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "",
            "SORT_ORDER2" => "",
            "FILTER_NAME" => "kbFilter",
            "FIELD_CODE" => array(),
            "PROPERTY_CODE" => array(),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "PREVIEW_TRUNCATE_LEN" => "130",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => $_REQUEST["SECTION_CODE"],
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Страницы",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "news",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "DISPLAY_IMG_WIDTH" => 273,
            "DISPLAY_IMG_HEIGHT" => 170,
        ),
        false
    );?>
    <?
}
?>


<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>