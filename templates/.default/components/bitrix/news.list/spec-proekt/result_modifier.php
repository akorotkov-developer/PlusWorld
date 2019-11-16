<?
/*foreach ($arResult["ITEMS"] as $key => $item) {

    $arPhotoSmall = CFile::ResizeImageGet(
        $item["PREVIEW_PICTURE"]["ID"],
        $fileID,
        array("width" => 580, "height" => 344),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true
    );

    $arResult["ITEMS"][$key]["PICTURE"]["SRC"] = $arPhotoSmall["src"];
}*/