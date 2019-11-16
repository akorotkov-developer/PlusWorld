<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)){?>

    <div class="journal show-for-large testtesttest" id="journal" data-toggler=".show-for-large">
        <div class="grid-container journal__container">
            <div class="grid-x grid-padding-x">
                <div class="cell medium-auto">
                    <ul class="news">
                        <?foreach($arResult as $arItem){?>
                            <?switch($arItem["PARAMS"]["PARAM"]) {

                                case "journal":?>

                                    <li class="news__item">
                                        <a class="news__link news__link_add" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"];?>

                                        </a>
                                        <div class="drop">
                                            <div class="grid-x grid-padding-x">
                                                <?
                                                $count=0;
                                                foreach ($arItem["ADDITIONAL_LINKS"]["SUB_MENU"] as $menuItem) {
                                                ?>
                                                    <?if ($count == 0) {?>
                                                        <div class="cell small-15">
                                                    <?} elseif ($count == 4) {?>
                                                        </div>
                                                        <div class="cell small-9">
                                                    <?}?>
                                                            <a class="drop__link" href="<?=$menuItem["URL"]?>"><?=$menuItem["NAME"]?></a>
                                                    <?$count++;?>
                                                <?}?>
                                                        </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?break;?>

                                <?case "news":?>

                                    <li class="news__item">
                                        <a class="news__link news__link_add" href="<?=$arItem["LINK"];?>"><?=$arItem["TEXT"];?></a>
                                        <div class="drop drop_mini">
                                            <?foreach ($arItem["ADDITIONAL_LINKS"]["SUB_MENU"] as $menuItem) {?>
                                                <a class="drop__link" href="<?=$menuItem["URL"]?>"><?=$menuItem["NAME"]?></a>
                                            <?}?>
                                        </div>
                                    </li>
                                    <?break;?>

                                <?case "rubrics":?>

                                    <li class="news__item"><a class="news__link" href="<?=$arItem["LINK"]?>"> <i class="fa fa-bars"></i><span><?=$arItem["TEXT"]?></span></a>
                                        <div class="drop drop_big">
                                            <div class="grid-x small-up-3 grid-padding-x">

                                                <?
                                                $count = 0;
                                                $elements = floor(count($arItem["ADDITIONAL_LINKS"]["SUB_MENU"]) / 3);
                                                ?>
                                                <div class="cell">
                                                    <?foreach ($arItem["ADDITIONAL_LINKS"]["SUB_MENU"] as $menuItem) {?>
                                                        <?if ($count % $elements == 0 and $count != count($arItem["ADDITIONAL_LINKS"]["SUB_MENU"]) and $count != 0) {?>
                                                            </div>
                                                            <div class="cell drop__line">
                                                        <?}?>
                                                        <a class="drop__link" href="<?=$menuItem["URL"]?>"><?=$menuItem["NAME"]?></a>
                                                        <?$count++;?>
                                                    <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?break;?>

                                <?case "service":?>

                                    <li class="news__item"><a class="news__link news__link_add" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                                        <div class="drop drop_micro">
                                            <?foreach ($arItem["ADDITIONAL_LINKS"]["SUB_MENU"] as $menuItem) {?>
                                                <a class="drop__link" href="<?=$menuItem["URL"]?>"><?=$menuItem["NAME"]?></a>
                                            <?}?>
                                        </div>
                                    </li>
                                    <?break;?>

                                <?default:?>
                                    <li class="news__item"><a class="news__link <?=$arItem["PARAMS"]["PARAM_CLASS"];?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                                    <?break;?>
                            <?}?>
                        <?}?>
                    </ul>
                </div>
                <div class="cell medium-shrink journal__info">
                    <a class="journal__flag" href="/en/">
                        <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/flag.svg" alt="">
                    </a>
                    <?if ($USER->IsAuthorized()) {?>
                        <a class="journal__enter" href="<?echo $APPLICATION->GetCurPageParam("logout=yes",array());?>">
                            <span class="journal__img">
                                <img style="width: 14px;" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/avatar-white.svg" alt="">
                            </span>
                            <span>Выйти</span>
                        </a>
                    <?} else {?>
                        <button class="journal__enter" type="button" data-open="login-form">
                            <span class="journal__img"><img style="width: 14px;" src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/avatar-white.svg" alt=""></span><span>вход</span>
                        </button>
                    <?}?>
                </div>
            </div>
        </div>
    </div>

<?}?>









