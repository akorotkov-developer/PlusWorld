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

<?
$i = 1;
foreach($arResult["ITEMS"] as $arItem) {?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>

    <div class="grid-x grid-padding-x article-preview"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="cell large-8 text-center hide-for-small-only"><img class="article-preview__image" src="<?=$arItem["PREVIEW"]["SRC"]?>" alt="<?=$arItem["NAME"]?>"/></div>
        <div class="cell large-12">
            <?
            $counter = $arItem['SHOW_COUNTER'];
            if($counter < 1)
                $counter = 0;
            $counter = intval($counter);
            $text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
            ?>
            <div class="article-preview__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?>, <?=$counter?>&nbsp;<?=$text_counter?></div>
            <a class="article-preview__title" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <span class="newsarticles__titles-h2"><?=$arItem["NAME"]?></span>
            </a>
            <p class="article-preview__text"><?=mb_substr(strip_tags($arItem["PREVIEW_TEXT"]),0,200);?></p>
        </div>
    </div>

    <?
    if ($i == 1) {
        ?>
        <?
        // включаемая область для раздела
        $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/banner_580_90.php", Array(), Array());
        ?>
        <?
    }
    $i++;
    ?>
<?}?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <div class="rubric-navigation bot">
        <?=$arResult["NAV_STRING"]?>
    </div>
<?endif;?>
