<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="bx-system-auth-form">

    <?if($arResult["FORM_TYPE"] == "login"):?>

        <?
        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
            ShowMessage($arResult['ERROR_MESSAGE']);
        ?>

        <form class="modal-form modal-form_auth" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
            <?if($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />
            <input class="modal-form__input" type="text" placeholder="Электронная почта" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>"  />
            <input  class="modal-form__input modal-form__input_low"  type="password" placeholder="Пароль" name="USER_PASSWORD" maxlength="50" />
            <?/*<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>">Восстановить пароль</a>*/?>
            <span data-open="forgot-password" class="link_forgot-password">Восстановить пароль</span>

            <?if($arResult["SECURE_AUTH"]):?>
                <span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                <div class="bx-auth-secure-icon"></div>
            </span>

                <script type="text/javascript">
                    document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
                </script>
            <?endif?>

            <style>
                .modal-form__label-rememberme {
                    margin-left: 0px!important;
                }
            </style>
            <br>
            <input class="modal-form__checkbox"  type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
            <label class="modal-form__label modal-form__label-rememberme" for="USER_REMEMBER_frm" title="Запомнить меня">Запомнить меня</label>

            <input class="button button_login expanded button_login_popup" type="submit" name="Login" value="Вход" />

            <?if ($arResult["CAPTCHA_CODE"]):?>
                <div class="g-recaptcha" id="auth_captcha" data-sitekey="<?=GoogleReCaptcha::getPublicKey()?>"></div>
            <?endif?>

        </form>

    <?
    else:
        ?>
        <form action="<?=$arResult["AUTH_URL"]?>">
            <table width="95%">
                <tr>
                    <td align="center">
                        <?=$arResult["USER_NAME"]?><br />
                        [<?=$arResult["USER_LOGIN"]?>]<br />
                        <a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=GetMessage("AUTH_PROFILE")?></a><br />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <?foreach ($arResult["GET"] as $key => $value):?>
                            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                        <?endforeach?>
                        <input type="hidden" name="logout" value="yes" />
                        <input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
                    </td>
                </tr>
            </table>
        </form>
    <?endif?>
    <div class="forgot_errors_auth"></div>

    <?if ($_POST) {?>
        <script>
            grecaptcha.render('auth_captcha', {
                'sitekey' : '<?=GoogleReCaptcha::getPublicKey()?>',
            });
        </script>
    <?}?>
</div>