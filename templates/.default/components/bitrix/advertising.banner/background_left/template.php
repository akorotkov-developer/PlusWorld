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
    <div class="background-left">

    </div>
    <style>
        .wrap-column .main-column {
            background: #e1e1e1;
            position: relative;
            display: inline-block;
        }
        footer .wrap-column .main-column {
            background: transparent;
        }
        .background-left {
            <? echo 'background-image:url(';
              print_r(preg_replace('/.*src=| width.*/','',$arResult["BANNER"]));
              echo ')!important;';?>
            background-repeat: no-repeat!important;
            cursor: pointer;
            position: fixed;
        }
    </style>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.background-left').click(function() {
                location.href="<?=$arResult["BANNER_PROPERTIES"]["URL"]?>";
            });
            $(window).resize(function(){
                $('.background-left').outerHeight($(window).height());
                $('.background-left').outerWidth(421);
                $('.background-left').css({"left": "164px"});
                var left = (($(window).outerWidth() - $('#page-wrapper').outerWidth() - 260) / 2) - 156;
                var roundleft = left.toFixed();
                $('.background-left').css({"left": roundleft + "px"});
            });

            $(window).resize();
        });
    </script>
<?
}
?>
