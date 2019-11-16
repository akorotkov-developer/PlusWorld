<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_r($arResult);?>
<?if(is_array($arResult))
{

    $obNext = CIBlockElement::GetList(array("NAME"=>"ASC"), array("SECTION_ID"=>$arResult["IBLOCK_SECTION_ID"], 'ACTIVE'=>'Y', 'IBLOCK_ID' => $arResult['IBLOCK_ID']),false, array("nElementID"=> $arResult["ID"],"nPageSize"=>"1"), array("ID","NAME","CODE"));
    while ($arNext =  $obNext->GetNext())
    {
        if ($arNext["ID"] == $arResult["ID"])
            $now =  $arNext["RANK"];
        $links[] = $arNext;
    }
    $next = 0;
    $prev = 0;
    foreach($links AS $k=>$v){
        if ($v["RANK"] < $now)
            $arResult["PREV"] = array("TITLE" => $v['NAME'], "LINK" => $v['CODE']);
        if ($v["RANK"] > $now)
            $arResult["NEXT"] = array("TITLE" => $v['NAME'], "LINK" => $v['CODE']);

    }


    $arSelect = Array("ID", "PROPERTY_CATEGORY", "DETAIL_TEXT");
    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams["DESCRIPTION_IBLOCK_ID"]),"PROPERTY_FIRM" => $arResult['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $descRes = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($ob = $descRes->GetNext())
    {
        $res = CIBlockSection::GetByID($ob["PROPERTY_CATEGORY_VALUE"]);
        $cattitle = '';
        if($ar_res = $res->GetNext())
        {
            $cattitle = $ar_res['NAME'];
            $arDesc[] = array("DESCRIPTION" => $ob["DETAIL_TEXT"], "CAT_TITLE" => $cattitle, "CAT_CODE" => $ar_res["CODE"]);
        }

    }
    $arResult["CAT_DESC"] = $arDesc;
}