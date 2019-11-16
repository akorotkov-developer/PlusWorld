<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$APPLICATION->SetTitle($arResult['NAME']);
$APPLICATION->SetPageProperty("title", $arResult['NAME']);
?>

<?
$link = trim(strip_tags(SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL']));
$title = trim(strip_tags(str_replace('&','_ampersant',$arResult['NAME'])));
$preview = trim(strip_tags(str_replace('&','_ampersant',$arResult['PREVIEW_TEXT'])));
?>
<div class="news-detail">
    <div class="clear"></div>
    <div class="firm-rating">
        <?$res = CIBlockElement::GetByID($arResult["ID"]);
        if($ar_res = $res->GetNext())
            $counter = $ar_res['SHOW_COUNTER'];
        if($counter < 1)
            $counter = 0;
        $counter = intval($counter);
        ?>

        <?//if(isset($_REQUEST['cnt'])) var_dump($ar_res);?>
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

        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
            <span class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
            <img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
            <span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>
        <?endif;?>
    </div>
    <div id="MessForPrint">
        <?
        global $USER;
        $arGroups = CUser::GetUserGroup($USER->GetID());
        ?>
        <?if
        (
        /*($_REQUEST["rt"]==1)
        AND*/
        ($arResult["PROPERTIES"]["REDUCED_ARTICLE"]["VALUE"]=='1')
        AND
        (!in_array(1,$arGroups))
        AND
        (!in_array(18,$arGroups))
        AND
        (!in_array(19,$arGroups))
        AND
        (!in_array(10,$arGroups))
        )

        {
        ?>

        <div class="full_access">
            <? } ?>
        <div class="clear"></div>
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
            <p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
        <?endif;?>
        <?if($arResult["NAV_RESULT"]):?>
            <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
            <?echo $arResult["NAV_TEXT"];?>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
        <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
        <?endif?>
            <?if
            (
            /*($_REQUEST["rt"]==1)
            AND*/
            ($arResult["PROPERTIES"]["REDUCED_ARTICLE"]["VALUE"]=='1')
            AND
            (!in_array(1,$arGroups))
            AND
            (!in_array(18,$arGroups))
            AND
            (!in_array(19,$arGroups))
            AND
            (!in_array(10,$arGroups))
            )

            {
            ?>
        </div>

    <?
    $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/include/full_access.php",
            "EDIT_TEMPLATE" => "",
            "CACHE_TYPE" => "Y",
            "CACHE_TIME" => "36000"
        )
    );?>

    <? } ?>
        <div style="clear:both"></div>
    </div>

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
    <div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="10" data-top-button="false" data-share-counter-type="disable" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp." data-share-size="20" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1386458" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>
    <div data-mobile-view="true" data-share-size="20" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1378571" data-mode="share_picture" data-background-color="#ffffff" data-share-shape="round" data-share-counter-size="10" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-text-color="#000000" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-type="disable" data-orientation="vertical" data-following-enable="false" data-sn-ids="fb.vk.tw.ok." data-preview-mobile="false" data-selection-enable="true" data-exclude-show-more="false" data-share-style="1" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" ></div>

    <br />
    <div class="art-links">
        <a href="javascript://" onclick="atoprint('MessForPrint');"><?=GetMessage("DAILY_NEWS_PRINT");?></a> &nbsp;
        <a id="iframe" href="/share.php?link=<?=$link?>&title=<?=$title?>&preview=<?=$preview?>"><?=GetMessage("DAILY_NEWS_SEND");?></a> &nbsp;
        <a href="/daily/add_news/"><?=GetMessage("DAILY_NEWS_ADD");?></a> &nbsp;
        <a href="/journal/subscribe/"><?=GetMessage("DAILY_NEWS_JOURNAL_SUBS");?></a>
    </div>
    <div class="clear"></div>
    <div>
        <div class="vote_label">Как вам статья?</div>
        <?$ElementID = $arParams["ELEMENT_ID"];?>
        <?$APPLICATION->IncludeComponent("askaron:askaron.ibvote.iblock.vote", "ajax", array(
            "IBLOCK_TYPE" => "services",
            "IBLOCK_ID" => "90",
            "ELEMENT_ID" => $ElementID,
            "SESSION_CHECK" => "B",
            "COOKIE_CHECK" => "N",
            "IP_CHECK_TIME" => "86400",
            "USER_ID_CHECK_TIME" => "0",
            "CACHE_TYPE" => "N",
            "CACHE_TIME" => "3600",
            "MAX_VOTE" => "5",
            "VOTE_NAMES" => array(
                0 => "1",
                1 => "2",
                2 => "3",
                3 => "4",
                4 => "5",
                5 => "",
            ),
            "SET_STATUS_404" => "N",
            "DISPLAY_AS_RATING" => "vote_avg"
        ),
            false
        );?>
    </div>
    <div class="clear"></div>
    <div>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <fb:like href="http://www.plusworld.ru<?=$arResult["DETAIL_PAGE_URL"]?>" layout="standard" action="like" show_faces="false" share="false"></fb:like>

        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru"></a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>

</div>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/include/tizer_rl_ru.php",
        "EDIT_TEMPLATE" => "",
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "3600"
    )
);?>
<div class="clear"></div>
<br />

<?if (count($arResult["ListElement"])>0) {?>
    <div class="">
        <h3>Другие материалы по этой теме</h3>
        <div class="news-list-articles">
            <?foreach($arResult["ListElement"] AS $element) {?>

            <div class="news-item">
                <?if (intval($element["PREVIEW_PICTURE"])>0) {?>
                    <div class="preview_picture_link">
                        <a href="<?=$element["DETAIL_PAGE_URL"]?>" target="_blank">
                            <img src="<?=CFile::GetPath($element["PREVIEW_PICTURE"]);?>" alt="<?=$element["NAME"]?>" title="<?=$element["NAME"]?>" class="preview_picture">
                        </a>
                    </div>
                <?}?>
                <a href="<?=$element["DETAIL_PAGE_URL"]?>" target="_blank" class="link"><?=$element["NAME"]?></a>
                <br>
                <?=$element["PREVIEW_TEXT"]?>
                <div class="clear"></div>

            </div>
            <?}?>
        </div>
    </div>
<?}?>