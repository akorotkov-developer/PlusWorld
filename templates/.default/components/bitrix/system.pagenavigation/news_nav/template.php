<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

$this->setFrameMode(true);
?>

<?
if($arResult["NavPageCount"] > 1) {
    ?>

    <ul class="pagination text-center">
        <li><?=GetMessage("total")?>: <?=$arResult["NavRecordCount"];?></li>
        <?
        $bFirst = true;

        if ($arResult["NavPageNomer"] > 1):
            if ($arResult["bSavePage"]):
                ?>
                <li class="pagination-next newsnav_li">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>" aria-label="Предыдущая страница"><xml version="1.0" encoding="UTF-8">
                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <!-- Creator: CorelDRAW X6 -->
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="9px" height="11px"  version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                 viewBox="0 0 9 11"
                                 xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g>
                            <path d="M8.541,10.988 L3.869,5.487 L8.541,-0.015 L5.133,-0.015 L0.460,5.487 L5.133,10.988 L8.541,10.988 Z"></path>
                        </g>
                        </svg>
                    </a>
                </li>
            <?
            else:
                if ($arResult["NavPageNomer"] > 2):
                    ?>
                    <li class="pagination-next newsnav_li">
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>" aria-label="Предыдущая страница"><xml version="1.0" encoding="UTF-8">
                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <!-- Creator: CorelDRAW X6 -->
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="9px" height="11px"  version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                     viewBox="0 0 9 11"
                                     xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g>
                            <path d="M8.541,10.988 L3.869,5.487 L8.541,-0.015 L5.133,-0.015 L0.460,5.487 L5.133,10.988 L8.541,10.988 Z"></path>
                        </g>
                        </svg>
                        </a>
                    </li>
                <?
                else:
                    ?>
                    <li class="pagination-next newsnav_li">
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>" aria-label="Предыдущая страница"><xml version="1.0" encoding="UTF-8">
                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <!-- Creator: CorelDRAW X6 -->
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="9px" height="11px"  version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                     viewBox="0 0 9 11"
                                     xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g>
                            <path d="M8.541,10.988 L3.869,5.487 L8.541,-0.015 L5.133,-0.015 L0.460,5.487 L5.133,10.988 L8.541,10.988 Z"></path>
                        </g>
                        </svg>
                        </a>
                    </li>
                <?
                endif;

            endif;
            ?>
            <?

            if ($arResult["nStartPage"] > 1):
                $bFirst = false;
                if ($arResult["bSavePage"]):
                    ?>
                    <li class="newsnav_li"><a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1" >1</a></li>
                <?
                else:
                    ?>
                    <li class="newsnav_li"><a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>" >1</a></li>
                <?
                endif;
                ?>
                <?
                if ($arResult["nStartPage"] > 2):
                    ?>
                    <li class="ellipsis newsnav_li">...</li>
                <?
                endif;
            endif;
        endif;
        ?>

        <?
        do
        {
            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
                <li class="current newsnav_li"><?=$arResult["nStartPage"]?></li>
            <?
            elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                ?>
                <li class="newsnav_li"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "news-page-first" : "")?>"><?=$arResult["nStartPage"]?></a></li>
            <?
            else:
                ?>
                <li class="newsnav_li"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
            <?
            endif;
            ?>
            <?
            $arResult["nStartPage"]++;
            $bFirst = false;
        } while($arResult["nStartPage"] <= $arResult["nEndPage"]);

        if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
            if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                    ?>
                    <li class="ellipsis newsnav_li">...</li>
                <?
                endif;
                ?>
                <li class="newsnav_li"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" title=""><?=$arResult["NavPageCount"]?></a></li>
            <?
            endif;
            ?>
            <li class="pagination-next newsnav_li">
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><xml version="1.0" encoding="UTF-8">
                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <!-- Creator: CorelDRAW X6 -->
                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="9px" height="11px"  version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                             viewBox="0 0 9 11"
                             xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g>
                            <path d="M0.754,10.988 L5.426,5.487 L0.754,-0.015 L4.162,-0.015 L8.835,5.487 L4.162,10.988 L0.754,10.988 Z"/>
                        </g>
                    </svg>
                </a>
            </li>
        <?
        endif;
        ?>

    </ul>
    <?
}
?>
