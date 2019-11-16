<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

$arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'GLOBAL_ACTIVE'=>'Y', 'CODE'=>$arParams["PARENT_SECTION_CODE"] );
$cat_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("ID"));
$cat_list->NavStart(1);
if ($cat_result = $cat_list->GetNext()):
    $PARENT_CAT_ID = $cat_result["ID"];

endif;

foreach($arResult["ITEMS"] AS $k=>$data):

    if ($PARENT_CAT_ID):
        $arSelect = Array("ID", "DETAIL_TEXT");
        $arFilter = Array("IBLOCK_ID"=>IntVal($arParams["DESCRIPTION_IBLOCK_ID"]),"PROPERTY_FIRM" => $data['ID'], "PROPERTY_CATEGORY" => $PARENT_CAT_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $descRes = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        if ($ob = $descRes->Fetch())
        {
            if (intval($arParams["PREVIEW_TRUNCATE_LEN"]) > 0):
                $arResult["ITEMS"][$k]["PREVIEW_TEXT"] = truncate($ob["DETAIL_TEXT"], $arParams["PREVIEW_TRUNCATE_LEN"], "&hellip;");
            else:
                $arResult["ITEMS"][$k]["PREVIEW_TEXT"] = $ob["DETAIL_TEXT"];
            endif;
        }
    endif;


    if(is_array($data["PREVIEW_PICTURE"]))
    {
    	$arFilter = '';
    	if($arParams["SHARPEN"] != 0)
    	{
    		$arFilter = array("name" => "sharpen", "precision" => $arParams["SHARPEN"]);
    	}

    	$arFileTmp = CFile::ResizeImageGet(
    		$data['PREVIEW_PICTURE'],
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


//if(isset($_REQUEST['dd']))print_r($arItem["ARTICLES"]);
//if(isset($_REQUEST['dd'])){echo "<pre>";print_r($sectionID);echo "</pre>";};