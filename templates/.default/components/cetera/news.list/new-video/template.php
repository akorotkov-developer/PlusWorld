<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>
<div class="video-sections-top">
<h3>Новое видео</h3>

	<table cellpadding="0" cellspacing="0" border="0" class="data-table">
			<tr class="head-row" valign="top">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?if(is_array($arItem)):?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));
					?>
					<td   id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						&nbsp;
						<?if($arResult["USER_HAVE_ACCESS"]):?>
							<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a><br />
							<?endif?>
						<?else:?>
							<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
								<img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /><br />
							<?endif?>
						<?endif?>
					</td>
				<?else:?>
					<td  rowspan="<?=$arResult["nRowsPerItem"]?>">
						&nbsp;
					</td>
				<?endif;?>
			<?endforeach?>
			</tr>
			<tr class="data-row">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?if(is_array($arItem)):?>
					<th valign="top"  class="data-cell">
						&nbsp;
						<?if($arResult["USER_HAVE_ACCESS"]):?>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?><?if($arParams["USE_RATING"] && $arItem["PROPERTIES"]["rating"]["VALUE"]) echo "(".$arItem["PROPERTIES"]["rating"]["VALUE"].")"?></a><br />
						<?else:?>
							<?=$arItem["NAME"]?><?if($arParams["USE_RATING"] && $arItem["PROPERTIES"]["rating"]["VALUE"]) echo "(".$arItem["PROPERTIES"]["rating"]["VALUE"].")"?><br />
						<?endif?>
					</th>
				<?endif;?>
			<?endforeach?>
			</tr>
	</table>
</div>
