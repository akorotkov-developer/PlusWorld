<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//echo "<pre>"; print_r($arResult["SECTIONS"]); echo "</pre>";?>
<ul id="pebg_rubrics">
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
foreach($arResult["SECTIONS"] as $arSection):
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
	if($CURRENT_DEPTH<$arSection["DEPTH_LEVEL"])
		echo "<ul>";
	elseif($CURRENT_DEPTH>$arSection["DEPTH_LEVEL"])
		echo str_repeat("</ul>", $CURRENT_DEPTH - $arSection["DEPTH_LEVEL"]);
	$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
	    $count = 0;
	$sect = CIBlockSection::GetList(
    Array("sort"=>"asc", 'name'=>'asc'), 
    Array(
        'IBLOCK_ID'=>"68", 
        'ID'=>$arSection['ID']
    ), 
    true, 
    array('NAME')
);
while($el = $sect->Fetch()):
    $count += $el["ELEMENT_CNT"];
endwhile;
if ($count>0) {
?>
	<li id="<?=$this->GetEditAreaId($arSection['ID']);?>"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?>&nbsp;(<?=$arSection["ELEMENT_CNT"]?>)<?endif;?></a></li>
	<? } ?>
<?endforeach?>
</ul>

