<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
?>
<?='<?xml version="1.0" encoding="'.SITE_CHARSET.'"?>'?>
<?='
<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:georss="http://www.georss.org/georss">'?>
    <channel>
        <title>Retail &amp; Loyalty</title>
        <link><?="https://".SITE_SERVER_NAME?></link>
        <description>retail-loyalty.org - журнал о рознице и инновациях</description>
        <language>ru</language>
        <?
        foreach($arResult["ITEMS"] as $arItem):
            $arItem["link"] = str_replace("http://", "https://", $arItem["link"]);
            ?>
        <item>
            <title><?=htmlspecialchars_decode($arItem["title"],ENT_QUOTES)?></title>
            <link><?=$arItem["link"]?></link>
            <pubDate><?=$arItem["pubDate"]?></pubDate>
            <category>Технологии</category>
            <category>Экономика</category>
            <?if($arItem["author-text"]){?>
                <author><?=htmlspecialchars_decode($arItem["author-text"],ENT_QUOTES)?></author>
            <?} else {?>
                <author>Редакция журнала Retail &amp; Loyalty</author>
            <?}?>
            <?/*if ($arItem["PROPERTIES"][\UTDD\Config::PROP_18]["VALUE_ENUM"]) {?>}
            <media:rating scheme="urn:simple">adult</media:rating>
            <?}*/?>
            <?
            /*switch ($arItem["ELEMENT"]["IBLOCK_ID"]) {
                case 17:
                    ?><category>Спорт</category><?
                    break;
                case 19:
                    ?><category>Экономика</category><?
                    break;
                case 21:
                    ?><category>Музыка</category><?
                    break;
                case 20:
                    ?><category>Мода</category><?
                    ?><category>Знаменитости</category><?
                    break;
                case 23:
                    ?><category>Общество</category><?
                    ?><category>Политика</category><?
                    break;
            }*/
            ?>
            <?/*<category><?=htmlspecialchars_decode($arItem["category"],ENT_QUOTES)?></category>*/?>
            <description><![CDATA[<?=strip_tags(htmlspecialchars_decode($arItem["description"],ENT_QUOTES),'<p>');?>]]></description>
            <?
            if (intval($arItem["ELEMENT"]['~DETAIL_PICTURE'])>0) {
                $arPict = CFile::GetFileArray($arItem["ELEMENT"]['~DETAIL_PICTURE']);
                ?>
                    <enclosure url="<?=$arItem["ELEMENT"]["DETAIL_PICTURE"]?>" type="<?=$arPict["CONTENT_TYPE"]?>"/>
                <?
            }
            ?>
            <content:encoded><![CDATA[
                <?
                if (intval($arItem["ELEMENT"]['~DETAIL_PICTURE'])>0) {
                    $arPict = CFile::GetFileArray($arItem["ELEMENT"]['~DETAIL_PICTURE']);
                    ?>
                        <figure>
                            <img src="<?=$arItem["ELEMENT"]["DETAIL_PICTURE"]?>" width="<?=$arPict["WIDTH"]?>" height="<?=$arPict["HEIGHT"]?>">
                            <figcaption><?=htmlspecialchars_decode($arItem["title"],ENT_QUOTES)?></figcaption>
                        </figure>
                    <?
                }
                ?>

                <?=strip_tags(htmlspecialchars_decode($arItem["full-text"],ENT_QUOTES),'<p>,<div>')?>]]></content:encoded>
        </item>
        <?endforeach?>
    </channel>
</rss>
