<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arPostNew = array();
$i = 0;

$SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
$arFilter = Array(
    "ACTIVE" => "Y",
    "GROUP_ID" => $arParams["GROUP_ID"],
    "UF_ARCHIVE" => false
);
$arSelectedFields = array("ID", "NAME", "DESCRIPTION", "URL", "OWNER_ID", "DATE_CREATE", "UF_ARCHIVE");

$dbBlogs = CBlog::GetList(
    $SORT,
    $arFilter,
    false,
    false,
    $arSelectedFields
);
$BLOG_ID = array();
while ($arBlog = $dbBlogs->Fetch())
{
    array_push($BLOG_ID, $arBlog["ID"]);
}

$SORT = Array("DATE_PUBLISH" => "DESC", "NAME" => "ASC");
$arFilter = Array(
    "BLOG_ID" => $BLOG_ID,
    "PUBLISH_STATUS" => "P",
);

$dbPosts = CBlogPost::GetList(
    $SORT,
    $arFilter
);

$arResult = array();
while ($arPost = $dbPosts->Fetch())
{
    array_push($arResult, $arPost);
}

foreach($arResult as $arPost)
{
    if ($i<=2) {
        $dbUser = CUser::GetByID($arPost["AUTHOR_ID"]);
        $arUser = $dbUser->Fetch();
        $BlogUser = CBlogUser::GetByID($arUser["ID"], BLOG_BY_USER_ID);
        $AuthorName = CBlogUser::GetUserName($BlogUser["ALIAS"], $arUser["NAME"], $arUser["LAST_NAME"], $arUser["LOGIN"]);

        $arBlog = CBlog::GetByID($arPost["BLOG_ID"]);
        $arBlogName = $arBlog["NAME"];
        $arBlogUrl = $arBlog["URL"];

        $arPost["AUTHOR_NAME"] = $AuthorName;
        $arPost["~AUTHOR_NAME"] = $AuthorName;


        $arPost["urlToAuthor"] = "http://www.plusworld.ru/blogs/?page=user&user_id=".$arPost["AUTHOR_ID"];
        $arPost["~urlToAuthor"] = "http://www.plusworld.ru/blogs/?page=user&user_id=".$arPost["AUTHOR_ID"];

        $arPost["urlToBlog"] = "http://www.plusworld.ru/blogs/?page=blog&blog=".$arBlogUrl;
        $arPost["~urlToBlog"] = "http://www.plusworld.ru/blogs/?page=blog&blog=".$arBlogUrl;

        $arPost["urlToPost"] = "http://www.plusworld.ru/blogs/?page=post&blog=".$arBlogUrl."&post_id=".$arPost["CODE"];
        $arPost["~urlToPost"] = "http://www.plusworld.ru/blogs/?page=post&blog=".$arBlogUrl."&post_id=".$arPost["CODE"];

        $arPost["urlToBlog"] = "http://www.plusworld.ru/blogs/?page=blog&blog=".$arBlogUrl;
        $arPost["~urlToBlog"] = "http://www.plusworld.ru/blogs/?page=blog&blog=".$arBlogUrl;

        $arPost["BLOG_USER_ALIAS"] = $arBlogName;
        $arPost["~BLOG_USER_ALIAS"] = $arBlogName;
        array_push($arPostNew,$arPost);
    }
    $i++;
}

$arResult = $arPostNew;

?>