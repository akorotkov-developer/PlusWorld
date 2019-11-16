<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<div class="padding-top-12 padding-bottom-6">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell">
                <a class="button <?if ($_GET["prev"] == "Y"){?>light-gray<?}?>" href="<?=$APPLICATION->GetCurPageParam("last=N", array("last","prev"));?>">Предстоящие</a>
                <a class="button <?if ($_GET["prev"] != "Y"){?>light-gray<?}?>" href="<?=$APPLICATION->GetCurPageParam("prev=Y", array("last","prev"));?>">Прошедшие</a>
                <div class="grid-x grid-padding-x small-up-1 medium-up-2 large-up-4" data-equalizer="events" data-equalize-by-row="true">

                    <?foreach($arResult["ITEMS"] as $arItem):?>
                        <?
                        $this->AddEditAction($arItem['ID']."_".$q, $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID']."_".$q, $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"));
                        ?>
                        <div class="cell margin-bottom-6" id="<?=$this->GetEditAreaId($arItem['ID']."_".$q);?>">
                            <div class="radius padding-6 background-main" data-equalizer-watch="events">
                                <div class="margin-bottom-1">
                                    <strong>
                                        <?echo $arItem["DISPLAY_ACTIVE_FROM"];?>
                                        <?
                                        if ($stmp = MakeTimeStamp($arItem["ACTIVE_TO"], "DD.MM.YYYY"))
                                        {
                                            echo " - ".date("d.m.Y", $stmp);
                                        }?>
                                    </strong>
                                </div>
                                <h6 class="margin-bottom-6">
                                    <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" title="<?echo $arItem["NAME"]?>"><?echo $arItem["NAME"]?></a>
                                </h6>
                                <div class="text-tertiary">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
                                        <div>
                                            <strong>
                                                <?if($pid == 'FORUM_MESSAGE_CNT'):?><?=GetMessage("IBLOCK_COMMENT")?><?else:?><?=$arProperty["NAME"]?><?endif;?>:&nbsp;
                                                    <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
                                                        <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
                                                    <?else:?>
                                                        <?=$arProperty["DISPLAY_VALUE"];?>
                                                 <?endif?>
                                            </strong>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>

                </div>
                <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                    <br /><?=$arResult["NAV_STRING"]?>
                <?endif;?>
            </div>
        </div>
    </div>
</div>
