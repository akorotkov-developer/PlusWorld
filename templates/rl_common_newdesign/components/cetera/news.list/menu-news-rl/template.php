<div class="header__marquee">
<span><a href="/news/novosti-kompaniy/">Новости Ритейла</a></span>
<a href="/news/e-commerce/">E-commerce</a>
<a href="/news/loyalty/">Лояльность</a>
<a href="/news/technologii/">Технологии</a>  
<a href="/news/payments-cash/">Платежи и кассы</a>
<a href="/news/innovation/">Инновации</a>
<a href="/news/horeca/">HoReCa</a> 
<a href="/news/cat_torgovie-seti/">Сети</a> 
<a href="/news/cat_logistica/">Логистика</a> 
<a href="/news/cat_fmcg-i-stm/">FMCG</a> 
<a href="/news/cat_issledovaniya/">Исследования</a>
</div>


<!--<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="header__marquee">
    <ul class="develop show-for-large" id="develop" data-toggler=".show-for-large">
        <?foreach($arResult["ITEMS"] as $arItem){?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <li id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="develop__item">
                <a class="develop__link" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
            </li>
        <?}?>
    </ul>
</div>-->