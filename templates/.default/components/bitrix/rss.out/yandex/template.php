<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?='<?xml version="1.0" encoding="'.SITE_CHARSET.'"?>'?>
<rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" version="2.0">
<channel>
<title><?=$arResult["NAME"].(strlen($arResult["SECTION"]["NAME"])>0?" / ".$arResult["SECTION"]["NAME"]:"")?></title>
<link><?="http://".$arResult["SERVER_NAME"]?></link>
<description><?=strlen($arResult["SECTION"]["DESCRIPTION"])>0?$arResult["SECTION"]["DESCRIPTION"]:$arResult["DESCRIPTION"]?></description>
<lastBuildDate><?=date("r")?></lastBuildDate>
<ttl><?=$arResult["RSS_TTL"]?></ttl>

<image> 
	<url>http://www.plusworld.ru/images/plus_logo.jpg</url>
	<title><?=$arResult["NAME"].(strlen($arResult["SECTION"]["NAME"])>0?" / ".$arResult["SECTION"]["NAME"]:"")?></title>
	<link>http://www.plusworld.ru</link> 
	<width>105</width>
	<height>39</height>
</image>
<?foreach($arResult["ITEMS"] as $arItem):?>
<?if($arItem["category"] != 'Выставки и Конференции/'):?>
	<item>
		<title><?=$arItem["title"]?></title>
		<link><?=$arItem["link"]?></link>
		<description><?=$arItem["description"]?></description>
		<?if(is_array($arItem["enclosure"])):?>
			<enclosure url="<?=$arItem["enclosure"]["url"]?>" length="<?=$arItem["enclosure"]["length"]?>" type="<?=$arItem["enclosure"]["type"]?>"/>
		<?endif?>
		<?if($arItem["category"]):?>
			<category><?=$arItem["category"]?></category>
		<?endif?>
		<?if($arParams["YANDEX"]):?>
			<?$arItem["full-text"] = substr_replace ($arItem["full-text"], '', strpos($arItem["full-text"], 'По материалам'))?>
			<yandex:full-text><?=preg_replace("/&lt;img(.*?)&gt;/i", " ", $arItem["full-text"])?></yandex:full-text>
		<?endif?>
		<pubDate><?=$arItem["pubDate"]?></pubDate>
	</item>
<?endif?>
<?endforeach?>
</channel>
</rss>