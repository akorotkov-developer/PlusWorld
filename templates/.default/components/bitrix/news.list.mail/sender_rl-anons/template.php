<?ini_set('display_errors', 1);?>
<?//Запретим прямой вызов скрипта
if(!defined( "B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//определяем глобальные переменные и присваиваем им первоначальные значения.
global $SUBSCRIBE_TEMPLATE_RESULT;
$SUBSCRIBE_TEMPLATE_RESULT=true;
global $SUBSCRIBE_TEMPLATE_RUBRIC;
$SUBSCRIBE_TEMPLATE_RUBRIC=$arRubric;
global $APPLICATION;

$rsSites = CSite::GetByID($arRubric["LID"]);
$arSite = $rsSites->Fetch();
$site_url = "http://".$arSite["SERVER_NAME"];
?>
<?if (CModule::IncludeModule("advertising")){
    $sub_sponsor = array();
    $rs = CAdvBanner::GetList($by="ip", $order="asc", array("TYPE_SID" => "HEAD_BANNER", "TYPE_SID_EXACT_MATCH" => "Y", "LAMP"=> "green"), $if_filtered, "N");
    while($ar = $rs->Fetch()) {
        $sub_sponsor[] = $ar;
    }
}
?>
<html>

<head>
    <!--ОБЯЗАТЕЛЬНАЯ СТРОКА --> <!--Content begin-->
    <title>
        <?=$arRubric['NAME']?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>

<body style="color:#000;">

<style type="text/css">
    .top-menu a {color:#fff; text-decoration:none;}
</style>


<table cellpadding="0" cellspacing="0" align="center" style="background-color:#fff;width: 850px;">
    <?$pos = strpos($APPLICATION->GetCurPage(),"include/subscribe");
    if ($pos === false) {?>
        <tr>
            <td>
                <div style="padding:20px 0; text-align: center;">
                    <a style=""
                       href="http://www.retail-loyalty.org/include/subscribe/rl-journal.php"
                       target="_blank">Смотреть в браузере</a>
                </div>
            </td>
        </tr>
    <? } ?>
    <tr><td>
            <table cellpadding="0" cellspacing="0" align="center" width="830px;"  style="font-family:Arial,Helvetica,sans-serif;background: #FFF;width:830px;">
                <tr><td colspan="3">
                        <table cellpadding="0" cellspacing="10" align="center" width="820px;" style="width:820px;">
                            <tr style="height:110px;">
                                <td style="vertical-align: bottom;width: 150px;" rowspan="2">
                                    <div style="font-size:12px; font-weight:bold; color:#56b02d; margin-bottom:3px; font-family:Arial,Helvetica,sans-serif;">
                                        <?if(CModule::IncludeModule("iblock"))
                                        {
                                            $obJournals = CIBlockElement::GetList(array('ID'=>'desc'), array(
                                                "IBLOCK_ID" => 40,
                                            ), false, false, array("ID", "NAME", "IBLOCK_ID"));
                                            if ($arJournal = $obJournals->Fetch())
                                                $LAST_JOURNAL_ID = $arJournal["ID"];

                                            $obArticle = CIBlockElement::GetList(array('SORT'=>'ASC'), array(
                                                "IBLOCK_ID" => 41,
                                                "PROPERTY_JOURNAL" => $LAST_JOURNAL_ID,
                                                "!PROPERTY_MAIN" => false
                                            ), false, false, array("ID", "NAME", "IBLOCK_ID"));
                                            $arArticle = $obArticle->Fetch();

                                            $resArticle = CIBlockElement::GetByID($arArticle["ID"]);
                                            $arArticle = $resArticle->GetNext();


                                            $res = CIBlockElement::GetByID($LAST_JOURNAL_ID);
                                            if($ar_res = $res->GetNext()){
                                                $arFile = CFile::GetFileArray($ar_res["DETAIL_PICTURE"]);
                                                ?>

                                                <a href="<?echo $ar_res["DETAIL_PAGE_URL"]?>"><img width="130" src="http://www.retail-loyalty.org/<?=$arFile["SRC"]?>" alt="<?=$ar_res['NAME']?>" title="<?=$ar_res['NAME']?>" style="border: none;"/></a>


                                            <?					 }
                                        }?>
                                    </div>
                                </td>
                                <td style="width: 150px;" rowspan="2">
                                    <a href="http://www.retail-loyalty.org/" target="_blank"><img src="http://www.retail-loyalty.org/images/sub-daily/logo.png" border="0" alt="ПЛАС" title="ПЛАС"></a>
                                </td>
                                <td style="width:280px;vertical-align: middle;;font-size: 14px; font-family:Arial,Helvetica,sans-serif; padding-left:10px; ">
                                    <strong>Анонс журнала "RETAIL&LOYALTY"</strong><br />
                                    <?if(CModule::IncludeModule("iblock"))
                                    {
                                        $obJournals = CIBlockElement::GetList(array('ID'=>'desc'), array(
                                            "IBLOCK_ID" => 40,
                                        ), false, false, array("ID", "NAME", "IBLOCK_ID"));
                                        if ($arJournal = $obJournals->Fetch())
                                            $LAST_JOURNAL_ID = $arJournal["ID"];

                                        $obArticle = CIBlockElement::GetList(array('SORT'=>'ASC'), array(
                                            "IBLOCK_ID" => 41,
                                            "PROPERTY_JOURNAL" => $LAST_JOURNAL_ID,
                                            "!PROPERTY_MAIN" => false
                                        ), false, false, array("ID", "NAME", "IBLOCK_ID"));
                                        $arArticle = $obArticle->Fetch();

                                        $resArticle = CIBlockElement::GetByID($arArticle["ID"]);
                                        $arArticle = $resArticle->GetNext();


                                        $res = CIBlockElement::GetByID($LAST_JOURNAL_ID);
                                        if($ar_res = $res->GetNext()){

                                            function strtolower_utf8(string $text){
                                                $text = mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
                                                return $text;
                                            }


                                            $arSelect = Array("PROPERTY_ONLINE");
                                            $arFilter = Array("IBLOCK_ID"=>40, "ID" =>$LAST_JOURNAL_ID);
                                            $res22 = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
                                            while($ob = $res22->GetNextElement())
                                            {
                                                $arFields = $ob->GetFields();

                                            }
                                            $url_online=$arFields['PROPERTY_ONLINE_VALUE'];





                                            $str = $ar_res['NAME'];

                                            $str =   mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
                                            $str = str_replace("retail&loyalty", "", $str, $count);
                                            ?>
                                            <strong><?=$str?></strong>
                                        <?					 }
                                    }?>

                                    <table width="80" border="0" cellspacing="0" cellpadding="0" style="width:80px;text-align: center; border-collapse:collapse;">
                                        <tr>
                                            <td align="left" style="padding-top:5px;">
                                                <a style="text-decoration: none" href="https://www.facebook.com/retailloyalty.org?ref=hl"><img style="border: none;" width="19" height="19" src="http://www.retail-loyalty.org/images/subscribe/fb.png" alt="FB" title="FB"></a>
                                            </td>
                                            <td align="left" style="padding-top:5px;">
                                                <a style="text-decoration: none" href="https://twitter.com/Retail_Loyalty_"><img style="border: none;" width="19" height="19" src="http://www.retail-loyalty.org/images/subscribe/tw.png" alt="TW" title="TW"></a>
                                            </td>
                                            <td align="left" style="padding-top:5px;">
                                                <a style="text-decoration: none" href="http://www.retail-loyalty.org/news/rss/"><img style="border: none;" width="19" height="19" src="http://www.retail-loyalty.org/images/subscribe/rss.png" alt="rss" title="rss"></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="150" align="center" style="width:150px;vertical-align: bottom;">
                                    <!--strong><span style="font-size: 14px; text-align: right; display: block; padding-bottom: 30px; font-family:Arial,Helvetica,sans-serif;">Издается <br /> с 1994 года</span></strong-->
                                </td>
                            </tr>
                            <?/*
					<tr><td colspan="2" style="text-align: center;">
                            <? /*<span style="font-size: 14px; text-align: left;  font-family:Arial,Helvetica,sans-serif;font-weight: bold;color: red;">Для подписчиков Журнала "RETAIL&LOYALTY" доступна</span><br />
                            <span style="font-size: 14px; text-align: left;  padding-bottom: 5px; font-family:Arial,Helvetica,sans-serif;font-weight: bold;color: #0000ff;">
                            <a style="color: color: #0000ff;;text-decoration: underline; font-size: 14px; text-align: left;  padding-bottom: 5px; font-family:Arial,Helvetica,sans-serif;font-weight: bold;color: #0000ff;" target="_blank" href=<?=$site_url.$url_online?>>
                                Электронная версия журнала
                            </a>
                            </span> */ ?>
                            <?/*
                            <a style="color: #000!important; width: 90%; display: inline-block;  text-decoration: none; text-align: center; font-size: 15px; font-family:Arial,Helvetica,sans-serif;font-weight: bold;"
                               href="http://www.retail-loyalty.org/journal_retail_loyalty/read_online/online-version/?utm_source=mailing&utm_medium=bannertop&utm_campaign=3daysth" target="_blank">
                    <span style="color: #000!important; width: 100%; display: inline-block;  background-color: #B38ED0;text-decoration: none; text-align: center; padding: 10px;  font-size: 15px; font-family:Arial,Helvetica,sans-serif;font-weight: bold;">
                        7 - 13 октября получите доступ к полной электронной <br/>версии свежего номера журнала R&L и архиву <br/>номеров прошлых выпусков!
                    </span>
                            </a>

					</td></tr>
                    */?>

                        </table>
                    </td></tr>
                <tr><td colspan="3">
                        <table align="center" cellpadding="12" cellspacing="0" width="820px;" height="40"
                               style="font-size:12px; font-weight:bold; color:#fff;font-family:Arial,Helvetica,sans-serif;width:820px;">
                            <tr style="color: white; font-weight: bold;">
                                <td style="margin: 0;padding: 0;"><a href="http://www.retail-loyalty.org/" style="padding:0; text-decoraton:none; border:none;"><img style="border: none;"  src="http://www.retail-loyalty.org/images/sub-rl/main.png" alt="Главная" title="Главная"></a></td>
                                <td style="margin: 0;padding: 0;"><a href="http://www.retail-loyalty.org/journal_retail_loyalty/podpiska/" style="padding:0; text-decoraton:none; border:none;"><img style="border: none;"  src="http://www.retail-loyalty.org/images/sub-rl/sub.png" alt="Подписка" title="Подписка"></a></td>
                                <td style="margin: 0;padding: 0;"><a href="http://www.retail-loyalty.org/advertising/" style="padding:0; text-decoraton:none; border:none;"><img style="border: none;"  src="http://www.retail-loyalty.org/images/sub-rl/a_d_vert_.png" alt="Для рекламодетелей" title="Для рекламодетелей"></a></td>
                                <td style="margin: 0;padding: 0;"><a href="http://www.retail-loyalty.org/news/" style="padding:0; text-decoraton:none; border:none;"><img style="border: none;"  src="http://www.retail-loyalty.org/images/sub-rl/new.png" alt="Разместить новость" title="Разместить новость"></a></td>
                                <td style="margin: 0;padding: 0;"><a href="http://www.retail-loyalty.org/contact_information/" style="padding:0; text-decoraton:none; border:none;"><img style="border: none;"  src="http://www.retail-loyalty.org/images/sub-rl/contacts.png" alt="Контакты" title="Контакты"></a></td>
                                <td style="margin: 0;padding: 0;"><a href="#" style="padding:0; text-decoraton:none; border:none;"><img style="border: none;"   src="http://www.retail-loyalty.org/images/sub-rl/feedback.png" alt="Обратная связь" title="Обратная связь"></a></td>
                            </tr>
                        </table>
                    </td></tr>
            </table>
        </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <?if (CModule::IncludeModule("advertising")){
                $sub_spec_proekt = array();
                $rs = CAdvBanner::GetList(
                    $by="s1",
                    $order="asc",
                    array(
                        "TYPE_SID" => "SPEC_PROEKT_RL_JOURNAL",
                        "TYPE_SID_EXACT_MATCH" => "Y",
                        "LAMP"=> "green"
                    ),
                    $if_filtered,
                    "N"
                );
                while($ar = $rs->Fetch()) {
                    $sub_spec_proekt[] = $ar;

                    $lid = $ar["LID"];
                }
            }
            ?>

            <?if ($sub_spec_proekt[0]) {?>
                <div style="text-align: center">
                    <?echo str_replace('site_id=ru','site_id='.$lid,str_replace('site_id=s1','site_id='.$lid,str_replace('src="/','src="http://www.retail-loyalty.org/',str_replace('href="/','href="http://www.retail-loyalty.org/',CAdvBanner::GetHTML($sub_spec_proekt[0])))));?>
                    <br />
                </div>
            <? }?>
        </td>
    </tr>
    <tr><td>
            <table cellpadding="0" cellspacing="0" align="center" width="820px"  style="width:820px;font-family:Arial,Helvetica,sans-serif;background:#FFFFFF;border-bottom:1px dotted;">
                <tr>
                    <td valign="top" style="font-family:Arial,Helvetica,sans-serif; padding-bottom: 10px;background: #eee">

                        <?if(CModule::IncludeModule("iblock"))
                        {
                            $obJournals = CIBlockElement::GetList(array('ID'=>'desc'), array(
                                "IBLOCK_ID" => 40,
                            ), false, false, array("ID", "NAME", "IBLOCK_ID"));
                            if ($arJournal = $obJournals->Fetch())
                                $LAST_JOURNAL_ID = $arJournal["ID"];
                        }
                        $IBLOCK = GetIBlock(40);?>

                        <?$APPLICATION->IncludeComponent("cetera:journal.subscribe", "new-retail", array(
                                "SITE_ID" => "ip",
                                "IBLOCK_TYPE" => "journals",
                                "ID" => "40",
                                "ELEMENT_ID" => $LAST_JOURNAL_ID
                            )
                        );?>


                        <table class="row" align="center" style="margin-top:23px; border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:675px">
                            <tbody>
                            <tr style="padding:0;text-align:left;vertical-align:top">
                                <th class="small-12 large-3 columns" style="color:#0a0a0a;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:129px">
                                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                            <th class="ico" style="height: 116px; background:#c72e60;color:#0a0a0a;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;padding-bottom:5px;padding-top:23px;text-align:left">
                                                <center data-parsed="" style="min-width:97px;width:100%">
                                                    <a href="https://www.retail-loyalty.org/journal_retail_loyalty/podpiska/" title="КОРПОРАТИВНАЯ ПОДПИСКА" target="_blank" style="color:#2199e8;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">
                                                        <img align="center" class="float-center ico__img" src="https://plusworld-ru.beta3.ceteralabs.com/082018-newsletter/i/ico1.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;float:none;height:59px;margin:0 auto;margin-bottom:11px;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto">
                                                    </a>
                                                    <p class="text-center ico__text" style="color:#fff;font-size:14px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">КОРПОРАТИВНАЯ ПОДПИСКА</p>
                                                </center>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
                                <th class="small-12 large-3 columns" style="color:#0a0a0a;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:129px">
                                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                            <th class="ico" style="background:#c72e60;color:#0a0a0a;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;padding-bottom:5px;padding-top:23px;text-align:left">
                                                <center data-parsed="" style="min-width:97px;width:100%">
                                                    <a href="http://market.plusworld.ru/" title="КОРПОРАТИВНАЯ ПОДПИСКА" target="_blank" style="color:#2199e8;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">
                                                        <img align="center" class="float-center ico__img" src="https://plusworld-ru.beta3.ceteralabs.com/082018-newsletter/i/ico2.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;float:none;height:59px;margin:0 auto;margin-bottom:11px;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto">
                                                    </a>
                                                    <p class="text-center ico__text" style="color:#fff;font-size:14px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:center">ПОДПИСКА ДЛЯ ФИЗИЧЕСКИХ ЛИЦ</p>
                                                </center>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
                                <th class="small-12 large-3 columns" style="color:#0a0a0a;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:129px">
                                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding:0;text-align:left;vertical-align:top"><th class="small-12 columns mob" colspan="2" style="color:#0a0a0a;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:0!important;padding-right:0!important;padding-top:20px;text-align:left">
                                                <center data-parsed="" style="min-width:none!important;width:100%">
                                                    <p class="mobile text-center" style="color:#565655;font-size:18px;font-weight:400;line-height:1.3;margin:0;margin-bottom:5px;padding:0;text-align:center">МОБИЛЬНОЕ ПРИЛОЖЕНИЕ</p>
                                                </center>
                                            </th>
                                        </tr>
                                        <tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;border-collapse:collapse!important;color:#0a0a0a;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                <table align="center" class="menu float-center" style="border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:auto!important">
                                                    <tbody>
                                                    <tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;border-collapse:collapse!important;color:#0a0a0a;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                                <tbody>
                                                                <tr style="padding:0;text-align:left;vertical-align:top">
                                                                    <th class="menu-item float-center" style="color:#0a0a0a;float:none;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:10px;padding-top:0;text-align:center">
                                                                        <a href="https://play.google.com/store/apps/details?id=ru.plusalliance.retail" title="Журнал ПЛАС в Google Play" target="_blank" style="color:#2199e8;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">
                                                                            <img src="https://www.plusworld.ru/wp-content/uploads/2018/08/google-play.png" align="center" alt="Журнал ПЛАС в Google Play" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
                                                                        </a>
                                                                    </th>
                                                                    <th class="menu-item float-center" style="color:#0a0a0a;float:none;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:10px;padding-top:0;text-align:center">
                                                                        <a href="https://itunes.apple.com/us/app/%D0%B6%D1%83%D1%80%D0%BD%D0%B0%D0%BB-retail-loyalty/id1321396794?l=ru&ls=1&mt=8" title="Журнал ПЛАС в App Store" target="_blank" style="color:#2199e8;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">
                                                                            <img src="https://www.plusworld.ru/wp-content/uploads/2018/08/app-store.png" align="center" alt="Журнал ПЛАС в App Store" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
                                                                        </a>
                                                                    </th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
                            </tr>
                            </tbody>
                        </table>

                    </td>

                    <td style="background-color: #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                    <?// Правая колонка?>

                    <td valign="top" style="background-color:#fff;">

                        <table cellpadding="0" cellspacing="0" align="center" width="234" style="background-color: #EEEEEE; font-size: 11pt; line-height:15px;">

                            <tr>
                                <td height="40" align="center" style="background-color: #C62D5F; border-radius: 5px 5px 0 0">

                                    <a href="http://www.retail-loyalty.org/expert-forum/<?=$labelUrl?>"
                                       style="color:#fff;
                                       font-size:12px;
                                       font-weight:bold;
                                       text-decoration:none;
                                       font-family:Arial,Helvetica,sans-serif;">Форум экспертов</a>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                            <tr style="text-align: left; ">
                                <td style="padding: 0 10px 0 0; ">
                                    <?
                                    $dateFilterprofessionals = array();
                                    $dateFilterprofessionals = array(
                                        "IBLOCK_ID" => array(23,91,41),
                                        "PROPERTY_EXPERT_FORUM_VALUE" => '1',
                                        "ACTIVE"=>"Y",
                                        "ACTIVE_DATE"=>"Y",
                                    );
                                    $GLOBALS["Filterprofessionals"] = $dateFilterprofessionals;
                                    /*$arIDFilterprofessionals = array();
                                    $res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC", "SORT"=>"ASC"), $dateFilter, false, array("nTopCount"=>5));
                                    while($ar_fields = $res->GetNext()) {
                                       array_push($arIDFilterprofessionals,$ar_fields["ID"]);
                                    }
                                    $GLOBALS["Filterprofessionals"] = $arIDFilterprofessionals;*/

                                    $APPLICATION->IncludeComponent(
                                        "cetera:subscribe.prof",
                                        "professionals.subscribe.daily_rl",
                                        Array(
                                            "SITE_ID" => "ip",
                                            "IBLOCK_TYPE" => "",
                                            "ID" => "",
                                            "SECTION_ID" => "",
                                            "NEWS_COUNT" => "5",
                                            "FILTER_NAME" => "Filterprofessionals",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "SORT_BY" => "ACTIVE_FROM",
                                            "SORT_ORDER" => "DESC"
                                        ),
                                        false
                                    );
                                    ?>
                                    <br />
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <br />



                        <?/*
					    <table cellpadding="0" cellspacing="0" width="234" style="width:234px;">
						<tr>
						    <td>
							<a target="_blank" href="<?=$sub_sponsor[0]['IMAGE_ALT']?>"><?echo CAdvBanner::GetHTML($sub_sponsor[0]);?></a>
						    </td>
						</tr>
						</table>
						<?if ($sub_sponsor[0]) { echo "<br />"; } ?>
					*/?>
                        <table cellpadding="5" cellspacing="0" width="234" style="width:234px;background:#eee;">
                            <tr>
                                <td height="40" align="center" style="background-color: #C62D5F; ">
                                    <a href="http://plus-forum.com/" style="color:#fff; font-size:12px; font-weight:bold; text-decoration:none; font-family:Arial,Helvetica,sans-serif;">ПЛАС-Форумы</a>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <?$APPLICATION->IncludeComponent(
                                        "cetera:subscribe.news",
                                        "subscribe.daily.projects",
                                        Array(
                                            "SITE_ID" => "ip",
                                            "IBLOCK_TYPE" => "forum",
                                            "ID" => "47",
                                            "SORT_BY" => "SORT",
                                            "SORT_ORDER" => "ASC"
                                        )
                                    );?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <br />

                        <?
                        $start = mktime();
                        //echo "1_".date("d.m.Y H:i:s", $start);

                        $finish = mktime() + 24096000;
                        //echo "2_".date("Y-m-d H:i:s", $finish);
                        $GLOBALS["arrFilter_pf"] = array(
                            ">=DATE_ACTIVE_FROM" => date("d.m.Y H:i:s", $start),
                            "<=DATE_ACTIVE_FROM" => date("d.m.Y H:i:s", $finish)
                        );?>

                        <table cellpadding="0" cellspacing="0" align="center" width="234" style="width:234px;background:#eee;font-size: 11pt; line-height:15px;">

                            <tr>
                                <td height="40" align="center" style="background-color: #C62D5F; ">
                                    <a href="http://www.retail-loyalty.org/calendar_retail_loyalty/events/" style="color:#fff; font-size:12px; font-weight:bold; text-decoration:none; font-family:Arial,Helvetica,sans-serif;">Календарь событий</a>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                            <tr>
                                <td style="padding: 0 10px 0 0;">
                                    <?$APPLICATION->IncludeComponent( "cetera:subscribe.events",
                                        "rl_events_new",
                                        Array(
                                            "SITE_ID" => "ip",
                                            "IBLOCK_TYPE" => "NEWS_IP",
                                            "ID" => "58",
                                            "FILTER_NAME" => "arrFilter_pf",
                                            "SECTION_ID" => "",
                                            "NEWS_COUNT" => 5,
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "SORT_BY" => "DATE_ACTIVE_FROM",
                                            "SORT_ORDER" => "ASC" ),
                                        false );?>

                                </td>
                            </tr>
                            <tr><td align="right">
                                    <a style="color:#A51340; font-size: 12px; text-decoration:none; font-weight:bold; font-family:Arial,Helvetica,sans-serif;" href="http://www.retail-loyalty.org/calendar_retail_loyalty/events/">Bсе события&nbsp;&nbsp;&nbsp;</a>
                                </td></tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <br />
                        <table cellpadding="5" cellspacing="0" align="center" width="234" style="width:234px;background:#eee; line-height:20px;">
                            <tr>
                                <td height="40" align="center" style="background-color: #C62D5F; font-weight:bold; color:#fff; font-family:Arial,Helvetica,sans-serif; font-size:12px;">Наши сервисы</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <ul style="padding-left:20px !important; margin-top:0;margin-bottom:0;">
                                        <li><a class="blacklinck" href="<?=$site_url;?>/journal_retail_loyalty/research/" style="color:#A51340; text-decoration:none; font-size: 12px; font-family:Arial,Helvetica,sans-serif;">Исследования и Обзоры </a></li>
                                        <li><a class="blacklinck" href="<?=$site_url;?>/translate/" style="color:#A51340; text-decoration:none; font-size: 12px; font-family:Arial,Helvetica,sans-serif;">Бюро переводов</a></li>
                                        <li><a class="blacklinck" href="http://bqdesign.ru/" style="color:#A51340; text-decoration:none; font-size: 12px; font-family:Arial,Helvetica,sans-serif;">Полиграфия</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <br/>
                    </td>
                </tr>

            </table>
        </td></tr>
    <tr>
        <td align="center">
            <table width="830" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;border-collapse:collapse; background-color: #EEEEEE; border-top: 1px dotted #C0C0C0; font-family:verdana;">
                <tr>
                    <td style="font: bold 12px sans-serif; padding: 10px 20px;">
                        <span style="display:block; padding-bottom: 5px;">Для рекламодателей:</span>
                        <a href="http://www.retail-loyalty.org/contact_information/" style="color: #A51340; text-decoration: none; padding-right: 20px;">Контакты</a> <a href="http://www.retail-loyalty.org/advertising/mediakit-get/" style="color: #A51340; text-decoration: none">Получить медиакит</a>
                    </td>
                    <td style="padding: 10px 20px; width: 120px;">
                <tr style="font-size: 12px; border-top: 1px dotted #C0C0C0; text-align: center">
                    <td colspan="2" style="padding: 10px 20px; text-align: left;">
                        Чтобы отказаться от рассылки перейдите по этой <a href="http://www.retail-loyalty.org/personal/profile/" style="color: #A51340;">ссылке</a><br /><br />
                        Адрес: Россия, 117218, Москва, ул. Кржижановского, д. 29, корпус 5, оф. 2-20 <a href="http://maps.yandex.ru/?ll=37.582932%2C55.674791&spn=0.019462%2C0.005214&z=16&l=map" style="color: #A51340;">посмотреть на карте</a><br /><br />
                        Телефон: +7 495 961 10 65 Факс: +7 495 988 37 30 Электронная почта: <a href="mailto: marketing@plusworld.ru" style="color: #A51340;">marketing@plusworld.ru</a><br /><br />
                        Отдел подписки <a href="mailto: podpiska@plusworld.ru" style="color: #A51340;">podpiska@plusworld.ru</a><br />

                    </td>
                </tr>
                </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?
//Получаем дату и время в правильном формате.
$new_date=$DB-> FormatDate(date("d.m.Y H:i:s"), "DD.MM.YYYY HH:MI:SS", CSite::GetDateFormat("FULL", "ru"));

$date = 'Анонс журнала "RETAIL&LOYALTY" '.$str;

if($SUBSCRIBE_TEMPLATE_RESULT)
    return array(
        "SUBJECT"=> $date,
        "BODY_TYPE" => "html",
        "CHARSET"=>"utf-8",
        "DIRECT_SEND"=>"Y",
        "FROM_FIELD"=>$SUBSCRIBE_TEMPLATE_RUBRIC["FROM_FIELD"],
    );
else
    return false;
?>
