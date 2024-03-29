<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!$this->__component->__parent || empty($this->__component->__parent->__name) || $this->__component->__parent->__name != "bitrix:blog"):
	//$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/style.css');
	//$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/themes/blue/style.css');
endif;
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
        <?$rsUser =CBlogUser::GetByID($arPost["AUTHOR_ID"], BLOG_BY_USER_ID);
        $url_avatar = CFile::GetPath($rsUser["AVATAR"]);

        $rsFile = CFile::GetByID($rsUser["AVATAR"]);

        $arFile = $rsFile->Fetch();
        $arFileTmp = CFile::ResizeImageGet(
            $arFile,
            array("width" => "80", "height" => "100"),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );?>
	<div class="blog-author">
	<?if($arParams["SEO_USER"] == "Y"):?>
		<noindex>
		<a class="blog-author-icon" href="<?=$arPost["urlToAuthor"]?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>" rel="nofollow"></a>
		</noindex>
	<?else:?>
		<a class="blog-author-icon" href="<?=$arPost["urlToAuthor"]?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>"></a>
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
	<?
	$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:main.user.link",
		'',
		array(
			"ID" => $arPost["AUTHOR_ID"],
			"HTML_ID" => "blog_new_posts_".$arPost["AUTHOR_ID"],
			"NAME" => $arTmpUser["NAME"],
			"LAST_NAME" => $arTmpUser["LAST_NAME"],
			"SECOND_NAME" => $arTmpUser["SECOND_NAME"],
			"LOGIN" => $arTmpUser["LOGIN"],
			"NAME_LIST_FORMATTED" => $arTmpUser["NAME_LIST_FORMATTED"],
			"USE_THUMBNAIL_LIST" => "N",
			"PROFILE_URL" => $arPost["urlToAuthor"],
			"PROFILE_URL_LIST" => $arPost["urlToBlog"],							
			"PATH_TO_SONET_MESSAGES_CHAT" => $arParams["~PATH_TO_MESSAGES_CHAT"],
			"PATH_TO_VIDEO_CALL" => $arParams["~PATH_TO_VIDEO_CALL"],
			"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
			"SHOW_YEAR" => $arParams["SHOW_YEAR"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
			"SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
			"PATH_TO_CONPANY_DEPARTMENT" => $arParams["~PATH_TO_CONPANY_DEPARTMENT"],
			"PATH_TO_SONET_USER_PROFILE" => ($arParams["USE_SOCNET"] == "Y" ? $arParams["~PATH_TO_USER"] : $arParams["~PATH_TO_SONET_USER_PROFILE"]),
			"INLINE" => "Y",
			"SEO_USER" => $arParams["SEO_USER"],
		),
		false,
		array("HIDE_ICONS" => "Y")
	);
	?>	
	</div>
	<div class="blog-clear-float"></div>
	<div class="blog-mainpage-title"><a href="<?=$arPost["urlToPost"]?>"><?echo $arPost["TITLE"]; ?></a></div>


    <?if (($i==0)and($url_avatar)) {?>
        <a href="<?=$arPost["urlToAuthor"]?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>" rel="nofollow">
        <img style="float: left;  margin-right: 10px;width: 80px" src='<?=$arFileTmp["src"]?>' />
        </a>
    <?}?>
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
	<div class="blog-clear-float"></div>
	</div>
	<?
    $i++;
}
?>	
