<?php
$prevText = strip_tags(TruncateText($arResult["PREVIEW_TEXT"], 100));
/*$this->SetViewTarget('OG_DESCRIPTION');
echo '<meta property="og:description" content="'.$prevText.'" />';
$this->EndViewTarget();*/

\CModule::IncludeModule('iblock');

//Получаем свойства статьи
    $rs = CIBlockElement::GetList(
        array("SORT"=>"ASC"), //Сортировка
        array("IBLOCK_ID"=>$arResult["IBLOCK_ID"], "ID"=> $arResult["ID"]), //Фильтр значению полей
        false, //Массив полей группировка
        false, //Параметр для постраничной навигации
        array("ID", "NAME", "PROPERTY_RL_FULL_ACCESS", "PROPERTY_JOURNAL") //Массив возвращаемых полей
    );

    while($ar = $rs->GetNext()) {
        $fullAccess = $ar["PROPERTY_RL_FULL_ACCESS_VALUE"];
        $journalID = $ar["PROPERTY_JOURNAL_VALUE"];
    }

//Получаем свойства журнала
    $rs = CIBlockElement::GetList(
        array("SORT"=>"ASC"), //Сортировка
        array("IBLOCK_ID"=>40, "ID"=>$journalID), //Фильтр значению полей
        false, //Массив полей группировка
        false, //Параметр для постраничной навигации
        array("NAME", "DETAIL_PAGE_URL") //Массив возвращаемых полей
    );

    while($ar = $rs->GetNext()) {
        $name = $ar["NAME"];
        $journalURL = $ar["DETAIL_PAGE_URL"];
    }

$arResult["FULL_ACCESS"] =  $fullAccess;
$arResult["JOURNAL_NAME"] =  $name;
$arResult["JOURNAL_URL"] =  $journalURL;

//Проверяем есть у пользователя доступ к статье
global $USER;

$userGroup = CUser::GetUserGroup($USER->GetID());
$accessGroupUsers = array(1,13,12);
foreach ($userGroup as $group) {
    if (in_array($group, $accessGroupUsers) or !$fullAccess) {
        $arResult["FULL_ACCESS_FOR_USER"] = "Y";
    }
}

//Добавим поле PREVIEW_TEXT в $arResult, так, чтобы его было видно в component_epilog.php
$cp = $this->__component; // объект компонента

if (is_object($cp))
{
    // добавим в arResult компонента поля
    $cp->arResult['FIELD_DESCRIPTION'] = $arResult['~PREVIEW_TEXT'];
    $cp->SetResultCacheKeys(array('FIELD_DESCRIPTION'));

    // сохраним их в копии arResult, с которой работает шаблон
    $arResult['FIELD_DESCRIPTION'] = $cp->arResult['FIELD_DESCRIPTION'];
}

$this->SetViewTarget('OG_PICTURE');
echo '<meta property="og:image" content="http://'.$_SERVER['HTTP_HOST'].$arResult["PREVIEW_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:secure_url" content="https://'.$_SERVER['HTTP_HOST'].$arResult["PREVIEW_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:type" content="'.$arResult["PREVIEW_PICTURE"]["CONTENT_TYPE"].'" />';
echo '<meta property="og:image:width" content="'.$arResult["PREVIEW_PICTURE"]["WIDTH"].'">';
echo '<meta property="og:image:height" content="'.$arResult["PREVIEW_PICTURE"]["HEIGHT"].'">';
$this->EndViewTarget();