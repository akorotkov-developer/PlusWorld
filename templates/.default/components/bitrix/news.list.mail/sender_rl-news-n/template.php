<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
// Метки для ссылок
$labelUrlDate = date('m').date('y');
$labelUrl = "?utm_source=mailing&utm_medium=".$labelUrlDate."&utm_campaign=RLnews";
$labelUrlA = "&utm_source=mailing&utm_medium=".$labelUrlDate."&utm_campaign=RLnews";
$labelUrlCashForum = "?utm_source=CASH&utm_medium=newsletter&utm_campaign=RL";

?>
<?if (CModule::IncludeModule("advertising")){
    if(!empty($banners)) {
        shuffle($banners);

        if(count($banners) > 5) {
            $banners = array_slice($banners, 0, 5);
        }
    }
    $banners_1 = Array();
    $arFilter = Array(
        "TYPE_SID"=> "SUBSCRIBE_RL_1",
        "ID_EXACT_MATCH"=>"Y" ,
        "ACTIVE"=> "Y",
        "LAMP"=> "green"
    );
    $rsBanners = CAdvBanner::GetList($by, $order, $arFilter, $is_filtered, "N");
    while($arBanner = $rsBanners->NavNext(true, "f_"))
    {
        $banners_1[] = $arBanner["ID"];
    }
    if(!empty($banners_1)) {
        shuffle($banners_1);
        if(count($banners_1) > 5) {
            $banners_1 = array_slice($banners_1, 0, 5);
        }
    }

    $banners_2 = Array();
    $arFilter = Array(
        "TYPE_SID"=> "SUBSCRIBE_RL_2",
        "ID_EXACT_MATCH"=>"Y" ,
        "ACTIVE"=> "Y",
        "LAMP"=> "green"
    );
    $rsBanners = CAdvBanner::GetList($by, $order, $arFilter, $is_filtered, "N");
    while($arBanner = $rsBanners->NavNext(true, "f_"))
    {
        $banners_2[] = $arBanner["ID"];
    }
    if(!empty($banners_2)) {
        shuffle($banners_2);
        if(count($banners_2) > 5) {
            $banners_2 = array_slice($banners_2, 0, 5);
        }
    }
}
?>
<?
function get_month($date){
    switch ($date) {
        case 2:
            $month = 'февраля';
            break;
        case 3:
            $month = 'марта';
            break;
        case 4:
            $month = 'апреля';
            break;
        case 5:
            $month = 'мая';
            break;
        case 6:
            $month = 'июня';
            break;
        case 7:
            $month = 'июля';
            break;
        case 8:
            $month = 'августа';
            break;
        case 9:
            $month = 'сентября';
            break;
        case 10:
            $month = 'октября';
            break;
        case 11:
            $month = 'ноября';
            break;
        case 12:
            $month = 'декабря';
            break;
        default:
            $month = 'января';
    }
    return($month);
}
?>
<div style="background-color: #e4ecee; padding: 15px 0 0 0;">
<table width="700" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif !important; text-align:left; border-collapse:collapse; margin: 0 auto; border-top: 5px solid #b81b50; width: 700px; background-color: #fff; white-space: normal;">
    <tr>
        <td>
            <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                <tr>
                    <td>
                        <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top: 5px; width: 620px;">
                            <tr>
                                <td width="125px;" style="width: 125px; font-family: Arial, Helvetica, sans-serif !important;">
                                    <a href="http://www.retail-loyalty.org/news/<?=$labelUrl?>" style="text-decoration: none; border: none">
                                        <img style="border: none;" width="125" height="auto" src="http://www.retail-loyalty.org/images/sub-daily/logo_new.png" alt="R&L" title="R&L">
                                    </a>
                                </td>
                                <td style="vertical-align: bottom; font-family: Arial, Helvetica, sans-serif !important;">
                                    <div style="text-align: center; font-size: 14px;"><span style="font: 14px Arial, sans-serif;"><b>Главные новости отрасли</b></span></div>
                                </td>
                                <td width="250px;" style="vertical-align: bottom; width: 250px; font-family: Arial, Helvetica, sans-serif !important;">
                                    <div style="margin-bottom: 15px; text-align: right;">
                                            <span style="color: #b81b50;  font: 14px Arial, sans-serif; font-weight: bold;">
                                                <?=date('j').' '.get_month(date('m')).' '.date('Y')?>
                                            </span>
                                    </div>
                                    <div>
                                        <span style="font: 12px Arial, sans-serif;"><b>Выпускающие редакторы:</b></span><br />
                                        <span style="font: 12px Arial, sans-serif;">Т.Аминова,</span><br />
                                        <span style="font: 12px Arial, sans-serif;">С. Зайцев, Т. Манаенко, К. Мартынова</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top:20px; font-family: Arial, Helvetica, sans-serif !important;">
                        <?$GLOBALS['RL_NEWS_MAIN_Filter'] = array("!PROPERTY_SUBSCRIBE" => false, "!PROPERTY_SUBSCRIBE_MAIN" => false/*, ">=DATE_ACTIVE_FROM" => date('d.m.Y')*/);?>
                        <?
                        $APPLICATION->IncludeComponent("cetera:subscribe.daily", "RL_news_main",
                            Array(
                                "SITE_ID" => "ip",
                                "IBLOCK_TYPE" => "NEWS_IP",
                                "ID" => "23",
                                "SECTION_ID" => "",
                                "FILTER_NAME" => "RL_NEWS_MAIN_Filter",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "SORT_BY" => "ACTIVE_FROM",
                                "CACHE_TYPE" => "N",
                                "SORT_ORDER" => "DESC",
                                "NEWS_COUNT" => "1",
                                "FILTER_DATE" => "N"
                            ), false
                        );?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">
                        <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                            <tr>
                                <td style="text-align: center;">
                                    <?if(!empty($banners_1)) {
                                        $rsBanner = CAdvBanner::GetByID($banners_1[0], "N");
                                        $arBanner = $rsBanner->Fetch();
                                        echo(str_replace('site_id=ru','site_id=s1',str_replace('src="/','src="http://www.retail-loyalty.org/',str_replace('href="/','href="http://www.retail-loyalty.org/',CAdvBanner::GetHTML($arBanner)))));
                                        unset($banners_1[0]);
                                        sort($banners_1);
                                    }?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">
                        <table width="619" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 619px; font-family: Arial, sans-serif;">
                            <tr>
                                <td style="width: 193px; padding-right: 10px; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <?$GLOBALS['RL_NEWS_BLOCK1_Filter'] = array("!PROPERTY_SUBSCRIBE" => false, "PROPERTY_SUBSCRIBE_MAIN" => false, "PROPERTY_SUBSCRIBE_3NEWS_VALUE" => "Новость 1", );?>
                                    <?$APPLICATION->IncludeComponent("cetera:subscribe.daily", "RL_news_3news",
                                        Array(
                                            "SITE_ID" => "ip",
                                            "IBLOCK_TYPE" => "NEWS_IP",
                                            "ID" => "23",
                                            "SECTION_ID" => "",
                                            "FILTER_NAME" => "RL_NEWS_BLOCK1_Filter",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "SORT_BY" => "ACTIVE_FROM",
                                            "CACHE_TYPE" => "N",
                                            "SORT_ORDER" => "DESC",
                                            "NEWS_COUNT" => "1",
                                            "FILTER_DATE" => "N"
                                        ), false
                                    );?>
                                </td>
                                <td style="width: 193px; padding: 0 10px; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <?$GLOBALS['RL_NEWS_BLOCK2_Filter'] = array("!PROPERTY_SUBSCRIBE" => false, "PROPERTY_SUBSCRIBE_MAIN" => false, "PROPERTY_SUBSCRIBE_3NEWS_VALUE" => "Новость 2");?>
                                    <?$APPLICATION->IncludeComponent("cetera:subscribe.daily", "RL_news_3news",
                                        Array(
                                            "SITE_ID" => "ip",
                                            "IBLOCK_TYPE" => "NEWS_IP",
                                            "ID" => "23",
                                            "SECTION_ID" => "",
                                            "FILTER_NAME" => "RL_NEWS_BLOCK2_Filter",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "SORT_BY" => "ACTIVE_FROM",
                                            "CACHE_TYPE" => "N",
                                            "SORT_ORDER" => "DESC",
                                            "NEWS_COUNT" => "1",
                                            "FILTER_DATE" => "N"
                                        ), false
                                    );?>
                                </td>
                                <td style="width: 193px; padding-left: 10px; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <?$GLOBALS['RL_NEWS_BLOCK3_Filter'] = array("!PROPERTY_SUBSCRIBE" => false, "PROPERTY_SUBSCRIBE_MAIN" => false, "PROPERTY_SUBSCRIBE_3NEWS_VALUE" => "Новость 3");?>
                                    <?$APPLICATION->IncludeComponent("cetera:subscribe.daily", "RL_news_3news",
                                        Array(
                                            "SITE_ID" => "ip",
                                            "IBLOCK_TYPE" => "NEWS_IP",
                                            "ID" => "23",
                                            "SECTION_ID" => "",
                                            "FILTER_NAME" => "RL_NEWS_BLOCK3_Filter",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "SORT_BY" => "ACTIVE_FROM",
                                            "CACHE_TYPE" => "N",
                                            "SORT_ORDER" => "DESC",
                                            "NEWS_COUNT" => "1",
                                            "FILTER_DATE" => "N"
                                        ), false
                                    );?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">
                        <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        <?if(!empty($banners_2)) {
                                            $rsBanner = CAdvBanner::GetByID($banners_2[0], "N");
                                            $arBanner = $rsBanner->Fetch();
                                            echo(str_replace('site_id=ru','site_id=s1',str_replace('src="/','src="http://www.retail-loyalty.org/',str_replace('href="/','href="http://www.retail-loyalty.org/',CAdvBanner::GetHTML($arBanner)))));
                                            unset($banners_2[0]);
                                            sort($banners_2);
                                        }?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px; font-family: Arial, Helvetica, sans-serif !important;">
                        <?$GLOBALS['RL_NEWS_LIST_Filter'] = array("!PROPERTY_SUBSCRIBE" => false, "PROPERTY_SUBSCRIBE_MAIN" => false, "PROPERTY_SUBSCRIBE_3NEWS" => false, ">=DATE_ACTIVE_FROM" => date('d.m.Y'));?>
                        <?$APPLICATION->IncludeComponent("cetera:subscribe.daily", "RL_news_list",
                            Array(
                                "SITE_ID" => "ip",
                                "IBLOCK_TYPE" => "NEWS_IP",
                                "ID" => "23",
                                "SECTION_ID" => "",
                                "FILTER_NAME" => "RL_NEWS_LIST_Filter",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "SORT_BY" => "ACTIVE_FROM",
                                "CACHE_TYPE" => "N",
                                "SORT_ORDER" => "DESC",
                                //"BANNERS" => $banners,
                                "FILTER_DATE" => "N"
                            ), false
                        );?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">
                        <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                            <tr>
                                <td style="width: 295px; vertical-align: top;">
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" style="width: 295px;">
                                        <tr>
                                            <td style="border: 2px solid #b81b50; border-bottom: none; width: 295px; padding: 10px; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif !important;">
                                                <div style="font: 16px Arial, sans-serif; padding-bottom: 20px;"><b>Календарь событий</b></div>
                                                <?$APPLICATION->IncludeComponent(
                                                    "cetera:subscribe.news",
                                                    "calendar_new",
                                                    Array(
                                                        "SITE_ID" => "ip",
                                                        "IBLOCK_TYPE" => "NEWS_IP",
                                                        "ID" => "58",
                                                        "SORT_BY" => "ACTIVE_FROM",
                                                        "SORT_ORDER" => "ASC"
                                                    )
                                                );?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 295px;">
                                                <?/*<a href="http://www.retail-loyalty.org/calendar_retail_loyalty/events/<?=$labelUrl?>"><img style="border: none; width: 295px; height: 50px;" src="http://www.retail-loyalty.org/images/sub-daily/events_button.png"></a>*/?>
                                                <a href="http://www.retail-loyalty.org/calendar_retail_loyalty/events/<?=$labelUrl?>"><img style="border: none; width: 295px; height: 50px;" src="http://www.retail-loyalty.org/images/sub-daily/events_button.png"></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 295px; padding-left: 30px; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <?if(CModule::IncludeModule("iblock")) {
                                        $obJournals = CIBlockElement::GetList(array('ID'=>'desc'), array(
                                            "IBLOCK_ID" => 40,
                                        ), false, false, array("ID", "NAME", "IBLOCK_ID", "PREVIEW_PICTURE"));
                                        if ($arJournal = $obJournals->Fetch()) {
                                            $LAST_JOURNAL_ID = $arJournal["ID"];
                                            $arFile = CFile::GetFileArray($arJournal["PREVIEW_PICTURE"]);
                                        }

                                        $res = CIBlockElement::GetByID($LAST_JOURNAL_ID);
                                        $ar_res = $res->GetNext();

                                        $mainArticle = CIBlockElement::GetList(array('ID'=>'desc'), array(
                                            "IBLOCK_ID" => 41,
                                            "PROPERTY_JOURNAL" => $ar_res["ID"],
                                            "!PROPERTY_MAIN" => false
                                        ), false, false, array("ID", "NAME", "IBLOCK_ID"));
                                        $mainArticleRes = $mainArticle->Fetch();
                                    }?>
                                    <div style="margin-bottom: 15px; text-align: center;">
                                        <?/*<a style="color: #A51340; text-decoration: none;" href="<?echo $ar_res["DETAIL_PAGE_URL"]?><?=$labelUrl?>">*/?>
                                        <a style="color: #A51340; text-decoration: none;" href=" https://www.retail-loyalty.org/lr/big-data-taxcom/">
                                            <img width="auto" height="232" src="http://www.retail-loyalty.org<?=$arFile["SRC"]?>" alt="<?=$ar_res['NAME']?>" title="<?=$ar_res['NAME']?>" style="border: none; width: auto; height: 232px;">
                                        </a>
                                    </div>
                                    <div style="font-size: 14px; margin-bottom: 10px; font-family: Arial, Helvetica, sans-serif !important;">
                                        <a style="color: #000; text-decoration: none; border: none; font: 14px Arial, sans-serif;" href="<?echo $ar_res["DETAIL_PAGE_URL"]?><?=$labelUrl?>"><b>Журнал <?echo $ar_res['NAME']?></b></a>
                                    </div>
                                    <div style="font: 14px Arial, sans-serif;"><?echo $mainArticleRes['NAME']?></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 16px; text-transform: uppercase; padding-top: 10px; font-family: Arial, Helvetica, sans-serif !important;">
                        <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                            <tr>
                                <td>
                                    <span style="font: 16px Arial, sans-serif;"><b>Плас-форумы</b></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">
                        <table width="618" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 618px;">
                            <tr>
                                <td style="width: 306px; text-align: center; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <a style="color: #000; font-size: 14px; text-decoration: none; border: none;" href="http://www.plus-forum.com/forum_2019/apr/<?=$labelUrl?>">
                                        <img style="border: none; height: 80px; width: auto;" src="http://www.retail-loyalty.org/images/sub-daily/apr.jpg">
                                        <br />
                                        <span style="text-decoration: none; font: 14px Arial, sans-serif;">&laquo;Online & Offline Retail 2019&raquo;</span>
                                    </a>
                                </td>
                                <td style="width: 306px; text-align: center; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <a style="color: #000; font-size: 14px; text-decoration: none; border: none;" href="http://www.plus-forum.com/forum_2019/may/<?=$labelUrl?>">
                                        <img style="border: none; height: 80px; width: auto;" src="http://www.retail-loyalty.org/images/sub-daily/may.jpg">
                                        <br />
                                        <span style="text-decoration: none; font: 14px Arial, sans-serif;">&laquo;Дистанционные сервисы, мобильные решения, карты и платежи 2019&raquo;</span>
                                    </a>
                                </td>
                                <td style="width: 306px; text-align: center; vertical-align: top; font-family: Arial, Helvetica, sans-serif !important;">
                                    <a style="color: #000; font-size: 14px; text-decoration: none; border: none;" href="http://www.plus-forum.com/forum_2019/oct-cash/<?=$labelUrlCashForum?>">
                                        <img style="border: none; height: 80px; width: auto;" src="http://www.retail-loyalty.org/images/sub-daily/oct-cash.jpg">
                                        <br />
                                        <span style="text-decoration: none; font: 14px Arial, sans-serif;">&laquo;Банковское самообслуживание, ритейл и НДО 2019&raquo;</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 20px;">
            <table width="700" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 700px; background-color: #b81b50; color: #fff;">
                <tr>
                    <td style="padding-top: 20px;">
                        <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                            <tr>
                                <td>
                                    <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                                        <tr>
                                            <td style="font-family: Arial, Helvetica, sans-serif !important;">
                                                <div style="color: #fff; font: 16px Arial, sans-serif;"><b>Подписывайтесь на наши каналы &mdash; следите за рынком!</b></div>
                                            </td>
                                            <td style="vertical-align: top;">
                                                <table align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                                    <tr>
                                                        <td style="text-align: right; padding-left: 15px;">
                                                            <a target="_blank" href="https://web.telegram.org/#/im?p=@retailloyaltyorg">
                                                                <img style="border: none" src="http://www.retail-loyalty.org/images/sub-daily/icon_tele_white.png">
                                                            </a>
                                                        </td>
                                                        <td style="text-align: right; padding-left: 15px;">
                                                            <a target="_blank" href="https://twitter.com/Retail_Loyalty_">
                                                                <img style="border: none" src="http://www.retail-loyalty.org/images/sub-daily/icon_tw_white.png">
                                                            </a>
                                                        </td>
                                                        <td style="text-align: right; padding-left: 15px;">
                                                            <a target="_blank" href="http://www.facebook.com/pages/Retail-Loyalty/291446587589171?ref=hl">
                                                                <img style="border: none" src="http://www.retail-loyalty.org/images/sub-daily/icon_fb_white.png">
                                                            </a>
                                                        </td>
                                                        <td style="text-align: right; padding-left: 15px;">
                                                            <a target="_blank" href="http://www.retail-loyalty.org/news/rss/">
                                                                <img style="border: none" src="http://www.retail-loyalty.org/images/sub-daily/icon_rss_white.png">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;">
                                    <table width="620" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width: 620px;">
                                        <tr>
                                            <td style="width: 154px; font-family: Arial, Helvetica, sans-serif !important;">
                                                <span style="color: #fff; font: 12px Arial, sans-serif;"><b>Редакция</b></span><br />
                                                <a style="text-decoration: none; border: none; font-size: 12px; color: #fff;" href="mailto:news@plusworld.ru"><span style="text-decoration: none; font: 12px Arial, sans-serif;">news@plusworld.ru</span></a>
                                            </td>
                                            <td style="width: 154px; font-family: Arial, Helvetica, sans-serif !important;">
                                                <span style="color: #fff; font: 12px Arial, sans-serif;"><b>Отдел рекламы</b></span><br />
                                                <a style="text-decoration: none; border: none; font-size: 12px; color: #fff;" href="mailto:marketing@plusworld.ru"><span style="text-decoration: none; font: 12px Arial, sans-serif;">marketing@plusworld.ru</span></a>
                                            </td>
                                            <td style="width: 154px; font-family: Arial, Helvetica, sans-serif !important;">
                                                <span style="color: #fff; font: 12px Arial, sans-serif;"><b>Отдел подписки</b></span><br />
                                                <a style="text-decoration: none; border: none; font-size: 12px; color: #fff;" href="mailto:podpiska@plusworld.ru"><span style="text-decoration: none; font: 12px Arial, sans-serif;">podpiska@plusworld.ru</span></a>
                                            </td>
                                            <td style="width: 154px; font-family: Arial, Helvetica, sans-serif !important;">
                                                <span style="color: #fff; font: 12px Arial, sans-serif;"><b>Телефон</b></span><br />
                                                <a style="text-decoration: none; border: none; font-size: 12px; color: #fff;" href="tel:+74959611065"><span style="text-decoration: none; font: 12px Arial, sans-serif;">+7&nbsp;495&nbsp;961-10-65</span></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>