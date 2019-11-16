<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?//if(isset($_REQUEST["dd"])) print_r($arResult);
$sectionID = $arResult['SECTION']['PATH']['0']['ID'];
?>
<?
global $USER;
$arFilter = array("ID" => $USER->GetID());
$arParams["SELECT"] = array("UF_CLOSE_GALLERY");
$arUser = CUser::GetList($by,$desc,$arFilter,$arParams);
if ($user = $arUser->Fetch()) {
	$arUserId[] = $user["ID"];
}

$ar_result=CIBlockSection::GetList(Array("SORT"=>"DESC"), Array("IBLOCK_ID"=>"33", "ID"=>$sectionID),false, Array("UF_CLOSE_GALLERY"));
$res=$ar_result->GetNext();
?>
<?if($res["UF_CLOSE_GALLERY"] != "1" || ($res["UF_CLOSE_GALLERY"] == "1" and ($USER->IsAdmin() or in_array($USER->GetID(), $arUserId)))):?>
	<div class="news-head">
	<?//if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h1><?=$arResult["NAME"]?></h1>
	<?//endif;?>
	<br />
		<div class="art-links">
				<a href="javascript://" onclick="atoprint('MessForPrint');"><?=GetMessage("DAILY_NEWS_PRINT");?></a> &nbsp;
				<a id="iframe" href="/share.php?link=<?=SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL']?>&title=<?=str_replace('&','_ampersant',$arResult['NAME'])?>&preview=<?=str_replace('&','_ampersant',$arResult['PREVIEW_TEXT'])?>"><?=GetMessage("DAILY_NEWS_SEND");?></a> &nbsp;
				<a href="/journal/subscribe/"><?=GetMessage("DAILY_NEWS_JOURNAL_SUBS");?></a>
		</div>
	<div class="clear"></div>
	</div>

	<div class="news-detail">
		<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["PROPERTIES"]["DATE_START"]["VALUE"]):?><span class="event-date-time "><?echo ConvertDateTime($arResult["PROPERTIES"]["DATE_START"]["VALUE"], "DD.MM.YYY")?><?if (MakeTimeStamp($arResult["PROPERTIES"]["DATE_END"]["VALUE"]) > MakeTimeStamp($arResult["PROPERTIES"]["DATE_START"]["VALUE"])+86400):?> &ndash; <?echo ConvertDateTime($arResult["PROPERTIES"]["DATE_END"]["VALUE"], "DD.MM.YYY")?><?endif;?></span> &nbsp; <?endif?>
		<div>
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>

	<img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="views" title="views" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
		<span style="font-size:11px; margin-left:3px; color:#555;"><?=$arResult["COUNTER"]?>&nbsp;<?=$arResult["TEXT_COUNTER"]?></span>
	<?$frame->end(); // Конец фрейма?>
	</div>
	<div class="firm-rating">
	<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
	<?$ElementID = $arParams["ELEMENT_ID"];?>
	<?$APPLICATION->IncludeComponent("askaron:askaron.ibvote.iblock.vote", "ajax", array(
		"IBLOCK_TYPE" => "services_org",
		"IBLOCK_ID" => "33",
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
	<?$frame->end(); // Конец фрейма?>
	</div>

	<br />
	<div id="MessForPrint">

	<?=$arResult["PROPERTIES"]["VIDEO"]["~VALUE"]["TEXT"]?>
	<?/*<div class="news-rating">
		<?=GetMessage("DAILY_NEWS_RATING");?>
	</div>
	<div class="news-comments">
	 <?$APPLICATION->IncludeComponent(
		"cetera:comments.count",
		"",
		Array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"COMMENTS_IBLOCK_ID" => 20,
		),
		false
	);?>
	</div>*/?><br />
	<div class="clear"></div>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
			<div class="detail_picture"><img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" /></div>
		<?endif?>

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
	</div>
	<p>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_EN/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-like" data-send="false" data-width="450" data-show-faces="false"></div>

	<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en"></a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</p>



		<div style="clear:both"></div>
		<br />




		<div class="news-detail-links">

			<?/*<a href="#"><?=GetMessage("DAILY_NEWS_SEND");?></a> &nbsp;&nbsp;
			<a href="#comments"><?=GetMessage("DAILY_NEWS_COMMENT");?> &darr;</a> &nbsp;*/?>
		</div>

			<div class="clear"></div>

		<div class="news-detail-navig">
		<?if ($arResult["PREV"]){?>
			<a href="<?=$arResult["PREV"]['DETAIL_PAGE_URL']?>" class="prev">&larr;&nbsp;<?=GetMessage("DAILY_NEWS_PREV");?></a>
		<?}?>
		<?if ($arResult["NEXT"]){?>
			<a href="<?=$arResult["NEXT"]['DETAIL_PAGE_URL'];?>" class="next"><?=GetMessage("DAILY_NEWS_NEXT");?>&nbsp;&rarr;</a>
		<?}?>
			<a href="<?=$arResult["SECTION"]["PATH"][0]["SECTION_PAGE_URL"];?>"><?=GetMessage("DAILY_NEWS_RUBRIC_RET");?> &uarr;</a>
		</div>
	</div>
	<div class="clear"></div><br />
<?else:?>
	<h1 style="color:red;">The gallery is closed from public viewing</h1>
<?endif;?>
