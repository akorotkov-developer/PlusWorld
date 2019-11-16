<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>

<?if ($arParams["SHOW_RUS"] == "Y"){?>
    <div class="cell margin-top-10">
        <ul class="anchor-list anchor-list_block">

            <?foreach ($arResult["ru"] AS $k=>$v)
            {?>
                <?if ($_GET["letter"]) {?>
                    <?if ($_GET["letter"] !== $k) { ?>
                        <li class="anchor-list__item"><a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" title="<?=$k?>" class="anchor-list__link anchor-list__link_active"><?=$k?></a></li>
                    <?} else {?>
                        <li class="anchor-list__item"><a class="anchor-list__link"><?=$k?></a></li>
                    <?}?>
                <?} else {?>
                    <?if ($v > 0) { ?>
                        <li class="anchor-list__item"><a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" title="<?=$k?>" class="anchor-list__link anchor-list__link_active"><?=$k?></a></li>
                    <?} else {?>
                        <li class="anchor-list__item"><a class="anchor-list__link"><?=$k?></a></li>
                    <?}?>
                <?}?>
            <?}?>

        </ul>
    </div>
<?}?>

<?if ($arParams["SHOW_NUM"] == "Y") {?>
    <div class="cell large-24">
        <ul class="anchor-list anchor-list_block anchor-list_blockleft" style="float:left">
            <?foreach ($arResult["num"] AS $k=>$v)
            {?>
                <?if ($_GET["letter"]) {?>
                    <?if ($_GET["letter"] !== $k) { ?>
                        <li class="anchor-list__item"><a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" title="<?=$k?>" class="anchor-list__link anchor-list__link_active"><?=$k?></a></li>
                    <?} else {?>
                        <li class="anchor-list__item"><a class="anchor-list__link"><?=$k?></a></li>
                    <?}?>
                <?} else {?>
                    <?if ($v > 0) { ?>
                        <li class="anchor-list__item"><a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" title="<?=$k?>" class="anchor-list__link anchor-list__link_active"><?=$k?></a></li>
                    <?} else {?>
                        <li class="anchor-list__item"><a class="anchor-list__link"><?=$k?></a></li>
                    <?}?>
                <?}?>
            <?}?>
        </ul>
        <?if ($arParams["SHOW_ENG"] == "Y") {?>
            <ul class="anchor-list anchor-list_block">
                <?foreach ($arResult["en"] AS $k=>$v)
                {?>
                    <?if ($_GET["letter"]) {?>
                    <?if ($_GET["letter"] !== $k) { ?>
                        <li class="anchor-list__item"><a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" title="<?=$k?>" class="anchor-list__link anchor-list__link_active"><?=$k?></a></li>
                    <?} else {?>
                        <li class="anchor-list__item"><a class="anchor-list__link"><?=$k?></a></li>
                    <?}?>
                <?} else {?>
                    <?if ($v > 0) { ?>
                        <li class="anchor-list__item"><a href="<?=$arParams["LIST_URL"];?>?letter=<?=$k?>" title="<?=$k?>" class="anchor-list__link anchor-list__link_active"><?=$k?></a></li>
                    <?} else {?>
                        <li class="anchor-list__item"><a class="anchor-list__link"><?=$k?></a></li>
                    <?}?>
                <?}?>
                <?}?>
            </ul>
        <?}?>
    </div>
<?}?>

