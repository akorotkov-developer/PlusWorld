<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); 
$APPLICATION->SetTitle($arResult['NAME']);
$APPLICATION->SetPageProperty("title", $arResult['NAME']);
?>
<?if ($_REQUEST["rt"]==1) {

$res = CIBlockElement::GetByID($arResult["ID"]);
if($ar_res = $res->GetNext())

  echo $APPLICATION->GetProperty("title");

}?>




<?
	$date = new DateTime($arResult["ACTIVE_FROM"]);
	echo "Дата публикации: ".$date->Format('d-m-Y');
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
?>
<?
		$res = CIBlockElement::GetByID($arResult['ID']);
		if($ar_res = $res->GetNext())
		  $counter = $ar_res['SHOW_COUNTER'];
		if($counter < 1)
			$counter = 0;
		$counter = intval($counter);
		$text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');
		if($_SERVER["SERVER_NAME"] == "www.plusworld.org")
			$text_counter = "views";
?>
<?
$link = trim(strip_tags(SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL']));
$title = trim(strip_tags(str_replace('&','_ampersant',$arResult['NAME'])));
$preview = trim(strip_tags(str_replace('&','_ampersant',$arResult['PREVIEW_TEXT'])));
?>

<div class="firm-detail" id="MessForPrint">
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
<img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
			<span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span><br />
			<?
function pluralForm_1($n, $form1, $form2, $form5)
{
	$n = abs($n) % 100;
	$n1 = $n % 10;
	if ($n > 10 && $n < 20) return $form5;
	if ($n1 > 1 && $n1 < 5) return $form2;
	if ($n1 == 1) return $form1;
	return $form5;
}
$name_array_1=array();
if($_SERVER["SERVER_NAME"] == "www.retail-loyalty.org") {
$user_online_counter =  user_online_counter("ip", $arResult["DETAIL_PAGE_URL"])-1;}
else {
$user_online_counter =  user_online_counter("s1", $arResult["DETAIL_PAGE_URL"])-1;
}
$text_counter_1 = pluralForm_1($user_online_counter, 'Пользователь', 'Пользователя', 'Пользователей');
$text_counter_2 = pluralForm_1($user_online_counter, 'читает', 'читают', 'читают');
if ($user_online_counter>0) {
echo "<p><span style='font-size:11px; margin-left:3px; color:rgb(184, 21, 21);'>Еще <b>".$user_online_counter."&nbsp;</b>&nbsp;".$text_counter_1." сейчас ".$text_counter_2." этот материал</span></p>" ;
}?>
<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<div class="detail_picture"><img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" /></div>
<?endif?>

<?$frame->end(); // Конец фрейма?>

<?if($arParams["SIMPLE_PAGE"]!="Y") :?>
<div class="firm-info">

</div>
<?endif?>



<div class="firm-desc">
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
    <div class="clear"></div>

<?
$arFiles = array();
$arFiles = $arResult['DISPLAY_PROPERTIES']['FILE_ATTACH']['FILE_VALUE'];
?>

<?if(isset($arFiles[0])):?>
	<p><strong>Прикрепленные файлы:</strong><br>
	<?foreach($arFiles as $files):?>
		<p><?=$files['ORIGINAL_NAME']?>&nbsp;<a href="<?=$files['SRC']?>">Скачать</a></p>
	<?endforeach;?>
<?elseif(isset($arFiles)):?>
	<p><?=$arFiles['ORIGINAL_NAME']?>&nbsp;<a href="<?=$arFiles['SRC']?>">Скачать</a></p>
<?endif;?>
</p>

<?if($arParams["SIMPLE_PAGE"]!="Y") :?>
    <div class="art-links">
        <a href="javascript://" onclick="atoprint('MessForPrint');"><?=GetMessage("FIRMS_PRINT_PAGE");?></a> &nbsp;
        <a id="iframe" href="/share.php?link=<?=$link?>&title=<?=$title?>&preview=<?=$preview?>"><?=GetMessage("FIRMS_SEND_FRIEND");?></a> &nbsp;
        <a href="<?if($_SERVER["SERVER_NAME"] == "www.retail-loyalty.org") {?>/contact_information/submit_news/<?} else {?>/daily/add_news/<? } ?>">Разместить новость</a>&nbsp;
        <a href="<?if($_SERVER["SERVER_NAME"] == "www.retail-loyalty.org") {?>/journal_retail_loyalty/podpiska/<?} else {?>/journal/subscribe/<? } ?>">Подписаться на журнал</a>
    </div>
<br /><br />
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-send="false" data-width="450" data-show-faces="false"></div>

<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru">Твитнуть</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>



<br /><br />

        <div class="clear"></div>

    <div class="firm-detail-navig">
    <?if (is_array($arResult["PREV"]) && !empty($arResult["PREV"])){?>
        <a href="<?=$arResult["SECTION_URL"];?><?=$arResult["PREV"]["LINK"];?>/" class="prev">&larr;&nbsp;<?//=$arResult["PREV"]["TITLE"]?><?=GetMessage("FIRMS_PREV")?></a>
    <?}?>
    <?if (is_array($arResult["NEXT"]) && !empty($arResult["NEXT"])){?>
        <a href="<?=$arResult["SECTION_URL"];?><?=$arResult["NEXT"]["LINK"];?>/" class="next"><?//=$arResult["NEXT"]["TITLE"]?><?=GetMessage("FIRMS_NEXT")?>&nbsp;&rarr;</a>
    <?}?>
        <a href="<?=$arResult["SECTION_URL"];?>"><?=GetMessage("FIRMS_BACK")?> &uarr;</a>
    </div>
<?endif?>
</div>
<div class="clear"></div>
