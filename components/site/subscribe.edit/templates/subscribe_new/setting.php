<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<input type='hidden' name='left_sub' value="<?=$_POST["left_sub"]?>" >
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
<div style="display: none">
		<h1><?echo GetMessage("subscr_rub")?><span class="starrequired">*</span></h1>
		<?
		//echo "<pre>"; print_r($arResult); echo "</pre>";
		$C_it = array();
		foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
		<?if ($itemValue["CHECKED"]==1) {
			$C_it[] = $itemValue["ID"];
		}?>
		<?endforeach;?>
	<?
	if ($_COOKIE["left_sub_per"]=="true_1") {

			$str_C_it = implode(",", $C_it);
			SetCookie("C_it",$str_C_it,time() + 300,'/');
			//echo "<pre>"; print_r(@$_COOKIE); echo "</pre>";
			$ar_cook1 = $_COOKIE["C_it"];
			//if (isset($_COOKIE["C_it"])) echo "111-".$ar_cook1;
			$str_C_it_1 = array();
			$pos = strpos($_COOKIE["C_it"], ',');
			if ($pos != false) {
				$str_C_it_1 = explode(",",$_COOKIE["C_it"]);
			}
			else
			{
				$str_C_it_1[] = $_COOKIE["C_it"];
			}

		//		echo "<pre>"; print_r($C_it); echo "</pre>";
		//	echo "<pre>"; print_r($str_C_it_1); echo "</pre>";
		

				
				if (($_COOKIE["left_sub_per"]=="true_1")&&(in_array(18,$C_it))){
				$date=date("j.m.Y  G:i");
				
				$arEventFields = array(
				"DATE"      => $date,
				"USER_ID"      => $arResult["ID"],
				"USER_EMAIL"      => $arResult["SUBSCRIPTION"]["EMAIL"]
				);
								
				CEvent::Send("ADD_SUBSCRIBER_BLOCK", "ip", $arEventFields);
				SetCookie("left_sub_per","false_0",time() - 300,'/');
			}
		
	}?>
</div>
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
