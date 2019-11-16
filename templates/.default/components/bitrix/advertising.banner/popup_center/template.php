<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    echo '<link rel="stylesheet" type="text/css" href="/bitrix/templates/.default/components/bitrix/advertising.banner/popup_center/style.css">';

    $end_sessid = strtotime(date('d F Y 00:00:01', strtotime("+1 day")))."<br />";
    $start_view = time();
?>
<script>
    function close_popup_center() {
        $(document).find('.popup_center').detach();
        $(document).find('#fade').detach();
    }

    function html_popup_center() {
        var div = document.createElement('div');
        div.id = "fade";

        $("body").append(div);
        $("body").append("<div class=\"popup_center \"><span class=\"close-form\" id=\"js-close\">&times;</span></div>");
        $(".popup_center").append($(".addfox_banner_content"));
        $('#fade').click(function () {
            close_popup_center();
        });
        $(document).find('.popup_center #js-close').click(function () {
            close_popup_center();
        });
    }
</script>
<?
    //$phpsessid = bitrix_sessid();
    if (!$_COOKIE["popup_center_sessid"]) {
        setcookie("popup_center", $start_view, $end_sessid, '/'); ?>
        <div class="addfox_banner" style="display: none">
            <div class="addfox_banner_content">
                <div id="adfox_154211609400026487"></div>
                <script>
                    (function(w, n) {
                        w[n] = w[n] || [];
                        w[n].push({
                            ownerId: 250505,
                            containerId: 'adfox_154211609400026487',
                            params: {
                                p1: 'cbsly',
                                p2: 'gbnn',
                                pfc: 'bvaov',
                                pfb: 'ftlvh'
                            },
                            onRender: function() {
                                html_popup_center()
                            }
                        });
                    })(window, 'adfoxAsyncParams');

                    <?/*window.Ya.adfoxCode.create({
                    ownerId: 250505,
                    containerId: 'adfox_154211609400026487',
                    params: {
                        p1: 'cbsly',
                        p2: 'gbnn',
                        pfc: 'bvaov',
                        pfb: 'ftlvh'
                    },
                    onLoad: function(data) {
                        console.log('data',data);
                    },
                });*/?>
                </script>
            </div>
        </div>
        <?/*<script>
                $(document).ready(function () {
                    var div = document.createElement('div');
                    div.id = "fade";

                    $("body").append(div);
                    $("body").append("<div class=\"popup_center 111\"><span class=\"close-form\" id=\"js-close\">&times;</span></div>");
                    $(".popup_center").append($(".addfox_banner_content"));
                    $('#fade').click(function () {
                        close_popup_center();
                    });
                    $('.popup_center #js-close').click(function () {
                        close_popup_center();
                    });
                });
        </script>*/?>
<?
        setcookie("popup_center_sessid", 1, $end_sessid, '/');
    }
    else
    {
        if (intval($_COOKIE["popup_center_sessid"])<3) {
            if ($_COOKIE["popup_center"] <= $start_view - 7200) {
                setcookie("popup_center", $start_view, $end_sessid, '/'); ?>
                <div class="addfox_banner" style="display: none">
                    <div class="addfox_banner_content">
                        <div id="adfox_154211609400026487"></div>
                        <script>
                            (function(w, n) {
                                w[n] = w[n] || [];
                                w[n].push({
                                    ownerId: 250505,
                                    containerId: 'adfox_154211609400026487',
                                    params: {
                                        p1: 'cbsly',
                                        p2: 'gbnn',
                                        pfc: 'bvaov',
                                        pfb: 'ftlvh'
                                    },
                                    onRender: function() {
                                        html_popup_center()
                                    }
                                });
                            })(window, 'adfoxAsyncParams');

                            <?/*window.Ya.adfoxCode.create({
                    ownerId: 250505,
                    containerId: 'adfox_154211609400026487',
                    params: {
                        p1: 'cbsly',
                        p2: 'gbnn',
                        pfc: 'bvaov',
                        pfb: 'ftlvh'
                    },
                    onLoad: function(data) {
                        console.log('data',data);
                    },
                });*/?>
                        </script>
                    </div>
                </div>
                <?/*<script>

                    function close_popup_center() {
                        $('.popup_center').detach();
                        $('#fade').detach();
                    }

                    $(document).ready(function () {
                        var div = document.createElement('div');
                        div.id = "fade";

                        $("body").append(div);
                        $("body").append("<div class=\"popup_center\"><span class=\"close-form\" id=\"js-close\">&times;</span></div>");
                        $(".popup_center").append($(".addfox_banner_content"));
                        $('#fade').click(function () {
                            close_popup_center();
                        });
                        $('.popup_center #js-close').click(function () {
                            close_popup_center();
                        });

                        //setTimeout(close_popup_center, 10000);
                    });

                </script>*/?>

                <?
                setcookie("popup_center_sessid", intval($_COOKIE["popup_center_sessid"])+1, $end_sessid, '/');
            }
        }
    }


    /*if ($_COOKIE["popup_center"]) {
            if (time()-$_COOKIE["popup_center"]>=86400) {
                setcookie("popup_center", time(),time()+86400);
                echo "
                <script>
                    function close_popup_center(){
                        $('.popup_center').detach();
                        $('#fade').detach();
                    }
                    var div = document.createElement('div');
                    div.id = \"fade\";
                    $(\"body\").append(div);
                    $(\"body\").append('<div class=\"popup_center\"><span class=\"close-form\" id=\"js-close\"><img id=\"js-close\" src=\"/images/close.png\"></span>".$arResult["BANNER"]."</div>');
                    $('#fade').click(function(){
                        close_popup_center();
                    });
                    $('.popup_center #js-close').click(function(){
                        close_popup_center();
                    });

                    setTimeout(close_popup_center, 15000);
                </script>
                ";
            }
        }
        else
        {
            setcookie("popup_center", time(),time()+86400);
            echo "
            <script>
                function close_popup_center(){
                    $('.popup_center').detach();
                    $('#fade').detach();
                }
                var div = document.createElement('div');
                div.id = \"fade\";
                $(\"body\").append(div);
                $(\"body\").append('<div class=\"popup_center\"><span class=\"close-form\" id=\"js-close\"><img id=\"js-close\" src=\"/images/close.png\"></span>".$arResult["BANNER"]."</div>');
                $('#fade').click(function(){
                    close_popup_center();
                });
                $('.popup_center #js-close').click(function(){
                    close_popup_center();
                });

                setTimeout(close_popup_center, 15000);
            </script>";
        }*/
