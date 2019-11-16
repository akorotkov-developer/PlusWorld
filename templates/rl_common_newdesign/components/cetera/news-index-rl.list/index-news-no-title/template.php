<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<div class="blank__title">
    ФОРУМ
    <span class="text-dark-gray sdfsd">ЭКСПЕРТОВ</span>
</div>

<?
foreach($arResult["ITEMS"] as $arItem){?>

    <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>


    <a class="buy text-left" href="<?=$arItem["DETAIL_PAGE_URL"];?>">
        <div class="grid-x grid-padding-x">
            <div class="cell xlarge-10 buy__img text-center xlarge-text-left"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"></div>
            <div class="cell xlarge-14 buy__title align-self-middle text-center xlarge-text-left"><?echo $arItem["NAME"]?></div>
        </div>
        <?
        $preview = substr($arItem["PREVIEW_TEXT"], 0, 70);
        ?>
        <div class="buy__text"><?echo $preview?>...</div>
    </a>

<?}?>

<a class="button hollow expanded" href="/expert-forum/">Все статьи</a>

<script>
    $('.buy__img').each(function(i,elem) {
        var width = $(elem).width();
        console.log(width);
        $(elem).find('img').height(width);
    });
</script>