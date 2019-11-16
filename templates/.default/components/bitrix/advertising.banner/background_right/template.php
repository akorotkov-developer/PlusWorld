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
    <div class="background-right">

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
        .background-right {
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
            $('.background-right').click(function() {
                location.href="<?=$arResult["BANNER_PROPERTIES"]["URL"]?>";
            });
            $(window).resize(function(){
                $('.background-right').outerHeight($(window).height());
                $('.background-right').outerWidth(421);
                $('.background-right').css({"left": "564px"});
                var left = (($(window).outerWidth() - $('#page-wrapper').outerWidth() ) / 2) + $('#page-wrapper').outerWidth();
                var roundleft = left.toFixed();
                var roundright = Number(roundleft)+Number(133);
                $('.background-right').css({"left": roundright + "px"});
            });

            $(window).resize();
        });
    </script>
<?
}
?>
