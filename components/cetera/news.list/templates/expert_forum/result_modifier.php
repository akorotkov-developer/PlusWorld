<?php
foreach($arResult["ITEMS"] as $key => $arItem){
    if (isset($arItem["PROPERTIES"]["REDIRECT"]["VALUE"]) and (strlen($arItem["PROPERTIES"]["REDIRECT"]["VALUE"])>0)) {
        $showCounterRedirect = showCounterRedirect($arItem["PROPERTIES"]["REDIRECT"]["VALUE"]);
        if ($showCounterRedirect > 0) {
            $arResult["ITEMS"][$key]["SHOW_COUNTER"] = $showCounterRedirect;
        }
    }


    if (is_array($arItem["FIELDS"]["DETAIL_PICTURE"])) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["FIELDS"]["DETAIL_PICTURE"]["ID"],
            array("width" => 280, "height" => 197),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            true,
            false,
            false,
            75
        );
        $arResult["ITEMS"][$key]["PREVIEW"]["SRC"] = $arFileTmp["src"];
    } else {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            array("width" => 280, "height" => 197),
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
            true,
            false,
            false,
            75
        );
        $arResult["ITEMS"][$key]["PREVIEW"]["SRC"] = $arFileTmp["src"];
    }
}