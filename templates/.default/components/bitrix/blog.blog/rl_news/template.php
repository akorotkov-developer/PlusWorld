<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!$this->__component->__parent || empty($this->__component->__parent->__name) || $this->__component->__parent->__name != "bitrix:blog"):
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/themes/blue/style.css');
endif;
?>
<?
$SORT = Array("DATE_PUBLISH" => "DESC", "NAME" => "ASC");
$arFilter = Array(
	"BLOG_ID" => $arResult["BLOG"]["ID"],
    "PUBLISH_STATUS" => "P"
    );	
$SELECT = array("ID", "TITLE", "CODE", "DATE_PUBLISH"); 

$dbPosts = CBlogPost::GetList(
        $SORT,
        $arFilter,
		$SELECT
    );
$count = 0;
$ar_post = array();
while ($arPost = $dbPosts->Fetch())
{
if (strtotime(date(d.'.'.m.'.'.Y.' '.H.':'.m.':'.s))-strtotime($arPost["DATE_PUBLISH"])<=86400*100) {
$ar_post[] = $arPost;
   //echo"<pre>";  print_r($arPost["DATE_PUBLISH"]); echo"</pre>";
   $count++;
   }
}

$ar_post_1[0]= $ar_post[0];
$ar_post_1[1]= $ar_post[1];
$ar_post_1[2]= $ar_post[2];


$ar_post = $ar_post_1;


?>
<?if($count>0) { ?><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 5px; background-color: #EEEEEE; border: 1px solid #C0C0C0;">
	<tbody>
	<tr>
		<td>
<h1 style="text-align: center; color: #A51340;font-size: 16px;font-family: Arial,helvetica,sans-serif;"  >Блог эксперта</h1>

<div id="blog-posts-content">
<?$rsUser =CBlogUser::GetByID($arResult["BLOG"]["OWNER_ID"], BLOG_BY_USER_ID);
$url_avatar = CFile::GetPath($rsUser["AVATAR"]);

$rsFile = CFile::GetByID($rsUser["AVATAR"]);

	$arFile = $rsFile->Fetch();
	$arFileTmp = CFile::ResizeImageGet(
		$arFile,
		array("width" => "80", "height" => "100"),
		BX_RESIZE_IMAGE_PROPORTIONAL,
		true
	);
	
if ($url_avatar) {?>
<table>
    <tr>
        <td style="width: 90px;">
         <?echo "<img style='width: 80px;' width='80px' src='".$arFileTmp["src"]."' />";?>
        </td>
        <td>
            <h2 style=" margin: 0;">
                <a style="color: #A51340;font-size: 14px;font-family: Arial,helvetica,sans-serif;"  href="http://www.retail-loyalty.org/blogs/?page=blog&blog=<?=$arParams['BLOG_URL']?>">
                    <?=$arResult['BLOG']['NAME']?>
                </a>
            </h2>
            <ul>
                <?foreach($ar_post as $ind => $CurPost)
                {
                    //echo"<pre>";  print_r($CurPost); echo"</pre>";
                    $className = "blog-post";
                    ?>
                    <?if ($CurPost["TITLE"]) {?>
                    <li>
                        <div class="<?=$className?>">
                            <div class="other-art" style="padding-bottom: 7px;">
                                <a style="color: #A51340;font-size: 12px;font-family: Arial,helvetica,sans-serif;" target="_blank" href="http://www.retail-loyalty.org/blogs/?page=post&blog=<?=$arParams['BLOG_URL']?>&post_id=<?=$CurPost["CODE"]?>" title="<?=$CurPost["TITLE"]?>"><?=$CurPost["TITLE"]?></a>
                            </div>
                        </div>
                    </li>
                <? } ?>
                <?
                }?>
            </ul>
        </td>
    </tr>
</table>
<?
} else {?>
<h2 style=" margin: 0;">
    <a style="color: #A51340;font-size: 14px;font-family: Arial,helvetica,sans-serif;"  href="http://www.retail-loyalty.org/blogs/?page=blog&blog=<?=$arParams['BLOG_URL']?>">
        <?=$arResult['BLOG']['NAME']?>
    </a>
</h2>
    <ul>
        <?foreach($ar_post as $ind => $CurPost)
        {
            //echo"<pre>";  print_r($CurPost); echo"</pre>";
            $className = "blog-post";
            ?>
            <?if ($CurPost["TITLE"]) {?>
            <li>
                <div class="<?=$className?>">
                    <div class="other-art" style="padding-bottom: 7px;">
                        <a style="color: #A51340;font-size: 12px;font-family: Arial,helvetica,sans-serif;" target="_blank" href="http://www.retail-loyalty.org/blogs/?page=post&blog=<?=$arParams['BLOG_URL']?>&post_id=<?=$CurPost["CODE"]?>" title="<?=$CurPost["TITLE"]?>"><?=$CurPost["TITLE"]?></a>
                    </div>
                </div>
            </li>
        <? } ?>
        <?
        }?>
    </ul>
<? } ?>



		</td>
	</tr>
</tbody>
</table>
		<?
}
?>	
