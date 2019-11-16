<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (CModule::IncludeModule("advertising")){
	$sub_banners = array();
	$rs = CAdvBanner::GetList($by="ip", $order="desc", array("TYPE_SID" => "SUB_DAILY_RL", "TYPE_SID_EXACT_MATCH" => "Y", "LAMP"=> "green"), $if_filtered, "N");
	while($ar = $rs->Fetch()) {
		$sub_banners[] = $ar;
	}
}
$num_banner = count($sub_banners); //всего баннеров

?>
<table cellpadding="0" cellspacing="0" border="0" style="background-color: #EEEEEE; border: 1px solid #C0C0C0; border-collapse: collapse;">
<?
foreach($arResult["IBLOCKS"] as $arIBlock):
	if(count($arIBlock["ITEMS"]) > 0):
	$frequency = intval(count($arIBlock["ITEMS"])/($num_banner)); //частота баннеров между новостями
?>

<?	$i = 0; //номер новости
	foreach($arIBlock["ITEMS"] as $arItem):
		++$i;
		if($arItem["PREVIEW_PICTURE"])
		{
			if(COption::GetOptionString("subscribe", "attach_images")==="Y")
			{
				$sImagePath = $arItem["PREVIEW_PICTURE"]["SRC"];
			}
			elseif(strpos($arItem["PREVIEW_PICTURE"]["SRC"], "http") !== 0)
			{
				$sImagePath = "http://".$arResult["SERVER_NAME"].$arItem["PREVIEW_PICTURE"]["SRC"];
			}
			else
			{
				$sImagePath = $arItem["PREVIEW_PICTURE"]["SRC"];
			}

			$width = 100;
			$height = 100;

			$width_orig = $arItem["PREVIEW_PICTURE"]["WIDTH"];
			$height_orig = $arItem["PREVIEW_PICTURE"]["HEIGHT"];

			if(($width_orig > $width) || ($height_orig > $height))
			{
				if($width_orig > $width)
					$height_new = ($width / $width_orig) * $height_orig;
				else
					$height_new = $height_orig;

				if($height_new > $height)
					$width = ($height / $height_orig) * $width_orig;
				else
					$height = $height_new;
			}
		}
?>	

	<tr>
		<td colspan="5">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td width="30">&nbsp;</td>
		<td>
			<?if($arItem["PREVIEW_PICTURE"]):?>
			<div style="max-width:100px; max-height:100px; border: 1px solid #ccc; display: table-cell; vertical-align: middle; text-align: center;" width="100" height="100"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><img style="border: none; max-width:100px; max-height:100px;" align='center' border='0' width="100" src="<?echo $sImagePath?>"  alt="<?echo $arItem["PREVIEW_PICTURE"]["ALT"]?>"  title="<?echo $arItem["NAME"]?>"></a></div>
			<?endif;?>
		</td>
		<td width="10">&nbsp;</td>
		<td style="vertical-align: top;">
			<p style="font-size: 12px; font-family: Arial,helvetica,sans-serif;">
				<a style="color: #A51340; text-decoration: none; font-weight: bold;" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			</p>
			<p style="font-size: 12px; font-family: Arial,helvetica,sans-serif;">
				<?echo $arItem["PREVIEW_TEXT"];?>
			</p>
			
		</td>
		<td width="30">&nbsp;</td>
	</tr>
	
	<?if ((is_int($i/$frequency)) && ($num_banner != 0)) { //если на очереди баннер и они еще есть?> 
	<tr>
		<td colspan="5">
			&nbsp;
		</td>
	</tr>	
	<tr>
		<td colspan="5" style="text-align: center;">
		<br />
		<a target="_blank" href="<?=$sub_banners[$num_banner-1]['IMAGE_ALT']?>"><?echo str_replace('/upload/', 'http://'.$_SERVER['SERVER_NAME'].'/upload/', CAdvBanner::GetHTML($sub_banners[$num_banner-1]));
		--$num_banner?></a>
		<br />
		</td>
	</tr>
	<tr>
		<td colspan="5">
			&nbsp;
		</td>
	</tr>	
	<?}?>
<?
	endforeach;
	endif;
?>

<?endforeach?>
	<?/*<tr>
		<td colspan="4">
			<br /><br />
		</td>
	</tr>	
	<tr>
		<td colspan="4" style="background-color: white; border-width: 1px; border-style: solid; border-color: #C0C0C0 white white; text-align: center;">
		<img width="228" height="8" src="http://<?=$_SERVER['SERVER_NAME']?>/images/sub-daily/shadow.png" style="border: none;">
		</td>
	</tr>*/?>
	
</table>


