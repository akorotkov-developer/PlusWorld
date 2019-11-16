<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<div class="firm-rating">
	<?$ElementID = $arParams["ELEMENT_ID"];?>
	<?$APPLICATION->IncludeComponent("askaron:askaron.ibvote.iblock.vote", "ajax", array(
		"IBLOCK_TYPE" => "journals",
		"IBLOCK_ID" => "41",
		"ELEMENT_ID" => $ElementID,
		"SESSION_CHECK" => "Y",
		"COOKIE_CHECK" => "Y",
		"IP_CHECK_TIME" => "86400",
		"USER_ID_CHECK_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"MAX_VOTE" => "5",
		"VOTE_NAMES" => array(
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "4",
			4 => "5",
			5 => "",
		),
		"SET_STATUS_404" => "N",
		"DISPLAY_AS_RATING" => "vote_avg"
		),
		false
	);?>	
	</div>
	<div style="clear:both"></div>
<?
function pluralForm($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}
?>

<?
$res = CIBlockElement::GetByID($arResult['ID']);
if($ar_res = $res->GetNext())
  $counter = $ar_res['SHOW_COUNTER'];
if($counter < 1)
	$counter = 0;
$counter = intval($counter);
$text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
if($_SERVER["REAL_FILE_PATH"] == "/en/journal/read_online/journal_text.php")
	$text_counter = "views";
//if(isset($_REQUEST['ff'])) print_r($_SERVER);
?>

<p>
	<?//if(isset($_REQUEST['ff'])) var_dump($arResult);?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span style="color:#555; font-size:11px;"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?else:?>
		<span style="color:#555; font-size:11px;"><?=$arResult["PREVIEW_PICTURE"]["TIMESTAMP_X"]?></span>
	<?endif;?>
	<img src="<?=SITE_TEMPLATE_PATH?>/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
	<span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>
</p>

<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
		
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	
<?$db_props = CIBlockElement::GetProperty(40, $arResult['PROPERTIES']['JOURNAL']['VALUE'] , "sort", "asc", Array("CODE"=>"ONLINE"));
if($ar_props = $db_props->Fetch()):
//echo "<pre>".print_r($ar_props, true)."</pre>";
endif;?>

<?if(!empty($ar_props['VALUE'])):?>
<p><a href="<?=$ar_props['VALUE']?>">Читать полную электронную версию номера журнала "Retail&Loyalty"</a></p>
<?endif?>

<p>	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-like" data-send="false" data-width="450" data-show-faces="false"></div>
	<a href="https://twitter.com/share" class="twitter-share-button" ><?=GetMessage("TWEET_TEXT")?></a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</p>
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;?>
	<?
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
</div>
