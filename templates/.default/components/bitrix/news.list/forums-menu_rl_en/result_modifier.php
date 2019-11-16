<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["ITEMS"] as $k => $v)
{
    $forum_user = $USER->GetID();
    
    $IBLOCK_ID = '49';
    
    $rsElement = CIBlockElement::GetList(array(), array(
        "IBLOCK_ID" => $IBLOCK_ID,
        "PROPERTY_USER" => $forum_user,
    ), false, false, array());

    $arResult["ITEMS"][$k]["STATUS"] = '0'; 
    if ($obElement = $rsElement->GetNext()) // существующая
    {
        $arResult["ITEMS"][$k]["STATUS"] = '1'; 
    }
    
}	

?>