<?
foreach ($arResult["ITEMS"] as $key => $arItem) {

        $arPhotoSmall = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"],
            array("width" => 280, "height" => 180),
            BX_RESIZE_IMAGE_EXACT, true
        );

        $arFields["PREVIEW_PICTURE_SRC"] = $arPhotoSmall["src"];

    $arResult["ITEMS"][$key]["IMPORTANT_ARTICLE"] = $arFields;
}

