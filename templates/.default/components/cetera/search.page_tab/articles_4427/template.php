<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<dt <?=(isset($_REQUEST["where"]) && $_REQUEST["where"] == 'articles' ? 'class="selected"': '')?>><?=GetMessage("CT_ARTICLES_TAB")?> (<?if ($arResult["NAV_RESULT"]) echo $arResult["NAV_RESULT"]->SelectedRowsCount(); else echo 0?>)</dt>
<dd <?=(isset($_REQUEST["where"]) && $_REQUEST["where"] == 'articles' ? 'class="selected"': '')?>>
<div class="search-page tab-content">

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>

	<div class="search-result">
	<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
	<?elseif($arResult["ERROR_CODE"]!=0):?>
		
	<?elseif(count($arResult["SEARCH"])>0):?>
<?if ($arParams["PAGER_WHERE"]) $arResult["NAV_STRING"] = preg_replace("/where=(news|articles|events|all)/","where={$arParams["PAGER_WHERE"]}", $arResult["NAV_STRING"]);?>
        <?if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
        <div class="clear"></div>
		<?
		$all_count_articles_1 =0;
		$all_count_articles_7 =0;
		$all_count_articles_30 =0;
		$all_count_articles_180 =0;
		$all_count_articles_366 =0;
		$all_count_articles_all =0;
		foreach($arResult["SEARCH"] as $arItem):
		$ID = $arItem["ITEM_ID"];
		$count_all=array();
			$count_all=count_material_RL_RU($ID);
			$all_count_articles_1=$all_count_articles_1+$count_all["count_1"] ;
			$all_count_articles_7=$all_count_articles_7+$count_all["count_7"] ;
			$all_count_articles_30=$all_count_articles_30+$count_all["count_30"] ;
			$all_count_articles_180=$all_count_articles_180+$count_all["count_180"] ;
			$all_count_articles_366=$all_count_articles_366+$count_all["count_366"] ;
			$res_articles = CIBlockElement::GetByID($arItem['ITEM_ID']);
		if($ar_res_articles = $res_articles->GetNext())
		  $counter_articles = $ar_res_articles['SHOW_COUNTER'];	
			$all_count_articles_all=$all_count_articles_all+$counter_articles ;
			
		endforeach;?>
		<style>
		table.count {width: 100%; text-align: center;}
		table.count th {padding: 5px; font-weight: bold; border: 1px solid rgb(233, 233, 233);}
		table.count td {padding: 5px; font-weight: normal; border: 1px solid rgb(233, 233, 233);}
		</style>
		<table class="count">
		<tr><th colspan="6">Количество просмотров</th></tr>
		<tr> 
		<th>за день</th>
		<th>за неделю</th>
		<th>за месяц</th>
		<th>за полгода</th>
		<th>за год</th>
		<th>за всё время</th>
		</tr>
			<tr>
			<td><?echo $all_count_articles_1; ?></td>
			<td><?echo $all_count_articles_7; ?></td>
			<td><?echo $all_count_articles_30; ?></td>
			<td><?echo $all_count_articles_180; ?></td>
			<td><?echo $all_count_articles_366; ?></td>
			<td><?echo $all_count_articles_all; ?></td>
			</tr>
		</table>
		<script type="text/javascript">
			var all_count_articles_1 = '<?php echo $all_count_articles_1;?>';
			var all_count_articles_7 = '<?php echo $all_count_articles_7;?>';
			var all_count_articles_30 = '<?php echo $all_count_articles_30;?>';
			var all_count_articles_180 = '<?php echo $all_count_articles_180;?>';
			var all_count_articles_366 = '<?php echo $all_count_articles_366;?>';
			var all_count_articles_all = '<?php echo $all_count_articles_all;?>';
		</script>
		
		<?/*$i = 1;$bannerPosition = 3;$countRes = count($arResult["SEARCH"]);
        if ($countRes < 3) $bannerPosition = $countRes;
        foreach($arResult["SEARCH"] as $arItem):?>
			<div class="search-item">
            <?
                $arItem["date"] =  '';
                $obElement = CIBlockElement::GetList(array(),array("IBLOCK_ID" => $arItem["PARAM2"], "ID"=>$arItem["ITEM_ID"]));
                if ($arElement = $obElement->GetNext())
                {
                    $arItem["date"] = $arElement["DATE_ACTIVE_FROM"];
                }
            ?>
                <?if ($arItem["ICON"]){?>
                    <a href="<?echo $arItem["URL"]?>"><img src="/upload/<?echo $arItem["ICON"]["SUBDIR"]."/".$arItem["ICON"]["FILE_NAME"]?>" class="preview_pict" /></a>
                <?}?>
               
                <?if ($arItem["date"]){?><span class="date"><?=date("d.m.Y H:i",MakeTimeStamp($arItem["date"], "DD.MM.YYYY HH:MI:SS"));?></span><?}?>
				<h4><a href="<?echo $arItem["URL"]?>"><?echo $arItem["TITLE_FORMATED"]?></a></h4>
				<div class="search-preview"><?echo $arItem["BODY_FORMATED"]?></div>
				<?if(
					($arParams["SHOW_ITEM_DATE_CHANGE"] != "N")
					|| ($arParams["SHOW_ITEM_PATH"] == "Y" && $arItem["CHAIN_PATH"])
					|| ($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"]))
				):?>
				<div class="search-item-meta">
					<?if (
						$arParams["SHOW_RATING"] == "Y"
						&& strlen($arItem["RATING_TYPE_ID"]) > 0
						&& $arItem["RATING_ENTITY_ID"] > 0
					):?>
					<div class="search-item-rate">
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:rating.vote", $arParams["RATING_TYPE"],
						Array(
							"ENTITY_TYPE_ID" => $arItem["RATING_TYPE_ID"],
							"ENTITY_ID" => $arItem["RATING_ENTITY_ID"],
							"OWNER_ID" => $arItem["USER_ID"],
							"USER_VOTE" => $arItem["RATING_USER_VOTE_VALUE"],
							"USER_HAS_VOTED" => $arItem["RATING_USER_VOTE_VALUE"] == 0? 'N': 'Y',
							"TOTAL_VOTES" => $arItem["RATING_TOTAL_VOTES"],
							"TOTAL_POSITIVE_VOTES" => $arItem["RATING_TOTAL_POSITIVE_VOTES"],
							"TOTAL_NEGATIVE_VOTES" => $arItem["RATING_TOTAL_NEGATIVE_VOTES"],
							"TOTAL_VALUE" => $arItem["RATING_TOTAL_VALUE"],
							"PATH_TO_USER_PROFILE" => $arParams["~PATH_TO_USER_PROFILE"],
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);?>
					</div>
					<?endif;?>
					<?if($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"])):?>
						<div class="search-item-tags"><label><?echo GetMessage("CT_BSP_ITEM_TAGS")?>: </label><?
						foreach ($arItem["TAGS"] as $tags):
							?><a href="<?=$tags["URL"]?>"><?=$tags["TAG_NAME"]?></a> <?
						endforeach;
						?></div>
					<?endif;?>

					<?if($arParams["SHOW_ITEM_DATE_CHANGE"] != "N"):?>
						<div class="search-item-date"><label><?echo GetMessage("CT_BSP_DATE_CHANGE")?>: </label><span><?echo $arItem["DATE_CHANGE"]?></span></div>
					<?endif;?>
				</div>
				<?endif?>
			</div>
		      <?if ($i == $bannerPosition){?>
                <div class="search-banner">
                <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "", Array(
                	"TYPE" => "SEARCH_BANNER_468",	// Тип баннера
                	"CACHE_TYPE" => "A",	// Тип кеширования
                	"NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
                	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
                	),
                	false
                );?>
                </div>
            <?}?>
		<?$i++;
        endforeach;*/?>
<?if ($arParams["PAGER_WHERE"]) $arResult["NAV_STRING"] = preg_replace("/where=(news|articles|events|all)/","where={$arParams["PAGER_WHERE"]}", $arResult["NAV_STRING"]);?>	
	<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<?if($arParams["SHOW_ORDER_BY"] != "N"):?>
			<div class="search-sorting"><label><?echo GetMessage("CT_BSP_ORDER")?>:</label>&nbsp;
			<?if($arResult["REQUEST"]["HOW"]=="d"):?>
				<a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></a>&nbsp;<b><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></b>
			<?else:?>
				<b><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></b>&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></a>
			<?endif;?>
			</div>
		<?endif;?>


	<?else:?>
		<?ShowNote(GetMessage("CT_BSP_NOTHING_TO_FOUND"));?>
	<?endif;?>

	</div>
</div>
</dd>