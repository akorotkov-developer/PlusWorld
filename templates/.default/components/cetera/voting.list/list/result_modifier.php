<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$rsPopular = $DB->Query("SELECT ID, TITLE, DATE_START, DATE_END, IMAGE_ID FROM b_vote WHERE ACTIVE = 'Y' ORDER BY COUNTER DESC LIMIT 3");
while ($row = $rsPopular->Fetch())
{
    if ($row["IMAGE_ID"]):

		$arFileTmp = CFile::ResizeImageGet(
			$row["IMAGE_ID"],
			array("width" => 60, "height" => 60),
			BX_RESIZE_IMAGE_PROPORTIONAL,
			true
		);

		$row['PICTURE'] = array(
			'SRC' => $arFileTmp["src"],
			'WIDTH' => $arFileTmp["width"],
			'HEIGHT' => $arFileTmp["height"],
		);
    endif;
    $row['VOTED'] = IsUserVoted($row['ID']);
    $arPopular[] = $row;
}

$arResult["POPULAR"] = $arPopular;
