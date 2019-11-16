<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$name1860 = '';
$res = CIBlockSection::GetByID(1860);
if($ar_res = $res->GetNext()) {
    $name1860 = $ar_res["NAME"];
    $url1860 = $ar_res["SECTION_PAGE_URL"];
}

function pluralForm($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}
?>

<?$i=0;?>
<?foreach($arResult["ITEMS"] as $arItem) {
    if ($i == count($arResult["ITEMS"]) - 1) {
        $lastChild = "article-preview__last";
    }
    ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <?$frame = $this->createFrame()->begin("");//Начало динамической области?>
    <?$i++;?>
    <div class="grid-x grid-padding-x article-preview" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])){?>
            <div class="cell large-8 text-center hide-for-small-only">
                <a href="<?=$arItem["DETAIL_PAGE_URL"].'?id='.$arItem["ID"]?>">
                    <img class="article-preview__image" src="<?=$arItem["PREVIEW"]["SRC"]?>" alt="<?=$arItem["NAME"]?>"/>
                </a>
            </div>
        <?}?>
        <?
        $counter = $arItem['SHOW_COUNTER'];
        if($counter < 1)
            $counter = 0;
        $counter = intval($counter);
        $text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
        ?>
        <div class="cell large-12 article-preview__content">
            <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["ACTIVE_FROM"]){?>
                <!--<div class="article-preview__date"><?/*=$counter*/?>,&nbsp; <?/*=$text_counter*/?></div>-->

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
                <div class="article-preview__date"><?echo rsdate("d M Y, H:i", strtotime($arItem["ACTIVE_FROM"]));?></div>
            <?}?>
            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]){?>
                <a class="article-preview__title <?=$lastChild?>" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <span class="newsarticles__titles-h2"><?echo $arItem["NAME"]?></span>
                </a>
            <?}?>
            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]){?>
                <p class="article-preview__text"><?echo mb_substr(strip_tags($arItem["PREVIEW_TEXT"]),0,200);?></p>
            <?}?>
        </div>
    </div>
    <?
    //TODO косяк с H1 надо разобраться
    /*if ($i == 3) {?>
        <div class="grid-x align-middle">
            <div class="cell large-14">
                <div class="margin-bottom-4">
                    <div class="text-center">
                        <?
                        // включаемая область для раздела
                        $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/banner_580_90.php", Array(), Array());
                        ?>
                    /div>
                </div>
            </div>
            <div class="cell large-offset-1 large-9">
                <?$APPLICATION->IncludeComponent("bitrix:sender.subscribe","short-subscribe",Array(
                        "COMPONENT_TEMPLATE" => ".default",
                        "USE_PERSONALIZATION" => "Y",
                        "CONFIRMATION" => "Y",
                        "SHOW_HIDDEN" => "Y",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_JUMP" => "Y",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "SET_TITLE" => "N"
                    )
                );?>
            </div>
        </div>
    <?}*/?>

    <?$frame->end(); // Конец фрейма?>
<?}?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>