<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?=ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
	echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>


<form class="form-personal" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>" />
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
    <div id="user_div_reg">

        <div class="grid-x margin-bottom-6 align-middle">
            <div class="cell auto">
                <h3 class="margin-0">Личные данные</h3>
            </div>
            <div class="cell shrink">
                <button class="button button_low hollow" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">Сохранить</button>
            </div>
        </div>

        <div class="margin-bottom-12">
            <input type="text" name="EMAIL" maxlength="50" placeholder="<?=GetMessage('EMAIL')?>" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
            <input type="text" name="NAME" maxlength="50" placeholder="<?=GetMessage('NAME')?>" value="<?=$arResult["arUser"]["NAME"]?>" />
            <input type="text" name="LAST_NAME" maxlength="50" placeholder="<?=GetMessage('LAST_NAME')?>" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
            <input type="text" name="SECOND_NAME" maxlength="50" placeholder="<?=GetMessage('SECOND_NAME')?>" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
            <input type="text" name="USER_PHONE" maxlength="255" placeholder="<?=GetMessage('USER_PHONE')?>" value="<?=$arResult["arUser"]["USER_PHONE"]?>" />
            <input type="text" name="LOGIN" maxlength="50" placeholder="<?=GetMessage('LOGIN')?>" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
            <input type="text" name="WORK_COMPANY" maxlength="255" placeholder="<?=GetMessage('USER_COMPANY')?>" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" />
            <input type="text" name="WORK_POSITION" maxlength="255" placeholder="<?=GetMessage('USER_POSITION')?>" value="<?=$arResult["arUser"]["WORK_POSITION"]?>" />
            <span class="form-personal__text">Указажите все данных и Вам будет доступна Еженедельная тематическая рассылка (рассылка отправляется 1 раз в неделю)
            <div class="text-primary">+ подписка на электронную версию журнала на 1 месяц</div></span>
        </div>

        <div class="form-personal__custom">
            <input type="password" name="NEW_PASSWORD" maxlength="50" placeholder="Новый пароль" value="" autocomplete="off" />
            <?if($arResult["SECURE_AUTH"]):?>
                <span id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                    <div class="bx-auth-secure-icon"></div>
                </span>
                <noscript>
                <span title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                    <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                </span>
                </noscript>
                <script type="text/javascript">
                    document.getElementById('bx_auth_secure').style.display = 'inline-block';
                </script>
            <?endif?>

            <input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" placeholder="Повторить пароль" value="" autocomplete="off" />
        </div>
        <span class="form-personal__text">Укажите новый пароль<br>Пароль должен быть не менее 6 символов.</span>

    </div>


    <?// ********************* User properties ***************************************************?>
    <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
    <div class="profile-link profile-user-div-link"><a title="<?=GetMessage("USER_SHOW_HIDE")?>" href="javascript:void(0)" OnClick="javascript: SectionClick('user_properties')"><?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></a></div>
    <div id="user_div_user_properties" class="profile-block-<?=strpos($arResult["opened"], "user_properties") === false ? "hidden" : "shown"?>">
    <table class="data-table profile-table">
        <thead>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </thead>
        <tbody>
        <?$first = true;?>
        <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
        <tr><td class="field-name">
            <?if ($arUserField["MANDATORY"]=="Y"):?>
                <span class="starrequired">*</span>
            <?endif;?>
            <?=$arUserField["EDIT_FORM_LABEL"]?>:</td><td class="field-value">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.field.edit",
                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
        <?endforeach;?>
        </tbody>
    </table>
    </div>
    <?endif;?>
    <?// ******************** /User properties ***************************************************?>
    <p class="desc"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
</form>

