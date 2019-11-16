<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?$ElementID = $APPLICATION->IncludeComponent("cetera:news.detail", "video_org", Array(
	"DISPLAY_DATE" => "Y",	// Выводить дату элемента
	"DISPLAY_NAME" => "N",	// Выводить название элемента
	"DISPLAY_PICTURE" => "N",	// Выводить детальное изображение
	"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
	"USE_SHARE" => "N",	// Отображать панель соц. закладок
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"IBLOCK_TYPE" => "services_org",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "33",	// Код информационного блока
	"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],	// ID новости
	"ELEMENT_CODE" => "",	// Код новости
	"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
	"FIELD_CODE" => "",	// Поля
	"PROPERTY_CODE" => array(	// Свойства
		0 => "LINK",
		1 => "DATE_START",
		2 => "DATE_END",
		3 => "VIDEO",
	),
	"IBLOCK_URL" => "",	// URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
	"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
	"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
	"BROWSER_TITLE" => "NAME",	// Установить заголовок окна браузера из свойства
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "Y",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
	"PAGER_TITLE" => "Страница",	// Название категорий
	"PAGER_TEMPLATE" => "",	// Название шаблона
	"PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	),
	$component
);?>

<?
if (isset($ElementID)) {
?>
</div>
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
<?}?>
<div class="clear"></div>
