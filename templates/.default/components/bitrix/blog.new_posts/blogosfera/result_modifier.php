<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arPostNew = array();
$i = 0;
foreach($arResult as $arPost)
{
    $ufArchive = 0;
    $arFilter = Array(
        "ACTIVE" => "Y",
        "ID" => $arPost["BLOG_ID"]
    );
    $arSelectedFields = array("UF_ARCHIVE");

    $dbBlogs = CBlog::GetList(
        $SORT,
        $arFilter,
        false,
        false,
        $arSelectedFields
    );

    while ($arBlog = $dbBlogs->Fetch())
    {
        $ufArchive = intval($arBlog["UF_ARCHIVE"]);
    }

    if ($ufArchive==0) {
        if ($i<=4) {
            array_push($arPostNew,$arPost);
        }
        $i++;
    }
}

    $arResult = $arPostNew;

?>