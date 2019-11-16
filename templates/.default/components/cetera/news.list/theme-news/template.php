<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (!empty($arResult["ITEMS"])){?>
    <div class="read-also">
        <div class="read-also__head">Читайте также</div>
        <?$i=0;
        foreach($arResult["ITEMS"] as $arItem){?>
            <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
            <div class="read-also__item">
                <div class="grid-x grid-padding-x">
                    <?if(is_array($arItem["DETAIL_PICTURE"])){?>
                        <div class="cell large-10">
                            <img class="read-also__image" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>">
                        </div>
                    <?}?>
                    <div class="cell large-14">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"];?>">
                            <span class="read-also__title"><?=$arItem["NAME"]?></span>
                        </a>
                        <p class="read-also__text"><?=substr($arItem["PREVIEW_TEXT"], 0, 200);?></p>
                    </div>
                </div>
            </div>
            <?
            $i++;
        }
        ?>
    </div>
<?}?>