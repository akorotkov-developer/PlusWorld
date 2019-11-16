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
				<?if ($ost <= 0):?>ЗАВЕРШЕНО
			
				<?else:?>Осталось <?=$time_left['days']?> д. <?=$time_left['hours']?> ч. <?=$time_left['min']?> мин.
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

			<a href="<?echo $arItem["DISPLAY_PROPERTIES"]["REG_LINK"]["VALUE"]?>" target="_blank">Регистрация на Форум</a><br />
			<a href="<?echo $arItem["DISPLAY_PROPERTIES"]["SPONSOR_LINK"]["VALUE"]?>" target="_blank">Стать спонсором</a><br />
			<a href="<?echo $arItem["DISPLAY_PROPERTIES"]["SPEAKER_LINK"]["VALUE"]?>" target="_blank">Стать спикером</a><br />
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
<?foreach($arResult["ITEMS"] as $k=>$arItem):?>
<div class="left-forum">
	<? switch($arItem['ID'])
	{
	   case '144748-': 
	       ?><div class="forum-sponors">
					<div class="vid_rolik">
					<p><a href="http://www.facebook.com/media/set/?set=a.254020284705937.55545.135855716522395&type=3"><img src="/images/fotoalbum_4.jpg" alt="Фотоальбом"></a></p>
					<p color="black" align="center"><strong>Фото</strong></p>
					</div>
					<div class="vid_rolik">
					<p><a href="http://www.youtube.com/watch?v=2ctSTqvBLIU&feature=results_main&playnext=1&list=PL57D21265AC9A3CC4&noredirect=1"><img src="/images/video_4.jpg" alt="" /></a></p>
					<p color="black" align="center"><strong>Видео</strong></p>
					</div>
					&nbsp;
					<div class="vid_rolik">
					<p><a href="http://www.youtube.com/playlist?list=PL57D21265AC9A3CC4&feature=plcp"><img src="/images/doklad_4.jpg" alt="Плейлист" /></a></p>
					<p color="black" align="center"><strong>Доклады</strong></p>
					</div>	
			</div><?; 
	   break;
	   case '144783-': // константное выражение 2
	       ?><div class="forum-sponors">
					<div class="vid_rolik">
					<p><a href="http://www.facebook.com/PLUSworld.ru/photos_stream"><img src="/images/fotoalbum_5.jpg" alt="Фотоальбом"></a></p>
					<p color="black" align="center"><strong>Фото</strong></p>
					</div>
					<div class="vid_rolik">
					<p><a href="http://www.youtube.com/watch?v=0qmv4n7Z8xQ&feature=plcp"><img src="/images/video_5.jpg" alt="Плейлист" /></a></p>
					<p color="black" align="center"><strong>Видео</strong></p>
					</div>
					<div class="vid_rolik">
					<p><a href="http://www.youtube.com/user/PLUSforums"><img src="/images/doklad_5.jpg" alt="Плейлист" /></a></p>
					<p color="black" align="center"><strong>Доклады</strong></p>
					</div>
			</div><?; 
	   break;
	   default:	;
	}?>
	<br/>
</div>
<?endforeach;?>
