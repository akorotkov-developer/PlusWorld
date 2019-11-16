<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)){?>
    <?foreach($arResult as $arItem){?>
        <a class="footer__menu" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
    <?}?>
<?}?>













