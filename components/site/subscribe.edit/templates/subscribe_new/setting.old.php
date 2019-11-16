<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<?echo bitrix_sessid_post();?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<thead><tr><td colspan="2"><h1><?echo GetMessage("subscr_title_settings")?></h1></td></tr></thead>
<tr valign="top">
	<td class="up">
		<p><?echo GetMessage("subscr_email")?><span class="starrequired">*</span><br />
		<input type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="30" maxlength="255" /></p>

        <p><?echo GetMessage("subscr_settings_note1")?></p>
		<p><?echo GetMessage("subscr_settings_note2")?></p>

	</td>
</tr>
<tr>
    <td colspan="2">
<br />
		<h1><?echo GetMessage("subscr_rub")?><span class="starrequired">*</span></h1>
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
		<?if ($itemValue["ID"]!=53) {?>
			<div class="pad_5"><label><input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> />&nbsp;<?=$itemValue["NAME"]?></label></div>
		<? } ?>
		<?endforeach;?><br />
		<p><?echo GetMessage("subscr_fmt")?></p>
		<div class="up"><label><input type="radio" name="FORMAT" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?> />&nbsp;<?echo GetMessage("subscr_text")?></label>&nbsp;/&nbsp;<label><input type="radio" name="FORMAT" value="html" <?if(!$arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked='checked' "?> />&nbsp;HTML</label></div>
    </td>
</tr>
<tfoot>
<tr>
    <td colspan="2"><br />
	<input type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
	<input type="reset" value="<?echo GetMessage("subscr_reset")?>" name="reset" />
</td></tr></tfoot>
</table>
<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?if($_REQUEST["register"] == "YES"):?>
	<input type="hidden" name="register" value="YES" />
<?endif;?>
<?if($_REQUEST["authorize"]=="YES"):?>
	<input type="hidden" name="authorize" value="YES" />
<?endif;?>
</form>
<br />
