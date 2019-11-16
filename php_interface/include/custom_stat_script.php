<?
$MESS["sender_stat_title"] = "Статистика";
$MESS["sender_stat_flt_mailing"] = "Рассылка";
$MESS["sender_stat_flt_mailing_chain"] = "Выпуск";
$MESS["sender_stat_error_no_data"] = "Нет данных. Выпуск не отправлялся или отправка не завершена.";

$MESS["sender_stat_report"] = "Отчет о выпуске";
$MESS["sender_stat_report_title"] = "Выпуск от";
$MESS["sender_stat_report_subject"] = "Тема сообщения:";
$MESS["sender_stat_report_date_create"] = "Создана:";
$MESS["sender_stat_report_date_sent"] = "Время запуска:";
$MESS["sender_stat_report_cnt_all"] = "Всего отправлено сообщений:";
$MESS["sender_stat_report_cnt_in"] = "в том числе:";
$MESS["sender_stat_report_cnt_read"] = "Число прочитанных:";
$MESS["sender_stat_report_cnt_click"] = "Переходы по ссылке:";
$MESS["sender_stat_report_cnt_error"] = "С ошибками:";
$MESS["sender_stat_report_cnt_unsub"] = "Отписались от рассылки:";

$MESS["sender_stat_graph"] = "Эффективность выпуска";
$MESS["sender_stat_graph_all"] = "Всего писем отправлено";
$MESS["sender_stat_graph_read"] = "Открыто писем";
$MESS["sender_stat_graph_click"] = "Имеют переходы по ссылкам";
$MESS["sender_stat_graph_unsub"] = "Отписались от писем";
$MESS["sender_stat_graph_error"] = "Ошибок при отправке";

$MESS["sender_stat_graphperiod"] = "Эффективность периодических отправок выпуска";
$MESS["sender_stat_graphperiod_all"] = "всего:";
$MESS["sender_stat_graphperiod_action"] = "Действия получателей сообщений";
$MESS["sender_stat_graphperiod_cnt_all"] = "Отправлено сообщений";
$MESS["sender_stat_graphperiod_cnt_read"] = "Прочитали";
$MESS["sender_stat_graphperiod_cnt_click"] = "Перешли по ссылкам";
$MESS["sender_stat_graphperiod_cnt_unsub"] = "Отписались";

$MESS["sender_stat_click_title"] = "Топ-15 переходов по ссылкам";
$MESS["sender_stat_click_cnt"] = "Количество";
$MESS["sender_stat_click_link"] = "Ссылка";
$MESS["sender_stat_click_no_data"] = "Нет данных";

$MESS["POST_U_YES"] = "Да";
$MESS["POST_U_NO"] = "Нет";
$MESS["MAIN_ALL"] = "(все)";
?>
<?
\Bitrix\Main\Loader::includeModule("sender");

$MAILING_ID = 1;
$ID = 1;

$sTableID = "tbl_sender_statistics";

if($ID <= 0)
{
    $postingDb = \Bitrix\Sender\PostingTable::getList(array(
        'select' => array('MAILING_CHAIN_ID'),
        'filter' => array('MAILING_ID' => $MAILING_ID, '!DATE_SENT' => null),
        'order' => array('DATE_SENT' => 'DESC', 'DATE_CREATE' => 'DESC'),
    ));
    $arPosting = $postingDb->fetch();
    if($arPosting)
        $ID = intval($arPosting['MAILING_CHAIN_ID']);
}

$statClickList = array();
$statResult = array(
    'all' => 0,
    'all_print' => 0,
    'delivered' => 0,
    'error' => 0,
    'not_send' => 0,
    'read' => 0,
    'click' => 0,
    'unsub' => 0,
);


if($ID > 0)
{
    $postingDb = \Bitrix\Sender\PostingTable::getList(array(
        'select' => array(
            'ID', 'DATE_CREATE', 'DATE_SENT',
            'MAILING_CHAIN_REITERATE' => 'MAILING_CHAIN.REITERATE',
            'SUBJECT' => 'MAILING_CHAIN.SUBJECT'
        ),
        'filter' => array('MAILING_CHAIN_ID' => $ID, '!DATE_SENT' => null),
        'order' => array('DATE_SENT' => 'DESC', 'DATE_CREATE' => 'DESC'),
        'limit' => 1
    ));
    $arPosting = $postingDb->fetch();

    $arPostingReiterateList = array();
    if (!empty($arPosting) && $arPosting['MAILING_CHAIN_REITERATE'] == 'Y')
    {
        $defaultDate = new \Bitrix\Main\Type\DateTime();

        $postingReiterateList = array();
        $postingReiterateDb = \Bitrix\Sender\PostingTable::getList(array(
            'select' => array(
                'ID', 'DATE_SENT'
            ),
            'filter' => array(
                'MAILING_CHAIN_ID' => $ID,
                '!STATUS' => \Bitrix\Sender\PostingTable::STATUS_NEW,
            ),
            'order' => array('DATE_SENT' => 'DESC', 'ID' => 'DESC'),
            'limit' => 50,
        ));
        while($postingReiterate = $postingReiterateDb->fetch())
        {
            $postingReiterate['CNT'] = 0;
            $postingReiterate['READ_CNT'] = 0;
            $postingReiterate['CLICK_CNT'] = 0;
            $postingReiterate['UNSUB_CNT'] = 0;

            $postingReiterateList[$postingReiterate['ID']] = $postingReiterate;
        }
        $postingReiterateListId = array_keys($postingReiterateList);

        $paramList = array('Recipient', 'Read', 'Click', 'Unsub');
        foreach($paramList as $paramName)
        {
            if($paramName == 'Recipient')
            {
                $paramNameKey = 'CNT';
                $paramGetListArgs = array(
                    'select' => array('POSTING_ID', 'CNT'),
                    'filter' => array('POSTING_ID' => $postingReiterateListId),
                    'runtime' => array(new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(%s)', 'ID'))
                );
            }
            else
            {
                $paramNameKey = strtoupper($paramName).'_CNT';
                $paramGetListArgs = array(
                    'select' => array('POSTING_ID', 'CNT'),
                    'filter' => array('POSTING_ID' => $postingReiterateListId),
                    'runtime' => array(new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(DISTINCT %s)', 'RECIPIENT_ID'))
                );
            }

            $statDb = call_user_func_array(
                array('Bitrix\Sender\Posting' . $paramName . 'Table', 'getList'),
                array($paramGetListArgs));
            while($statParam = $statDb->fetch())
            {
                $postingReiterateList[$statParam['POSTING_ID']][$paramNameKey] = $statParam['CNT'];
            }
        }

        foreach($postingReiterateList as $arPostingReiterate)
        {
            if(empty($arPostingReiterate['DATE_SENT']))
                $arPostingReiterate['DATE_SENT'] = $defaultDate;

            $cntDivider = $arPostingReiterate['CNT'] > 0 ? $arPostingReiterate['CNT'] : 1;
            $cntDivider = $cntDivider/100;

            $defaultDateTimeStamp = $arPostingReiterate['DATE_SENT']->getTimestamp();
            $arPostingReiterateList[$defaultDateTimeStamp] = array(
                'date' => $arPostingReiterate['DATE_SENT']->format("d/m"),

                'sent' => $arPostingReiterate['CNT'],
                'read' => $arPostingReiterate['READ_CNT'],
                'click' => $arPostingReiterate['CLICK_CNT'],
                'unsub' => $arPostingReiterate['UNSUB_CNT'],

                'sent_prsnt' => '100',
                'read_prsnt' => round($arPostingReiterate['READ_CNT']/$cntDivider, 2),
                'click_prsnt' => round($arPostingReiterate['CLICK_CNT']/$cntDivider, 2),
                'unsub_prsnt' => round($arPostingReiterate['UNSUB_CNT']/$cntDivider, 2)
            );
        }

        if(!empty($arPostingReiterateList))
        {
            if (count($arPostingReiterateList) < 2)
            {
                $arPostingReiterateList = array();
            }
            else
            {
                ksort($arPostingReiterateList);
                $arPostingReiterateList = array_values($arPostingReiterateList);
            }
        }
    }

    if(!empty($arPosting))
    {
        $statListDb = \Bitrix\Sender\PostingRecipientTable::getList(array(
            'select' => array('STATUS', 'CNT'),
            'filter' => array('POSTING_ID' => $arPosting['ID']),
            'runtime' => array(
                new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(%s)', 'ID'),
            ),
        ));
        while($stat = $statListDb->fetch())
        {
            $statResult['all'] += $stat['CNT'];
            switch($stat['STATUS'])
            {
                case \Bitrix\Sender\PostingRecipientTable::SEND_RESULT_SUCCESS:
                    $statResult['delivered'] = $stat['CNT'];
                    break;
                case \Bitrix\Sender\PostingRecipientTable::SEND_RESULT_ERROR:
                    $statResult['error'] = $stat['CNT'];
                    break;
                case \Bitrix\Sender\PostingRecipientTable::SEND_RESULT_NONE:
                    $statResult['not_send'] = $stat['CNT'];
                    break;
            }
        }
        $statResult['all_print'] = $statResult['all'];

        $paramList = array('Read', 'Click', 'Unsub');
        foreach($paramList as $paramName)
        {
            $paramGetListArgs = array(
                'select' => array('CNT'),
                'filter' => array('POSTING_ID' => $arPosting['ID']),
                'runtime' => array(new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(DISTINCT %s)', 'RECIPIENT_ID'))
            );
            $statDb = call_user_func_array(
                array('Bitrix\Sender\Posting' . $paramName . 'Table', 'getList'),
                array($paramGetListArgs));
            $statParam = $statDb->fetch();
            $statResult[strtolower($paramName)] = $statParam['CNT'];
        }
    }

    if(!empty($arPosting))
    {
        $statClickDb = \Bitrix\Sender\PostingClickTable::getList(array(
            'select' => array(
                'URL', 'CNT'
            ),
            'filter' => array('POSTING_ID' => $arPosting['ID']),
            'runtime' => array(
                new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(%s)', 'ID'),
            ),
            'group' => array('URL'),
            'order' => array('CNT' => 'DESC'),
            'limit' => 15
        ));

        while($statClick = $statClickDb->fetch())
        {
            $statClickList[] = $statClick;
        }
    }
}

ob_start();
if(!empty($strError)):
    CAdminMessage::ShowMessage($strError);
else:

    if(intval($statResult['all'])<=0)
    {
        $statResult['all'] = 1;
    }
    $cntDivider = $statResult['all']/100;
    ?>
    <?
    $topLinks = array();
    $topLinksCount = array();
    $SENDER_STAT_REPORT = GetMessage("sender_stat_report");
    $SENDER_STAT_REPORT_TITLE = GetMessage("sender_stat_report_title");
    $DATE_SENT = htmlspecialcharsbx($arPosting['DATE_SENT']);
    $SENDER_STAT_REPORT_SUBJECT = GetMessage("sender_stat_report_subject");
    $SUBJECT = htmlspecialcharsbx($arPosting['SUBJECT']);
    $SENDER_STAT_REPORT_DATE_CREATE = GetMessage("sender_stat_report_date_create");
    $DATE_CREATE = htmlspecialcharsbx($arPosting['DATE_CREATE']);
    $SENDER_STAT_REPORT_DATE_SENT = GetMessage("sender_stat_report_date_sent");
    $SENDER_STAT_REPORT_CNT_ALL = GetMessage("sender_stat_report_cnt_all");
    $ALL_PRINT = intval($statResult['all_print']);
    $ALL_PRINT_PERCENT = round(intval($statResult['all_print'])/$cntDivider, 2);
    $SENDER_STAT_REPORT_CNT_IN = GetMessage("sender_stat_report_cnt_in");
    $SENDER_STAT_REPORT_CNT_READ = GetMessage("sender_stat_report_cnt_read");
    $READ = intval($statResult['read']);
    $READ_PERCENT = round(intval($statResult['read'])/$cntDivider, 2);
    $SENDER_STAT_REPORT_CNT_CLICK = GetMessage("sender_stat_report_cnt_click");
    $CLICK = intval($statResult['click']);
    $CLICK_PERCENT = round(intval($statResult['click'])/$cntDivider, 2);
    $SENDER_STAT_REPORT_CNT_ERROR = GetMessage("sender_stat_report_cnt_error");
    $ERROR = intval($statResult['error']);
    $ERROR_PERCENT = round(intval($statResult['error'])/$cntDivider, 2);
    $SENDER_STAT_REPORT_CNT_UNSUB = GetMessage("sender_stat_report_cnt_unsub");
    $UNSUB = intval($statResult['unsub']);
    $UNSUB_PERCENT = round(intval($statResult['unsub'])/$cntDivider, 2);
    ?>
    <?foreach($statClickList as $clickItem):?>
    <?
    array_push($topLinks, htmlspecialcharsbx($clickItem['URL']));
    array_push($topLinksCount, htmlspecialcharsbx($clickItem['CNT']));
    ?>
<?endforeach?>
<?
endif;
?>
<?
//Подготавливаем массив переменных для использования в шаблоне письма
$mailResultArr = array(
    "LINK_0" => $topLinks[0],
    "LINK_1" => $topLinks[1],
    "LINK_2" => $topLinks[2],
    "LINK_3" => $topLinks[3],
    "LINK_4" => $topLinks[4],
    "LINK_5" => $topLinks[5],
    "LINK_6" => $topLinks[6],
    "LINK_7" => $topLinks[7],
    "LINK_8" => $topLinks[8],
    "LINK_9" => $topLinks[9],
    "LINK_10" => $topLinks[10],
    "LINK_11" => $topLinks[11],
    "LINK_12" => $topLinks[12],
    "LINK_13" => $topLinks[13],
    "LINK_14" => $topLinks[14],
    "LINK_15" => $topLinks[15],
    "LINK_CNT_0" => $topLinksCount[0],
    "LINK_CNT_1" => $topLinksCount[1],
    "LINK_CNT_2" => $topLinksCount[2],
    "LINK_CNT_3" => $topLinksCount[3],
    "LINK_CNT_4" => $topLinksCount[4],
    "LINK_CNT_5" => $topLinksCount[5],
    "LINK_CNT_6" => $topLinksCount[6],
    "LINK_CNT_7" => $topLinksCount[7],
    "LINK_CNT_8" => $topLinksCount[8],
    "LINK_CNT_9" => $topLinksCount[9],
    "LINK_CNT_10" => $topLinksCount[10],
    "LINK_CNT_11" => $topLinksCount[11],
    "LINK_CNT_12" => $topLinksCount[12],
    "LINK_CNT_13" => $topLinksCount[13],
    "LINK_CNT_14" => $topLinksCount[14],
    "LINK_CNT_15" => $topLinksCount[15],
    "SENDER_STAT_REPORT" => $SENDER_STAT_REPORT,
    "SENDER_STAT_REPORT_TITLE" => $SENDER_STAT_REPORT_TITLE,
    "DATE_SENT" => $DATE_SENT,
    "SENDER_STAT_REPORT_SUBJECT" => $SENDER_STAT_REPORT_SUBJECT,
    "SUBJECT" => $SUBJECT,
    "SENDER_STAT_REPORT_DATE_CREATE" => $SENDER_STAT_REPORT_DATE_CREATE,
    "DATE_CREATE" => $DATE_CREATE,
    "SENDER_STAT_REPORT_DATE_SENT" => $SENDER_STAT_REPORT_DATE_SENT,
    "SENDER_STAT_REPORT_CNT_ALL" => $SENDER_STAT_REPORT_CNT_ALL,
    "ALL_PRINT" => $ALL_PRINT,
    "ALL_PRINT_PERCENT" => $ALL_PRINT_PERCENT,
    "SENDER_STAT_REPORT_CNT_IN" => $SENDER_STAT_REPORT_CNT_IN,
    "SENDER_STAT_REPORT_CNT_READ" => $SENDER_STAT_REPORT_CNT_READ,
    "READ" => $READ,
    "READ_PERCENT" => $READ_PERCENT,
    "SENDER_STAT_REPORT_CNT_CLICK" => $SENDER_STAT_REPORT_CNT_CLICK,
    "CLICK" => $CLICK,
    "CLICK_PERCENT" => $CLICK_PERCENT,
    "SENDER_STAT_REPORT_CNT_ERROR" => $SENDER_STAT_REPORT_CNT_ERROR ,
    "ERROR" => $ERROR,
    "ERROR_PERCENT" => $ERROR_PERCENT,
    "SENDER_STAT_REPORT_CNT_UNSUB" => $SENDER_STAT_REPORT_CNT_UNSUB,
    "UNSUB" => $UNSUB,
    "UNSUB_PERCENT" => $UNSUB_PERCENT,
);

function setDailyStat($arr) {
    $statFile = './daily_stat.txt';
    $dataForWrite = serialize($arr);
    file_put_contents($statFile, $dataForWrite);
}

function sendDailyStat() {
    $statFile = './daily_stat.txt';
    $data = file_get_contents($statFile);
    $dataForSend = unserialize($data);
    CEvent::Send("MAIL_STATISTIC_SEND", "ip", $dataForSend);
}

sendDailyStat();
/*setDailyStat($mailResultArr);*/
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

