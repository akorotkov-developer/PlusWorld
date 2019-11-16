<?php
    \CModule::IncludeModule('iblock');

$elems = array();
//Получем прошедшие мероприятия
$arFilter = array('IBLOCK_ID' => "58",'<=DATE_ACTIVE_FROM' => date("d.m.Y"));

        $rs = CIBlockElement::GetList(
            array("SORT"=>"ASC"), //Сортировка
            $arFilter, //Фильтр значению полей
            false, //Массив полей группировка
            false, //Параметр для постраничной навигации
            array("ID", "ACTIVE_FROM", "DETAIL_PAGE_URL", "NAME") //Массив возвращаемых полей
        );


        while($ar = $rs->GetNext()) {
            $elems[] = $ar;
        }

//Получаем будущие мероприятия
$arFilter = array('IBLOCK_ID' => "58",'>=DATE_ACTIVE_FROM' => date("d.m.Y"));

$rs = CIBlockElement::GetList(
    array("SORT"=>"ASC"), //Сортировка
    $arFilter, //Фильтр значению полей
    false, //Массив полей группировка
    false, //Параметр для постраничной навигации
    array("ID", "ACTIVE_FROM", "DETAIL_PAGE_URL", "NAME") //Массив возвращаемых полей
);

while($ar = $rs->GetNext()) {
    $elems[] = $ar;
}

$arResult["CUSTOM_ITEMS"] = $elems;

//Приведем все даты к единому виду в массиве
foreach ($arResult["CUSTOM_ITEMS"] as $key => $arItem) {
    $date = date("d.m.Y", strtotime($arItem["ACTIVE_FROM"]));
    $arResult['CUSTOM_ITEMS'][$key]["FORMATED_DATE"] = $date;
}