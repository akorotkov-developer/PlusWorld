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
<?if (LANG != 'en') { ?>
<?
    $pos_daily = strpos($APPLICATION->GetCurPage(),"daily");

    if ($pos_daily != false){
        if ($APPLICATION->GetCurPage() != '/daily/') {
            $APPLICATION->IncludeComponent(
                "cetera:super.component",
                "banner_rubrics_sponsor-daily",
                Array(
                    "IBLOCK_ID" => "9",
                    "CODE_SECTION_DEFAULT" => "DAILY",
                ),
                false
            );
        }
        else {
            $APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                "sponsors-section-daily__new",
                Array(
                    "TYPE" => "DAILY_SPONSOR",	// Тип баннера
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
                    "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                    "TEXT-banner"=> "",
                ),
                false
            );
        }
    }
?>
    <div class="clear"></div>
    <?/*
        $APPLICATION->IncludeComponent(
            "bitrix:search.tags.cloud",
            "",
            Array(
                "FONT_MAX" => "14",
                "FONT_MIN" => "12",
                "COLOR_NEW" => "3E74E6",
                "COLOR_OLD" => "C0C0C0",
                "PERIOD_NEW_TAGS" => "",
                "SHOW_CHAIN" => "Y",
                "COLOR_TYPE" => "Y",
                "WIDTH" => "100%",
                "SORT" => "CNT",
                "PAGE_ELEMENTS" => "20",
                "PERIOD" => "60",
                "URL_SEARCH" => "/daily/tags/",
                "TAGS_INHERIT" => "Y",
                "CHECK_DATES" => "Y",
                "FILTER_NAME" => "",
                "arrFILTER" => Array(
                    "iblock_news",
                ),
                "arrFILTER_iblock_news" => array("9"),
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600000"
            )
        );*/
    ?>
    <? } else {?>
    <?
    $APPLICATION->IncludeComponent(
        "bitrix:advertising.banner",
        "sponsors-section-daily__new",
        Array(
            "TYPE" => "DAILY_SPONSOR",	// Тип баннера
            "CACHE_TYPE" => "A",	// Тип кеширования
            "NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
            "CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "TEXT-banner"=> "",
        ),
        false
    );?>
    <? } ?>
<br />
<div class="clear"></div>


<?/*if($arParams["USE_SEARCH"]=="Y"):?>
<?=GetMessage("SEARCH_LABEL")?><?$APPLICATION->IncludeComponent(
	"bitrix:search.form",
	"flat",
	Array(
		"PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"]
	),
	$component
);?>
<br />
<?endif*/?>

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
    $GLOBALS['popular_filter'] = array("!PROPERTY_INTRESTING"=>false);
$APPLICATION->IncludeComponent("cetera:news.list", "popular", array(
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"NEWS_COUNT" => "3",
	"SORT_BY1" => "DATE_ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
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

<?if (LANG != 'en') { ?>
    <style>
        #featured {
            width: 40%;
            padding-right: 60%;
            border: 5px solid #ccc;
            padding-bottom: 5px;
        }
        #featured ul.ui-tabs-nav {
            width: 60%;
            left: 40%;
        }
        #featured .ui-tabs-panel {
            width: 100%;
        }
        .rubric-top-tabs {
            border: none;
        }
    </style>
<?/*
        <div style="border: 5px solid #ccc; display: inline-block; margin-top: 20px; width: 100%">
            <div style="width:53%; float: left; padding-right: 2%;  padding-bottom: 5px;">
                <img style="width: 100%; "
                src="http://www.plusworld.ru/images/subscribe/9may/PLUS_9May-2016_PLUS.jpg" style="border:none;" alt="ПЛАС-daily" title="ПЛАС-daily" />
            </div>
            <div style="width: 45%; float: left;">
                <div style="line-height: 14px;  font-size: 14px; font-family: Arial,Helvetica,sans-serif;  padding-right: 5px;">
                    <br/>
                    <p style="margin-top: 0"><b>Белорусский вокзал. 1945 год.<br/><br/>
                            Вглядитесь в эти лица -<br/>
                            как же они умели ждать<br/>
                            своих вернувшихся<br/>
                            и не вернувшихся все тысяча<br/>
                            четыреста восемнадцать дней<br/>
                            Великой Отечественной Войны… </b></p>

                    <p style="margin-bottom: 0;text-align: right"><b><i>Команда журнала "ПЛАС" поздравляет всех с Днём Победы! </i></b></p>
                </div>
            </div>
        </div>
*/?>

        <div style="clear: both;"></div>
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
    CModule::IncludeModule("iblock");
    $newsCounter = CIBlockElement::GetList(Array(), $dateFilter, Array());
    ?>

    <div class="news-block" data-count="<?= $newsCounter ?>">
        <div class="news-list">
            <?$APPLICATION->IncludeFile("/include/news_list.php"); ?>
        </div>
        <div class="else_news show-more">
            <p><img src="/bitrix/templates/plus/images/arr.png"></p>
            Показать еще
        </div>
    </div>
<?
} else {
?>

<?$APPLICATION->IncludeComponent(
	"cetera:news.list",
	"daily",
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
		"NEWS_COUNT"	=>	$arParams["NEWS_COUNT"],
		"SORT_BY1"	=>	$arParams["SORT_BY1"],
		"SORT_ORDER1"	=>	$arParams["SORT_ORDER1"],
		"SORT_BY2"	=>	$arParams["SORT_BY2"],
		"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
		"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
		"DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"IBLOCK_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"DISPLAY_DATE"	=>	$arParams["DISPLAY_DATE"],
		"DISPLAY_NAME"	=>	"Y",
		"DISPLAY_PICTURE"	=>	$arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT"	=>	$arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES"	=>	$arParams["CHECK_DATES"],
	),
	$component
);?>
<? }?>