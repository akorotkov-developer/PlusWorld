<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult["ITEMS"] as $k=>$arItem):?>
<div class="left-forum">
    <div class="left w50">
		<img class="preview_picture" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" >
		<div class="forum-desc <?=($k== 0? 'active' : '')?>" id="forum-<?=$k?>"><h3> <a href="<?echo $arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>" ><?echo $arItem["NAME"]?></a></h3>
			<br />
		</div>
		<?
		$ost = MakeTimeStamp($arItem["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"])-time();
		$start = MakeTimeStamp($arItem["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"]);
		$end  = MakeTimeStamp($arItem["DISPLAY_PROPERTIES"]["DATE_END"]["VALUE"]);
		if ($ost > 0)
		{
			$time_left['days'] = floor($ost/86400);
			$time_left['hours'] = floor(($ost - $time_left['days']*86400)/3600);
			$time_left['min'] = floor(($ost - $time_left['days']*86400 - $time_left['hours']*3600)/60);
		}?>
	    <span class="date"><?if ($end >  $start ):?><?echo ConvertDateTime($arItem["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"], "DD")?> &ndash; <?echo ConvertDateTime($arItem["DISPLAY_PROPERTIES"]["DATE_END"]["VALUE"], "DD.MM.YYY")?><?else:?><?echo ConvertDateTime($arItem["DISPLAY_PROPERTIES"]["DATE_START"]["VALUE"], "DD.MM.YYY")?><?endif;?></span>
		<div class="anons"><?echo $arItem["PREVIEW_TEXT"]?>
		</div>
	</div>
    <div class="right w45">
		<div class="counter">
			<div class="timer <?if ($start < time()):?>finished<?elseif ($start < time()+30*86400):?> soon<?endif;?>">
				<?if ($ost <= 0):?>COMPLETED
			
			<?else:?>Left <?=$time_left['days']?> d. <?=$time_left['hours']?> h. <?=$time_left['min']?> min.
						<div class="forum-request" id="fr-<?echo $arItem["ID"]?>">
			<?/*if ($arItem["STATUS"] == 0) {?>
			<input class="request2forum" type="button" value="Принять участие" />
			<?}else{?>
			<p class="notetext">Ваша заявка рассматривается Оргкомитетом</p>
			<?}*/?>
			</div>
			<?endif;?>
		</div>
		</div>
		<br/>
		
		<?if ($ost > 0):?>			
			
			<?/*if ($USER->IsAuthorized()):*/?>
			<div class="register">

			<a href="<?echo $arItem["DISPLAY_PROPERTIES"]["REG_LINK"]["VALUE"]?>" target="_blank">To register</a><br />
			<a href="<?echo $arItem["DISPLAY_PROPERTIES"]["SPONSOR_LINK"]["VALUE"]?>" target="_blank">To become a sponsor</a><br />
			<a href="<?echo $arItem["DISPLAY_PROPERTIES"]["SPEAKER_LINK"]["VALUE"]?>" target="_blank">To make a speech</a><br />
			</div>
			<?/*else:?>
				<a href="/personal/register/" rel="nofollow">Зарегистрироваться</a><br />
			<?endif;*/?>
		
		<?endif;?>
    </div>
	
	<div class="clear"></div>
</div>
<?endforeach;?>

</div>
	<div class="clear"></div>