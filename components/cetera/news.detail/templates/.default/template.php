<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>
<?if ($arResult["PROPERTIES"]["REDIRECT"]["VALUE"] !="") {?>
    <?
    header('Location: '.$arResult["PROPERTIES"]["REDIRECT"]["VALUE"],true, 302); ?>
<?}?>

<?
$ID = $arResult["ID"];
$id_sessid = bitrix_sessid();
add_material_RL_RU($ID,$id_sessid);
?>



<div class="news-detail">

    <?$res = CIBlockElement::GetByID($arResult["ID"]);
    if($ar_res = $res->GetNext())
        $counter = $ar_res['SHOW_COUNTER'];
    /*if($counter < 1)
        $counter = 0;*/
    $counter = intval($counter);
    ?>

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

    $text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
    ?>
    <div class="grid-x page-head">
        <?$rubric = getRubric($arResult["IBLOCK_SECTION_ID"]);?>
        <?
        $curPage = $APPLICATION->GetCurPage();
        $curPage = explode('/', $curPage);
        if ($curPage[1] == "expert-forum") {
            ?>
            <div style="padding-right: 8px">
                <a class="button button_low hollow" href="/expert-forum/" style="margin-top:0px">Форум экспертов</a>
            </div>
            <?
        } else {
        ?>
            <div style="padding-right: 8px">
                <a class="button button_low hollow" style="margin-top:0px" href="<?=$rubric["URL"]?>"><?=$rubric["TITLE"]?></a>
            </div>
        <?}?>
        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
            <?$frame = $this->createFrame()->begin("");//Начало динамической области?>
            <div class="page-head__time" style="padding-bottom:4px">
                <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 -3 15 23" style="enable-background:new 0 0 17 17;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:#B71752;}
                        </style>
                    <path class="st0" d="M8.5,17C3.8,17,0,13.2,0,8.5C0,3.8,3.8,0,8.5,0C13.2,0,17,3.8,17,8.5C17,13.2,13.2,17,8.5,17z M8.5,1
                            C4.4,1,1,4.4,1,8.5C1,12.6,4.4,16,8.5,16c4.1,0,7.5-3.4,7.5-7.5C16,4.4,12.6,1,8.5,1z"/>
                    <path class="st0" d="M13.5,10.3C13.5,10.3,13.4,10.2,13.5,10.3l-5.8-1C7.4,9.2,7,9,7,8.8V2.3C7,2,7.2,1.8,7.5,1.8C7.8,1.8,8,2,8,2.3
                            v6.1l5.3,0.9c0.3,0,0.6,0.3,0.5,0.6C13.8,10.1,13.7,10.3,13.5,10.3z"/>
                    </svg>
                <span>
                        <?
                        if (!function_exists("rsdate")) {
                            function rsdate($param, $time = 0)
                            {
                                if (intval($time) == 0) $time = time();
                                $MonthNames = array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
                                if (strpos($param, 'M') === false) return date($param, $time);
                                else return date(str_replace('M', $MonthNames[date('n', $time) - 1], $param), $time);
                            }
                        }
                        ?>
                        <?echo rsdate("d M Y, H:i", strtotime($arResult["ACTIVE_FROM"]));?>
                    </span>
            </div>
            <?$frame->end(); // Конец фрейма?>
        <?endif;?>
        <div class="page-head__view" style="padding-bottom:4px">
            <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 20 13" style="enable-background:new 0 0 20 13;" xml:space="preserve">
                <style type="text/css">
                    .st0{fill:#9B1D51;}
                </style>
                <path class="st0" d="M10,1c4,0,7.5,4,8.7,5.5C17.5,8,14,12,10,12c-4,0-7.5-4-8.7-5.5C2.5,5,6,1,10,1 M10,0C4.5,0,0,6.5,0,6.5
                    S4.5,13,10,13c5.5,0,10-6.5,10-6.5S15.5,0,10,0z"/>
                <path class="st0" d="M10,9.3C8.5,9.3,7.2,8,7.2,6.5C7.2,5,8.5,3.7,10,3.7c1.5,0,2.8,1.2,2.8,2.8C12.8,8,11.5,9.3,10,9.3z M10,4.7
                    c-1,0-1.8,0.8-1.8,1.8c0,1,0.8,1.8,1.8,1.8c1,0,1.8-0.8,1.8-1.8C11.8,5.5,11,4.7,10,4.7z"/>
            </svg>
            <span><?=$counter?><span class="nocounter">&nbsp;<?=$text_counter?></span></span>
        </div>
        <div class="cell page-head__print">
            <a href="javascript://" onclick="PrintElem('#div_for_print')">
                <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <div style="width: 100%;position: relative;margin-top:-26px"><svg style="position:absolute;right:0px" width="26px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 13" style="enable-background:new 0 0 20 13;" xml:space="preserve">
                    <style type="text/css">
                        .st0{fill:#B71752;}
                    </style>
                        <g>
                            <g>
                                <path class="st0" d="M6.1,10.1h0.2v2.2c0,0.2,0.1,0.3,0.3,0.3h6.8c0.2,0,0.3-0.1,0.3-0.3v-2.2h0.2c1,0,1.8-0.8,1.8-1.8V4.7
                            c0-1-0.8-1.8-1.8-1.8h-0.2V0.7c0-0.2-0.1-0.3-0.3-0.3H6.6c-0.2,0-0.3,0.1-0.3,0.3V3H6.1c-1,0-1.8,0.8-1.8,1.8v3.6
                            C4.3,9.3,5.1,10.1,6.1,10.1z M13.1,12H6.9v-1.9h6.2V12z M6.9,1h6.2v3.6H6.9V1L6.9,1z M4.9,4.7c0-0.6,0.5-1.2,1.2-1.2h0.2v1H5.7
                            c-0.2,0-0.3,0.1-0.3,0.3c0,0.2,0.1,0.3,0.3,0.3h0.9h6.8h0.8c0.2,0,0.3-0.1,0.3-0.3c0-0.2-0.1-0.3-0.3-0.3h-0.5v-1h0.2
                            c0.6,0,1.2,0.5,1.2,1.2v3.6c0,0.6-0.5,1.2-1.2,1.2h-0.5H6.6H6.1C5.4,9.5,4.9,9,4.9,8.3V4.7L4.9,4.7z"/>
                                <path class="st0" d="M6.6,8.3C6.8,8.3,7,8.2,7,7.9c0-0.2-0.2-0.4-0.4-0.4c-0.2,0-0.4,0.2-0.4,0.4C6.2,8.2,6.4,8.3,6.6,8.3z"/>
                                <path class="st0" d="M12.4,3.6H7.6c-0.2,0-0.3,0.1-0.3,0.3c0,0.2,0.1,0.3,0.3,0.3h4.8c0.2,0,0.3-0.1,0.3-0.3
                            C12.7,3.7,12.6,3.6,12.4,3.6z"/>
                                <path class="st0" d="M12.4,2.5H7.6c-0.2,0-0.3,0.1-0.3,0.3c0,0.2,0.1,0.3,0.3,0.3h4.8c0.2,0,0.3-0.1,0.3-0.3
                            C12.7,2.6,12.6,2.5,12.4,2.5z"/>
                            </g>
                        </g>
                </svg></div>
            </a>
        </div>
    </div>

    <div id="page-news" class="page-news">
        <div id="MessForPrint">
            <h1 class="page-news__title"><?=$arResult["NAME"]?></h1>



            <div class="news-text">
                <?$APPLICATION->SetPageProperty("goimage_prop", $arResult["PREVIEW_PICTURE"]["SRC"]);?>
                <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
                    <p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
                <?endif;?>
                <?if($arResult["NAV_RESULT"]):?>
                    <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
                    <?echo $arResult["NAV_TEXT"];?>
                    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
                <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
                    <?echo replaceRL($arResult["DETAIL_TEXT"]);?>
                <?else:?>
                    <?echo replaceRL($arResult["PREVIEW_TEXT"]);?>
                <?endif?>

                <?
                // включаемая область для раздела
                $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/banner_580_90.php", Array(), Array());
                ?>

                <?if ($arResult["PROPERTIES"]["LINK_SOURCE"]["VALUE"]) {?>
                    <p class="page-news__source">Источник: <?=$arResult["PROPERTIES"]["LINK_SOURCE"]["VALUE"]?></p>
                <?}?>

                <div class="page-tags">
                    <div class="page-tags__title">Теги:</div>
                    <?foreach ($arResult["TAGS"] as $tag) {?>
                        <a class="button button_tag" href="/news/?tags=<?=trim($tag)?>"><?=trim($tag)?></a>
                    <?}?>
                </div>

                <div class="hide-for-print">

                    <div class="page-share">
                        <span class="page-share__title">Понравился материал? Поделись.</span>
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

                    <?/*?>
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
                    <?*/?>

                </div>
            </div>
            <div class="zen-subscribe">
                <?$APPLICATION->ShowBanner("YANDEX_ZEN_ARTICLE", "<div>", "</div>");?>
            </div>
            <div class="hide-for-print">
                <?
                // включаемая область для раздела
                $APPLICATION->IncludeFile("/local/include/fb-comments.php", Array(), Array());
                ?>

                <?/*
                        <div id="comments" class="news-detail-navig daily__news-detail">
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s); js.id = id;
                                    js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=1558470907748780&version=v2.3";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-comments" data-href="<?echo $result;?>"  data-width="598" data-numposts="5" data-colorscheme="light"></div>
                        </div>
                    */?>

                <?/*if ($arResult["NEXTT"]){?>
                    <div class="news-detail-navig daily__news-detail">
                        <h3>Читайте дальше</h3>
                        <a href="<?=$arResult["NEXTT"]['DETAIL_PAGE_URL'];?>" title="<?=$arResult["NEXTT"]['NAME'];?>"><?=$arResult["NEXTT"]['NAME'];?>&nbsp;&rarr;</a>
                    </div>
                <?}*/?>
            </div>
            <?if ($arResult["COMPANY"]){?>
                <div class="linked_company">
                    <h4>Упоминаемые в материале организации:</h4>
                    <?foreach($arResult["COMPANY"] AS $firm){?>
                        <div class="firm">
                            <?if ($firm["PREVIEW_PICTURE"]){?>
                                <a href="<?=$firm["DETAIL_PAGE_URL"]?>"><img src="<?=$firm["PREVIEW_PICTURE"]["src"]?>" /></a><br />
                            <?}?>
                            <a href="<?=$firm["DETAIL_PAGE_URL"]?>"><?=$firm["NAME"];?></a>
                        </div>
                    <?}?>
                    <div class="clear"></div>
                </div>
            <?}?>
        </div>
    </div>
</div>

<!-- Для верссии для печати      -->

<script type="text/javascript">
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }
    function Popup(data)
    {
        var mywindow = window.open();
        mywindow.document.write('<html><head><title>TITLE новости</title>');
        mywindow.document.write('<style>      @media print { \n' +
            '        @page {\n' +
            '          padding: 0;\n' +
            '          margin: 0; \n' +
            '        }\n' +
            '      }</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();
        return true;
    }
</script>

<div id="div_for_print" style="display: none; position: relative;">
    <style>
        hr {
            height: 1px;
            border-top: 0;
            border-right: 0;
            border-left: 0;
            border-color: #a9aaaa!important;
            position: absolute;
            width: 100%;
            top: 110px;
        }
        .print_content {
            margin-left: 70px;
            margin-right: 70px;
            margin-top: 30px;
            position: relative;
        }
        .button.hollow {
            border: 1px solid #b71852;
            color: #b71852;
        }
        .button_low {
            margin: .35714rem 0;
        }
        .button {
            text-transform: uppercase;
            font-family: "Fira Sans",sans-serif;
        }
        .button {
            display: inlin e-block;
            vertical-align: middle;
            padding: .35714rem .71429rem;
            border: 1px solid transparent;
            border-radius: .14286rem;
            -webkit-transition: background-color 0.25s ease-out,color 0.25s ease-out;
            transition: background-color 0.25s ease-out,color 0.25s ease-out;
            font-family: "Open Sans",sans-serif;
            font-size: 1rem;
            -webkit-appearance: none;
            line-height: 1;
            text-align: center;
            cursor: pointer;
            background-color: #b71852;
            color: #fff;
        }
        .page-news__title {
            font-family: "Fira Sans", sans-serif;
            font-size: 2.64286rem;
            font-style: normal;
            font-weight: 700;
            color: inherit;
            text-rendering: optimizeLegibility;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        .page-news__source {
            text-align: right;
            margin-top: 20px;
        }
    </style>

    <hr>

    <div class="print_content">
        <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/logo_retail.png" style="width: 300px">

        <div style="padding-right: 8px; margin-top: 100px!important; display: flex; justify-content: space-between;">
            <a class="button button_low hollow" style="margin-top:0px" ><?=$rubric["TITLE"]?></a>
            <span style="color: #939393;"><?echo rsdate("d M Y, H:i", strtotime($arResult["ACTIVE_FROM"]));?></span>
        </div>

        <h1 class="page-news__title"><?=$arResult["NAME"]?></h1>

        <?echo replaceRL($arResult["DETAIL_TEXT"]);?>

        <p class="page-news__source">Источник: <?=$arResult["PROPERTIES"]["LINK_SOURCE"]["VALUE"]?></p>
    </div>
</div>

<!-- Конец для версии для печати -->