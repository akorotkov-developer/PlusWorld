<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="cell large-5 hide-for-large medium-24 search-top_mobileblock">
    <form class="search-top input-group search-top-mobile" action="<?=$arResult["FORM_ACTION"]?>">
        <?if($arParams["USE_SUGGEST"] === "Y"):?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:search.suggest.input",
                "",
                array(
                    "NAME" => "q",
                    "VALUE" => "",
                    "INPUT_SIZE" => 15,
                    "DROPDOWN_SIZE" => 10,
                ),
                $component, array("HIDE_ICONS" => "Y")
            );?>
        <?else:?>
            <input class="search-top__input input-group-field" type="text" name="q" placeholder="<?=GetMessage("BSF_T_SEARCH_PLACEHOLDER")?>" value="">
            <input type="hidden" name="where" value="all">
            <div class="input-group-button">
                <button class="search-top__button search-top__button-mobile" name="s" type="submit">
                    поиск
                </button>
            </div>
        <?endif;?>
    </form>
</div>



