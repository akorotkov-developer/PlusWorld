<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
if( !function_exists('pluralForm') ){
    function pluralForm($n, $form1, $form2, $form5)
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $form5;
        if ($n1 > 1 && $n1 < 5) return $form2;
        if ($n1 == 1) return $form1;
        return $form5;
    }
}
?>

<div class="grid-x">
    <div class="cell auto">
        <h1 class="margin-bottom-0">ВСЕ НОВОСТИ</h1>
    </div>
    <div class="cell shrink align-self-bottom"><a class="button hollow button_low" href="/articles/">Статьи</a></div>
</div>
<hr>

<?$showHr = false;?>
<?$showHr = false; $q = RandString(5);?>
<?$i=0;?>
<?foreach($arResult["ITEMS"] as $arItem){?>
    <?
    $this->AddEditAction($arItem['ID']."_".$q, $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID']."_".$q, $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"));
    ?>
    <div class="grid-x grid-padding-x article-preview" id="<?=$this->GetEditAreaId($arItem['ID']."_".$q);?>">
        <?if($arParams["DISPLAY_PICTURE"]!="N") {?>
            <div class="cell large-8 text-center hide-for-small-only">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <img class="article-preview__image"  src="<?=$arItem["PREVIEW_IMG"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"/>
                </a>
            </div>
        <?}?>
        <div class="cell large-12">
            <?$frame = $this->createFrame()->begin("");//Начало динамической области?>
                <?
                $counter = $arItem['SHOW_COUNTER'];
                if($counter < 1)
                    $counter = 0;
                $counter = intval($counter);
                $text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
                ?>

                <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                    <div class="article-preview__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?>, <?=$counter?>&nbsp;<?=$text_counter?></div>
                <?endif?>

                <?if ($arItem["PROPERTIES"]["REDIRECT"]["VALUE"] !="") {?>
                    <a class="article-preview__title" href="<?=$arItem["PROPERTIES"]["REDIRECT"]["VALUE"]?>">
                        <span class="newsarticles__titles-h2"><?echo $arItem["NAME"]?></span>
                    </a>
                <?} else {?>
                    <a class="article-preview__title" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                        <span class="newsarticles__titles-h2"><?echo $arItem["NAME"]?></span>
                    </a>
                <?}?>
                <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                    <p class="article-preview__text"><?echo $arItem["PREVIEW_TEXT"];?></p>
                <?endif;?>
            <?$frame->end(); // Конец фрейма?>
        </div>
    </div>
    <?
    if ($i == 0) {
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
    <br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
