<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//*************************************
//show confirmation form
//*************************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="get">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<thead><tr><td colspan="2"><h1><?echo GetMessage("subscr_title_confirm")?></h1></td></tr></thead>
<tr valign="top">
	<td class="up">
		<p><?echo GetMessage("subscr_conf_code")?><span class="starrequired">*</span><br />
		<input type="text" name="CONFIRM_CODE" value="<?echo $arResult["REQUEST"]["CONFIRM_CODE"];?>" size="20" /></p>
		<p><?echo GetMessage("subscr_conf_date")?>: <?echo $arResult["SUBSCRIPTION"]["DATE_CONFIRM"];?></p>

		<p class="desc"><?echo GetMessage("subscr_conf_note1")?> <a title="<?echo GetMessage("adm_send_code")?>" href="<?echo $arResult["FORM_ACTION"]?>?ID=<?echo $arResult["ID"]?>&amp;action=sendcode&amp;<?echo bitrix_sessid_get()?>"><?echo GetMessage("subscr_conf_note2")?></a>.</p>
	</td>
</tr>
<tfoot><tr><td colspan="2"><br /><input type="submit" name="confirm" value="<?echo GetMessage("subscr_conf_button")?>" /></td></tr></tfoot>
</table>

<input type="hidden" name="ID" value="<?echo $arResult["ID"];?>" />
<?echo bitrix_sessid_post();?>
</form>
<br />
