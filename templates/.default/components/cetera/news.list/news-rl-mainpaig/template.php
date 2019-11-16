<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>


<div class="grid-x grid-padding-x margin-bottom-6">
    <div class="cell large-18 news_mainpage">
        <?$i = 0;?>
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
    <div class="cell large-6 news_mainpage-rightsidebar">
        <?if ($arResult["IMPORTANT_NEWS"]) {?>
            <a class="blank blank_high" href="<?=$arResult["IMPORTANT_NEWS"]["PROPERTY_URL_NEWS_VALUE"]?>">
                <div class="blank__back"></div>
                <div class="blank__container">
                    <div class="blank__triangle"></div>
                </div>
                <div class="blank__man text-center"><img src="<?=$arResult["IMPORTANT_NEWS"]["PREVIEW_PICTURE_SRC"]?>" alt="<?=$arResult["NAME"]?>"></div>
                <?if ($arResult["IMPORTANT_NEWS"]["PROPERTY_TYPE_VALUE"] != "") {?>
                    <div class="blank__cat"><?=$arResult["IMPORTANT_NEWS"]["PROPERTY_TYPE_VALUE"]?></div>
                <?}?>
                <div class="blank__info"><?=$arResult["NAME"]?></div>
                <div class="blank__quote"><?echo mb_substr(strip_tags($arResult["IMPORTANT_NEWS"]["PREVIEW_TEXT"]),0,40);?></div>
            </a>
        <?} else {?>
            <a class="blank blank_high" href="<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>">
                <div class="blank__back"></div>
                <div class="blank__container">
                    <div class="blank__triangle"></div>
                </div>
                <div class="blank__man text-center"><img src="<?=$arResult["ITEMS"][0]["DETAIL_PICTURE_RIGHT"]["SRC"]?>" alt="<?=$arResult["ITEMS"][0]["NAME"]?>"></div>
                <div class="blank__info"><?=$arResult["NAME"]?></div>
                <div class="blank__quote"><?echo mb_substr(strip_tags($arResult["ITEMS"][0]["PREVIEW_TEXT"]),0,40);?></div>
            </a>
        <?}?>
    </div>
</div>