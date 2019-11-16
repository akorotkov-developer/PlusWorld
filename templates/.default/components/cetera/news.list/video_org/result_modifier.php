<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach ($arResult["ITEMS"] AS $k=>$item):
if (empty($item["PREVIEW_PICTURE"]))
{
    $findkey = preg_match("/^.*[youtube.com|youtu.be]\/.*[v\/|\?v=|embed\/]([a-zA-Z0-9]{11}).*$/",$item["PROPERTIES"]["VIDEO"]["VALUE"]["TEXT"], $matches);

    if ($matches[1])
    {
        $arResult["ITEMS"][$k]["PREVIEW_PICTURE"]["SRC"] = "http://img.youtube.com/vi/{$matches[1]}/0.jpg";
        $arResult["ITEMS"][$k]["PREVIEW_PICTURE"]["WIDTH"] = 240;
        $arResult["ITEMS"][$k]["PREVIEW_PICTURE"]["HEIGHT"] = "";
    }
}
else{

        if(is_array($item["PREVIEW_PICTURE"]))
        {
        	$arFilter = '';
        	if($arParams["SHARPEN"] != 0)
        	{
        		$arFilter = array("name" => "sharpen", "precision" => $arParams["SHARPEN"]);
        	}

        	$arFileTmp = CFile::ResizeImageGet(
        		$item['PREVIEW_PICTURE'],
        		array("width" => 240, "height" => 180),
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
endforeach;

