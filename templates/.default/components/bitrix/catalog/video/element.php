<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true); ?>
<?global $USER;
// ������� ����� pas-5220 
if (($_REQUEST["rt"]==1) &&($_SERVER["REMOTE_ADDR"]=='77.220.48.42')){
$res = CIBlockElement::GetByID($arResult["VARIABLES"]["ELEMENT_ID"]);
 
 $db_props = CIBlockElement::GetProperty('67', $arResult["VARIABLES"]["ELEMENT_ID"], array("sort" => "asc"), Array("CODE" =>"PAID_VIDEO"));
if($ar_props = $db_props->Fetch()) {
  $code_video = $ar_props["VALUE"];
} 
  
  $db_props = CIBlockElement::GetProperty('67', $arResult["VARIABLES"]["ELEMENT_ID"], array("sort" => "asc"), Array("CODE" =>"PAID"));
if($ar_props = $db_props->Fetch()) {
	$flag_video = $ar_props["VALUE_ENUM"];
 // echo "<pre>"; print_r($ar_props); echo "</pre>";
  }
 
$ElementID = $APPLICATION->IncludeComponent("cetera:news.detail", "video_new_2014", Array(
	"DISPLAY_DATE" => "Y",	// �������� ���� ��������
	"DISPLAY_NAME" => "N",	// �������� �������� ��������
	"DISPLAY_PICTURE" => "N",	// �������� ��������� �����������
	"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
	"USE_SHARE" => "N",	// ���������� ������ ���. ��������
	"AJAX_MODE" => "N",	// �������� ����� AJAX
	"IBLOCK_TYPE" => "services",	// ��� ��������������� ����� (������������ ������ ��� ��������)
	"IBLOCK_ID" => "67",	// ��� ��������������� �����
	"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],	// ID �������
	"ELEMENT_CODE" => "",	// ��� �������
	"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
	"FIELD_CODE" => "",	// ����
	"PROPERTY_CODE" => array(	// ��������
		0 => "LINK",
		1 => "DATE_START",
		2 => "DATE_END",
		3 => "VIDEO",
	),
	"IBLOCK_URL" => "",	// URL �������� ��������� ������ ��������� (�� ��������� - �� �������� ���������)
	"META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
	"META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
	"BROWSER_TITLE" => "NAME",	// ���������� ��������� ���� �������� �� ��������
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"SET_STATUS_404" => "Y",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "Y",	// �������� ������ � ������� ���������
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"USE_PERMISSIONS" => "N",	// ������������ �������������� ����������� �������
	"CACHE_TYPE" => "N",	// ��� �����������
	"CACHE_TIME" => "3600",	// ����� ����������� (���.)
	"CACHE_GROUPS" => "Y",	// ��������� ����� �������
	"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
	"PAGER_TITLE" => "��������",	// �������� ���������
	"PAGER_TEMPLATE" => "",	// �������� �������
	"PAGER_SHOW_ALL" => "Y",	// ���������� ������ "���"
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	),
	$component
);

} else { ?>
<?$ElementID = $APPLICATION->IncludeComponent("cetera:news.detail", "video", Array(
	"DISPLAY_DATE" => "Y",	// �������� ���� ��������
	"DISPLAY_NAME" => "N",	// �������� �������� ��������
	"DISPLAY_PICTURE" => "N",	// �������� ��������� �����������
	"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
	"USE_SHARE" => "N",	// ���������� ������ ���. ��������
	"AJAX_MODE" => "N",	// �������� ����� AJAX
	"IBLOCK_TYPE" => "services",	// ��� ��������������� ����� (������������ ������ ��� ��������)
	"IBLOCK_ID" => "67",	// ��� ��������������� �����
	"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],	// ID �������
	"ELEMENT_CODE" => "",	// ��� �������
	"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
	"FIELD_CODE" => "",	// ����
	"PROPERTY_CODE" => array(	// ��������
		0 => "LINK",
		1 => "DATE_START",
		2 => "DATE_END",
		3 => "VIDEO",
	),
	"IBLOCK_URL" => "",	// URL �������� ��������� ������ ��������� (�� ��������� - �� �������� ���������)
	"META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
	"META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
	"BROWSER_TITLE" => "NAME",	// ���������� ��������� ���� �������� �� ��������
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"SET_STATUS_404" => "Y",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "Y",	// �������� ������ � ������� ���������
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"USE_PERMISSIONS" => "N",	// ������������ �������������� ����������� �������
	"CACHE_TYPE" => "N",	// ��� �����������
	"CACHE_TIME" => "600",	// ����� ����������� (���.)
	"CACHE_GROUPS" => "N",	// ��������� ����� �������
	"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
	"PAGER_TITLE" => "��������",	// �������� ���������
	"PAGER_TEMPLATE" => "",	// �������� �������
	"PAGER_SHOW_ALL" => "Y",	// ���������� ������ "���"
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	),
	$component
);?>
<? } ?>
<?
/*
if (isset($ElementID)) {
?>
<?$APPLICATION->IncludeComponent(
	"arneo:tree_comments",
	"list",
	Array(
		"OBJECT_ID" => $ElementID,
		"PREMODERATION" => "Y",
		"ALLOW_RATING" => "N",
		"AUTH_PATH" => "/personal/",
		"TO_USERPAGE" => "",
		"LEFT_MARGIN" => "30",
		"MAX_DEPTH_LEVEL" => "6",
		"ASNAME" => "name_lastname",
		"SHOW_USERPIC" => "N",
		"SHOW_DATE" => "Y",
		"SHOW_COMMENT_LINK" => "N",
		"DATE_FORMAT" => "H:i, j F Y",
        "GROUPS" => array("8"),
		"SHOW_COUNT" => "Y",
        "TO_USERPAGE" => "",
		"NO_FOLLOW" => "Y",
		"NO_INDEX" => "Y",
		"NON_AUTHORIZED_USER_CAN_COMMENT" => "N",
		"USE_CAPTCHA" => "NO",
		"SEND_TO_USER_AFTER_ANSWERING" => "Y",
		"SEND_TO_USER_AFTER_MENTION_NAME" => "Y",
		"SEND_TO_ADMIN_AFTER_ADDING" => "Y",
		"SEND_TO_USER_AFTER_ACTIVATE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
false
);?>
<?}
*/?>
<div class="clear"></div>
<div></div>