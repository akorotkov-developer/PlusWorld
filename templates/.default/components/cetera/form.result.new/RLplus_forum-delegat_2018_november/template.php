
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>
<? if ($arResult["FORM_NOTE"]) : ?><div id="message">
        <div class="notetext"><?= $arResult["FORM_NOTE"] ?>

        </div>
        <script type="text/javascript">
            window.location.hash = 'message';
        </script>
    </div><? endif; ?>
<?
if ($arResult["isFormNote"] != "Y") {
    ?>
    <?= $arResult["FORM_HEADER"] ?>

    <table>
        <?
        if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
            ?>
            <tr>
                <td><?
                    /*                     * *********************************************************************************
                      form header
                     * ********************************************************************************* */
                    if ($arResult["isFormTitle"]) {/*
                      ?>
                      <h3><?=$arResult["FORM_TITLE"]?></h3>
                      <? */
                    } //endif ;

                    if ($arResult["isFormImage"] == "Y") {
                        ?>
                        <a href="<?= $arResult["FORM_IMAGE"]["URL"] ?>" target="_blank" alt="<?= GetMessage("FORM_ENLARGE") ?>"><img src="<?= $arResult["FORM_IMAGE"]["URL"] ?>" <? if ($arResult["FORM_IMAGE"]["WIDTH"] > 300): ?>width="300"<? elseif ($arResult["FORM_IMAGE"]["HEIGHT"] > 200): ?>height="200"<? else: ?><?= $arResult["FORM_IMAGE"]["ATTR"] ?><? endif; ?> hspace="3" vscape="3" border="0" /></a>
                        <? //=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
                        <?
                    } //endif
                    ?>

                    <p><?= $arResult["FORM_DESCRIPTION"] ?></p>
                </td>
            </tr>
            <?
        } // endif
        ?>
    </table>
    <br />
    <?
    /*     * *********************************************************************************
      form questions
     * ********************************************************************************* */
    ?>
    <?
    //$arResult["QUESTIONS"];
    //echo "<pre>";
    //print_r($arResult);
    //echo "</pre>";
    ?>
    <?
    //$arResult["QUESTIONS"];
    //echo "<pre>";
    //print_r($arResult["QUESTIONS"]["QUESTIONNAIRE_1"]);
    //echo "</pre>";
    ?>

    <style>
        .margin-bottom-10{
            margin-bottom: 10px;
        }
        .div_25 {
            width:25%;
            float:left;
        }
        .w_40 {
            width: 38%;
            float: left;
            margin-right: 2%;
        }
        .w_58 {
            width: 58%;
            float: left;
        }
        textarea {
            max-width: 99%;
            max-height: 400px;
        }
        .f_bold {
            font-weight: bold;
        }
        .div_mar_10 {
            width: 100%;
            display: inline-block;
            margin-bottom: 10px;
        }

        .div-l-h {
            width: 100%;
            display: inline-block;
            margin-bottom: 5px;
        }
        .ui-content .div-l-h {
            line-height: 50px;
        }
        ul {
            margin-top: 0;
            margin-bottom: 0;
            list-style: none!important;
        }
        .ui-content .div_box {
            margin-left: 10px;
        }
        .ui-radio {
            width: 40px;
            float: left;
        }
        .ui-radio .ui-btn {
            border: 0;
            padding: 10px;
        }
        .ui-content ul {
            -webkit-padding-start: 10px;
        }
        .ui-radio .ui-radio-off:after {
            background-image: none!important;
        }
        .div_75 {
            width:75%;float:left;
        }
        .div_25 {
            width:25%;float:left;
        }
        .ul_disc {
            list-style: disc;
        }
        .div_ui-radio {
            width: 100%;
            display: inline-block;
        }
        @media screen and (max-width: 500px) {
            .ui-content .div-l-h {
                line-height: 40px;
            }
            .div-l-h, label {
                font-size: 13px!important;
            }
            .div_75 {
                width:100%;float:left;
            }
            .div_25 {
                width:100%;float:left;
            }
            .ul_disc {
                -webkit-padding-start: 0px!important;
                list-style: none;
            }
            .w_40 {
                width: 100%;
            }
            .w_58 {
                width: 100%;
            }
        }
        .row{
            max-width: 100%;
            box-sizing: border-box;
           
        }
        .row::after,
        .row::before{
            content: "";
            display: table;
            clear:both;
        }
    </style>
    <script>
        $(document).ready(function () {
            (function () {
                j = 1;
                $(".ui-radio").each(function (i) {
                    var $inner = $(this),
                            id = "#id_div_" + j,
                            $inner_1 = $inner.next();


                    $inner.wrap("<div class='div_ui-radio' id='id_div_" + j + "'></div>");
                    $inner_1.appendTo(id);
                    j++;
                });
            })();
        });

    </script>
    <div class="row">
        <div class="div_25 fgdhfgh">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_2"]["CAPTION"]; ?><?
            if ($arResult["QUESTIONS"]["QUESTIONNAIRE_2"]["REQUIRED"] == "Y") {
                echo $arResult["REQUIRED_SIGN"];
            }
            ?>
        </div>
        <div class="div_75">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_2"]["HTML_CODE"]; ?>
        </div>
    </div>
    <div class="row">
        <!------------------>
        <div class="div_25 fgdhfgh">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_3"]["CAPTION"]; ?><?
            if ($arResult["QUESTIONS"]["QUESTIONNAIRE_3"]["REQUIRED"] == "Y") {
                echo $arResult["REQUIRED_SIGN"];
            }
            ?>
        </div>
        <div class="div_75">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_3"]["HTML_CODE"]; ?>
        </div>
        <!------------>
    </div>
    <div class="row">
        <div class="div_25 fgdhfgh">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_4"]["CAPTION"]; ?><?
            if ($arResult["QUESTIONS"]["QUESTIONNAIRE_4"]["REQUIRED"] == "Y") {
                echo $arResult["REQUIRED_SIGN"];
            }
            ?>
        </div>
        <div class="div_75">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_4"]["HTML_CODE"]; ?>
        </div>
        <!------------------->
    </div>
    <div class="row">
        <div class="div_25 fgdhfgh">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_5"]["CAPTION"]; ?><?
            if ($arResult["QUESTIONS"]["QUESTIONNAIRE_5"]["REQUIRED"] == "Y") {
                echo $arResult["REQUIRED_SIGN"];
            }
            ?>
        </div>
        <div class="div_75">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_5"]["HTML_CODE"]; ?>
        </div>
    </div>
    <div class="row">
        <!------------------------->
        <div class="div_25 fgdhfgh">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_5_1"]["CAPTION"]; ?><?
            if ($arResult["QUESTIONS"]["QUESTIONNAIRE_5"]["REQUIRED"] == "Y") {
                echo $arResult["REQUIRED_SIGN"];
            }
            ?> 
        </div>
        <div class="div_75">
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_5_1"]["HTML_CODE"]; ?>
        </div>
    </div>

    <!----------------------------->

    <div class="div_25 fgdhfgh">
        <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_6"]["CAPTION"]; ?><?
        if ($arResult["QUESTIONS"]["QUESTIONNAIRE_6"]["REQUIRED"] == "Y") {
            echo $arResult["REQUIRED_SIGN"];
        }
        ?> 
    </div>
    <div class="div_75">
        <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_6"]["HTML_CODE"]; ?>
    </div> 

    <div class="clear"></div><br />	

    <ul style="list-style: disc;">
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_61"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_61"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_7"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_7"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_8"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_8"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_9"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_9"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_10"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_10"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_11"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_11"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_12"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_12"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_13"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_13"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_14"]["CAPTION"]; ?><?
                if ($arResult["QUESTIONS"]["QUESTIONNAIRE_14"]["REQUIRED"] == "Y") {
                    echo $arResult["REQUIRED_SIGN"];
                }
                ?> </div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_14"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_15"]["CAPTION"]; ?><?
                if ($arResult["QUESTIONS"]["QUESTIONNAIRE_15"]["REQUIRED"] == "Y") {
                    echo $arResult["REQUIRED_SIGN"];
                }
                ?> </div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_15"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_17"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_17"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_18"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_18"]["HTML_CODE"]; ?>
        </li>
    </ul>


    <div class="clear"></div>


    <p>
        14-15 ноября 2018 года в Москве состоится 10-й Международный ПЛАС-Форум «Банковское самообслуживание, ритейл и НДО 2018». Регистрация уже открыта! Подробнее на plus-forum.com
    </p>

    <ul style="list-style: disc;">
        <li>
            <div><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_19"]["CAPTION"]; ?></div>
            <?= $arResult["QUESTIONS"]["QUESTIONNAIRE_19"]["HTML_CODE"]; ?>
        </li>
        <li>
            <div class="f_bold"><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_16"]["CAPTION"]; ?></div>
            <div class="f_bold"><?= $arResult["QUESTIONS"]["QUESTIONNAIRE_16"]["HTML_CODE"]; ?></div>
        </li>
    </ul>


    <?
    if ($arResult["isUseCaptcha"] == "Y") {
        ?>
        <p><?= GetMessage("FORM_CAPTCHA_TABLE_TITLE") ?></p>
        <p><input type="hidden" name="captcha_sid" value="<?= htmlspecialchars($arResult["CAPTCHACode"]); ?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialchars($arResult["CAPTCHACode"]); ?>" width="180" height="40" /></p>
        <p><?= GetMessage("FORM_CAPTCHA_FIELD_TITLE") ?><?= $arResult["REQUIRED_SIGN"]; ?></p>
        <p><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></p>
            <?
        } // isUseCaptcha
        ?>

    <input <?= (intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : ""); ?> type="submit" name="web_form_submit" value="<?= htmlspecialchars(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>" />
    <? if ($arResult["F_RIGHT"] >= 15): ?>
        &nbsp;<input type="hidden" name="web_form_apply" value="Y" />
        <? /* <input type="submit" name="web_form_apply" value="<?=GetMessage("FORM_APPLY")?>" /> */ ?>
    <? endif; ?>
    <? /* &nbsp;<input type="reset" value="<?=GetMessage("FORM_RESET");?>" /> */ ?>
    <p>
        <?= $arResult["REQUIRED_SIGN"]; ?> - <?= GetMessage("FORM_REQUIRED_FIELDS") ?>
    </p>
    <?= $arResult["FORM_FOOTER"] ?>
    <?
} //endif (isFormNote)
?>