<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);
?>

<div class="cell auto">
    <div class="text-center">
        <h1 class="margin-bottom-10"><?$APPLICATION->ShowTitle();?></h1>
    </div>
    <div class="grid-x grid-padding-x align-center">
        <div class="cell small-24 medium-24 large-16">
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
                <p>
                    <?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
                </p>


                <b><?=GetMessage("AUTH_GET_CHECK_STRING")?></b><br>
                <label><?=GetMessage("AUTH_LOGIN")?>
                    <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />&nbsp;<?=GetMessage("AUTH_OR")?>
                </label>

                <label><?=GetMessage("AUTH_EMAIL")?>
                    <input type="text" name="USER_EMAIL" maxlength="255" />
                </label>

                <button class="button" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>"><?=GetMessage("AUTH_SEND")?> &nbsp;<i class="far fa-envelope fa-lg"></i></button>
                <a href="<?=$arResult["AUTH_AUTH_URL"]?>" title=""><?=GetMessage("AUTH_AUTH")?></a>

            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>



<div class="cell medium-8 large-6">
    <div class="margin-bottom-10">
        <?
        $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/include/journal.php");
        ?>
    </div>
    <div class="margin-bottom-10">
        <?
        $APPLICATION->IncludeFile(\Plusworld\Config::PLUSWORLD_TEMPLATE_PATH."/include/forum-expertov.php");
        ?>
    </div>
</div>