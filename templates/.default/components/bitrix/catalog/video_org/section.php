<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->SetAdditionalCSS("/bitrix/templates/.default/components/bitrix/photogallery/photo/style.css");
$APPLICATION->SetAdditionalCSS("/bitrix/templates/.default/components/bitrix/photogallery/photo/themes/gray/style.css");
?>
<?
if(CModule::IncludeModule("iblock"))
{ 
	$res = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
	if($ar_res = $res->GetNext())
	$header_section = $ar_res['NAME'];
	$APPLICATION->SetPageProperty('title', $header_section);
}
?>
<h1><?=$header_section?></h1>
<?
	global $USER;
	$arFilter = array("UF_CLOSE_GALLERY"=>"1", "ID"=>$USER->GetID());
	$arUser = CUser::GetList(($by="ID"), ($order="DESC"), $arFilter);
	
	$rsUser = $arUser->Fetch();
	
	$user=$USER->GetID();
		if ($rsUser["ID"]==$user) {$rsUser_1=true;} else {$rsUser_1=false;}
?>
	
	
<?$ar_result=CIBlockSection::GetList(Array("SORT"=>"DESC"), Array("IBLOCK_ID"=>"33", "ID"=>$arResult["VARIABLES"]["SECTION_ID"]),false, Array("UF_CLOSE_GALLERY"));
		$res=$ar_result->GetNext();
?>

<? if ($res["UF_CLOSE_GALLERY"] != "1" || ($res["UF_CLOSE_GALLERY"] == "1" and ($USER->IsAdmin() or ($rsUser_1==true))))  {?>
		
		<div class="video-items">
<?$APPLICATION->IncludeComponent("cetera:news.list", "video_org", Array(
	"DISPLAY_DATE" => "Y",	// Выводить дату элемента
	"DISPLAY_NAME" => "Y",	// Выводить название элемента
	"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
	"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"IBLOCK_TYPE" => "services_org",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "33",	// Код информационного блока
	"NEWS_COUNT" => "10",	// Количество новостей на странице
	"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
	"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
	"SORT_BY2" => "",	// Поле для второй сортировки новостей
	"SORT_ORDER2" => "",	// Направление для второй сортировки новостей
	"FILTER_NAME" => "",	// Фильтр
	"FIELD_CODE" => "",	// Поля
	"PROPERTY_CODE" => array(	// Свойства
		0 => "LINK",
		1 => "DATE_START",
		2 => "DATE_END",
		3 => "VIDEO",
	),
	"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
	"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
	"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
	"PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
	"PAGER_TITLE" => "Видео",	// Название категорий
	"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
	"PAGER_TEMPLATE" => "search",	// Название шаблона
	"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
	"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"INCLUDE_SUBSECTIONS"=>"N",
	),
	$component
);?>
</div>
		
		<?;} 
	elseif ($res["UF_CLOSE_GALLERY"] == "1")  
		{?>
		





If you see this message, it means you should login and amend your data in the Personal Cabinet

Yours sincerely,

www.PLUSworld.ru
		<p>Access to the videos available in this section is only provided to the authorized users who filled out the following fields of the online registration form correctly:</p>
		<ul>
			<li>Surname </li>
			<li>Name </li>
			<li>Corporate e-mail </li>
			<li>Company name  </li>
			<li>Position </li>
		</ul>
		<p>If you see this message, it means you should <a style="color: blue;" href="/auth/" alt="" title="" target="_blank" >login</a> and amend your data in the <a style="color: blue;" href="/personal/" alt="Personal Cabinet" title="Personal Cabinet" target="_blank" >Personal Cabinet</a></p>
		<p>Or <a style="color: blue;" href="/personal/register/" alt="Register" title="Register" target="_blank" >Register</a> online</p>
		<p>If you have provided the correct information, after the check performed by the portal moderator you will have access to the private video gallery!
 </p>
		<p>Yours sincerely,<br />
		Administration of PLUSworld.ru </p>
		<? ;}
		else
		{
		?>
	
<div class="video-items">
<?$APPLICATION->IncludeComponent("cetera:news.list", "video_org", Array(
	"DISPLAY_DATE" => "Y",	// Выводить дату элемента
	"DISPLAY_NAME" => "Y",	// Выводить название элемента
	"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
	"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"IBLOCK_TYPE" => "services_org",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "33",	// Код информационного блока
	"NEWS_COUNT" => "10",	// Количество новостей на странице
	"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
	"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
	"SORT_BY2" => "",	// Поле для второй сортировки новостей
	"SORT_ORDER2" => "",	// Направление для второй сортировки новостей
	"FILTER_NAME" => "",	// Фильтр
	"FIELD_CODE" => "",	// Поля
	"PROPERTY_CODE" => array(	// Свойства
		0 => "LINK",
		1 => "DATE_START",
		2 => "DATE_END",
		3 => "VIDEO",
	),
	"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
	"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
	"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
	"PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
	"PAGER_TITLE" => "Видео",	// Название категорий
	"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
	"PAGER_TEMPLATE" => "search",	// Название шаблона
	"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
	"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"INCLUDE_SUBSECTIONS"=>"N",
	),
	$component
);?>
</div>
<? }?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"video",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
        "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
	),
	$component
);?>
<br />
<?if($arParams["USE_FILTER"]=="Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.filter",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"FIELD_CODE" => $arParams["FILTER_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
		"PRICE_CODE" => $arParams["FILTER_PRICE_CODE"],
		"OFFERS_FIELD_CODE" => $arParams["FILTER_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["FILTER_OFFERS_PROPERTY_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	),
	$component
);
?>
<br />
<?endif?>
<?if($arParams["USE_COMPARE"]=="Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NAME" => $arParams["COMPARE_NAME"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
	),
	$component
);?>
<br />
<?endif?>