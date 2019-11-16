<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["ITEMS"] AS $k=>$data):

    if ($data["IBLOCK_SECTION_ID"]):
        $cat_list = CIBlockSection::GetByID($data["IBLOCK_SECTION_ID"]);

        if ($cat_result = $cat_list->GetNext()):
            $arResult["ITEMS"][$k]["SECTION"] = $cat_result;
        endif;
    endif;


    if(is_array($data["DETAIL_PICTURE"]))
    {
    	$arFilter = '';
    	if($arParams["SHARPEN"] != 0)
    	{
    		$arFilter = array("name" => "sharpen", "precision" => $arParams["SHARPEN"]);
    	}

    	$arFileTmp = CFile::ResizeImageGet(
    		$data['DETAIL_PICTURE'],
    		array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
    		BX_RESIZE_IMAGE_PROPORTIONAL,
    		true, $arFilter
    	);

    	$arResult["ITEMS"][$k]['PREVIEW_PICTURE'] = array(
    		'SRC' => $arFileTmp["src"],
    		'WIDTH' => $arFileTmp["width"],
    		'HEIGHT' => $arFileTmp["height"],
    	);
    }
endforeach;

