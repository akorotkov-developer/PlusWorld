<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<div class="firm-detail" id="MessForPrint">

<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<div class="detail_picture"><img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" /></div>
<?endif?>


<div class="firm-info">

</div>

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
	<div style="clear:both"></div></div>
    <div class="clear"></div>


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

<?
//print_r($arResult);
$arFiles = array();
$arFiles = $arResult['DISPLAY_PROPERTIES']['FILE_ATTACH']['FILE_VALUE'];
//print_r($arFiles);
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
</div>
<div class="clear"></div>
