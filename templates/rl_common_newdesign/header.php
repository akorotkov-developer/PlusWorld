<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;
use Plusworld\Config;

?>

<!DOCTYPE html>
<html class="no-js" lang="ru" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
    <?
    //CJSCore::Init(array("popup", "fx", "ajax", "window"));
    ?>
    <?$APPLICATION->ShowHead();?>

    <?//og:meta теги?>
        <?
        $url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        ?>
        <meta property="og:title" content="<?$APPLICATION->ShowTitle();?> ">
        <?
        $curDir = $APPLICATION->GetCurDir();
        $curDir = explode('/', $curDir);
        if ($curDir[1] == "journal_retail_loyalty") {
            ?>
            <meta property="og:type" content="article">
            <?
        } elseif ($curDir[1] == "news" or $curDir[1] == "expert-forum" or $curDir[2] == "glossary") {
            ?>
            <meta property="og:type" content="article">
            <?
        } else {
            ?>
            <meta property="og:type" content="website">
            <?
        }
        ?>
        <?$APPLICATION->ShowViewContent('OG_PICTURE');?>
        <?if ($APPLICATION->GetCurPage() == "/" or $curDir[1] == "calendar_retail_loyalty" or $curDir[1] == "knowledgebase" or $curDir[2] == "all") {?>
            <meta property="og:image" content="http://<?=$_SERVER['HTTP_HOST']?>/local/templates/rl_common_newdesign/images/logo-og.png">
            <meta property="og:image:secure_url" content="https://<?=$_SERVER['HTTP_HOST']?>/local/templates/rl_common_newdesign/images/logo-og.png">
            <meta property="og:image:type" content="image/jpeg" />
            <meta property="og:image:width" content="1261">
            <meta property="og:image:height" content="201">
        <?}?>
        <meta property="og:url" content="<?=$url;?>">
        <meta property="og:locale" content="ru_RU">
        <meta property="og:site_name" content="Retail & Loyalty" />
        <?$APPLICATION->ShowProperty("og-description");?>
        <meta property="fb:app_id" content="257953674358265" />
    <?//конец og:meta теги?>


    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="copyright" content="Retail-Loyalty.org - журнал о рознице и инновациях в онлайн ритейле">
    <meta name="author" content="RETAIL & LOYALTY">
    <meta name="cmsmagazine" content="f21b68cb09efe1a7161ca2caaacaf749">

    <title><?$APPLICATION->ShowTitle()?></title>

    <!--https://realfavicongenerator.net/-->


    <link rel="apple-touch-icon" sizes="180x180" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/safari-pinned-tab.svg" color="#5f4b8b">
    <link rel="shortcut icon" href="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/favicon.ico">

    <?/*facebook comments*/?>
    <div id="fb-root"></div>
    <?
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "/js/lib.js");
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "/js/app.js");
    ?>
    <!-- <script type="text/javascript" async="async" data-skip-moving="true" src="<?/*=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH*/?>/js/jquery-2.2.4.min.js"></script>-->
    <script type="text/javascript" async="async" src="//vk.com/js/api/share.js?11" charset="windows-1251"></script>
    <script type="text/javascript" charset="UTF-8" src="//cdn.sendpulse.com/js/push/015c11dfa16d80ed76ea2ca004b3f695_0.js" async="async"></script>
    <script src="https://yastatic.net/pcode/adfox/loader.js" crossorigin="anonymous"></script>


    <?
    Asset::getInstance()->addCss(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "/css/style.css");
    Asset::getInstance()->addCss(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "/css//jquery-ui.css");
    Asset::getInstance()->addCss(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "/css/common.css");




    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "/js/common.js");


    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "//vk.com/js/api/share.js?11");
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "//cdn.sendpulse.com/js/push/015c11dfa16d80ed76ea2ca004b3f695_0.js");
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . "https://yastatic.net/pcode/adfox/loader.js");
    ?>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.2"></script>
    <?/*******************/?>

    <meta name="msapplication-TileColor" content="#5f4b8b">
    <meta name="msapplication-config" content="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#5f4b8b">


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="reveal" id="example1" data-reveal="" data-deep-link="true"><a href="#"><img src="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/i/800.png" alt=""></a></div>

<div class="text-center background-black header-banner">
    <?
    // включаемая область для раздела
    $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/banners/banner_header.php", Array(), Array());
    ?>
</div>

<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "top-newdesignmobile",
    array(
        "ROOT_MENU_TYPE" => "top-newdesign-mobile",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "N",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "COMPONENT_TEMPLATE" => "top-newdesign-mobile"
    ),
    false
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top-newdesign", 
	array(
		"ROOT_MENU_TYPE" => "top-newdesign",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "top-newdesign"
	),
	false
);?>

<header class="header">
    <div class="header__top">
        <div class="grid-container header__rel">
            <div class="grid-x grid-padding-x align-middle">
                <div class="cell large-auto medium-12 small-19"><a class="header__logo" href="/"><img src="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/logo.png" alt=""></a></div>
                <div class="cell medium-12 hide-for-large text-right small-5">
                    <div class="close-mobilesearch">
                        <img src="<?=Config::PLUSWORLD_TEMPLATE_PATH?>/images/close.svg">
                    </div>
                    <div class="search-button-inmobilemenu">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="header__toggle" data-toggle=""><i class="fas fa-bars">     </i></div>
                </div>
                <!--<a id="mobile_menu_btn">burger</a>-->
                <div class="cell large-7 show-for-large">
                    <span class="header__title">Журнал о рознице и инновациях</span>
                </div>
                <div class="cell large-shrink large-text-right header__icons medium-12 text-center medium-text-left show-for-large" id="soc" data-toggler=".show-for-large"><a class="header__soc" href="http://www.facebook.com/pages/Retail-Loyalty/291446587589171?ref=hl"><i class="fab fa-facebook-f" data-fa-transform="shrink-6 " data-fa-mask="fas fa-circle"></i></a><a class="header__soc" href="https://twitter.com/Retail_Loyalty_"><i class="fab fa-twitter" data-fa-transform="shrink-8 " data-fa-mask="fas fa-circle"></i></a><a class="header__soc" href="https://web.telegram.org/#/im?p=@retailloyaltyorg"><i class="fab fa-telegram-plane" data-fa-transform="shrink-6 " data-fa-mask="fas fa-circle"></i></a><a class="header__soc" href="/news/rss/"><i class="fas fa-rss" data-fa-transform="shrink-9 " data-fa-mask="fas fa-circle"></i></a></div>
                <?$APPLICATION->IncludeComponent("bitrix:search.form", "header-home", array(
                    "NUM_CATEGORIES" => "3",
                    "TOP_COUNT" => "5",
                    "ORDER" => "date",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "CHECK_DATES" => "N",
                    "SHOW_OTHERS" => "Y",
                    "PAGE" => "#SITE_DIR#search/",
                    "CATEGORY_OTHERS_TITLE" => GetMessage("OTHER_TITLE"),
                    "CATEGORY_0_TITLE" => GetMessage("NEWS_TITLE"),
                    "CATEGORY_0" => array(
                        0 => "iblock_NEWS_IP",
                        1 => "iblock_services_ip",
                        2 => "iblock_photos",
                    ),
                    "CATEGORY_0_iblock_NEWS_IP" => array(
                        0 => "23",
                        1 => "28",
                    ),
                    "CATEGORY_0_iblock_services_ip" => array(
                        0 => "all",
                    ),
                    "CATEGORY_0_iblock_photos" => array(
                        0 => "all",
                    ),
                    "CATEGORY_1_TITLE" => GetMessage("BLOG_TITLE"),
                    "CATEGORY_1" => array(
                        0 => "blog",
                    ),
                    "CATEGORY_1_blog" => array(
                        0 => "all",
                    ),
                    "CATEGORY_2_TITLE" => GetMessage("JOB_TITLE"),
                    "CATEGORY_2" => array(
                    ),
                    "SHOW_INPUT" => "Y",
                    "INPUT_ID" => "title-search-input",
                    "CONTAINER_ID" => "title-search"
                ),
                    false
                );?>

                <?$APPLICATION->IncludeComponent("bitrix:search.form", "header-home_mobileversion", array(
                    "NUM_CATEGORIES" => "3",
                    "TOP_COUNT" => "5",
                    "ORDER" => "date",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "CHECK_DATES" => "N",
                    "SHOW_OTHERS" => "Y",
                    "PAGE" => "#SITE_DIR#search/",
                    "CATEGORY_OTHERS_TITLE" => GetMessage("OTHER_TITLE"),
                    "CATEGORY_0_TITLE" => GetMessage("NEWS_TITLE"),
                    "CATEGORY_0" => array(
                        0 => "iblock_NEWS_IP",
                        1 => "iblock_services_ip",
                        2 => "iblock_photos",
                    ),
                    "CATEGORY_0_iblock_NEWS_IP" => array(
                        0 => "23",
                        1 => "28",
                    ),
                    "CATEGORY_0_iblock_services_ip" => array(
                        0 => "all",
                    ),
                    "CATEGORY_0_iblock_photos" => array(
                        0 => "all",
                    ),
                    "CATEGORY_1_TITLE" => GetMessage("BLOG_TITLE"),
                    "CATEGORY_1" => array(
                        0 => "blog",
                    ),
                    "CATEGORY_1_blog" => array(
                        0 => "all",
                    ),
                    "CATEGORY_2_TITLE" => GetMessage("JOB_TITLE"),
                    "CATEGORY_2" => array(
                    ),
                    "SHOW_INPUT" => "Y",
                    "INPUT_ID" => "title-search-input",
                    "CONTAINER_ID" => "title-search"
                ),
                    false
                );?>
            </div>
        </div>
    </div>
    <div class="reveal reveal_register-complete" id="register-complete" data-reveal>
        <img class="reveal_picture" src="<?=Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/i/mail-reminder.png" alt="Регистрация прошла успешно">
        <p class="reveal_title">Регистрация прошла успешно</p>
        <p class="reveal_text">На ваш e-mail пришло письмо с подтверждением</p>
        <button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
    </div>

    <?
    global $USER;
    if (!$USER->IsAuthorized()) {
    ?>
        <div style="display: none">
            <span data-open="forgot-password-message"></span>
            <span data-open="login-form" class="link_forgot-password-hidden"></span>
        </div>
        <div class="reveal reveal_login" id="forgot-password-message" data-reveal data-deep-link="true">
            <div class="popup_close">
                <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/exit.svg">
            </div>
            <p>На вашу почту отправлена ссылка для восстановления пароля</p>
        </div>
        <div class="reveal reveal_login" id="forgot-password" data-reveal data-deep-link="true">
            <div class="popup_close_forgot_password">
                <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/exit.svg">
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:system.auth.forgotpasswd",
                "forgot-password",
                Array(
                    "AUTH" => "Y",
                    "SHOW_ERRORS" => "Y",
                    "USE_BACKURL" => "Y",
                    "SUCCESS_PAGE" => "",
                    "SET_TITLE" => "N",
                    "USER_PROPERTY" => Array(),
                    "SEF_FOLDER" => "/",
                    "VARIABLE_ALIASES" => Array(),
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_MODE" => "Y",
                    "SEF_MODE" => "Y",
                    )
            );?>
        </div>
        <div class="reveal reveal_login" id="login-form" data-reveal data-deep-link="true">
            <div class="popup_close">
                <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/exit.svg">
            </div>
            <ul class="tabs tabs_login" id="user-tabs" data-tabs>
                <li class="tabs-title is-active"><a href="#user-login">Вход</a></li>
                <li class="tabs-title"><a href="#user-register" data-tabs-target="user-register">Регистрация</a></li>
            </ul>
            <div class="tabs-content tabs-content_login" data-tabs-content="user-tabs">
                <div class="tabs-panel is-active" id="user-login">
                    <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "top-menu-auth", array(
                        "REGISTER_URL" => "/auth/",
                        "FORGOT_PASSWORD_URL" => "/auth/",
                        "PROFILE_URL" => "/personal/",
                        "SHOW_ERRORS" => "Y",
                        "AJAX_MODE" => "Y", // режим AJAX
                        "AJAX_OPTION_SHADOW" => "N", // затемнять область
                        "AJAX_OPTION_JUMP" => "Y", // скроллить страницу до компонента
                        "AJAX_OPTION_STYLE" => "Y", // подключать стили
                        "AJAX_OPTION_HISTORY" => "N",
                    ),
                        false
                    );?>
                </div>
                <div class="tabs-panel" id="user-register">
                    <?$APPLICATION->IncludeComponent("bitrix:main.register","top-menu-register",Array(
                            "USER_PROPERTY_NAME" => "",
                            "SEF_MODE" => "Y",
                            "SHOW_FIELDS" => Array("PERSONAL_PHONE", "NAME"),
                            "REQUIRED_FIELDS" => Array("PERSONAL_PHONE", "NAME"),
                            "AUTH" => "Y",
                            "USE_BACKURL" => "Y",
                            "SUCCESS_PAGE" => "",
                            "SET_TITLE" => "N",
                            "USER_PROPERTY" => Array(),
                            "SEF_FOLDER" => "/",
                            "VARIABLE_ALIASES" => Array(),
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_MODE" => "Y",
                        )
                    );?>
                </div>
            </div>
            <button class="close-button show-for-small-only" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
        </div>
    <?}?>

    <?$APPLICATION->IncludeComponent(
        "cetera:news.list",
        "menu-news-rl",
        array(
            "IBLOCK_TYPE" => "news",
            "IBLOCK_ID" => "23",
            "NEWS_COUNT" => "10",
            "SORT_BY1" => "DATE_ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "FILTER_NAME" => "",
            "FIELD_CODE" => array(),
            "PROPERTY_CODE" => array(),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "H:i, j F",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
            "ADD_SECTIONS_CHAIN" => "Y",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Новости",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "N",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
    );?>
</header>
