<div class="grid-x grid-padding-x medium-up-2">

    <?
    /*
     * Получаем случайную статью из последнего журнала
     * */
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

    \CModule::IncludeModule('iblock');

    $rs = CIBlockElement::GetList(
        array("SORT"=>"ASC"), //Сортировка
        array("IBLOCK_ID"=>41, "=PROPERTY_JOURNAL.ID" => $LAST_JOURNAL["ID"] ), //Фильтр значению полей
        false, //Массив полей группировка
        false, //Параметр для постраничной навигации
        array("ID", "PREVIEW_PICTURE", "NAME", "DETAIL_PAGE_URL", "PREVIEW_TEXT") //Массив возвращаемых полей
    );

    $articles = array();
    while($ar = $rs->GetNext()) {
        $articles[] = $ar;
    }

    $key = rand(0, count($articles) - 1);

    $arFileTmp = CFile::ResizeImageGet(
        $articles[$key]['PREVIEW_PICTURE'],
        array("width" => 280, "height" => 180),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true, $arFilter
    );
    ?>

    <div class="cell">
        <a class="art" href="<?=$articles[$key]["DETAIL_PAGE_URL"]?>" rel="nofollow noopener noreferrer">
            <div class="art__img text-center"><img src="<?=$arFileTmp["src"];?>"></div>
            <div class="art__title"><?=$articles[$key]["NAME"]?></div>
            <div class="art__business"><?echo strip_tags(TruncateText($articles[$key]["PREVIEW_TEXT"], 200));?><br>
            </div>
        </a>
    </div>

    <?
    /*
     * Полцчаем случайную новость PLUS-FORUM
     * */
    \CModule::IncludeModule('iblock');

    $rs = CIBlockElement::GetList(
        array("SORT"=>"ASC"), //Сортировка
        array("IBLOCK_ID"=>23, "=PROPERTY_NEWS_PLUSFORUM_VALUE" => "YES" ), //Фильтр значению полей
        false, //Массив полей группировка
        false, //Параметр для постраничной навигации
        array("ID", "PREVIEW_PICTURE", "NAME", "DETAIL_PAGE_URL", "PREVIEW_TEXT") //Массив возвращаемых полей
    );

    $articles = array();
    while($ar = $rs->GetNext()) {
        $articles[] = $ar;
    }

    $key = rand(0, count($articles) - 1);

    $arFileTmp = CFile::ResizeImageGet(
        $articles[$key]['PREVIEW_PICTURE'],
        array("width" => 280, "height" => 180),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true, $arFilter
    );
    ?>
    <div class="cell">
        <a class="art" href="<?=$articles[$key]["DETAIL_PAGE_URL"]?>">
            <div class="art__img text-center"><img src="<?=$arFileTmp["src"];?>"></div>
            <div class="art__title"><?=$articles[$key]["NAME"]?></div>
            <div class="art__business"><?echo strip_tags(TruncateText($articles[$key]["PREVIEW_TEXT"], 200));?></div>
        </a>
    </div>

</div>