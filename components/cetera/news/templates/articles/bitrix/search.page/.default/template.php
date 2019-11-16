<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="search-page">
<form action="" method="get">
	<input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
<?if($arParams["SHOW_WHERE"]):?>
	&nbsp;<select name="where">
	<option value=""><?=GetMessage("SEARCH_ALL")?></option>
	<?foreach($arResult["DROPDOWN"] as $key=>$value):?>
	<option value="<?=$key?>"<?if($arResult["REQUEST"]["WHERE"]==$key) echo " selected"?>><?=$value?></option>
	<?endforeach?>
	</select>
<?endif;?>
	&nbsp;<input type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
	<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
</form><br />
<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>
<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
<?elseif($arResult["ERROR_CODE"]!=0):?>
	<p><?=GetMessage("SEARCH_ERROR")?></p>
	<?ShowError($arResult["ERROR_TEXT"]);?>
	<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
	<br /><br />
	<p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
	<table border="0" cellpadding="5">
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
			<td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
			<td><?=GetMessage("SEARCH_AND_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
			<td><?=GetMessage("SEARCH_OR_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
			<td><?=GetMessage("SEARCH_NOT_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top">( )</td>
			<td valign="top">&nbsp;</td>
			<td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
		</tr>
	</table>
<?elseif(count($arResult["SEARCH"])>0):?>
	<?=$arResult["NAV_STRING"]?>
	<br /><hr />
    <?
    function pluralForm($n, $form1, $form2, $form5)
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $form5;
        if ($n1 > 1 && $n1 < 5) return $form2;
        if ($n1 == 1) return $form1;
        return $form5;
    }
    ?>
	<?foreach($arResult["SEARCH"] as $arItem):?>



        <?
        //CModule::IncludeModule("iblock");
        $res = CIBlockElement::GetByID($arItem["ITEM_ID"]);
        if($ar_res = $res->GetNext()) {
            $PREVIEW_PICTURE = $ar_res["PREVIEW_PICTURE"];
            $counter = $ar_res['SHOW_COUNTER'];
        }

        if($counter < 1)
            $counter = 0;
        $counter = intval($counter);
        $text_counter = pluralForm($counter, 'просмотр', 'просмотра', 'просмотров');

        ?>


        <div class="news-item">
            <?if (intval($PREVIEW_PICTURE)>0) {?>
            <div class="preview_picture_link">
                <a href="<?echo $arItem["URL"]?>">
                    <img src="<?=CFile::GetPath($PREVIEW_PICTURE)?>" width="300" height="163" alt="<?echo strip_tags($arItem["TITLE_FORMATED"])?>" title="<?echo strip_tags($arItem["TITLE_FORMATED"])?>" class="preview_picture">
                </a>
            </div>
            <? } ?>

            <span class="date"><?=$arItem["DATE_CHANGE"]?></span>
            <img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;">
            <span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>
            <br>
            <a href="<?echo $arItem["URL"]?>" class="link">
                <?echo $arItem["TITLE_FORMATED"]?>
            </a><br>
            <?echo $arItem["BODY_FORMATED"]?>
            <div class="clear"></div>
        </div>
        <hr />
	<?endforeach;?>
	<?=$arResult["NAV_STRING"]?>
	<br />
    <?/*
	<p>
	<?if($arResult["REQUEST"]["HOW"]=="d"):?>
		<a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("SEARCH_SORT_BY_RANK")?></a>&nbsp;|&nbsp;<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
	<?else:?>
		<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>&nbsp;|&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
	<?endif;?>
	</p>
*/?>
<?else:?>
	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?endif;?>
</div>