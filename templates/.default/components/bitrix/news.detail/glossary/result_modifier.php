<?php

$metaDescription = \Bitrix\Main\Type\Collection::firstNotEmpty(
    $arResult["PROPERTIES"], array($arParams["META_DESCRIPTION"], "VALUE")
    ,$arResult["IPROPERTY_VALUES"], "ELEMENT_META_DESCRIPTION"
);
if (is_array($metaDescription)) {
    $APPLICATION->SetPageProperty("description", implode(" ", $metaDescription), $arTitleOptions);
    $APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . implode(" ", $metaDescription) . "'>");
} elseif ($metaDescription != "") {
    $APPLICATION->SetPageProperty("description", $metaDescription, $arTitleOptions);
    $APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . $metaDescription . "'>");
} elseif ($arResult["PREVIEW_TEXT"] != "") {
    $APPLICATION->SetPageProperty("description", $arResult["PREVIEW_TEXT"]);
    $APPLICATION->SetPageProperty("og-description", "<meta property='og:description' content='" . $arResult["PREVIEW_TEXT"] . "'>");
}