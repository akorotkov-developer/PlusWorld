<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<h1 style="background-color: #C62D5F; color: white; padding: 0; text-align: center;"><img width="228" height="47" src="http://<?=$_SERVER['SERVER_NAME']?>/images/sub-daily/company.png" alt="<?=$arIBlock['NAME']?>" title="<?=$arIBlock['NAME']?>" style="border: none;"></h1>
<table cellpadding="0" cellspacing="0" border="0" style="background-color: #EEEEEE; border: 1px solid #C0C0C0;">
<?
foreach($arResult["IBLOCKS"] as $arIBlock):
	if(count($arIBlock["ITEMS"]) > 0):
?>

<?
	foreach($arIBlock["ITEMS"] as $arItem):
?>
	<tr>
		<td width="30px">&nbsp;</td>
		<td>
			<span style="display: block; padding-top: 15px; font-size: 12px; font-family: Arial,helvetica,sans-serif;">
			<a style="color: #A51340; text-decoration: none;" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			</span>
		</td>
		<td width="30px">&nbsp;</td>
	</tr>
<?
	endforeach;
	endif;
?>

<?endforeach?>
	<tr>
		<td colspan="3">
			&nbsp;
		</td>
	</tr>
</table>
<img width="228" height="8" src="http://<?=$_SERVER['SERVER_NAME']?>/images/sub-daily/shadow.png" style="border: none;">