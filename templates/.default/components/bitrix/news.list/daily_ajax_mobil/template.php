<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?//echo "<pre>"; print_r($arResult["ACTIVE_FROM"); echo "</pre>"?>

<?foreach($arResult["ITEMS"] as $arItem):?>
		<li class="ui-li-static ui-body-inherit">
            <?//if (intval($_GET['PAGEN_1'])<2) {?>
            <div class="b-item__detail-picture">
                <?if(is_array($arItem["DETAIL_PICTURE"])):?>
                     <a class="ui-link" data-ajax="false" href="/m<?echo $arItem["DETAIL_PAGE_URL"]?>">
                        <img src="<?=$arItem["DETAIL_PICTURE_NEW"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"/>
                     </a>
                <?endif?>
            </div>
        <? //} ?>

            <div class="b-item__date"><?echo date("d.m.Y",strtotime($arItem["ACTIVE_FROM"]))?></div>
			<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
					<h3><a class="ui-link" data-ajax="false" href="/m<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></h3>
				<?else:?>
					<h3><?echo $arItem["NAME"]?></h3>
				<?endif;?>
			<?endif;?>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				    <p><?echo substr($arItem["PREVIEW_TEXT"],0,100);?><?if (strlen($arItem["PREVIEW_TEXT"])>100) {echo "...";}?>
                        <span class="b-item__span"><a class="ui-link" data-ajax="false" href="/m<?echo $arItem["DETAIL_PAGE_URL"]?>">Читать</a></span></p>
			<?endif;?>
		</li>
	<?endforeach;?>