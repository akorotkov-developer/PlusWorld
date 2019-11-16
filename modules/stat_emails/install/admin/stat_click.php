<?
use Bitrix\Main\Loader,
	Bitrix\Main;
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);
ClearVars();

require($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/prolog_admin_after.php");
CModule::IncludeModule('iblock');
CModule::IncludeModule('subscribe');
global $APPLICATION;

$APPLICATION->SetTitle("Рассылка: Статистика кликов");

$POSTING_ID = intval($_REQUEST["POSTING_ID"]);
$page = $APPLICATION->GetCurPage();

if ($POSTING_ID == 0) {
    header('Location: /bitrix/admin/stat_emails.php');
    die();
} else {
    $namePosting = 'Рассылка: Статистика кликов';
    $arFilter = array(
        "ID" => $POSTING_ID
    );
    $cData = new CPosting;
    $rsData = $cData->GetList(array($by=>$order), $arFilter);
    $rsData = new CAdminResult($rsData, $sTableID);
    $rsData->NavStart();
    while($arRes = $rsData->NavNext(true, "f_")) {
        $namePosting = $arRes["SUBJECT"];
    }

    $idSubscribeStatClick = 0;
    $res = CIBlock::GetList(
        Array(),
        Array(
            'ACTIVE'=>'Y',
            "CNT_ACTIVE"=>"Y",
            "CODE"=>'subscribe_stat_click'
        ), true
    );
    while($ar_res = $res->Fetch())
    {
        $idSubscribeStatClick = intval($ar_res["ID"]);
    }
    if ($idSubscribeStatClick > 0) {
        $arResult = array();
        $arFilterStatClick = Array(
            "IBLOCK_ID" => $idSubscribeStatClick,
            "ACTIVE"=>"Y",
            "PROPERTY_POSTING_ID" => $_REQUEST["POSTING_ID"]
        );
        $resStatClick = CIBlockElement::GetList(Array("NAME"=>"DESC"), $arFilterStatClick, false, false, array("ID","IBLOCK_ID"));
        while($obStatClick = $resStatClick->GetNextElement()){
            $arItem = array();
            $arFieldsStatClick = $obStatClick->GetFields();
            $arItem = $arFieldsStatClick;
            $arPropsStatClick = $obStatClick->GetProperties();
            $arItem["PROPERTY"] = $arPropsStatClick;
            $arResult[] = $arItem;
        }
?>
        <div class="clearfix"></div>
        <form name="form-cats" method="POST" action="" id="user_vars_form">
            <?=bitrix_sessid_post()?>
            <?
            $aTabs = array(
                array("DIV" => "ps_settings_filter", "TAB" => $namePosting, "ICON" => "icon_16", "TITLE" => ''),
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
                            <td>Дата</td>
                            <td>Тип блока</td>
                            <td>Порядковый номер элемента в Блоке</td>
                            <td>Количество кликов</td>
                        </tr>
                        <?
                        $i = 0;
                        foreach($arResult as $arItem){
                            ?>
                            <tr>
                                <td><?=$arItem['PROPERTY']["DATE"]["VALUE"]?></td>
                                <td><?=$arItem['PROPERTY']["TYPE"]["VALUE"]?></td>
                                <td><?=$arItem['PROPERTY']["NUMBER"]["VALUE"]?></td>
                                <td><?=$arItem['PROPERTY']["CLICK"]["VALUE"]?></td>
                            </tr>
                        <?}?>
                        </tbody>
                    </table>
                </td>
                <td style="text-align:left; vertical-align:top;">
                    <div></div>
                </td>
            </tr>
            <?$tabControl->EndTab();
            $tabControl->Buttons();
            $tabControl->End();?>
        </form>
        <div class="clearfix"></div>
<?  }
    else {
        header('Location: /bitrix/admin/stat_emails.php');
        die();
    }
}
require($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_admin.php");
