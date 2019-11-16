<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>


<div class="grid-x grid-padding-x margin-bottom-6">
    <div class="cell large-24 news_mainpage">

        <?foreach($arResult["ITEMS"] as $arItem) {?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <?$frame = $this->createFrame()->begin("");//Начало динамической области?>
            <?if ($i==0) {?>
                <a class="art" href="<?=$arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="grid-x grid-padding-x align-middle">
                        <div class="cell large-10">
                            <div class="art__img text-center"><img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>"></div>
                        </div>
                        <div class="cell xlarge-10 large-14">
                            <div class="art__title art__title_big"><?=$arItem["NAME"]?></div>
                            <div class="art__text">
                                <?echo mb_substr(strip_tags($arItem["PREVIEW_TEXT"]),0,200);?>
                            </div>
                        </div>
                    </div>
                </a>
            <?} else {?>
                <?if ($i==1) {?>
                <div class="grid-x grid-padding-x large-up-3 small-up-2">
                <?}?>
                    <div class="cell news_mainpage-item">
                        <a class="smart" href="<?=$arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <div class="smart__img text-center large-text-left"> <img src="<?=$arItem["PICTURE"]?>" alt="<?=$arItem["NAME"]?>"></div>
                            <div class="smart__title"><?=$arItem["NAME"]?></div>
                        </a>
                    </div>
                <?if ($i==3) {?>
                </div>
                <?}?>
            <?}?>
            <?$i++;?>
            <?$frame->end(); // Конец фрейма?>
        <?}?>
    </div>

</div>