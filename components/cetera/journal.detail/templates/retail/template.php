<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="grid-container margin-bottom-20">
    <div class="grid-x grid-padding-x number">
        <div class="cell medium-10 medium-offset-1 large-offset-0 large-8">
            <img class="number__poster" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>">
            <div class="number__buttons">
                <a class="button button_low large hollow" href="http://market.plusworld.ru/catalog/subscription_to_the_journal_of_retail_loyalty/">Купить номер</a>
                <a class="button button_low large hollow" href="/journal_retail_loyalty/podpiska/">Подписаться</a>
            </div>
        </div>
        <div class="cell medium-auto medium-offset-1">
            <a class="button hollow number__archive" href="/journal_retail_loyalty/read_online/">Архив номеров</a>
            <h1 class="number__title"><?=$arResult["NAME"]?></span></h1>
            <a href="<?=$arResult["MAIN_ARTICLE"]["DETAIL_PAGE_URL"]?>">
                <h2 class="number__subtitle"><?=$arResult["MAIN_ARTICLE"]["NAME"]?></h2>
            </a>
            <p class="number__text"><?echo TruncateText($arResult["MAIN_ARTICLE"]["PREVIEW_TEXT"],1400);?></p>
        </div>
    </div>

    <?if (isset($arResult["ARTICLES"]) && !empty($arResult["ARTICLES"])){
        foreach($arResult["ARTICLES"] as $k=>$value){
        ?>
            <div class="grid-x article-preview">
                <div class="cell medium-offset-1 medium-8 large-7 large-offset-0">
                    <img class="article-preview__image" src="<?=$value["PREVIEW_PICTURE"]["SRC"]?>" alt=""/>
                </div>
                <div class="cell medium-offset-1 medium-14">
                    <a class="article-preview__title" href="<?=$value["DETAIL_PAGE_URL"]?>">
                        <h2><?=$value["NAME"];?></h2>
                    </a>
                    <p class="article-preview__text"><?=TruncateText(strip_tags($value["PREVIEW_TEXT"]),200);?></p>
                </div>
            </div>
        <?
        }
    }?>
</div>