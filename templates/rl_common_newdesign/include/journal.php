<div class="blank text-center blank_journal">
    <?
    CModule::IncludeModule("iblock");
    $obJournals = \CIBlockElement::GetList(array('ID'=>'desc'), array(
        "IBLOCK_ID" => 40,
        "ACTIVE" => "Y",
        "ACTIVE_DATE" => "Y",
    ), false, false, array());
    if ($arJournal = $obJournals->Fetch())
        $LAST_JOURNAL = $arJournal;
    ?>
    <?
    $name = str_ireplace('RETAIL&LOYALTY', '<span class="text-dark-gray">RETAIL&#38;LOYALTY</span><br>', $LAST_JOURNAL["NAME"]);
    $link = $LAST_JOURNAL["LIST_PAGE_URL"].$LAST_JOURNAL["ID"]."/";

    $picture = \CFile::ResizeImageGet(
        $LAST_JOURNAL["PREVIEW_PICTURE"],
        array('width' => 250, 'height' => 192),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true
    );

    ?>
    <div class="blank__title">ЖУРНАЛ <?=$name?></div>
    <p><img class="journal_preview_image" src="<?=$picture["src"]?>" height="192" alt=""></p>
    <div class="text-center">
        <a class="button hollow blank__button" href="<?=$link?>">читать online  </a>
        <a class="button hollow blank__button" href="/journal_retail_loyalty/podpiska/">Подписатьcя  </a>
    </div>
</div>