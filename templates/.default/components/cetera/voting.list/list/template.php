<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
<?if (!$this->__component->__parent || empty($this->__component->__parent->__name)):
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/voting.current/templates/.default/style.css');
endif;
//echo '<pre>';print_r($arResult);
if ($arParams["DISPLAY_TOP_PAGER"] == 'Y' && strlen($arResult["NAV_STRING"]) > 0):
?>
<div class="vote-navigation-box vote-navigation-top">
	<div class="vote-page-navigation">
		<?=$arResult["NAV_STRING"]?>
	</div>
	<div class="vote-clear-float"></div>
</div>
<?
endif;

?>

<?
$iCount = 0;
foreach ($arResult["VOTES"] as $arVote):
	$iCount++;
?>
	<div class="vote-item  <?=($iCount%2 == 0 ? "vote-item-vote-odd " : "vote-item-vote-even ")?><?
				?><?=($arVote["LAMP"]=="green" ? "vote-item-vote-active " : "")?><?
				?><?=($arVote["LAMP"]=="red" ? "vote-item-vote-disable " : "")?><?
				?>">
		<div class="vote-item-header">
        <?
	if ($arVote["DATE_START"] || ($arVote["DATE_END"] && $arVote["DATE_END"] != "31.12.2030 23:59:59")):
?>
		<div class="vote-item-date">
<?
		if ($arVote["DATE_START"]):
?>
			<span class="vote-item-date-start"><?=FormatDateFromDB($arVote["DATE_START"], "SHORT")?></span>
<?

		endif;
		if ($arVote["DATE_END"] && $arVote["DATE_END"]!="31.12.2030 23:59:59"):
			if ($arVote["DATE_START"]):
?>
			<span class="vote-item-date-sep"> - </span>
<?
			endif;
?>
			<span class="vote-item-date-end"><?=FormatDateFromDB($arVote["DATE_END"], "SHORT")?></span>
<?
		endif;
?>
		</div>
<?
	endif;

/*?>
			<div class="vote-item-links float-links">
<?if ($arVote["LAMP"]=="green" && $arVote["MAX_PERMISSION"] >= 2 && $arVote["USER_ALREADY_VOTE"] != "Y"):?>
				[&nbsp;<a href="<?=$arVote["VOTE_FORM_URL"]?>"><?=GetMessage("VOTE_VOTING")?></a>&nbsp;]
<?
	endif;


?>
			</div>

<?*/
	if (strlen($arVote["TITLE"]) > 0):
?>
		<a href="<?if ($arVote["LAMP"]=="green" && $arVote["MAX_PERMISSION"] >= 2 && $arVote["USER_ALREADY_VOTE"] != "Y"):?><?=$arVote["VOTE_FORM_URL"]?><?else:?><?=$arVote["VOTE_RESULT_URL"]?><?endif;?>" class="vote-item-title"><?=$arVote["TITLE"];?></a>
<?
	/*	if ($arVote["LAMP"]=="green"):
?>
			<span class="vote-item-lamp vote-item-lamp-green">[ <span class="active"><?=GetMessage("VOTE_IS_ACTIVE_SMALL")?></span> ]</span>
<?
		elseif ($arVote["LAMP"]=="red"):
?>
			<span class="vote-item-lamp vote-item-lamp-red">[ <span class="disable"><?=GetMessage("VOTE_IS_NOT_ACTIVE_SMALL")?></span> ]</span>
<?
		endif;*/
	endif;
?>
			<div class="vote-clear-float"></div>
		</div>
<?/*?>
		<div class="vote-item-counter"><span><?=GetMessage("VOTE_VOTES")?>:</span> <?=$arVote["COUNTER"]?></div>
<?*/?>
<?
	if (strlen($arVote["TITLE"]) <= 0):
		if ($arVote["LAMP"]=="green"):
?>
		<div class="vote-item-lamp vote-item-lamp-green"><span class="active"><?=GetMessage("VOTE_IS_ACTIVE")?></span></div>
<?
		elseif ($arVote["LAMP"]=="red"):
?>
		<div class="vote-item-lamp vote-item-lamp-red"><span class="disable"><?=GetMessage("VOTE_IS_NOT_ACTIVE")?></span></div>
<?
		endif;
	endif;

	if ($arVote["IMAGE"] !== false || !empty($arVote["DESCRIPTION"])):
?>
		<div class="vote-item-footer">
<?
		/*if ($arVote["IMAGE"] !== false):
?>
			<div class="vote-item-image">
				<img src="<?=$arVote["IMAGE"]["SRC"]?>" width="<?=$arVote["IMAGE"]["WIDTH"]?>" height="<?=$arVote["IMAGE"]["HEIGHT"]?>" border="0" />
			</div>
<?
		endif;*/

		if (!empty($arVote["DESCRIPTION"])):
?>
			<div class="vote-item-description"><?=$arVote["DESCRIPTION"];?></div>
<?
		endif
?>
			<div class="vote-clear-float"></div>
		</div>
<?
	endif;
?>
	</div>

<?if ($iCount == '2'):?>
<div class="clear"></div>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/vote-banner.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
<?endif;?>

<? /*
<?if ($iCount == '2' && !empty($arResult["POPULAR"])):?>
<div class="clear"></div>
<div class="popular-votes">
<h2><?=GetMessage("POPULAR_VOTES_TITLE")?></h2>
<?foreach($arResult["POPULAR"] AS $pop):?>
<div class="popular-vote">
    <?if ($pop['PICTURE']):?>
        <a href="/votes/<?=($pop['VOTED'] ? 'result.php' : 'new.php');?>?VOTE_ID=<?=$pop['ID']?>"><img src="<?=$pop['PICTURE']['SRC']?>" alt="<?=$pop["TITLE"]?>" /></a>
    <?endif;?>

    <div class="vote-item-date">
        <?if ($pop["DATE_START"]):?>
        <span class="vote-item-date-start"><?=$DB->FormatDate($pop["DATE_START"], "YYYY-MM-DD HH:MI:SS", "DD.MM.YYYY")?></span>
        <?endif;
        if ($pop["DATE_END"] && $pop["DATE_END"]!="31.12.2030 23:59:59"):
        if ($pop["DATE_START"]):?><span class="vote-item-date-sep"> - </span><?endif;?>
        <span class="vote-item-date-end"><?=$DB->FormatDate($pop["DATE_END"], "YYYY-MM-DD HH:MI:SS", "DD.MM.YYYY")?></span>
        <?endif;?>
    </div>
    <a href="/votes/<?=($pop['VOTED'] ? 'result.php' : 'new.php');?>?VOTE_ID=<?=$pop['ID']?>"><?=$pop["TITLE"]?></a>
</div>
<?endforeach;?>
<div class="clear"></div>
</div>
<?endif;?>
*/?>
<?
endforeach;
?>

<div class="clear"></div>
<?

if ($arParams["DISPLAY_BOTTOM_PAGER"] == 'Y' && strlen($arResult["NAV_STRING"]) > 0):
?>
<div class="vote-navigation-box vote-navigation-bottom">
    <div class="search-page-navcount">
		<?=$arParams["PAGER_TITLE"]?> &nbsp; <?=$arResult['NavRecordCount']?></div>
	<div class="vote-page-navigation">
		<?=$arResult["NAV_STRING"]?>
	</div>
	<div class="vote-clear-float"></div>
</div>
<?
endif;
?>
<div class="clear"></div>
<?$frame->end(); // Конец фрейма?>