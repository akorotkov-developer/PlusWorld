<?php
foreach($arResult["ITEMS"] as $key => $arItem){
    $arFileTmp = CFile::ResizeImageGet(
        $arItem["PREVIEW_PICTURE"],
        array("width" => 278, "height" => 170),
        BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
        true,
        false,
        false,
        75
    );
    $arResult["ITEMS"][$key]["PREVIEW"]["SRC"] = $arFileTmp["src"];
}