<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>

     <?/*    <form action="#" method="POST">



          <div class="subscription-form-captcha">
            <p class="subscription-form-captcha__title">Защита от автоматического заполнения<span class="text-primary">*</span></p>
            <p class="subscription-form-captcha__text">Введите символы с картинки</p><img class="subscription-form-captcha__image" src="./i/captcha.png" alt="captcha">
            <input class="subscription-form-captcha__input" type="text">
          </div>
          <p><span class="text-primary">*</span> - обязательные поля</p>
          <button class="button button_submit button_low expanded" type="submit">Отправить</button>
        </form>*/?>

<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>
<?/*
<table>
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<tr>
		<td><?
//	form header
if ($arResult["isFormTitle"])
{
?>
	<b><?=$arResult["FORM_TITLE"]?></b>
<?
} //endif ;

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<p><?=$arResult["FORM_DESCRIPTION"]?></p>
		</td>
	</tr>
	<?
} // endif
	?>
</table>
<br />
*/?>
<?
/***********************************************************************************
						form questions
***********************************************************************************/
    foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
        if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
            echo $arQuestion["HTML_CODE"];
        }
    }
?>
    <style>
        input[type=text] {
            padding-left: 20px;
        }
    </style>
    <div class="form-close">
        <img src="<?=\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH?>/images/exit.svg">
    </div>
    <div class="subscription-field">
        <input placeholder="Ф.И.О Получателя" class="subscription-field__input"name="form_text_2" id="name" type="text" required value="<?if ($_REQUEST["form_text_2"]) echo $_REQUEST["form_text_2"]?>">
        <label class="subscription-field__label" for="name"><span class="text-primary">*</span></label>
    </div>
    <div class="subscription-field subscription-field_helping">
        <input style="margin-bottom: 0px!important;" placeholder="Компания" class="subscription-field__input" name="form_text_3" id="company" type="text" value="<?if ($_REQUEST["form_text_3"]) echo $_REQUEST["form_text_3"]?>">
        <label class="subscription-field__label" for="company"></label><span class="subscription-field__helptext">Указать при оформлении корпоративной подписки</span>
    </div>
    <div class="subscription-field">
        <input placeholder="Телефон" class="subscription-field__input" name="form_text_5" id="phone" type="text" required value="<?if ($_REQUEST["form_text_5"]) echo $_REQUEST["form_text_5"]?>">
        <label class="subscription-field__label" for="phone"><span class="text-primary">*</span></label>
    </div>
    <div class="subscription-field">
        <input placeholder="E-mail" class="subscription-field__input" name="form_email_9" id="email" type="text" required value="<?if ($_REQUEST["form_email_9"]) echo $_REQUEST["form_email_9"]?>">
        <label class="subscription-field__label" for="email"><span class="text-primary">*</span></label>
    </div>
    <div class="subscription-field">
        <textarea placeholder="Ваши комментарии\" class="subscription-field__area" name="form_textarea_4322" id="comments"><?if ($_REQUEST["form_textarea_4322"]) echo $_REQUEST["form_textarea_4322"]?></textarea>
        <label class="subscription-field__label" for="comments"></label>
    </div>

    <input class="subscription-form__checkbox"  type="checkbox" id="4053" checked name="form_checkbox_personal_data[]" value="4053">
    <label class="subscription-form__label" for="4053">Согласен на обработку <a href="/agreement/">персональных данных*</a></label>
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
    <b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b><br>
    <input type="hidden" name="captcha_sid" value="<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" /><br>
    <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" width="180" height="40" /><br>
    <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?><br>
    <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
<?
} // isUseCaptcha
?>

    <div class="g-recaptcha" id="subscribe_captcha" data-sitekey="<?=GoogleReCaptcha::getPublicKey()?>"></div>

	<input class="button button_submit button_low expanded" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialchars(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />


 <?if ($_POST) {?>
    <script>
        grecaptcha.render('subscribe_captcha', {
            'sitekey' : '<?=GoogleReCaptcha::getPublicKey()?>',
        });
    </script>
<?}?>

<p>
<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>
<?$frame->end(); // Конец фрейма?>