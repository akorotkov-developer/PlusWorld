<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="banner_news">
	<?$APPLICATION->IncludeComponent(
		"bitrix:advertising.banner",
		"",
		Array(
			"TYPE" => "SUB_DAILY_SPONSOR",
			"NOINDEX" => "Y",
			"CACHE_TYPE" => "N",
			"CACHE_TIME" => "0"
		),
		false,
		Array(
			'ACTIVE_COMPONENT' => 'Y'
		)
	);?>
</div>

<div class="banner_news">
	<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "", Array(
			"TYPE" => strtoupper(str_replace("-","_","RL_".$arResult["SECTION"]["PATH"][0]["CODE"]))."_SPONSOR",	// Тип баннера
			"CACHE_TYPE" => "N",	// Тип кеширования
			"NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
			"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		),
		false
	);?>
</div>

<div style="clear:both"></div>
<div class="firm-rating">
	<?$ElementID = $arParams["ELEMENT_ID"];?>
	<?$APPLICATION->IncludeComponent("askaron:askaron.ibvote.iblock.vote", "ajax", array(
		"IBLOCK_TYPE" => "NEWS_IP",
		"IBLOCK_ID" => "23",
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
<br/>


<div style="margin-bottom:5px;">
<a href="javascript://" onclick="atoprint('MessForPrint');">Версия для печати</a>&nbsp;&nbsp;
<a class="iframe" href="/share.php?link=<?=SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL']?>&title=<?=str_replace('&','_ampersant',$arResult['NAME'])?>&preview=<?=str_replace('&','_ampersant',$arResult['PREVIEW_TEXT'])?>">Отправить другу</a>
</div>
<?
$ID = $arResult["ID"];
$id_sessid = bitrix_sessid();
add_material_RL_RU($ID,$id_sessid);
?>
<div class="news-detail">

<?$res = CIBlockElement::GetByID($arResult["ID"]);
if($ar_res = $res->GetNext())
  $counter = $ar_res['SHOW_COUNTER'];
if($counter < 1)
	$counter = 0;
$counter = intval($counter);
?>

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

$text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
?>

<div id="MessForPrint">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
	<div class="news-picture">
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	</div>
	<?endif?>

	
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span class="news-date-time" style="color:#555 !important;"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
		<img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
		<span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>
	<?endif;?>
	
	
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<div class="news-text">
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

	<?foreach($arResult["FIELDS"] as $code=>$value):?>
		<?if ($code != 'PREVIEW_PICTURE'):?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
		<?endif?>
	<?endforeach;?>

	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<?if($pid != "THEME"):?>
			<div class="news-property"><?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</div>
		<?endif?>
	<?endforeach;?>
		<?/*<div class="news-property">
			<?=GetMessage("T_NEWS_SHORT_URL");
			$shortPageURL = (CMain::IsHTTPS()) ? "https://" : "http://";
			$shortPageURL.= $_SERVER["HTTP_HOST"].CBXShortUri::GetShortUri($arResult["~DETAIL_PAGE_URL"]);
			?>
			<a href="<?=$shortPageURL?>"><?=$shortPageURL?></a>
		</div>*/?>
	</div>
	
	</div>
	<div class="news-detail-back">
	<a href="<?=$arResult["LIST_PAGE_URL"]?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></div>
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
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<?if($pid == "THEME" && count($arResult["ITEMS_THEME"]) > 0 ):?>
			<div class="news-detail-theme">
			<div class="news-theme-title"><?=GetMessage("T_NEWS_DETAIL_THEME")?>:&nbsp;
				<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode(",&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</div>
			<?foreach($arResult["ITEMS_THEME"] as $pid=>$arProperty):?>
				<div class="news-theme-item"><div class="news-theme-date"><?=$arProperty["ACTIVE_FROM"]?></div><div class="news-theme-url"><a href="<?=$arProperty["DETAIL_PAGE_URL"]?>"><?=$arProperty["NAME"]?></a></div></div>
			<?endforeach;?>
			<div class="br"></div>
			</div>
		<?endif?>
	<?endforeach;?>
</div>
