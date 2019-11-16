<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



	<?if(count($arResult["ITEMS"]) > 0){?>
	<div id="accordion" style="padding-top: 46px;">
		<?foreach($arResult["ITEMS"] as $arItem){
			?>
			<h3><?=strip_tags($arItem["PROPERTIES"]["TEXT"]["VALUE"])?></h3>
			<?$count = 0;?>
			<div>
				<?foreach($arItem["PROPERTIES"]["QUESTS"]["VALUE"] as $arQuest) {?>
					<span><b>На вопрос отвечает:
					<?=$arItem["PROPERTIES"]["QUESTS"]["DESCRIPTION"][$count]?></b></span>
					<hr width="50%">
					<?=$arQuest["TEXT"];?>
					<br />
					<hr />
					<?$count++;?>
				<?}?>
				<div><?=$arItem["PREVIEW_TEXT"]?></div>
			</div>
		<?}?>
	</div>
	<style>
		.ui-accordion-content {
			height: inherit !important;
		}
	</style>
	<?}?>

    <script>
        $( document ).ready(function() {
            $( "#accordion" ).accordion({
                collapsible: true
            });
        });
    </script>

<?if ($_GET["rt"]=="rt") {?>

	<?if(count($arResult["ITEMS"]) > 0){?>
	<a name="back"></a>
	<ul class="questions-ul">
		<?foreach($arResult["ITEMS"] as $arItem){?>
			<li class="questions-li">
				<a href="#questions_<?=$arItem['ID']?>"><?=strip_tags($arItem["PROPERTIES"]["TEXT"]["VALUE"])?></a>
			</li>
		<?}?>
	</ul>
	<?}?>

	<?
	/* 	echo "<pre>";
		var_dump($arResult["ITEMS"]);
		echo "</pre>"; */
	?>

	<?if(count($arResult["ITEMS"]) > 0){?> 
		<?foreach($arResult["ITEMS"] as $arItem){?>
			<a name="questions_<?=$arItem['ID']?>"></a>
			<div>
				<h1><?=strip_tags($arItem["PROPERTIES"]["TEXT"]["VALUE"])?></h1>
				<?if ($_GET["rt"]=="rt") {?>

					<?$count = 0;?>
					<?foreach($arItem["PROPERTIES"]["QUESTS"]["VALUE"] as $arQuest) {?>
						<span><b>На вопрос отвечает: 
						<?=$arItem["PROPERTIES"]["QUESTS"]["DESCRIPTION"][$count]?></b></span>
						<hr width="50%">
						<?=$arQuest["TEXT"];?>
						<br />
						<hr />
						<?$count++;?>
					<?}?>
				<?}?>
				<div><?=$arItem["PREVIEW_TEXT"]?></div>
				<p class="questions-back"><a href="#back">Назад к списку вопросов</a></p>
			</div>
		<?}?>
	<?}?>

<?}?>


