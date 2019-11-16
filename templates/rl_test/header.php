<? use Plusworld\Config;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>


<!DOCTYPE html>
<html class="no-js" lang="ru">
<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="copyright" content="Создание сайтов - Cetera Labs, www.cetera.ru, 2018">
    <meta name="author" content="Cetera Labs, http://www.cetera.ru/, создание сайтов, поддержка сайтов, продвижение сайтов">
    <meta name="cmsmagazine" content="f21b68cb09efe1a7161ca2caaacaf749">
    <title>Cetera Labs WireFrames</title>
    <?
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH_TEST . "/css/style.css");
    ?>
    <meta property="og:title" content="Cetera Labs WireFrames">
    <meta property="og:description" content="Cetera Labs WireFrames">
    <meta property="og:image" content="http://wireframes.cetera.ru/boilerplate_wireframe/images/logo_og.png">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="400">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://wireframes.cetera.ru/boilerplate_wireframe/">
    <meta property="og:locale" content="ru_RU">
    <!--https://realfavicongenerator.net/-->
    <meta name="msapplication-TileColor" content="#5f4b8b">
    <meta name="theme-color" content="#5f4b8b">
    <!--script window.FontAwesomeConfig = { showMissingIcons: false }-->
    <?
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH_TEST . "/js/lib.js");
    Asset::getInstance()->addJs(Plusworld\Config::PLUSWORLD_TEMPLATE_PATH_TEST . "/js/app.js");
    ?>
    <!--script(src='https://use.fontawesome.com/releases/v5.0.13/js/v4-shims.js' defer)-->
</head>
<body>
