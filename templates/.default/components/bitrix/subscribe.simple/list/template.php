<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$frame = $this->createFrame()->begin("");//������ ������������ �������?>
<?//if(isset($_REQUEST['ff']))var_dump($arResult);?>
<ul>
	<?foreach($arResult["RUBRICS"] as $arRubric):?>
		<?if($arRubric["CHECKED"]):?><li><?echo $arRubric["NAME"]?>  <br />
	<span class="desc"><?echo $arRubric["DESCRIPTION"]?> </span></li><?endif;?>
	<?endforeach?>
</ul>
<?$frame->end(); // ����� ������?>