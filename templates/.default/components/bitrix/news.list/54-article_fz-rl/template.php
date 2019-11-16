<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin("");//Начало динамической области?>
<?$APPLICATION->SetTitle($arResult["SECTION"]["PATH"]["0"]["NAME"]);?>



<div class="clear"></div>

<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>

<?$sectionID = $arResult['SECTION']['PATH']['0']['ID'];
$resArticles = CIBlockElement::GetList(array("DATE_ACTIVE_FROM"=>"DESC"), array("IBLOCK_ID"=>$arParams["ARTICLES_IBLOCK_ID"],"PROPERTY_KNOW_BASE"=>$sectionID), false, false, array("ID","IBLOCK_ID","NAME","PREVIEW_PICTURE","DETAIL_PAGE_URL"));
$i = 0;
while($obArticle = $resArticles->GetNextElement()){$i++;}?>

<?$countAll = count($arResult["ITEMS"]) + $i?>


<?$count = count($arResult["ITEMS"])-1;?>


<?

$resArticles->NavStart(20);
            while($obArticle = $resArticles->GetNextElement())
    		{
    			$arArticle = $obArticle->GetFields();
                $arItem["ARTICLES"][] = $arArticle;
            }

//if(isset($_REQUEST['dd']))var_dump($arItem["ARTICLES"]);
?>



<?if($arItem["ARTICLES"]):?>
        <?$coun_ar54 = 0?>
        <?foreach($arItem["ARTICLES"] as $k => $arArticle):?>
            <div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <?$file = CFile::ResizeImageGet($arArticle["PREVIEW_PICTURE"], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_EXACT, true);?>
                <div class="a54_newsforthem_list_picture">
                    <div class="preview_picture_link">
                        <a target="_blank" href="<?=$arItem["DETAIL_PAGE_URL"].'?id='.$arItem["ID"]?>">
                            <img src="<?=$file['src']?>"
                                 alt="<?=$arArticle["NAME"]?>"
                                 title="<?=$arArticle["NAME"]?>"
                                 class="preview_picture" /></a>
                    </div>
                </div>

                <div class="a54_newsforthem_list_content">
                    <a target="_blank"href="<?=$arArticle["DETAIL_PAGE_URL"]?>" class="link" ><?echo $arArticle["NAME"]?></a><br />

                    <?echo $arArticle["PREVIEW_TEXT"];?>

                </div>

                <div class="clear"></div>
            </div>
            <?$coun_ar54++;?>
            <?if ($coun_ar54 > 2) break;?>
        <?endforeach;?>


	<?echo $resArticles->NavPrint(GetMessage("PAGES"));?>
<?endif;?>
</div>
<?$frame->end(); // Конец фрейма?>