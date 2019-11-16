<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<dt <?=(isset($_REQUEST["where"]) && $_REQUEST["where"] == 'news' ? 'class="selected"': '')?>><?=GetMessage("CT_NEWS_TAB")?> (<?if ($arResult["NAV_RESULT"]) echo $arResult["NAV_RESULT"]->SelectedRowsCount(); else echo 0?>)</dt>
<dd <?=(isset($_REQUEST["where"]) && $_REQUEST["where"] == 'news' ? 'class="selected"': '')?>>
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
		$all_count_news_1 =0;
		$all_count_news_7 =0;
		$all_count_news_30 =0;
		$all_count_news_180 =0;
		$all_count_news_366 =0;
		$all_count_news_all =0;
		//echo "<pre>"; print_r($arResult["SEARCH"]); echo "</pre>";
        foreach($arResult["SEARCH"] as $arItem):
		$ID = $arItem["ITEM_ID"];
		//echo $ID."<br >";
		$count_all=array();
			$count_all=count_material_RL_RU($ID);
			$all_count_news_1=$all_count_news_1+$count_all["count_1"] ;
			$all_count_news_7=$all_count_news_7+$count_all["count_7"] ;
			$all_count_news_30=$all_count_news_30+$count_all["count_30"] ;
			$all_count_news_180=$all_count_news_180+$count_all["count_180"] ;
			$all_count_news_366=$all_count_news_366+$count_all["count_366"] ;
		$res_news = CIBlockElement::GetByID($arItem['ITEM_ID']);
		if($ar_res_news = $res_news->GetNext())
		  $counter_news = $ar_res_news['SHOW_COUNTER'];	
			$all_count_news_all=$all_count_news_all+$counter_news ;
		
		 		 
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
			<td><?echo $all_count_news_1; ?></td>
			<td><?echo $all_count_news_7; ?></td>
			<td><?echo $all_count_news_30; ?></td>
			<td><?echo $all_count_news_180; ?></td>
			<td><?echo $all_count_news_366; ?></td>
			<td><?echo $all_count_news_all; ?></td>
			</tr>
		</table>
		
		<script type="text/javascript">
			all_count_news_1 = '<?php echo $all_count_news_1;?>';
			all_count_news_7 = '<?php echo $all_count_news_7;?>';
			all_count_news_30 = '<?php echo $all_count_news_30;?>';
			all_count_news_180 = '<?php echo $all_count_news_180;?>';
			all_count_news_366 = '<?php echo $all_count_news_366;?>';
			all_count_news_all = '<?php echo $all_count_news_all;?>';
		</script>
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