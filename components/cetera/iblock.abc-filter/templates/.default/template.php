    <?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if ($arParams["SHOW_RUS"] == "Y"):?>
<div class="rus test">
<?foreach ($arResult["ru"] AS $k=>$v)
{?>
    <?if ($v > 0):?>
        <a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" <?=($_REQUEST['letter'] == $k ? 'style="font-weight:bold"' : '');?> title="<?=$k?>"><?=$k?></a>
    <?else:?>
        <span class="inactive"><?=$k?></span>
    <?endif;?>
<?}?>
</div>
<br />
<?endif;?>

<?if ($arParams["SHOW_NUM"] == "Y"):?>
<div class="num">
<?foreach ($arResult["num"] AS $k=>$v)
{?>
    <?if ($v > 0):?>
        <a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" <?=($_REQUEST['letter'] == $k ? 'style="font-weight:bold"' : '');?> title="<?=$k?>"><?=$k?></a>
    <?else:?>
        <span class="inactive"><?=$k?></span>
    <?endif;?>
<?}?>
</div>
<?endif;?>
&nbsp;&nbsp;
<?if ($arParams["SHOW_ENG"] == "Y"):?>
<div class="eng">
<?foreach ($arResult["en"] AS $k=>$v)
{?>
    <?if ($v > 0):?>
        <a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" <?=($_REQUEST['letter'] == $k ? 'style="font-weight:bold"' : '');?> title="<?=$k?>"><?=$k?></a>
    <?else:?>
        <span class="inactive"><?=$k?></span>
    <?endif;?>
<?}?>
</div>
<?endif;?>
