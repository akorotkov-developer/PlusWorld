<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?='<?xml version="1.0" encoding="'.SITE_CHARSET.'"?>'?>
<rss version="2.0"<?if($arParams["YANDEX"]) echo ' xmlns="http://backend.userland.com/rss2" xmlns:yandex="http://news.yandex.ru"';?>>
<channel>
<title><?=$arResult["NAME"].(strlen($arResult["SECTION"]["NAME"])>0?" / ".$arResult["SECTION"]["NAME"]:"")?></title>
<link><?="http://".$arResult["SERVER_NAME"]?></link>
<description><?=strlen($arResult["SECTION"]["DESCRIPTION"])>0?$arResult["SECTION"]["DESCRIPTION"]:$arResult["DESCRIPTION"]?></description>
<lastBuildDate><?=date("r")?></lastBuildDate>
<ttl><?=$arResult["RSS_TTL"]?></ttl>
<?//if(is_array($arResult["PICTURE"])):?>
<image>
	<url>http://www.retail-loyalty.org/images/rss-yandex/rl-logo.png</url>
	<title>Новости Retail&amp;Loyalty</title>
	<link>http://www.retail-loyalty.org/</link>
</image>
<?//endif?>
<?foreach($arResult["ITEMS"] as $arItem):?>
<item>
	<title><?=$arItem["title"]?></title>
	<link><?=$arItem["link"]?></link>
	<description><?
	$l = $arItem["description"];
	$l = htmlspecialchars_decode($l);
	$l = strip_tags($l);
	$l = str_replace(array("&ldquo;", "&rdquo;","&laquo;","&raquo;"), '"',$l);
	$l = str_replace(array("&ndash;"), '-',$l);
	$l = htmlspecialchars($l);
	echo $l;
	?></description>
	<?if(is_array($arItem["enclosure"])):?>
		<enclosure url="<?=$arItem["enclosure"]["url"]?>" length="<?=$arItem["enclosure"]["length"]?>" type="<?=$arItem["enclosure"]["type"]?>"/>
	<?endif?>
	<?if($arItem["category"]):?>
		<category><?=$arItem["category"]?></category>
	<?endif?>
	<?if($arParams["YANDEX"]):?>

	<yandex:full-text><?
	$r = $arItem["full-text"];
	    $a = str_replace('По материалам', '', $r);	
		$t = htmlspecialchars_decode($a);
		$t = strip_tags($t);
		$t = str_replace(array("&ldquo;", "&rdquo;","&laquo;","&raquo;"), '"',$t);
		$t = str_replace(array("&ndash;"), '-',$t);
		$t = htmlspecialchars($t);
	
	echo $t;
		?>
	</yandex:full-text>
	<?endif?>
	<pubDate><?=$arItem["pubDate"]?></pubDate>
</item>
<?endforeach?>
</channel>
</rss>
