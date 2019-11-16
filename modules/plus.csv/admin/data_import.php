<?
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/prolog.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use plus\csv\WorkWithSubscribe;

Loc::loadMessages(__FILE__);

//Подключаем модуль подписок
Loader::includeModule("subscribe");
//Подключаем классы нашего модуля
Loader::includeModule("plus.csv");

set_time_limit(0);

// получим права доступа текущего пользователя на модуль
$POST_RIGHT = $APPLICATION->GetGroupRight("subscribe");
// если нет прав - отправим к форме авторизации с сообщением об ошибке
if ($POST_RIGHT == "D")
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
?>
<?
if (isset($_REQUEST["CUR_LOAD_SESS_ID"]) && strlen($_REQUEST["CUR_LOAD_SESS_ID"]) > 0)
    $CUR_LOAD_SESS_ID = $_REQUEST["CUR_LOAD_SESS_ID"];
else
    $CUR_LOAD_SESS_ID = "CL".time();

$strError = "";
$line_num = 0;
$io = CBXVirtualIo::GetInstance();
//Обеъект класса, который отвечает за все манипуляции над подписчиками
$WorkWithSubscribe = new WorkWithSubscribe;
?>

<?
/*----- Список полей для подписчиков ------*/
$arIBlockAvailProdFields = array(
    "NAME" => array(
        "field" => "NAME",
        "name" => Loc::getMessage("SUB_NAME"),
    ) ,
    "SECOND_NAME" => array(
        "field" => "SECOND_NAME",
        "name" => Loc::getMessage("SUB_SECOND_NAME"),
    ) ,
    "LAST_NAME" => array(
        "field" => "LAST_NAME",
        "name" => Loc::getMessage("LAST_NAME"),
    ) ,
    "WORK_COMPANY" => array(
        "field" => "WORK_COMPANY",
        "name" => Loc::getMessage("WORK_COMPANY"),
    ) ,
    "WORK_POSITION" => array(
        "field" => "WORK_POSITION",
        "name" => Loc::getMessage("WORK_POSITION"),
    ) ,
    "PERSONAL_PHONE" => array(
        "field" => "PERSONAL_PHONE",
        "name" => Loc::getMessage("PERSONAL_PHONE"),
    ) ,
    "EMAIL" => array(
        "field" => "EMAIL",
        "name" => Loc::getMessage("SUB_EMAIL"),
    ) ,

    "PLUS_DAILY" => array(
        "field" => "PLUSDAILY",
        "name" => Loc::getMessage("SUB_PLUSDAILY"),
    ) ,
    "RETAYL_DAILY" => array(
        "field" => "RETAYLDAILY",
        "name" => Loc::getMessage("SUB_RETAYLDAILY"),
    ) ,
);
/*-----------------------------------------*/
?>

<?
//Формируем переменную $SUB_PARAM
$SUB_PARAM = array();
foreach ($arIBlockAvailProdFields as $field_name => $arField)
{
    $SUB_PARAM[$field_name] = "";
}
?>

<?
/*-----Панель закладок----------------*/
$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("IBLOCK_ADM_IMP_TAB1"),
        "ICON" => "iblock",
        "TITLE" => Loc::getMessage("IBLOCK_ADM_IMP_TAB1_ALT"),
    ) ,
    array(
        "DIV" => "edit2",
        "TAB" => Loc::getMessage("IBLOCK_ADM_IMP_TAB2") ,
        "ICON" => "iblock",
        "TITLE" => Loc::getMessage("IBLOCK_ADM_IMP_TAB2_ALT"),
    ) ,
    array(
        "DIV" => "edit3",
        "TAB" => Loc::getMessage("IBLOCK_ADM_IMP_TAB3") ,
        "ICON" => "iblock",
        "TITLE" => Loc::getMessage("IBLOCK_ADM_IMP_TAB3_ALT"),
    ) ,
    array(
        "DIV" => "edit4",
        "TAB" => Loc::getMessage("IBLOCK_ADM_IMP_TAB4") ,
        "ICON" => "iblock",
        "TITLE" => Loc::getMessage("IBLOCK_ADM_IMP_TAB4_ALT"),
    ) ,
);
$tabControl = new CAdminTabControl("tabControl", $aTabs, false, true);
/*------------------------------------*/
?>


<?
$ID = intval($ID);		// идентификатор редактируемой записи

$STEP = intval($STEP);
if ($STEP <= 0)
    $STEP = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["backButton"]) && strlen($_POST["backButton"]) > 0)
    $STEP = $STEP - 2;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["backButton2"]) && strlen($_POST["backButton2"]) > 0)
    $STEP = 1;
?>



<?
if ($REQUEST_METHOD == "POST"  && $STEP > 1 && check_bitrix_sessid()) {
    if ($STEP > 1) {
        /*---------------------Получаем путь к файлу и проверяем его------------*/

        $DATA_FILE_NAME = $_REQUEST["URL_DATA_FILE"];

        if (strlen($DATA_FILE_NAME) <= 0) {
            $strError .= Loc::getMessage("IBLOCK_ADM_IMP_NO_DATA_FILE_SIMPLE") . "<br>";
        } elseif (strtolower(GetFileExtension($URL_DATA_FILE)) != "csv") {
            $strError.= Loc::getMessage("IBLOCK_ADM_IMP_NOT_CSV")."<br>";
        }

        if (strlen($strError) > 0)
            $STEP = 1;
        /*-------------------------------------------------------------------------*/
    }

}

if ($STEP > 3 && check_bitrix_sessid()) {
    if (strlen($strError) > 0)
        $STEP = 3;
}

$APPLICATION->SetTitle(Loc::getMessage("IMPORT_TITLE").$STEP); //Заголовок окна с шагом
?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); // второй общий пролог
?>

<? CAdminMessage::ShowMessage($strError); ?>
<form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
    <?// проверка идентификатора сессии ?>
    <?echo bitrix_sessid_post();?>
    <input type="hidden" name="lang" value="<?=LANG?>">
    <?if($ID>0 && !$bCopy):?>
        <input type="hidden" name="ID" value="<?=$ID?>">
    <?endif;?>
    <?
    // отобразим заголовки закладок
    $tabControl->Begin();
    ?>
    <?
    //********************
    // первая закладка - форма редактирования параметров рассылки
    //********************
    $tabControl->BeginNextTab();
    ?>

        <?if ($STEP == 1) {?>
            <tr>
                <td width="40%"><?=Loc::getMessage("IBLOCK_ADM_IMP_DATA_FILE")?></td>
                <td width="60%">
                    <?
                    /*Получение списка полей пользователя
                        $userBy = "id";
                        $userOrder = "desc";
                        $filter = Array
                        (
                            "ID"                  => 1
                        );
                        $rsUsers = \CUser::GetList($userBy, $userOrder, $filter); // выбираем пользователей
                        if ($arResult['USER'] = $rsUsers->Fetch())
                        {
                            echo "<pre>";
                            print_r( $arResult['USER'] );
                            echo "</pre>";
                        }
                    */
                    ?>
                    <input type="text" name="URL_DATA_FILE" value="<?echo htmlspecialcharsbx($URL_DATA_FILE)?>" size="30">
                    <input type="button" value="<?=Loc::getMessage("IBLOCK_ADM_IMP_OPEN")?>" OnClick="BtnClick()">
                    <?CAdminFileDialog::ShowScript(array(
                            "event" => "BtnClick",
                            "arResultDest" => array(
                                "FORM_NAME" => "post_form",
                                "FORM_ELEMENT_NAME" => "URL_DATA_FILE",
                            ) ,
                            "arPath" => array(
                                "SITE" => SITE_ID,
                                "PATH" => "/".COption::GetOptionString("main", "upload_dir", "upload"),
                            ) ,
                            "select" => 'F', // F - file only, D - folder only
                            "operation" => 'O', // O - open, S - save
                            "showUploadTab" => true,
                            "showAddToMenuTab" => false,
                            "fileFilter" => 'csv',
                            "allowAllFiles" => true,
                            "SaveConfig" => true,
                        ));
                    ?>
                </td>
            </tr>
        <?}?>

    <?
    $tabControl->EndTab();
    ?>
    <?
    //********************
    // вторая закладка - параметры автоматической генерации рассылки
    //********************
    $tabControl->BeginNextTab();
    ?>
        <?if ($STEP == 2)
        {?>
            <tr class="heading">
                <td colspan="2"><?=Loc::getMessage("IBLOCK_ADM_IMP_FIELDS_SOOT")?></td>
            </tr>
            <tr>
                <?
                $sContent = "";
                $arFile = array();

                if (strlen($DATA_FILE_NAME) > 0)
                {
                    $DATA_FILE_NAME = trim(str_replace("\\", "/", trim($DATA_FILE_NAME)) , "/");
                    $FILE_NAME = rel2abs($_SERVER["DOCUMENT_ROOT"], "/".$DATA_FILE_NAME);
                    if (
                        (strlen($FILE_NAME) > 1)
                        && ($FILE_NAME == "/".$DATA_FILE_NAME)
                        && $APPLICATION->GetFileAccessPermission($FILE_NAME) >= "W"
                    )
                    {
                        $f = $io->GetFile($_SERVER["DOCUMENT_ROOT"].$FILE_NAME);
                        $file_id = $f->open("rb");

                        $sContent = fread($file_id, 1000000);
                        fclose($file_id);
                    }
                }
                ?>

                <?
                    /*----- Преобразовываем текст в массив построчно -----*/
                    $subscribses_file = explode("\n", $sContent);
                    /*----- Преобразовываем первую строку в массив ------*/
                    $fields = explode(";", $subscribses_file[0]);
                    $COUNT_FIELDS = count($fields);
                    /*----- Составляем список полей для соответствия -----*/
                    $arAvailFields = array();
                    foreach ($arIBlockAvailProdFields as $field_name => $arField)
                    {
                        $arAvailFields[] = array(
                            "value" => $field_name,
                            "name" => $arField["name"],
                        );
                    }

                    foreach ($fields as $i => $field)
                    {
                        ?>
                        <tr>
                            <td width="40%">
                                <b><?echo htmlspecialcharsbx($field)?>:
                            </td>
                            <td width="60%">
                                <select name="field_<?echo $i ?>">
                                    <option value=""> - </option>
                                    <?
                                    foreach ($arAvailFields as $ar)
                                    {
                                        $bSelected = ${"field_".$i} == $ar["value"];
                                        if (!$bSelected && !isset(${"field_".$i}))
                                            $bSelected = $ar["value"] == $field;

                                        if (!$bSelected && !isset(${"field_".$i}))
                                            $bSelected = $ar["code"] == $field;
                                        ?>
                                        <option value="<?echo $ar["value"] ?>" <?
                                        if ($bSelected)
                                            echo "selected" ?>><?echo htmlspecialcharsbx($ar["name"])?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?
                    }
                    /*------------------------------------------------------*/
                ?>
                <input type="hidden" name="NUM_FIELDS" value="<?=$COUNT_FIELDS?>">
            </tr>


            <tr class="heading">
                <td colspan="2"><?=Loc::getMessage("IBLOCK_ADM_IMP_DATA_SAMPLES")?></td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <textarea wrap="OFF" rows="10" cols="80" style="width:100%"><?echo htmlspecialcharsbx($sContent)?></textarea>
                </td>
            </tr>
        <?}?>
    <?
    $tabControl->EndTab();
    ?>

    <?$tabControl->BeginNextTab();?>
        <?if ($STEP == 3) {?>
            <tr class="heading">
                <td colspan="2"><?=Loc::getMessage("CHECK_SUB")?></td>
            </tr>
            <tr>
                <td>
                    <?
                    /*------------ Устанавливаем соответствие полей файла и параметров подписчика ----------------*/

                    $count_fields = $_POST["NUM_FIELDS"];
                    for ($i=0; $i<$_POST["NUM_FIELDS"]; $i++) {
                        if ($_POST["field_".$i] != "") {
                            $SUB_PARAM[$_POST["field_" . $i]] = $i;
                        }
                    }

                    if ($SUB_PARAM["EMAIL"] == "") {
                        $strError .= Loc::getMessage("NO_EMAIL") . "<br>";
                    }
                    /*------------ -------------------------------------------------------------- ----------------*/
                    ?>


                    <?
                    //Проверка соответсвий полей.
                    foreach ($arIBlockAvailProdFields as $field_name => $arField)
                    {
                        ?>
                         <p><b><?=$arField["name"]?></b> - <?if ($SUB_PARAM[$field_name]==""){echo "Столбец не задан"; } else { ?><?echo "Столбец № ".$num=$SUB_PARAM[$field_name]+1?></p> <?}?>
                        <?
                    }
                    ?>


                    <input type="hidden" name="NUM_FIELDS" value="<?=$count_fields?>">
                </td>
            </tr>
        <?}?>
    <? $tabControl->EndTab();?>

    <?$tabControl->BeginNextTab();?>
        <?if ($STEP == 4) {?>
            <tr class="heading">
                <td colspan="2"><?=Loc::getMessage("REZULT_SUB")?></td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <?/*----------------- Добавляем подписчиков------------------------*/?>
                    <?
                    $SUBSCRIBE_FILE = array(); //Содержимое файла с подписчиками
                    $SUBSCRIBE_LINE = array(); //Строка из таблицы с подписчиками
                    ?>

                    <?
                       $count_fields = $_POST["NUM_FIELDS"];
                       for ($i=0; $i<$_POST["NUM_FIELDS"]; $i++) {
                           if ($_POST["field_".$i] != "") {
                               $SUB_PARAM[$_POST["field_" . $i]] = $i;
                           }
                       }
                    ?>

                    <?/*Убираем первую строку у файла и преобразовываем весь файл в массив*/?>
                    <?

                    if (strlen($DATA_FILE_NAME) > 0)
                    {
                        $DATA_FILE_NAME = trim(str_replace("\\", "/", trim($DATA_FILE_NAME)) , "/");
                        $FILE_NAME = rel2abs($_SERVER["DOCUMENT_ROOT"], "/".$DATA_FILE_NAME);
                        if (
                            (strlen($FILE_NAME) > 1)
                            && ($FILE_NAME == "/".$DATA_FILE_NAME)
                            && $APPLICATION->GetFileAccessPermission($FILE_NAME) >= "W"
                        )
                        {
                            $f = $io->GetFile($_SERVER["DOCUMENT_ROOT"].$FILE_NAME);
                            $file_id = $f->open("rb");

                            $sContent = fread($file_id, 1000000);
                            fclose($file_id);
                        }
                    }

                    $SUBSCRIBE_FILE = explode("\n", $sContent);
                    unset($SUBSCRIBE_FILE[0]);

                    $countSubscribe = 0;

                    //Определяем список всех доступных сайтов
                    $arLid = array(); // Список всех доступных сайтов
                    $rsSites = CSite::GetList($by="sort", $order="desc", Array("ACTIVE" => "Y"));
                    while ($arSite = $rsSites->Fetch())
                    {
                        $arLid[] = $arSite["LID"];
                    }

                    //Перебираем все строки в файле
                    foreach ($SUBSCRIBE_FILE as $data) {
                        $SUBSCRIBE_LINE = explode(";", $data);
						$USER_FIELDS = array();//Массив пользовательских полей для передачи нашему классу

						$WorkWithSubscribe->arLid = $arLid;

                        foreach ($SUB_PARAM as $sub_param_name => $sub_param_numberfield){
                            if ($sub_param_name != "RETAYL_DAILY" and $sub_param_name != "PLUS_DAILY") {
                                if ($sub_param_numberfield > 0) {
                                    $USER_FIELDS[$sub_param_name] = $SUBSCRIBE_LINE[intval($sub_param_numberfield)];
                                }
                            }
                        }
                        $WorkWithSubscribe->USER_FIELDS = $USER_FIELDS;

                        $WorkWithSubscribe->subRL = (intval($SUB_PARAM["RETAYL_DAILY"]) > 0) ? strtolower($SUBSCRIBE_LINE[intval($SUB_PARAM["RETAYL_DAILY"])]) : "";
                        $WorkWithSubscribe->subPlus = (intval($SUB_PARAM["PLUS_DAILY"]) > 0) ? strtolower($SUBSCRIBE_LINE[intval($SUB_PARAM["PLUS_DAILY"])]) : "";

                        //Заносим подписчиков
                        if ($WorkWithSubscribe->RefreshSubscribe()) $countSubscribe++;

                    }
                    ?>

                    <p><?=Loc::getMessage("REFRESH_SUB")?></p>
                    <?if ($countSubscribe > 0) {?>
                        <p><?=Loc::getMessage("CREATED")?><b><?=$countSubscribe?></b><?=Loc::getMessage("NEW_SUBSCRIBE")?></p>
                    <?} ?>
                    <?/*---------------------------------------------------------------*/?>
                </td>
            </tr>
        <?}?>
    <? $tabControl->EndTab();?>

    <?// завершение формы - вывод кнопок сохранения изменений
    $tabControl->Buttons();
    ?>

    <? if ($STEP < 4){ ?> <input type="hidden" name="STEP" value="<?echo $STEP + 1?>"> <?}?>
    <?echo bitrix_sessid_post()?>

    <?if (($STEP > 1) && ($STEP < 4)) { ?>
        <input type="hidden" name="URL_DATA_FILE" value="<?echo htmlspecialcharsbx($DATA_FILE_NAME)?>">
        <input type="submit" name="backButton" value="&lt;&lt; <?=Loc::getMessage("IBLOCK_ADM_IMP_BACK")?>">
    <?}?>

    <?if ($STEP < 4) { ?>
        <input type="submit" value="<?echo ($STEP == 3) ? Loc::getMessage("IBLOCK_ADM_IMP_NEXT_STEP_F") : Loc::getMessage("IBLOCK_ADM_IMP_NEXT_STEP")?> &gt;&gt;" name="submit_btn" class="adm-btn-save">
    <?}?>

    <? if ($STEP <> 2){ ?>

        <?foreach ($_POST as $name => $value) { ?>
            <?if (preg_match("/^field_(\\d+)$/", $name)){ ?>
                <input type="hidden" name="<? echo $name ?>" value="<? echo htmlspecialcharsbx($value) ?>">
            <?}?>
        <?}?>

    <?}?>

    <?
    // завершаем интерфейс закладки
    $tabControl->End();
    ?>
</form>

<script language="JavaScript">
    <!--
    <?if ($STEP < 2): ?>
    tabControl.SelectTab("edit1");
    tabControl.DisableTab("edit2");
    tabControl.DisableTab("edit3");
    tabControl.DisableTab("edit4");
    <?elseif ($STEP == 2): ?>
    tabControl.SelectTab("edit2");
    tabControl.DisableTab("edit1");
    tabControl.DisableTab("edit3");
    tabControl.DisableTab("edit4");
    <?elseif ($STEP == 3): ?>
    tabControl.SelectTab("edit3");
    tabControl.DisableTab("edit1");
    tabControl.DisableTab("edit2");
    tabControl.DisableTab("edit4");
    <?elseif ($STEP > 3): ?>
    tabControl.SelectTab("edit4");
    tabControl.DisableTab("edit1");
    tabControl.DisableTab("edit2");
    tabControl.DisableTab("edit3");
    <?endif?>
    //-->
</script>

<?/*echo BeginNote();?>
<span class="required">*</span><?echo Loc::getMessage("REQUIRED_FIELDS")?>
<?echo EndNote();*/?>

<?require ($DOCUMENT_ROOT."/bitrix/modules/main/include/epilog_admin.php");
?>
