<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//TODO не забыть перенести стили?>
<style>
    .full_access {
        height: 1000px;
        overflow: hidden;
    }
</style>
<?
function pluralForm($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}
?>

<?
$res = CIBlockElement::GetByID($arResult['ID']);
if($ar_res = $res->GetNext())
  $counter = $ar_res['SHOW_COUNTER'];
if($counter < 1)
	$counter = 0;
$counter = intval($counter);
$text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
if($_SERVER["REAL_FILE_PATH"] == "/en/journal/read_online/journal_text.php")
	$text_counter = "views";
//if(isset($_REQUEST['ff'])) print_r($_SERVER);
?>
<?
$full_access = "full_access";
if ($arResult["FULL_ACCESS_FOR_USER"]) $full_access = "";
?>
<div class="cell auto">
    <div class="grid-x page-head">
        <div class="cell small-21 small-order-1 medium-order-1 medium-13 large-order-1 large-9">
            <a class="button button_low hollow" href="<?=$arResult["JOURNAL_URL"]?>"><?=$arResult["JOURNAL_NAME"] ?></a>
        </div>
        <div class="cell small-24 small-order-3 medium-order-2 medium-11 large-order-2 large-8 page-head__time">
            <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]){ ?>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 -3 15 23" width="17" height="17">
                    <style type="text/css">
                        .st0{fill:#B71752;}
                    </style>
                    <path class="st0" d="M8.5,17C3.8,17,0,13.2,0,8.5C0,3.8,3.8,0,8.5,0C13.2,0,17,3.8,17,8.5C17,13.2,13.2,17,8.5,17z M8.5,1
                        C4.4,1,1,4.4,1,8.5C1,12.6,4.4,16,8.5,16c4.1,0,7.5-3.4,7.5-7.5C16,4.4,12.6,1,8.5,1z"/>
                    <path class="st0" d="M13.5,10.3C13.5,10.3,13.4,10.2,13.5,10.3l-5.8-1C7.4,9.2,7,9,7,8.8V2.3C7,2,7.2,1.8,7.5,1.8C7.8,1.8,8,2,8,2.3
                        v6.1l5.3,0.9c0.3,0,0.6,0.3,0.5,0.6C13.8,10.1,13.7,10.3,13.5,10.3z"/>
                </svg>
            <?}?>
            <span><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
        </div>
        <div class="cell small-24 small-order-4 medium-11 medium-order-4 large-order-3 large-6 page-head__view">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20 13" width="20" height="13">
                <style type="text/css">
                    .st0{fill:#9B1D51;}
                </style>
                <path class="st0" d="M10,1c4,0,7.5,4,8.7,5.5C17.5,8,14,12,10,12c-4,0-7.5-4-8.7-5.5C2.5,5,6,1,10,1 M10,0C4.5,0,0,6.5,0,6.5
	                S4.5,13,10,13c5.5,0,10-6.5,10-6.5S15.5,0,10,0z"/>
                <path class="st0" d="M10,9.3C8.5,9.3,7.2,8,7.2,6.5C7.2,5,8.5,3.7,10,3.7c1.5,0,2.8,1.2,2.8,2.8C12.8,8,11.5,9.3,10,9.3z M10,4.7
	                c-1,0-1.8,0.8-1.8,1.8c0,1,0.8,1.8,1.8,1.8c1,0,1.8-0.8,1.8-1.8C11.8,5.5,11,4.7,10,4.7z"/>
            </svg>
            <span><?=$counter?>&nbsp;<?=$text_counter?></span>
        </div>
    </div>
    <h1 class="page-title"><?=$arResult["NAME"]?>
        <a class="page-title__settings" href="">
            <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 85 85" style="enable-background:new 0 0 85 85;" xml:space="preserve">
                <g>
                    <g>
                        <path d="M42.5,46c-4.7,0-8.4,3.8-8.4,8.4c0,2.3,1,4.5,2.6,6.1v7.6c0,3.2,2.6,5.8,5.8,5.8c3.2,0,5.8-2.6,5.8-5.8v-7.6
                            c1.7-1.6,2.6-3.8,2.6-6.1C51,49.7,47.2,46,42.5,46z M45.5,57.6c-0.8,0.8-1.3,1.8-1.3,2.9v7.7c0,0.9-0.8,1.7-1.7,1.7
                            s-1.7-0.8-1.7-1.7v-7.7c0-1.1-0.5-2.2-1.3-2.9c-0.9-0.8-1.4-2-1.4-3.2c0-2.4,2-4.4,4.4-4.4c2.4,0,4.4,2,4.4,4.4
                            C46.9,55.6,46.4,56.7,45.5,57.6z"/>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M67.3,34.9h-6.1V18.6C61.1,8.4,52.8,0,42.5,0S23.9,8.4,23.9,18.6v16.2h-6.1c-3.4,0-6.1,2.8-6.1,6.1v37.9
			        c0,3.4,2.8,6.1,6.1,6.1h49.5c3.4,0,6.1-2.8,6.1-6.1V41C73.4,37.6,70.6,34.9,67.3,34.9z M28,18.6c0-8,6.5-14.5,14.5-14.5
			        c8,0,14.5,6.5,14.5,14.5v16.2H28V18.6z M69.3,78.9L69.3,78.9c0,1.1-0.9,2-2,2H17.8c-1.1,0-2-0.9-2-2V41c0-1.1,0.9-2,2-2h49.5
			        c1.1,0,2,0.9,2,2V78.9z"/>
                    </g>
                </g>
            </svg>
        </a>
    </h1>

    <div class="page-interview <?=$full_access?>" id="MessForPrint">
        <?echo $arResult["DETAIL_TEXT"];?>
    </div>

    <div class="hide-for-print">
        <?if (!$arResult["FULL_ACCESS_FOR_USER"]) {?>
            <div class="grid-x page-subscribe">
                <div class="cell small-24">
                    <div class="page-subscribe__title">Продолжение материала содержит</div>
                    <div class="page-subscribe__title">полезную для вашего бизнеса информацию…</div>
                    <div class="page-subscribe__subtitle">Подписка позволяет читать все статьи портала</div>
                </div>
                <div class="cell small-24">
                    <div class="grid-x grid-padding-x large-up-3" data-equalizer>
                        <div class="cell margin-bottom-6"><a href="/journal_retail_loyalty/podpiska/">
                                <div class="subscribe-type" data-equalizer-watch><img class="subscribe-type__img" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/subscribe-1.svg" alt="">
                                    <div class="subscribe-type__title">Корпоративная подписка</div>
                                </div></a></div>
                        <div class="cell margin-bottom-6"><a href="http://market.plusworld.ru/">
                                <div class="subscribe-type" data-equalizer-watch><img class="subscribe-type__img" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/subscribe-2.svg" alt="">
                                    <div class="subscribe-type__title">Подписка для физических лиц</div>
                                </div></a></div>
                        <div class="cell margin-bottom-6">
                            <div class="subscribe-type subscribe-type_hollow" data-equalizer-watch>
                                <div class="subscribe-type__title">Мобильное приложение</div>
                                <div class="grid-x subscribe-type__buttons">
                                    <div class="cell small-11 large-12">
                                        <a href="https://itunes.apple.com/us/app/%D0%B6%D1%83%D1%80%D0%BD%D0%B0%D0%BB-retail-loyalty/id1321396794?l=ru&ls=1&mt=8">
                                            <img class="subscribe-type__apple" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/apple-subscribe-button.svg" alt=""></a></div>
                                    <div class="cell small-offset-2 small-11 large-offset-0 large-12">
                                        <a href="https://play.google.com/store/apps/details?id=ru.plusalliance.retail">
                                            <img class="subscribe-type__google" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/google-subscribe-button.svg" alt=""></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell small-24">
                    <div class="page-subscribe__bottom">Если у вас уже есть подписка нажмите<a href="/personal/profile/" class="page-subscribe__login" href="">Войти</a></div>
                </div>
            </div>
        <?}?>

        <div class="page-share">
            <span class="page-share__title">Понравился материал? Поделись</span>
            <script type="text/javascript">(function(w,doc) {
                    if (!w.__utlWdgt ) {
                        w.__utlWdgt = true;
                        var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                        s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
                        var h=d[g]('body')[0];
                        h.appendChild(s);
                    }})(window,document);
            </script>
            <div data-mobile-view="false" data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1697408" data-mode="share" data-background-color="#ffffff" data-share-shape="round" data-share-counter-size="12" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.ok.wh.vb.tm." data-text-color="#000000" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-type="disable" data-orientation="horizontal" data-following-enable="false" data-sn-ids="fb.tw.tm." data-preview-mobile="false" data-selection-enable="true" data-exclude-show-more="true" data-share-style="1" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" ></div>
        </div>

        <?$page = $APPLICATION->GetCurPage();?>
        <?$APPLICATION->IncludeComponent("bitrix:form.result.new", "fast_subscribe_detailnews", Array(
            "SEF_MODE" => "N",	// Включить поддержку ЧПУ
            "WEB_FORM_ID" => "112",	// ID веб-формы
            "LIST_URL" => $page,	// Страница со списком результатов
            "EDIT_URL" => "result_edit.php",	// Страница редактирования результата
            "SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
            "CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
            "CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
            "IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
            "USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "COMPONENT_TEMPLATE" => ".default",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
            false
        );?>

        <div class="blank blank_subscribe">
            <div class="blank__back"></div>
            <div class="blank__container">
                <div class="blank__triangle"></div>
            </div>
            <div class="grid-x align-middle">
                <div class="cell small-4"><img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/i/subscribe-channel.png" alt=""></div>
                <div class="cell small-20">
                    <div class="blank__title">Подписывайтесь на канал&nbsp;<span class="text-primary">RETAIL-LOYALTY.ORG &nbsp;</span>на Яндекс.Дзен&nbsp;</div>
                </div>
            </div>
        </div>

        <?
        // включаемая область для раздела
        $APPLICATION->IncludeFile("/local/include/fb-comments.php", Array(), Array());
        ?>

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

    </div>
</div>
