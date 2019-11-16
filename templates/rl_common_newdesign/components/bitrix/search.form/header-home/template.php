<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="cell large-5 show-for-large medium-12" id="search" data-toggler=".show-for-large">
    <form class="search-top input-group" action="<?=$arResult["FORM_ACTION"]?>">
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
            <div class="input-group-button">
                <button class="search-top__button" name="s" type="submit"><i class="fas fa-search"></i></button>
            </div>
        <?endif;?>
    </form>
</div>



