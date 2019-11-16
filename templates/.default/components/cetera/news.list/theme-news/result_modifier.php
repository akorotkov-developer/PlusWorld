<?php
foreach($arResult["ITEMS"] as $key => $arItem) {
    $arFileTmp = CFile::ResizeImageGet(
        $arItem["DETAIL_PICTURE"],
        array("width" => 230, "height" => 165),
        BX_RESIZE_IMAGE_EXACT,
        true,
        false,
        false,
        75
    );
    $arResult["ITEMS"][$key]["DETAIL_PICTURE"]["SRC"] = $arFileTmp["src"] ;
}