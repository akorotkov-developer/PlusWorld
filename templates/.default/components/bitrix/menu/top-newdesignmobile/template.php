<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)){?>

    <div id="mobile_menu_pop" class="mobile-menu__pop">
        <div id="mobile_menu" class="mobile-menu">
            <div class="mobile-menu__top_area">
                <?
                global $USER;
                if ($USER->IsAuthorized()) {?>
                    <div class="mobile-menu__user"><a href="/personal/profile/" class="auth-link"><?=$USER->GetLogin();?></a></div>
                <?} else {?>
                    <div class="mobile-menu__user"><a class="auth-link" data-open="login-form">Вход</a></div>
                <?}?>
                <div id="mobile_menu_close_btn" class="mobile-menu__close-btn">
                    <svg style="height: 30px;width: 23px; transform: rotate(90deg); position: absolute; top: 13px; right: 10px" class="svg-inline--fa fa-bars fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path style="fill: #B71852;" fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>
                </div>
            </div>

            <ul id="menu-glavnoe-menyu-mobilnoe" class="top__list_mobile">

                <?foreach ($arResult as $key => $item) {?>
                    <?
                    $depthClass = "";
                    if (count($item["ADDITIONAL_LINKS"]["SUB_MENU"]) > 0) {
                        $depthClass = "menu-item-has-children";
                    } else {
                        $depthClass = "menu-item-home";
                    }
                    ?>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom <?=$depthClass?>">
                        <a href="<?=$item["LINK"]?>"><?=$item["TEXT"]?></a>
                        <?if (count($item["ADDITIONAL_LINKS"]["SUB_MENU"]) > 0) {?>
                            <ul class="sub-menu">
                                <?foreach ($item["ADDITIONAL_LINKS"]["SUB_MENU"] as $itemSubmenu) {?>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custo">
                                        <a href="<?=$itemSubmenu["URL"]?>"><?=$itemSubmenu["NAME"]?></a>
                                    </li>
                                <?}?>
                            </ul>
                        <?}?>
                    </li>
                <?}?>

            </ul>

            <div class="mobile-menu__buttom_area">
                <div class="mobile-menu__left">

                </div>
                <div class="mobile-menu__right"><div class="social-mobile">
                        <a href="https://www.facebook.com/retailloyalty.org/" target="_blank" rel="nofollow noopener" class="social-mobile__icon_fb">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg></a>
                        <a href="https://web.telegram.org/#/im?p=@retailloyaltyorg" target="_blank" rel="nofollow noopener" class="social-mobile__icon_tel">
                            <svg viewBox="0 0 24 24" width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><path id="telegram-1" d="M18.384,22.779c0.322,0.228 0.737,0.285 1.107,0.145c0.37,-0.141 0.642,-0.457 0.724,-0.84c0.869,-4.084 2.977,-14.421 3.768,-18.136c0.06,-0.28 -0.04,-0.571 -0.26,-0.758c-0.22,-0.187 -0.525,-0.241 -0.797,-0.14c-4.193,1.552 -17.106,6.397 -22.384,8.35c-0.335,0.124 -0.553,0.446 -0.542,0.799c0.012,0.354 0.25,0.661 0.593,0.764c2.367,0.708 5.474,1.693 5.474,1.693c0,0 1.452,4.385 2.209,6.615c0.095,0.28 0.314,0.5 0.603,0.576c0.288,0.075 0.596,-0.004 0.811,-0.207c1.216,-1.148 3.096,-2.923 3.096,-2.923c0,0 3.572,2.619 5.598,4.062Zm-11.01,-8.677l1.679,5.538l0.373,-3.507c0,0 6.487,-5.851 10.185,-9.186c0.108,-0.098 0.123,-0.262 0.033,-0.377c-0.089,-0.115 -0.253,-0.142 -0.376,-0.064c-4.286,2.737 -11.894,7.596 -11.894,7.596Z"></path></svg></a>
                        <a href="https://twitter.com/Retail_Loyalty_" target="_blank" rel="nofollow noopener" class="social-mobile__icon_tw">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg></a>
                        <a href="https://vk.com/retailloyalty_org">
                            <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/vk.svg" style="margin-bottom: 12px;">
                        </a>
                        <a href="https://www.instagram.com/retailloyalty_org/">
                            <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/instagram.svg" style="margin-bottom: 12px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?}?>









