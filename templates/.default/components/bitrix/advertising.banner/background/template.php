<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["BANNER"]) {
    preg_match('~<a.*?href="([^"]+)".*?>(.*?)</a>~s', $arResult["BANNER"], $matches);
    $strURL = '';
    if ($matches[1])
    {
        $strURL = $matches[1];
    }
    else
    {
        $strURL = $arResult["BANNER_PROPERTIES"]["URL"];
    }
?>
    <style>
        .wrap-column .main-column {
            background: #e1e1e1;
            position: relative;
            display: inline-block;
        }
        footer .wrap-column .main-column {
            background: transparent;
        }
        body {
            <? echo 'background-image:url(';
              print_r(preg_replace('/.*src=| width.*/','',$arResult["BANNER"]));
              echo ')!important;';?>
            background-position: top center!important;
            background-repeat: no-repeat!important;
            background-attachment: fixed!important;
        }
    </style>
<?
}
?>
