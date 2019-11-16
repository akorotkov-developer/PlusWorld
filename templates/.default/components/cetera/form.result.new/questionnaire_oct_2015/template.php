<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?if ($arResult["FORM_NOTE"]) :?><div id="message">
	<div class="notetext"><?=$arResult["FORM_NOTE"]?>
	
	</div>
	 <script type="text/javascript">
	   window.location.hash = 'message';
	</script>
</div><?endif;?>
<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>

<table>
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<tr>
		<td><?
/***********************************************************************************
					form header
***********************************************************************************/
if ($arResult["isFormTitle"])
{/*
?>
	<h3><?=$arResult["FORM_TITLE"]?></h3>
<?*/
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
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>
<?//$arResult["QUESTIONS"];
				//echo "<pre>";
				//print_r($arResult);
				//echo "</pre>";
?>
<?//$arResult["QUESTIONS"];
				//echo "<pre>";
				//print_r($arResult["QUESTIONS"]["QUESTIONNAIRE_1"]);
				//echo "</pre>";
?>

<div style="width:47%;float:left"><?=$arResult["QUESTIONS"]["name"]["CAPTION"];?>:<?if ($arResult["QUESTIONS"]["name"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
 <?=$arResult["QUESTIONS"]["name"]["HTML_CODE"];?></div>
<div style="width:47%;float:left"><?=$arResult["QUESTIONS"]["lastname"]["CAPTION"];?>:<?if ($arResult["QUESTIONS"]["lastname"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
 <?=$arResult["QUESTIONS"]["lastname"]["HTML_CODE"];?></div>
<div class="clear"></div><br />

    <div style="width:47%;float:left"><?=$arResult["QUESTIONS"]["email"]["CAPTION"];?>:<?if ($arResult["QUESTIONS"]["email"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <?=$arResult["QUESTIONS"]["email"]["HTML_CODE"];?></div>
    <br /><br /><br />

<div style="width:100%; margin-bottom: 5px;"><?=$arResult["QUESTIONS"]["plus_daily"]["CAPTION"];?>
<?if ($arResult["QUESTIONS"]["plus_daily"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
<?=$arResult["QUESTIONS"]["plus_daily"]["HTML_CODE"];?>
    <br /><br /><br />

<div style="width:100%; margin-bottom: 5px;"><?=$arResult["QUESTIONS"]["plus_journal"]["CAPTION"];?>
<?if ($arResult["QUESTIONS"]["plus_journal"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
<?=$arResult["QUESTIONS"]["plus_journal"]["HTML_CODE"];?>
    <br /><br /><br />

    <div style="width:100%; margin-bottom: 5px;"><?=$arResult["QUESTIONS"]["plus_journal_sub"]["CAPTION"];?>
        <?if ($arResult["QUESTIONS"]["plus_journal_sub"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
    <?=$arResult["QUESTIONS"]["plus_journal_sub"]["HTML_CODE"];?>
    <br /><br /><br />

    <div style="width:100%; margin-bottom: 5px;"><?=$arResult["QUESTIONS"]["news_retail"]["CAPTION"];?>
        <?if ($arResult["QUESTIONS"]["news_retail"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
    <?=$arResult["QUESTIONS"]["news_retail"]["HTML_CODE"];?>
    <br /><br /><br />

    <div style="width:100%; margin-bottom: 5px;"><?=$arResult["QUESTIONS"]["podpis_retail"]["CAPTION"];?>
        <?if ($arResult["QUESTIONS"]["podpis_retail"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
    <?=$arResult["QUESTIONS"]["podpis_retail"]["HTML_CODE"];?>
    <br /><br /><br />

    <div style="width:100%; margin-bottom: 5px;"><?=$arResult["QUESTIONS"]["free_sub"]["CAPTION"];?><?if ($arResult["QUESTIONS"]["free_sub"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
    <?=$arResult["QUESTIONS"]["free_sub"]["HTML_CODE"];?>
    <br /><br /><br />

<div style="width:100%; margin-bottom: 5px;">Какие отраслевые издания (журналы/сайты) Вы читаете?</div>

    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["plus_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["plus_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["plus_read"]["HTML_CODE"];?></div>
    <div class="clear"></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["plus_jur_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["plus_jur_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["plus_jur_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["banki_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["banki_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["banki_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["bankir_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["bankir_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["bankir_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["cnews_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["cnews_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["cnews_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["futurebanking_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["futurebanking_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["futurebanking_read"]["HTML_CODE"];?></div>

    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["abzh_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["abzh_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["abzh_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["bank_teh_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["bank_teh_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["bank_teh_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["bank_delo_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["bank_delo_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["bank_delo_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["bank_obozr_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["bank_obozr_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["bank_obozr_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["retailloyalty"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["retailloyalty"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["retailloyalty"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["retailloyaltyorg"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["retailloyaltyorg"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["retailloyaltyorg"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["mir_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["mir_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["mir_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["nbj_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["nbj_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["nbj_read"]["HTML_CODE"];?></div>
    <div style="padding-top: 5px;padding-bottom:10px">
        <div style="width:40%;float:left">
            <?=$arResult["QUESTIONS"]["other_read"]["CAPTION"];?>
            <?if ($arResult["QUESTIONS"]["other_read"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?> </div>
        <?=$arResult["QUESTIONS"]["other_read"]["HTML_CODE"];?></div>
    <br /><br /><br />

    <div style="width:100;"><?=$arResult["QUESTIONS"]["result_speaker"]["CAPTION"];?>:<?if ($arResult["QUESTIONS"]["result_speaker"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["result_speaker"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["plus_2016"]["CAPTION"];?>:<?if ($arResult["QUESTIONS"]["plus_2016"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["plus_2016"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["vistup_plus"]["CAPTION"];?>:<?if ($arResult["QUESTIONS"]["vistup_plus"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["vistup_plus"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["priglashenie"]["CAPTION"];?>:
        <?if ($arResult["QUESTIONS"]["priglashenie"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["priglashenie"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["uroven"]["CAPTION"];?>:
        <?if ($arResult["QUESTIONS"]["uroven"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["uroven"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["time"]["CAPTION"];?>:
        <?if ($arResult["QUESTIONS"]["time"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["time"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["time_pojelenie"]["CAPTION"];?>:
        <?if ($arResult["QUESTIONS"]["time_pojelenie"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["time_pojelenie"]["HTML_CODE"];?></div>
    <br /><br /><br />
    <div style="width:100;"><?=$arResult["QUESTIONS"]["pojelanie_organizstor"]["CAPTION"];?>:
        <?if ($arResult["QUESTIONS"]["pojelanie_organizstor"]["REQUIRED"] == "Y"){echo $arResult["REQUIRED_SIGN"];}?>
        <br /><?=$arResult["QUESTIONS"]["pojelanie_organizstor"]["HTML_CODE"];?></div>


<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
<p><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></p>
<p><input type="hidden" name="captcha_sid" value="<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" width="180" height="40" /></p>
<p><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></p>
<p><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></p>
<?
} // isUseCaptcha
?>

<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialchars(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
				<?if ($arResult["F_RIGHT"] >= 15):?>
				&nbsp;<input type="hidden" name="web_form_apply" value="Y" />
				<?/*<input type="submit" name="web_form_apply" value="<?=GetMessage("FORM_APPLY")?>" />*/?>
				<?endif;?>
				<?/*&nbsp;<input type="reset" value="<?=GetMessage("FORM_RESET");?>" />*/?>
<p>
<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>
<?$frame->end(); // Конец фрейма?>