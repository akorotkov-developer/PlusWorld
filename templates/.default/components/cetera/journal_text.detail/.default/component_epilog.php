<?php
if ($arParams["SET_META_DESCRIPTION"] != "Y") {
    if ($arResult['FIELD_DESCRIPTION']) {
        $APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . strip_tags($arResult['FIELD_DESCRIPTION']) . "'>");
    }
    $APPLICATION->SetPageProperty("description", strip_tags($arResult['FIELD_DESCRIPTION']));
}
