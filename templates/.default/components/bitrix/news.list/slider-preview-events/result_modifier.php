<?
foreach ($arResult["ITEMS"] as $key => $arItem) {

        $arPhotoSmall = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            array("width" => 200, "height" => 140),
            BX_RESIZE_IMAGE_EXACT, true
        );

        $arFields["PREVIEW_PICTURE_SRC"] = $arPhotoSmall["src"];

    $arResult["ITEMS"][$key] = $arFields;
}

