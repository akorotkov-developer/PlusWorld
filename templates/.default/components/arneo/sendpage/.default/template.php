<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>
<?if ($arParams["INCLUDE_JQUERY"] == 'Y') $APPLICATION->AddHeadScript('//yandex.st/jquery/2.0.0/jquery.min.js');?>

<span class="sp-link" id="sp_link_<?=$arParams["ID"]?>"><?=GetMessage("SP_LINK")?></span>
<div class="sendpage <?=(empty($arResult["ERROR_MESSAGE"]) && strlen($arResult["OK_MESSAGE"]) == '0' ? "sp-hide" : '');?>" id="sp_form_<?=$arParams["ID"]?>">
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="sp-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=$APPLICATION->GetCurPage()?>" method="POST">
<?=bitrix_sessid_post()?>
    <div class="sp-to-email">
		<label class="sp-text">
			<?=GetMessage("SP_SUBJECT")?><br />
            <input type="text" name="subject" value="<?=($arResult["SUBJECT"] ? $arResult["SUBJECT"] : $APPLICATION->GetTitle());?>"/>
        </label>
	</div>
    <div class="sp-to-email">
		<label class="sp-text">
			<?=GetMessage("SP_TO_EMAIL")?><span class="sp-req">*</span><br />
            <input type="text" name="to_email" value="<?=$arResult["TO_EMAIL"]?>"/>
        </label>
	</div>
	<div class="sp-name">
		<label class="sp-text">
			<?=GetMessage("SP_NAME")?><span class="sp-req">*</span><br />
            <input type="text" name="from_name" value="<?=$arResult["FROM_NAME"]?>"/>
		</label>
	</div>
	<div class="sp-email">
		<label class="sp-text">
			<?=GetMessage("SP_EMAIL")?><span class="sp-req">*</span><br />
            <input type="text" name="from_email" value="<?=$arResult["FROM_EMAIL"]?>"/>
		</label>
	</div>
	<div class="sp-message">
		<label class="sp-text">
			<?=GetMessage("SP_MESSAGE")?><br />
            <textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
		</label>
	</div>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="sp-captcha">
		<label class="sp-text"><?=GetMessage("SP_CAPTCHA")?>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>"/>
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA"/>
		<?=GetMessage("SP_CAPTCHA_CODE")?><span class="sp-req">*</span><br />
		<input type="text" name="captcha_word" size="30" maxlength="50" value=""/></label>
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>"/>
	<input type="hidden" name="PAGE_URL" value="http://<?=$_SERVER["HTTP_HOST"].$APPLICATION->GetCurUri();?>"/>

	<div class="sp-submit"><input type="submit" name="submit" value="<?=GetMessage("SP_SUBMIT")?>"/></div>
</form>
</div>