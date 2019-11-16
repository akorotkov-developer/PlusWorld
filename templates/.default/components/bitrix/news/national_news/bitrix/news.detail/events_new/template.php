<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if (strlen($arResult["PROPERTIES"]["META_TITLE"]["VALUE"])>3) {$title_page = $arResult["PROPERTIES"]["META_TITLE"]["VALUE"];} else {$title_page = $arResult["NAME"];}
$APPLICATION->SetPageProperty("title", $title_page);
if (strlen($arResult["PROPERTIES"]["META_KEYS"]["VALUE"])>3) {
$APPLICATION->SetPageProperty("keywords", $arResult["PROPERTIES"]["META_KEYS"]["VALUE"]);
}
if (strlen($arResult["PROPERTIES"]["META_DESC"]["VALUE"])>3) {
$APPLICATION->SetPageProperty("description", $arResult["PROPERTIES"]["META_DESC"]["VALUE"]);
}?>

<div class="padding-bottom-6">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell small-24 medium-10 large-8 medium-order-2">
                <div class="padding-6 margin-bottom-6 radius background-main">
                    <div class="text-size-xxlarge text-secondary margin-bottom-3">
                        <?echo $arResult["DISPLAY_ACTIVE_FROM"];
                        if ($stmp = MakeTimeStamp($arResult["DATE_ACTIVE_TO"], "DD.MM.YYYY"))
                        {
                            echo " - ".date("d.m.Y", $stmp);
                        }?>
                    </div>
                    <div class="text-size-large margin-bottom-6">
                        <i title="Место проведения" class="fas fa-map-marker-alt"></i>
                        <strong><?if (strlen($arResult["PROPERTIES"]["PLACE"]["VALUE"])>3) {echo "&nbsp;&nbsp;&nbsp;".$arResult["PROPERTIES"]["PLACE"]["VALUE"];}?></strong>
                        <br>
                        <img title="Организатор" style="width: 12px;" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/avatar.svg">
                        <strong>&nbsp;&nbsp;&nbsp;<?=$arResult["PROPERTIES"]["ORGANIZER"]["VALUE"]?></strong>
                    </div>
                    <a class="button secondary expanded margin-bottom-0" href="<?=trim($arResult["PROPERTIES"]["ORGANIZER_URL"]["VALUE"]);?>">Регистрация</a>
                </div>
            </div>
            <div class="cell small-24 medium-14 large-16 medium-order-1">
                <div style="width: 29%; float: left; text-align: right;">
                    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["PROPERTIES"]["PARTNER"]["PREVIEW_IMG_SMALL"])):?>
                        <div class="news-picture">
                            <img class="preview_picture" border="0" src="<?=$arResult["PROPERTIES"]["PARTNER"]["PREVIEW_IMG_SMALL"]["SRC"]?>" alt="<?if ($arResult["PROPERTIES"]["PARTNER_STATUS"]["VALUE"]) {echo $arResult["PROPERTIES"]["PARTNER_STATUS"]["VALUE"];} else {echo $arResult["NAME"];}?>" title="<?if ($arResult["PROPERTIES"]["PARTNER_STATUS"]["VALUE"]) {echo $arResult["PROPERTIES"]["PARTNER_STATUS"]["VALUE"];} else {echo $arResult["NAME"];}?>" />
                        </div>
                    <?endif?>
                </div>
                <div class="clear"></div>
                <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
                    <p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
                <?endif;?>
                <?if($arResult["NAV_RESULT"]):?>
                    <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
                    <?echo $arResult["NAV_TEXT"];?>
                    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
                <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
                    <div><?echo replaceRL($arResult["DETAIL_TEXT"]);?></div>
                <?else:?>
                    <div><?echo replaceRL($arResult["PREVIEW_TEXT"]);?></div>
                <?endif?>
            </div>
        </div>
    </div>
</div>

<div class="padding-top-12 padding-bottom-6">
    <hr>
    <div class="grid-container spec-projects">
        <h6>Анонс мероприятий</h6>
        <div class="grid-x grid-padding-x">
            <div class="cell large-16">
                <?
                $DateFrom = "01.01.2008";

                $arrFilter = array(">=PROPERTY_DATE" => ConvertDateTime($DateFrom, "YYYY-MM-DD")." 00:00:00");
                ?>
                <?$APPLICATION->IncludeComponent("bitrix:news.list","anons-preview",Array(
                        "FIELD_CODE" => Array("ID"),
                        "IBLOCK_ID" => "58",
                        "NEWS_COUNT" => 3,
                        "SORT_BY1" => "PROPERTY_DATE",
                        "SORT_ORDER1" => "DESC",
                        "FILTER_NAME" => "arrFilter",
                        "PROPERTY_CODE" => Array("DESCRIPTION","PLACE", "DATE", "TIME"),
                        "IBLOCK_TYPE" => "services_ip",
                    )
                );?>
            </div>
            <div class="cell large-8 text-center large-text-right datecollection">
                <?$APPLICATION->IncludeComponent("bitrix:news.list","anons-preview-calendare",Array(
                        "FIELD_CODE" => Array("ID"),
                        "IBLOCK_ID" => "58",
                        "NEWS_COUNT" => 10,
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "PROPERTY_CODE" => Array("DESCRIPTION","PLACE", "DATE", "TIME"),
                        "IBLOCK_TYPE" => "services_ip",
                    )
                );?>
            </div>
        </div>
        <div class="grid-x grid-padding-x align-center margin-bottom-10 margin-top-10">
            <?$APPLICATION->IncludeComponent("bitrix:news.list","slider-preview-events",Array(
                    "FIELD_CODE" => Array("ID"),
                    "IBLOCK_ID" => "121",
                    "IBLOCK_TYPE" => "NEWS_IP",
                    "NEWS_COUNT" => 30,
                    "PROPERTY_CODE" => Array("DESCRIPTION", "URL"),
                    "IBLOCK_TYPE" => "services_ip",
                )
            );?>
        </div>
    </div>
</div>

