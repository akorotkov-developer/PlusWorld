<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?if (count($arResult["ITEMS"])>0){?>
<div class="theme-news">
    <h3>Статьи по теме</h3>
    <?foreach($arResult["ITEMS"] as $arItem) {
        ?>
        <?$counter = intval($arItem["SHOW_COUNTER"]);
       $text_counter = pluralMain($counter, 'просмотр', 'просмотра', 'просмотров');
        ?>
      <div class="item">
          <?if(is_array($arItem["PREVIEW_PICTURE"])) {?>
              <div class="item_img">
                  <a href="<?=$arItem["DETAIL_PAGE_URL"];?>" >
                      <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"  width="100" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"  />
                  </a>
              </div>
          <?}?>
          <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]) {?>
              <div>
                  <span class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
                    <img src="/bitrix/templates/plus/images/eye.png" height="9" width="16" alt="Количество просмотров" title="Количество просмотров" border="0" style="margin:0; padding-left:5px; border-left: dotted 1px #555;" />
                    <span style="font-size:11px; margin-left:3px; color:#555;"><?=$counter?>&nbsp;<?=$text_counter?></span>
              </div>
          <? } ?>

          <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]) {?>
              <a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="link" ><?echo $arItem["NAME"]?></a>
            <br />
           <? }?>
              <?
              $string = strip_tags($arItem["PREVIEW_TEXT"]);
              $string = substr($string, 0, 200);
              $string = rtrim($string, "!,.-");
              $string = substr($string, 0, strrpos($string, ' '));
              $string .= "… ";
              ?>
              <div><?=$string?></div>
            <div class="clear"></div>
       </div>
    <? } ?>
</div>
 <?}?>
    <div class="clear"></div>