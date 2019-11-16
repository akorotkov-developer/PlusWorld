<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);
?>

    <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
        <?
        if (strlen($arResult["BACKURL"]) > 0)
        {
            ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
        }
        ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">

        <span class="span_forgot-password">Восстановление пароля</span>

        <label>
            <input type="text" name="USER_EMAIL" maxlength="255" class="input_forgot-password" placeholder="Электронная почта"/>
        </label>

        <input class="button button_login expanded" type="submit" name="send_account_info" value="Восстановить пароль">

    </form>

    <div class="forgot_errors"></div>

<script>
    $('form[name=bform]').submit(function( event ){
        event.preventDefault();
        var forgot_password = 'yes',
            backurl = '?backurl=%2F',
            AUTH_FORM = 'Y',
            TYPE = 'SEND_PWD',
            USER_LOGIN = '0',
            USER_EMAIL = $('input[name=USER_EMAIL]').val(),
            send_account_info = 'Выслать контрольную строчку';
        $.ajax({
            type: "POST",
            url: "/auth/forgotpasswdajax/index.php",
            data: {forgot_password:forgot_password, backurl:backurl,AUTH_FORM:AUTH_FORM,TYPE:TYPE,USER_LOGIN:USER_LOGIN,USER_EMAIL:USER_EMAIL,send_account_info:send_account_info}
        }).done(function( result )
        {
            if(result.indexOf('Логин или EMail не найдены.') + 1) {
                $('.forgot_errors').text("Пользователя с таким e-mail не существует. Пожалуйста проверьте введенный e-mail.");
            } else {
                $("span[data-open=forgot-password-message").trigger( "click" );
                function close_confirm_window() {
                    $(".reveal-overlay").trigger( "click" );
                }
                setTimeout(close_confirm_window, 5000);
            }

        });
    });
</script>




