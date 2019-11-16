<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

	if($arResult["PROPERTIES"]["PARTNER"]["VALUE"])
	{
		$rsFile = CFile::GetByID($arResult["PROPERTIES"]["PARTNER"]["VALUE"]);
		//if ($_REQUEST["rt"]==1) {echo "111<pre>"; print_r ($rsFile); echo "</pre>";}
        $arFile = $rsFile->Fetch();
		//if ($_REQUEST["rt"]==1) {echo "111<pre>"; print_r ($arFile); echo "</pre>";
		//echo '/upload/'.$arFile["SUBDIR"].'/'.$arFile["FILE_NAME"]
		//}
		$arFileTmp = CFile::ResizeImageGet(
			$arFile,
			array("width" => "100", "height" => "60"),
			BX_RESIZE_IMAGE_PROPORTIONAL,
			true
		);
        if ($arFileTmp["src"]=="") {$arFileTmp["src"]='/upload/'.$arFile["SUBDIR"].'/'.$arFile["FILE_NAME"];}
		$arResult["PROPERTIES"]["PARTNER"]["PREVIEW_IMG_SMALL"] = array(
			"SRC" => $arFileTmp["src"],
			"WIDTH" => $arFileTmp["width"],
			"HEIGHT" => $arFileTmp["height"],
		);
	}

	if ($arResult["PREVIEW_TEXT"] != "") {
        $APPLICATION->SetPageProperty("description", $arResult["PREVIEW_TEXT"]);
        $APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='".$arResult["PREVIEW_TEXT"]."'>");
    }
?>