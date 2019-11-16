<?php
foreach($arResult["ARTICLES"] as $key => $arItem){
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

$arFileTmp = CFile::ResizeImageGet(
    $arResult["DETAIL_PICTURE"]["ID"],
    array("width" => 380, "height" => 492),
    BX_RESIZE_IMAGE_PROPORTIONAL_ALT ,
    true,
    false,
    false,
    75
);
$arResult["DETAIL_PICTURE"]["SRC"] = $arFileTmp["src"];

//Добавим поле PREVIEW_TEXT в $arResult, так, чтобы его было видно в component_epilog.php
$cp = $this->__component; // объект компонента

if (is_object($cp))
{
    // добавим в arResult компонента поля
    $cp->arResult['FIELD_DESCRIPTION'] = $arResult['~PREVIEW_TEXT'];
    $cp->SetResultCacheKeys(array('FIELD_DESCRIPTION'));

    // сохраним их в копии arResult, с которой работает шаблон
    $arResult['FIELD_DESCRIPTION'] = $cp->arResult['FIELD_DESCRIPTION'];
}

$this->SetViewTarget('OG_PICTURE');
echo '<meta property="og:image" content="http://'.$_SERVER['HTTP_HOST'].$arResult["PREVIEW_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:secure_url" content="https://'.$_SERVER['HTTP_HOST'].$arResult["PREVIEW_PICTURE"]["SRC"].'" />';
echo '<meta property="og:image:type" content="'.$arResult["PREVIEW_PICTURE"]["CONTENT_TYPE"].'" />';
echo '<meta property="og:image:width" content="'.$arResult["PREVIEW_PICTURE"]["WIDTH"].'">';
echo '<meta property="og:image:height" content="'.$arResult["PREVIEW_PICTURE"]["HEIGHT"].'">';
$this->EndViewTarget();