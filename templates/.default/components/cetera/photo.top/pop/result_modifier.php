<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["TD_WIDTH"] = round(100/$arParams["LINE_ELEMENT_COUNT"])."%";
$arResult["nRowsPerItem"] = 2; //Image and Name
$arResult["bDisplayFields"] = count($arParams["FIELD_CODE"])>0;
//print_r($arResult);

	foreach($arResult["ITEMS"] as $k => $arItem)
	{
		if(count($arItem["DISPLAY_PROPERTIES"])>0)
			$arResult["bDisplayFields"] = true;
		if($arResult["bDisplayFields"])
			break;


        if(is_array($arItem["PICTURE"]))
        {
        	$arFilter = '';
        	if($arParams["SHARPEN"] != 0)
        	{
        		$arFilter = array("name" => "sharpen", "precision" => $arParams["SHARPEN"]);
        	}

        	$arFileTmp = CFile::ResizeImageGet(
        		$arItem['PICTURE'],
        		array("width" => $arParams["PHOTO_SIZE"], "height" => ceil($arParams["PHOTO_SIZE"]/8)*5),
        		BX_RESIZE_IMAGE_PROPORTIONAL,
        		true, $arFilter
        	);

        	$arResult["ITEMS"][$k]['PICTURE'] = array(
        		'SRC' => $arFileTmp["src"],
        		'WIDTH' => $arFileTmp["width"],
        		'HEIGHT' => $arFileTmp["height"],
        	);
        }
    }
/*
if($arResult["bDisplayFields"])
	$arResult["nRowsPerItem"]++; // Plus one row for fields
//array_chunk
foreach($arResult["SECTIONS"] as $section_id=>$arSection)
{
	$arResult["SECTIONS"][$section_id]["ROWS"] = array();
	while(count($arSection["ITEMS"])>0)
	{
		$arRow = array_splice($arSection["ITEMS"], 0, $arParams["LINE_ELEMENT_COUNT"]);
		while(count($arRow) < $arParams["LINE_ELEMENT_COUNT"])
			$arRow[]=false;
		$arResult["SECTIONS"][$section_id]["ROWS"][]=$arRow;
	}
}*/
?>
