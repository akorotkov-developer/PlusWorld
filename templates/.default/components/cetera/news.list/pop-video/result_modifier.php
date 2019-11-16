<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
# обрезать массив до 4 элементов 
$arResult["ITEMS"] = array_slice($arResult["ITEMS"], 0, $arParams["ELEMENT_COUNT"]);
foreach($arResult["ITEMS"] as $k => $arItem)
{
   if (empty($arItem["PREVIEW_PICTURE"]))
    {
        $findkey = preg_match("/^.*[youtube.com|youtu.be]\/.*[v\/|\?v=|embed\/]([a-zA-Z0-9]{11}).*$/",$arItem["PROPERTIES"]["VIDEO"]["VALUE"]["TEXT"], $matches);

        if ($matches[1])
        {
            $arResult["ITEMS"][$k]["PREVIEW_PICTURE"]["SRC"] = "http://img.youtube.com/vi/{$matches[1]}/default.jpg";
            $arResult["ITEMS"][$k]["PREVIEW_PICTURE"]["WIDTH"] = 120;
            $arResult["ITEMS"][$k]["PREVIEW_PICTURE"]["HEIGHT"] = "";
        }
    }
    else
    {
        if(is_array($arItem["PREVIEW_PICTURE"]))
        {
        	$arFilter = '';
        	if($arParams["SHARPEN"] != 0)
        	{
        		$arFilter = array("name" => "sharpen", "precision" => $arParams["SHARPEN"]);
        	}

        	$arFileTmp = CFile::ResizeImageGet(
        		$arItem['PREVIEW_PICTURE'],
        		array("width" => 120, "height" => 120),
        		BX_RESIZE_IMAGE_PROPORTIONAL,
        		true, $arFilter
        	);

        	$arResult["ITEMS"][$k]['PREVIEW_PICTURE'] = array(
        		'SRC' => $arFileTmp["src"],
        		'WIDTH' => $arFileTmp["width"],
        		'HEIGHT' => $arFileTmp["height"],
        	);
        }
    }
}

?>
