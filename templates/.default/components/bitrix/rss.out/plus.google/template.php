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
	<url>http://www.plusworld.ru/images/rss-yandex/logo.jpg</url>
	<title>Новости журнала ПЛАС</title>
	<link>http://www.plusworld.ru/</link>
</image>
<?//endif?>
<?foreach($arResult["ITEMS"] as $arItem):?>
<?//print_r($arItem['ELEMENT']['ID'])?>
<item>
	<title><?=$arItem["title"]?></title>
	<link><?=$arItem["link"].'?id='.$arItem['ELEMENT']['ID']?></link>
	<description><?=$arItem["description"]?></description>
	<?if(is_array($arItem["enclosure"])):?>
		<enclosure url="<?=$arItem["enclosure"]["url"]?>" length="<?=$arItem["enclosure"]["length"]?>" type="<?=$arItem["enclosure"]["type"]?>"/>
	<?endif?>
	<?if($arItem["category"]):?>
		<category><?=$arItem["category"]?></category>
	<?endif?>
	<?if($arParams["YANDEX"]):?>
		<yandex:full-text><?
		$arItem["full-text"] = substr_replace ($arItem["full-text"], '', strpos($arItem["full-text"], 'По материалам'));
		$a = $arItem["full-text"];
		$a = htmlspecialchars_decode($a);
		$a = strip_tags($a);
		$a = str_replace(array("&ldquo;", "&rdquo;"), '"',$a);
		$a = htmlspecialchars($a);
		//$a = str_replace("“",'"',$a);
		echo $a;
		?></yandex:full-text>
	<?endif?>
	<pubDate><?=$arItem["pubDate"]?></pubDate>
</item>
<?endforeach?>
</channel>
</rss>
