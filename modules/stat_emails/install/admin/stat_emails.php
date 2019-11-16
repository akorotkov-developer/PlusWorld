<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);
ClearVars();

require($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/prolog_admin_after.php");
CModule::IncludeModule('stat_emails');
CModule::IncludeModule('subscribe');
global $DB, $APPLICATION;


$APPLICATION->SetTitle("Статистика рассылок");

# события. Чтение писем event1=mail&event2=read
# event3=football2002@inbox.ru|2001 (email|id_рассылки)
/*$arFilter = array(
    "EVENT1" => "mail",
    "EVENT1_EXACT_MATCH" => "Y",
    "EVENT2" => "read",
    "EVENT1_EXACT_MATCH" => "Y"
);
$cData = new CStatEvent;
$rsData = $cData->GetList($by, $order, $arFilter, $is_filtered);*/

$rsData = $DB->Query("SELECT ID, EVENT3, DATE_ENTER, SITE_ID FROM `b_stat_emails`");

$mailEvents = array();
while ($arMailEvent = $rsData->Fetch())
{
    $event3 = $arMailEvent["EVENT3"];
    if (strpos($event3, "|") > 0) {
        $event3Splitted = explode("|", trim($event3));
        $mail = $event3Splitted[0];
        $subscriptionId = intval($event3Splitted[1]);
        if (filter_var($mail, FILTER_VALIDATE_EMAIL) && $subscriptionId > 0) {
            $arMailEvent["EMAIL"] = $mail;
            if (!$mailEvents[$subscriptionId]["ITEMS"][$arMailEvent["EVENT3"]]) {
                $mailEvents[$subscriptionId]["ITEMS"][$arMailEvent["EVENT3"]] = $arMailEvent;
                if (!$mailEvents[$subscriptionId]["STAT"]) $mailEvents[$subscriptionId]["STAT"] = 1;
                else $mailEvents[$subscriptionId]["STAT"]++;
            }
        }
    }
}

# рассылки
$sTableID = "tbl_posting";
$days = 90;
$arFilter = array(
    "STATUS_ID" => "S",
    "DATE_SENT_1" => ConvertTimeStamp(time()-86400 * $days, "FULL"),
    "DATE_SENT_2" => ConvertTimeStamp(time(), "FULL"),
);
$cData = new CPosting;
$rsData = $cData->GetList(array($by=>$order), $arFilter);

$rsData = new CAdminResult($rsData, $sTableID);
$rsData->NavStart();
//$lAdmin->NavText($rsData->GetNavPrint(GetMessage("post_nav")));

while($arRes = $rsData->NavNext(true, "f_")):

    # TODO optimize
    $amount = 0;
    $rsEmailData = CPosting::GetEmailsByStatus($arRes["ID"], "N");
    $arRes["AMOUNT_OF_EMAILS"] = $rsEmailData->SelectedRowsCount();

    if ($mailEvents[$arRes["ID"]]["STAT"]) $arRes["AMOUNT_OF_READ_EMAILS"] = $mailEvents[$arRes["ID"]]["STAT"];
    else $arRes["AMOUNT_OF_READ_EMAILS"] = 0;

    $userVars[] = $arRes;
endwhile;
if (intval($_REQUEST["PAGEN_1"])==0) {
    $page = $APPLICATION->GetCurPageParam("PAGEN_1=1");
    header('Location: '.$page);
}

?>
    <div class="clearfix"></div>
    <p><?$navStr = $rsData->GetPageNavStringEx($navComponentObject, "Страницы:", ".default");
        echo $navStr;?></p>
    <div class="clearfix"></div>
    <form name="form-cats" method="POST" action="" id="user_vars_form">
        <?=bitrix_sessid_post()?>
        <?
        $aTabs = array(
            array("DIV" => "ps_settings_filter", "TAB" => "Статистика писем", "ICON" => "icon_16", "TITLE" => "Статистика писем"),
        );

        $tabControl = new CAdminTabControl("tabControl", $aTabs);
        $tabControl->Begin();

        // ====================== TAB 1 =======================
        ?>
        <?$tabControl->BeginNextTab();?>
        <tr>
            <td style="text-align:left; vertical-align:top;">
                <table cellspacing="0" cellpadding="0" border="0" align="center" id="ib_prop_list" class="internal">
                    <tbody>
                    <tr class="heading">
                        <?
                        /*[STATUS_TITLE] => Отправлено
                        [ID] => 2001
                        [STATUS] => S
                        [FROM_FIELD] => subscribe@plusworld.ru
                        [TO_FIELD] =>
                        [EMAIL_FILTER] =>
                        [SUBJECT] => Retail&Loyalty News, 06/06/14, information portal Retail-loyalty.org
                        [BODY_TYPE] => html
                        [DIRECT_SEND] => Y
                        [CHARSET] => utf-8
                        [MSG_CHARSET] => UTF-8
                        [SUBSCR_FORMAT] =>
                        [TIMESTAMP_X] => 06.06.2014 17:46:01
                        [DATE_SENT] => 06.06.2014 17:46:01*/
                        ?>
                        <td>ID</td>
                        <td>Наименование</td>
                        <td>Статус</td>
                        <td>Дата</td>
                        <td>Прочитано</td>
                    </tr>
                    <?
                    $i = 0;
                    foreach($userVars as $uVar){
                        $i++;
                        ?>
                        <tr>
                            <td><?=$uVar['ID']?></td>
                            <td><?=$uVar['SUBJECT']?></td>
                            <td><?=$uVar['STATUS_TITLE']?></td>
                            <td><?=$uVar['DATE_SENT']?></td>
                            <td style="text-align: center"><?=$uVar['AMOUNT_OF_READ_EMAILS']?>/<?=$uVar['AMOUNT_OF_EMAILS']?></td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>

                <?/*echo BeginNote('width="100%"');?>
                <div id="n1d"><sup>1</sup> Замечание</div>
                <?echo EndNote(); */?>
            </td>
            <td style="text-align:left; vertical-align:top;">
                <div></div>
            </td>
        </tr>

        <?$tabControl->EndTab();?>

        <?
        $tabControl->Buttons();
        ?>

        <?$tabControl->End();?>
    </form>
    <div class="clearfix"></div>
    <p><?$navStr = $rsData->GetPageNavStringEx($navComponentObject, "Страницы:", ".default");
        echo $navStr;?></p>
    <div class="clearfix"></div>
<?


require($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_admin.php");
