<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<h2>Азбука потребителя</h2>
<div class="special-projects special-projects_3th">

    <?foreach($arResult["ITEMS"] as $k => $arItem) {?>
        <div class="special-projects__item">
            <a class="project-card" href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
                <div class="project-card__image" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>)"></div>
                <div class="project-card__wrapper">
                    <?
                    $name = TruncateText(strip_tags($arItem["NAME"]), 60). "..."
                    ?>
                    <h3 class="project-card__title"><?=$name?></h3>
                </div>
            </a>
        </div>
    <?}?>

</div>