<?$this->setFrameMode(true);?>
<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div> 

<?/*?>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (strlen($arResult["PAGE_URL"]) > 0):

	?>

	<div class="share-window-parent">
	<div id="share-dialog<?echo $arResult["COUNTER"]?>" class="share-dialog share-dialog-<?=$arParams["ALIGN"]?>" style="display: <?=(array_key_exists("HIDE", $arParams) && $arParams["HIDE"] == "Y" ? "none" : "block")?>;">
		<div class="share-dialog-inner share-dialog-inner-<?=$arParams["ALIGN"]?>">
		<? if (is_array($arResult["BOOKMARKS"]) && count($arResult["BOOKMARKS"]) > 0): ?>	
			<table cellspacing="0" cellpadding="0" border="0" class="bookmarks-table">
			<tr>
			<?
			foreach($arResult["BOOKMARKS"] as $name => $arBookmark)
			{
				?><td class="bookmarks"><?=$arBookmark["ICON"]?></td><?
			}
			?>
			</tr>		
			</table>	
		<? endif; ?>
		</div>		
	</div>
	</div>
	<a class="share-switch" href="#" onClick="return ShowShareDialog(<?echo $arResult["COUNTER"]?>);" title="<?=GetMessage("SHARE_SWITCH")?>"></a>
	<?
endif;
?>
<?*/?>