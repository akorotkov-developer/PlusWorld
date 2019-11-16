<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!$this->__component->__parent || empty($this->__component->__parent->__name) || $this->__component->__parent->__name != "bitrix:blog"):
	//$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/style.css');
	//$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/themes/blue/style.css');
endif;
?>
<?
// Метки для ссылок
$labelUrlDate = date('m').date('y');
$labelUrl = "?utm_source=mailing&utm_medium=".$labelUrlDate."&utm_campaign=plusdaily";
$labelUrlA = "&utm_source=mailing&utm_medium=".$labelUrlDate."&utm_campaign=plusdaily";
?>

<?
if(empty($arResult))
	echo GetMessage("SONET_BLOG_EMPTY");

$i = 0;
foreach($arResult as $arPost)
{
	if($arPost["FIRST"]!="Y")
	{
		?><div class="blog-line"></div><?
	}
	?>
	<div class="blog-mainpage-item ">
        <?/*$rsUser =CBlogUser::GetByID($arPost["AUTHOR_ID"], BLOG_BY_USER_ID);
        $url_avatar = CFile::GetPath($rsUser["AVATAR"]);

        $rsFile = CFile::GetByID($rsUser["AVATAR"]);

        $arFile = $rsFile->Fetch();
        $arFileTmp = CFile::ResizeImageGet(
            $arFile,
            array("width" => "80", "height" => "100"),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );*/?>
	<div style="padding-top: 10px;" >
	<?if($arParams["SEO_USER"] == "Y"):?>
		<noindex>
		<a style="background-image: url(http://www.plusworld.ru/bitrix/templates/.default/components/bitrix/blog.new_posts/blogosfera-rl-news/images/user.gif);
		width: 16px;
    height: 16px;
    display: block;
    float: left;
    background-repeat: no-repeat;
    padding-right: 0.2em;
    line-height: 1em;"  href="<?=$arPost["urlToAuthor"]?><?=$labelUrlA?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>" rel="nofollow"></a>
		</noindex>
	<?else:?>
		<a style="background-image: url(http://www.plusworld.ru/bitrix/templates/.default/components/bitrix/blog.new_posts/blogosfera-rl-news/images/user.gif);
		width: 16px;
    height: 16px;
    display: block;
    float: left;
    background-repeat: no-repeat;
    padding-right: 0.2em;
    line-height: 1em;" href="<?=$arPost["urlToAuthor"]?><?=$labelUrlA?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>"></a>
	<?endif;?>
	<?
	if (COption::GetOptionString("blog", "allow_alias", "Y") == "Y" && (strlen($arPost["urlToBlog"]) > 0 || strlen($arPost["urlToAuthor"]) > 0) && array_key_exists("BLOG_USER_ALIAS", $arPost) && strlen($arPost["BLOG_USER_ALIAS"]) > 0)
		$arTmpUser = array(
			"NAME" => "",
			"LAST_NAME" => "",
			"SECOND_NAME" => "",
			"LOGIN" => "",
			"NAME_LIST_FORMATTED" => $arPost["~BLOG_USER_ALIAS"],
		);
	elseif (strlen($arPost["urlToBlog"]) > 0 || strlen($arPost["urlToAuthor"]) > 0)
		$arTmpUser = array(
			"NAME" => $arPost["~AUTHOR_NAME"],
			"LAST_NAME" => $arPost["~AUTHOR_LAST_NAME"],
			"SECOND_NAME" => $arPost["~AUTHOR_SECOND_NAME"],
			"LOGIN" => $arPost["~AUTHOR_LOGIN"],
			"NAME_LIST_FORMATTED" => "",
		);
	?>
        <span style="display: block; font-size: 12px; font-family: Arial,helvetica,sans-serif;  text-align: left">
			<a style="color: #070; font-weight: bold"
               href="<?= $arPost["urlToBlog"]?><?=$labelUrlA?>"><?=$arPost["AUTHOR_NAME"]?></a>
        </span>
	</div>
	<div style="clear: both;float: none;"></div>
    <div>
        <span style="display: block; font-size: 12px; font-family: Arial,helvetica,sans-serif;  text-align: left">
            <a style="color: #070;"
               href="<?= $arPost["urlToBlog"]?><?=$labelUrlA?>"><?=$arTmpUser["NAME_LIST_FORMATTED"]?></a>
        </span>
    </div>
	<div class="blog-mainpage-title"  style="margin-bottom: 15px;"><a style="    color: #000;
    text-decoration: none;
    font-size: 12px;
    font-family: Arial,Helvetica,sans-serif;" href="<?=$arPost["urlToPost"]?><?=$labelUrlA?>"><?echo $arPost["TITLE"]; ?></a></div>


    <?/*if (($i==0)and($url_avatar)) {?>
        <a href="<?=$arPost["urlToAuthor"]?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>" rel="nofollow">
        <img style="float: left;  margin-right: 10px;width: 80px" src='<?=$arFileTmp["src"]?>' />
        </a>
    <?}*/?>
	<div class="blog-mainpage-content">
	<?=$arPost["TEXT_FORMATED"]?>
	</div>
	<div class="blog-mainpage-meta">
		<a href="<?=$arPost["urlToPost"]?>" title="<?=GetMessage("BLOG_BLOG_M_DATE")?>"><?=$arPost["DATE_PUBLISH_FORMATED"]?></a>
    <?if ($arParams["SHOW_VIEWS"] == "Y"):?>
		<?if(IntVal($arPost["VIEWS"]) > 0):?>
			<span class="blog-vert-separator"></span> <a href="<?=$arPost["urlToPost"]?>" title="<?=GetMessage("BLOG_BLOG_M_VIEWS")?>"><?=GetMessage("BLOG_BLOG_M_VIEWS")?>:&nbsp;<?=$arPost["VIEWS"]?></a>
		<?endif;?>
    <?endif;?>
		<?if(IntVal($arPost["NUM_COMMENTS"]) > 0):?>
			<span class="blog-vert-separator"></span> <a href="<?=$arPost["urlToPost"]?>#comments" title="<?=GetMessage("BLOG_BLOG_M_NUM_COMMENTS")?>"><?=GetMessage("BLOG_BLOG_M_NUM_COMMENTS")?>:&nbsp;<?=$arPost["NUM_COMMENTS"]?></a>
		<?endif;?>
		<?if ($arParams["SHOW_RATING"] == "Y"):?>
		<span class="rating_vote_text">
		<span class="blog-vert-separator"></span>
		<?
		$APPLICATION->IncludeComponent(
			"bitrix:rating.vote", $arParams["RATING_TYPE"],
			Array(
				"ENTITY_TYPE_ID" => "BLOG_POST",
				"ENTITY_ID" => $arPost["ID"],
				"OWNER_ID" => $arPost["AUTHOR_ID"],
				"USER_VOTE" => $arResult[0]["RATING"][$arPost["ID"]]["USER_VOTE"],
				"USER_HAS_VOTED" => $arResult[0]["RATING"][$arPost["ID"]]["USER_HAS_VOTED"],
				"TOTAL_VOTES" => $arResult[0]["RATING"][$arPost["ID"]]["TOTAL_VOTES"],
				"TOTAL_POSITIVE_VOTES" => $arResult[0]["RATING"][$arPost["ID"]]["TOTAL_POSITIVE_VOTES"],
				"TOTAL_NEGATIVE_VOTES" => $arResult[0]["RATING"][$arPost["ID"]]["TOTAL_NEGATIVE_VOTES"],
				"TOTAL_VALUE" => $arResult[0]["RATING"][$arPost["ID"]]["TOTAL_VALUE"],
				"PATH_TO_USER_PROFILE" => $arParams["~PATH_TO_USER"],
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?>
		</span>
		<?endif;?>
	</div>
	<div style="clear: both;float: none;"></div>
	</div>
	<?
    $i++;
}
?>	
