<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<div class="cell medium-9 large-6">

    <div class="show-for-small-only banneronsidbar">
        <?
        // включаемая область для раздела
        $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/newslist_banner_top.php", Array(), Array());
        ?>
    </div>

    <span class="h6_title hide-for-small-only">Все новости</span>
    <div class="show-for-small-only">
        <h1 class="news-header__title">Все новости</h1>
        <hr>
    </div>
    <?
    $count = 0;
    $last = "";
    $countElements = count($arResult["ITEMS"]);
    ?>

    <?foreach($arResult["ITEMS"] as $arItem):?>
    <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <?$count++;?>

        <?
        if ($count == $countElements) {
            $last = "info_last";
        }
        ?>

        <a id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="info <?=$last?>" href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
            <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                <div class="info__line">
                    <?
                    if (!function_exists("rsdate")) {
                        function rsdate($param, $time = 0)
                        {
                            if (intval($time) == 0) $time = time();
                            $MonthNames = array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
                            if (strpos($param, 'M') === false) return date($param, $time);
                            else return date(str_replace('M', $MonthNames[date('n', $time) - 1], $param), $time);
                        }
                    }
                    ?>
                    <div class="info__date"><?echo rsdate("H:i, d M", strtotime($arItem["ACTIVE_FROM"]));?></div>
                </div>
            <?endif?>
            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                <div class="info__title"><?echo $arItem["NAME"]?></div>
            <?endif;?>
        </a>
        <?if ($count == 3) {?>
            <div class="hide-for-small-only">
                <?
                // включаемая область для раздела
                $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/newslist_banner.php", Array(), Array());
                ?>
            </div>
        <?}?>

    <?endforeach;?>

    <div class="margin-bottom-7">
        <a class="button button_arrow hollow" href="/news/">
            Читайте все новости
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 19 19" width="19" height="19" fill="#B71852" stroke="#B71852">
               <path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/>
            </svg>
        </a>
    </div>

</div>
