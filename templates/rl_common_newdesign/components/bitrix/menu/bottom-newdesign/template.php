<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)){?>
    <div class="cell large-4 padding-top-1 medium-order-2 large-order-3 medium-9">
        <?foreach($arResult as $arItem){?>
            <a class="footer__menu" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
        <?}?>
    </div>
<?}?>













