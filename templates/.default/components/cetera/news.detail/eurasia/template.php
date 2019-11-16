<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
</div>

<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="cell auto">
            <h2><?=$arResult["NAME"]?></h2>
            <img src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
            <br>

            <?if ($arResult["DISPLAY_PROPERTIES"]["ADDRESS"]):?><strong>Адрес: </strong> <?=$arResult["DISPLAY_PROPERTIES"]["ADDRESS"]["DISPLAY_VALUE"];?><br /><?endif;?>
            <?if ($arResult["DISPLAY_PROPERTIES"]["PHONE"]):?><strong>Телефон: </strong> <?=$arResult["DISPLAY_PROPERTIES"]["PHONE"]["DISPLAY_VALUE"];?><br /><?endif;?>
            <?if ($arResult["DISPLAY_PROPERTIES"]["FAX"]):?><strong>Факс: </strong> <?=$arResult["DISPLAY_PROPERTIES"]["FAX"]["DISPLAY_VALUE"];?><br /><?endif;?>
            <?if ($arResult["DISPLAY_PROPERTIES"]["EMAIL"]):?><strong>Email: </strong> <?=$arResult["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"];?><br /><?endif;?>
            <?$url = explode(",",$arResult["DISPLAY_PROPERTIES"]["URL"]["VALUE"]); ?>
            <?if (is_array($url) && !empty($url)):?><strong>Сайт: </strong> <?foreach($url AS $u){ echo '<a href="//'.trim($u).'" target="_blank">'.trim($u).'</a> &nbsp;';}?><br /><?endif;?>

            <br>
            <p>
                <?echo $arResult["DETAIL_TEXT"];?>
            </p>
        </div>
        <div class="cell medium-9 large-6">
            <?
            // включаемая область для раздела
            $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/newslist_banner.php", Array(), Array());
            ?>
        </div>
    </div>
</div>