<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult["VOTE"]))
	return false;

$rsNext = $DB->Query("SELECT ID, TITLE FROM b_vote WHERE ACTIVE = 'Y' AND CHANNEL_ID = '{$arResult["VOTE"]["CHANNEL_ID"]}' AND(C_SORT > '{$arResult["VOTE"]["C_SORT"]}' OR ID > '{$arResult["VOTE"]["ID"]}') ORDER BY C_SORT,ID  LIMIT 1");
if ($row = $rsNext->Fetch())
{
    $row['VOTED'] = IsUserVoted($row['ID']);
    $arResult["VOTE_NEXT"] =  $row;
}
$rsPrev = $DB->Query("SELECT ID, TITLE FROM b_vote WHERE ACTIVE = 'Y' AND CHANNEL_ID = '{$arResult["VOTE"]["CHANNEL_ID"]}' AND(C_SORT < '{$arResult["VOTE"]["C_SORT"]}' OR ID < '{$arResult["VOTE"]["ID"]}') ORDER BY C_SORT DESC,ID DESC LIMIT 1");
if ($row = $rsPrev->Fetch())
{
    $row['VOTED'] = IsUserVoted($row['ID']);
    $arResult["VOTE_PREV"] =  $row;
}