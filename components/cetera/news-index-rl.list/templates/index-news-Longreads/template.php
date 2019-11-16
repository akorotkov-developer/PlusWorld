<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<h2>Специальные проекты</h2>
<div class="special-projects">
    <?foreach($arResult["ITEMS"] as $arItem){?>
        <div class="special-projects__item">
            <a class="project-card" href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"];?>">
                <?if ($arItem["PREVIEW_PICTURE"]) {?>
                    <div class="project-card__image" style="background-image: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>)"></div>
                <?}?>
                <div class="project-card__wrapper">
                    <h3 class="project-card__title"><?echo $arItem["NAME"]?></h3>
                    <p class="project-card__text"><?echo TruncateText($arItem["PREVIEW_TEXT"], 250);?></p>
                </div>
            </a>
        </div>
    <?}?>
</div>
