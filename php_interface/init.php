<?php

use Bitrix\Main\Loader;

\Bitrix\Main\Loader::includeModule('ceteralabs.uservars');

include "include/handlers.php";
include "include/config.php";
include "include/checkauth.php";
include "include/GoogleReCaptcha.php";

//Получить ID инфоблока по его коду
function GetIDByCode($code, $iblockType = null, $site_id = SITE_ID)
{
    if (! Loader::includeModule("iblock")) {
        $GLOBALS["APPLICATION"]->ThrowException('Модуль инфоблоков не установлен');
        return false;
    } else {
        if(empty($site_id) || ! strlen($code))
            return 0;

            $arFilter = array(
                "ACTIVE" => "Y",
                "SITE_ID" => $site_id,
                "CODE" => $code,
                "MIN_PERMISSION" => "R"
            );

            if (null != $iblockType)
                $arFilter["TYPE"] = $iblockType;
            $result = 0;
            $rs = \CIBlock::GetList(array(), $arFilter, false);
            if ($ar = $rs->Fetch())
                $result = $ar["ID"];

        return $result;
    }
}

//Получить рубрику
function getRubric($SectionID) {
    $rubricsPageURL = array(
        "1883" => "/news/innovation/",
        "1356" => "/news/novosti-kompaniy/",
        "1461" => "/news/novosti-kompaniy/",
        "1348" => "/news/novosti-kompaniy/",
        "1352" => "/news/e-commerce/",
        "1343" => "/news/e-commerce/",
        "1345" => "/news/e-commerce/",
        "1351" => "/news/torgovie-seti/",
        "1462" => "/news/technologii/",
        "1346" => "/news/technologii/",
        "1353" => "/news/technologii/",
        "1715" => "/news/technologii/",
        "1354" => "/news/payments-cash/",
        "1342" => "/news/payments-cash/",
        "1347" => "/news/payments-cash/",
        "1358" => "/news/loyalty/",
        "1344" => "/news/loyalty/",
        "1350" => "/news/logistika/",
        "1775" => "/news/horeca/",
        "1463" => "/news/horeca/",
        "1701" => "/news/fmcg-i-stm/",
        "1349" => "/news/issledovaniya/"
    );

    $rubricsPageName = array(
        "/news/innovation/" => "Инновации",
        "/news/novosti-kompaniy/" => "Новости ритейла",
        "/news/e-commerce/" => "E-Commerce",
        "/news/torgovie-seti/" => "Торговые сети",
        "/news/technologii/" => "Технологии",
        "/news/payments-cash/" => "Платежи и кассы",
        "/news/loyalty/" => "Лояльность",
        "/news/logistika/" => "Логистика",
        "/news/horeca/" => "HORECA",
        "/news/fmcg-i-stm/" => "FMCG",
        "/news/issledovaniya/" => "Исследования"
    );

    $arName = $rubricsPageURL[$SectionID];
    $arTitle = $rubricsPageName[$arName];
    $arRes["URL"] = $arName;
    $arRes["TITLE"] = $arTitle;

    return $arRes;
}

if (!function_exists('isManagerPlas')) {
    function isManagerPlas()
    {
        global $USER;
        $flag = false;
        if (intval($USER->GetID()) > 0) {
            $GroupIdGeneralManager = array(1, 6, 11, 12);
            $arCUserGroup = CUser::GetUserGroup($USER->GetID());
            $arCUserGroupGM = array_intersect($arCUserGroup, $GroupIdGeneralManager);
            if (count($arCUserGroupGM) >= 0) {
                $flag = true;
            }
        }
        return $flag;
    };
}

/**
 * 1.	Новости рынка
Новости ритейла
Выставки и конференции
Исследования и обзоры
Топливный и транспортный ритейл
Туризм и travel
Компания в фокусе
 */
$GLOBALS["filterIndexNewsMarket"] =  array(
    "SECTION_ID" => array(1461,1357,1349,1463,1796,1859)
);
/**
 * 2.	Регуляторы
Новости регуляторов рынка
ЕГАИС в рознице

 */
$GLOBALS["filterIndexRegulators"] =  array(
    "SECTION_ID" => array(1348,1715)
);
/**
 * 3.	Торговый ритейл
Новости регуляторов рынка
ЕГАИС в рознице

 */
$GLOBALS["filterIndexTradingRetail"] =  array(
    "SECTION_ID" => array(1351,1356)
);
/**
 * 4.	E-Commerce
Онлайн-коммерция
Социальные сети
Мобильная коммерция
 */
$GLOBALS["filterIndexECommerce"] =  array(
    "SECTION_ID" => array(1343,1355,1352)
);
/**
 * 5.	HoReCa
HoReCa
 */
$GLOBALS["filterIndexHoReCa"] =  array(
    "SECTION_ID" => array(1775)
);
/**
 * 6.	FMCG
FMCG и СТМ
 */
$GLOBALS["filterIndexFMCGСТМ"] =  array(
    "SECTION_ID" => array(1701)
);
/**
 * 7.	Сети и поставщики

 */
$GLOBALS["filterIndexNetworksSuppliers"] =  array(
    "SECTION_ID" => array(1874)
);
/**
 * 9.	Лояльность
Программы лояльности
Ко-брендинг
 */
$GLOBALS["filterIndexLoyalty"] =  array(
    "SECTION_ID" => array(1344,1358)
);
/**
 * 10.	Платежи
POS-оборудование и кассовые решения
Платежные технологии
Эквайринг
Бесконтактные технологии
 */
$GLOBALS["filterIndexPayments"] =  array(
    "SECTION_ID" => array(1347,1342,1345,1353)
);
/**
 * 11.	Технологии
Безопасность
IT в ритейле
Self-Checkout
 */
$GLOBALS["filterIndexTechnologies"] =  array(
    "SECTION_ID" => array(1462,1346,1354)
);
/**
 * 12.	Логистика
Логистика
 */
$GLOBALS["filterIndexLogistics"] =  array(
    "SECTION_ID" => array(1350)
);

//Получить Json Строку для Заказа для оплаты банком RFI
function getJsonStringForOrder($order_id) {
    /*Создаем массив для JSON*/
    $jsonInvoiceData = array();

    //Получаем товары в корзине
    $arBasketItems = array();

    $dbBasketItems = \CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "LID" => SITE_ID,
            "ORDER_ID" => $order_id
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE",
            "PRODUCT_ID", "QUANTITY", "DELAY",
            "CAN_BUY", "PRICE", "WEIGHT")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        if (strlen($arItems["CALLBACK_FUNC"]) > 0)
        {
            \CSaleBasket::UpdatePrice($arItems["ID"],
                $arItems["CALLBACK_FUNC"],
                $arItems["MODULE"],
                $arItems["PRODUCT_ID"],
                $arItems["QUANTITY"]);
            $arItems = \CSaleBasket::GetByID($arItems["ID"]);
        }

        $arBasketItems[] = $arItems;
    }

    //Получаем нужные данные товара по ID
    $orderPrice = 0;
    $arOrder = \CSaleOrder::GetByID($order_id);
    if ($arOrder["PRICE_DELIVERY"]) {
        $orderPrice = (int)$arOrder["PRICE_DELIVERY"];
    }
    $n=0;
    foreach ($arBasketItems as $arItem) {
        if ($arItem["DELAY"] != "Y") {

            $jsonInvoiceData[$n]["code"] = (string)$arItem["PRODUCT_ID"];

            $arSelect = Array(
                'ID',
                'NAME',
                'IBLOCK_ID',
                'PROPERTY_*',
            );

            $arFilter = array('ACTIVE' => 'Y', 'IBLOCK_ID' => 63, $arItem["PRODUCT_ID"]);

            if (\Bitrix\Main\Loader::includeModule('iblock')) {
                $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while ($rs = $res->getNext()) {
                    $jsonInvoiceData[$n]["name"] = $rs["NAME"];
                    $jsonInvoiceData[$n]["unit"] = "piece";
                    $jsonInvoiceData[$n]["quantity"] = intval( $arBasketItems[$n]["QUANTITY"] );
                    $jsonInvoiceData[$n]["price"] = $arBasketItems[$n]["PRICE"];
                    $jsonInvoiceData[$n]["sum"] = $arBasketItems[$n]["QUANTITY"] * $arBasketItems[$n]["PRICE"];
                    $jsonInvoiceData[$n]["vat_mode"] = "none";
                }
            }
        }
        $n++;
    }
    $jsonInvoiceData[count($jsonInvoiceData) - 1]["sum"] += $orderPrice ;

    // Печатаем массив, содержащий актуальную на текущий момент корзину
    class jsonRFI_items {
        var $code,
            $name,
            $price,
            $unit,
            $quantity,
            $sum,
            $vat_mode;

        public function __construct($invoiceDataItem)
        {
            $this->code = (string)$invoiceDataItem["code"]." ";
            $this->name = $invoiceDataItem["name"];
            $this->price = (float)$invoiceDataItem["price"];
            $this->unit = $invoiceDataItem["unit"];
            $this->quantity = intval($invoiceDataItem["quantity"]);
            $this->sum = (float)$invoiceDataItem["sum"];
            $this->vat_mode = $invoiceDataItem["vat_mode"];
        }
    }

    class jsonRFI
    {
        var $items;

        public function __construct($jsonArray = array())
        {
            for ($i=0; $i<count($jsonArray); $i++ ) {
                $this->items[] = new jsonRFI_items($jsonArray[$i]);
            }
        }
    }

    $jsonObj = new jsonRFI($jsonInvoiceData);

    return htmlentities(json_encode($jsonObj, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION));
}

function getElementShowCounterByCode($codeElement, $codeIblock) {
    $count = 0;
    $arFilter = Array(
        "CODE" => $codeElement,
        "ACTIVE"=>"Y"
    );
    $arSelect = Array(
        "IBLOCK_ID",
        "ID",
        "DETAIL_PAGE_URL",
        "SHOW_COUNTER",
    );
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, false, $arSelect);
    while($ar_fields = $res->GetNext()) {
        $strPos = strpos($ar_fields["DETAIL_PAGE_URL"], '/' . $codeIblock . '/');
        if ($strPos !== false) {
            $count = $ar_fields["SHOW_COUNTER"];
        }
    }
    return $count;
}
function getElementShowCounterByID($idElement) {
    $count = 0;
    $arFilter = Array(
        "ID" => intval($idElement),
        "ACTIVE"=>"Y"
    );
    $arSelect = Array(
        "IBLOCK_ID",
        "ID",
        "DETAIL_PAGE_URL",
        "SHOW_COUNTER",
    );
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, false, $arSelect);
    while($ar_fields = $res->GetNext()) {
        $count = $ar_fields["SHOW_COUNTER"];
    }
    return $count;
}
function showCounterRedirect($urlRedirect) {
    $count = 0;
    CModule::IncludeModule("iblock");
    $strPos = strpos($urlRedirect, 'http');
    $arUrl = explode("/", $urlRedirect);
    $codeElement = $arUrl[count($arUrl)-2];
    $codeIblock = $arUrl[count($arUrl)-3];
    $strPosArt = strpos($codeElement, 'art');
    if ($strPos === false) {
        if ($strPosArt === false) {
            $count = getElementShowCounterByCode($codeElement, $codeIblock);
        } else {
            $idElement = str_replace("art","",$codeElement);
            $count = getElementShowCounterByID($idElement);
        }
    } else {
        $strPos = strpos($urlRedirect, 'retail-loyalty.org');
        if ($strPos !== false) {
            if ($strPosArt === false) {
                $count = getElementShowCounterByCode($codeElement, $codeIblock);
            } else {
                $idElement = str_replace("art","",$codeElement);
                $count = getElementShowCounterByID($idElement);
            }
        }
    }
    return $count;
}

function showCounterLong($arId) {
    \CModule::IncludeModule("iblock");
    foreach ($arId as $id) {
        CIBlockElement::CounterInc($id);
    }

    $SHOW_COUNTER = 0;
    $arSelect = Array("ID", "IBLOCK_ID", "SHOW_COUNTER");
    $arFilter = Array("ID"=>$arId[0], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    while($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $SHOW_COUNTER = $arFields["SHOW_COUNTER"];
    }
    ?><div style="background:#736d6d;display:inline-block;padding: 2px 5px;color:#fff;"><?=$SHOW_COUNTER?></div><?
}

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"].'/log_init.txt');

function replaceRL($content) {
    $content = str_replace(array('R&amp;L','R &amp; L','r &amp; l','R&L','R & L','r&l','r & l'), "Retail & Loyalty", str_replace("\n","",$content));
    return $content;
}


AddEventHandler("main", "OnBeforeEventAdd", array("SubscribeFastConfirm", "OnBeforeEventAddHandler"));
class SubscribeFastConfirm
{
    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
        if (($event == "SUBSCRIBE_CONFIRM") and ($lid == "si")){
            $lid = "ip";
            $arFields["SUBSCR_SECTION"] = "/personal/fastsubscribe/";
        }
        if (($event == "SUBSCRIBE_CONFIRM") and ($lid == "ip")){
            function generatePassword($length = 8){
                $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
                $numChars = strlen($chars);
                $string = '';
                for ($i = 0; $i < $length; $i++) {
                    $string .= substr($chars, rand(1, $numChars) - 1, 1);
                }
                return $string;
            }

            $ID = false;
            $email = $arFields["EMAIL"];

            $rsUsers = CUser::GetList($by="", $order="", array('=EMAIL' => $email));
            while($arr = $rsUsers->GetNext()) :
                $ID = $arr["ID"];
            endwhile;

            if (!$ID) {
                $password = generatePassword();
                $arFiel = Array(
                    "ACTIVE" => "Y",
                    "GROUP_ID" => 9,
                    "NAME" => $email,
                    "EMAIL" => $email,
                    "LOGIN" => $email,
                    "PASSWORD" => $password,
                    "CONFIRM_PASSWORD" => $password,
                );

                $user = new \CUser;
                $userID = $user->Add($arFiel);
            }

            if ($userID) {
                $arFields["USER_REGISTRED_LOGIN"] = $email;
                $arFields["USER_REGISTRED_PASSWORD"] = $password;
            }

        }
        if ($event == "FORM_FILLING_podpiska_rassilka"){
            $lid = "ip";
            $arFields["EMAIL"] = $_POST["form_email_4060"];
            $app = new \CMAIN;
            $arFields["CURPAGE"] = $app->GetCurPage();
        }
    }
}



function deleteStatEmail() {
    /* удаляем старые данные о статистике прочтения писем */
    global $DB;
    $date = date("Y-m-d H:i:s",strtotime('-3 month'));
    $strSql = "DELETE FROM b_stat_emails WHERE (DATE_ENTER < '$date') ";
    $res = $DB->Query($strSql);
    return "deleteStatEmail();";
}


function setStatusArticlesJournalRL()
{
    $IBLOCK_ID = 41;

    CModule::IncludeModule("iblock");
    $arIdArticles = array();

    $arFilter = Array(
        "IBLOCK_ID" => $IBLOCK_ID,
        "ACTIVE"=>"Y",
        "<=DATE_CREATE" => date ("d.m.Y H:i:s", strtotime("-2 year")),
        "!PROPERTY_RL_FULL_ACCESS_VALUE" => false
    );
    $arSelect = array("ID", "IBLOCK_ID", "ACTIVE", "DATE_CREATE", "PROPERTY_RL_FULL_ACCESS");
    $res = CIBlockElement::GetList(Array("PROPERTY_RL_FULL_ACCESS"=>"ASC"), $arFilter, false, false,$arSelect);
    while($ar_fields = $res->GetNext()) {
        array_push($arIdArticles,$ar_fields["ID"]);
    }

    foreach ($arIdArticles as $id) {
        CIBlockElement::SetPropertyValues($id, $IBLOCK_ID, null, "RL_FULL_ACCESS");
    }

    return "setStatusArticlesJournalRL();";
}

function setStatusArticlesJournalPlus()
{
    $IBLOCK_ID = 39;

    CModule::IncludeModule("iblock");
    $arIdArticles = array();

    $arFilter = Array(
        "IBLOCK_ID" => $IBLOCK_ID,
        "ACTIVE"=>"Y",
        "<=DATE_CREATE" => date ("d.m.Y H:i:s", strtotime("-2 year")),
        "!PROPERTY_FULL_ACCESS_VALUE" => false
    );
    $arSelect = array("ID", "IBLOCK_ID", "ACTIVE", "DATE_CREATE", "PROPERTY_FULL_ACCESS");
    $res = CIBlockElement::GetList(Array("PROPERTY_FULL_ACCESS"=>"ASC"), $arFilter, false, false,$arSelect);
    while($ar_fields = $res->GetNext()) {
        array_push($arIdArticles,$ar_fields["ID"]);
    }

    foreach ($arIdArticles as $id) {
        CIBlockElement::SetPropertyValues($id, $IBLOCK_ID, null, "FULL_ACCESS");
    }

    return "setStatusArticlesJournalPlus();";
}

function getCountCommentsCetera($ID) {
    /* Количество Комментариев */
    global $DB;
    $ID = intval($ID);
    $strSql = "SELECT ID,OBJECT_ID,ACTIVATED FROM arneo_treecomments WHERE ( (OBJECT_ID='$ID') AND (ACTIVATED = '1') )";
    $res = $DB->Query($strSql);
    $i = 0;
    while ($row = $res->Fetch())
    {
        $i++;
    }
    return $i;
}

/** http://pm.cetera.ru/browse/PAS-6763
 * Если подписчик не активировал ссылку в течении 2х суток выслать письмо повторно.
 * Если подписчик не активировал ссылку в течении 1 недели выслать письмо повторно.
 * Если подписчик не активировал ссылку в течении 2 недель выслать письмо повторно.
 * Если подписчик не активировал ссылку в течении 1 месяца выслать письмо повторно.
 * Если активация так и не прошла прислать инфо на plusworld
 */
function CeteraEmailSubscribe() {
    CModule::IncludeModule("subscribe");

    $subscr = CSubscription::GetList(
        array("ID"=>"ASC"),
        array("EMAIL" =>'slava_mokin@mail.ru',"CONFIRMED"=>"Y", "ACTIVE"=>"N")
    );
    while($subscr_arr = $subscr->Fetch()) {
        $SubId = $subscr_arr["ID"];
        $SubEmail = $subscr_arr["EMAIL"];
        $SubDateUpdate = strtotime($subscr_arr["DATE_UPDATE"]);
        if (strlen($SubDateUpdate)<2) {
            $SubDateUpdate = strtotime($subscr_arr["DATE_INSERT"]);
        }
        //$currentDate = time();
        $date2Day = strtotime("-2 day");
        $date7Day = strtotime("-7 day");
        $date14Day = strtotime("-14 day");
        $date30Day = strtotime("-30 day");
        $date31Day = strtotime("-31 day");

        $raz31 = $date31Day-$SubDateUpdate;
        $raz30 = $date30Day-$SubDateUpdate;
        $raz14 = $date14Day-$SubDateUpdate;
        $raz7 = $date7Day-$SubDateUpdate;
        $raz2 = $date2Day-$SubDateUpdate;

        $arEventFields = array(
            "CETERA_USER_EMAIL" => $SubEmail
        );

        echo "<pre>"; print_r($SubEmail); echo "</pre>";
        echo "<pre>"; print_r(date("d.m.Y H:i:s", $SubDateUpdate)); echo "</pre>";
        if (($raz31<0)AND($raz30>=0)) {
            echo "<pre>"; echo '30'; echo "</pre>";
           // CEvent::Send("CETERA_SUBSCRIBER_DAYS", "s1", $arEventFields);
        }
        elseif (($raz30<0)AND($raz14>=0)) {
            echo "<pre>"; echo '14'; echo "</pre>";
        }
        elseif (($raz14<0)AND($raz7>=0)) {
            echo "<pre>"; echo '7'; echo "</pre>";
        }
        elseif (($raz7<0)AND($raz2>=0)) {
            echo "<pre>"; echo '2'; echo "</pre>";
        }
        else
        {
           // CEvent::Send("CETERA_SUBSCRIBER_DAYS", "s1", $arEventFields);
            echo "<pre>"; echo 'Письмо администратору'; echo "</pre>";
        }
    }
}


// include "/bitrix/php_interface/valute.php";


function statSpeech($string) {
    /* Количество слов в материалах */

global $DB;
$strSql = "SELECT * FROM stat_speech WHERE (speech='$string')";

    $res = $DB->Query($strSql);

    $i = 0;
    while ($row = $res->Fetch())
    {
        $i++;
        $idSpeech = $row["ID"];
    }

    if ($i == 0) {
        // добавляем слово
        $strSqlNew = "INSERT INTO stat_speech (speech, count_speech) VALUES ('$string', 1)";
        $resNew = $DB->Query($strSqlNew, false);
    }
    else
    {
        $strSqlNew = "UPDATE stat_speech SET count_speech = count_speech+1 WHERE (ID ='$idSpeech')";
        $resNew = $DB->Query($strSqlNew, false);
    }

}


function user_order_list($id_user, $id_video) {
  global $DB;

  $strSql1 = "SELECT ID, DATE_PAYED FROM b_sale_order WHERE ((USER_ID='$id_user') AND (PAYED='Y'))"; /* AND (STATUS_ID!='N') */
		$res = $DB->Query($strSql1);
			$name_array_1=array();
	while ($row = $res->Fetch())
	{
		array_push($name_array_1, $row);
	}

		$name_array_2=array();

		/* ПОЛУЧАЕМ Id элемента по его коду (=Id видео) */
		$strSql_1 = "SELECT ID FROM b_iblock_element WHERE (CODE='$id_video') LIMIT 1";
		$res_1 = $DB->Query($strSql_1);
		$name_array_3=array();
			while ($row = $res_1->Fetch())
				{
					array_push($name_array_3, $row);
				}
				$id_el_vid = $name_array_3[0]["ID"];//id элемента

	foreach($name_array_1 as $arIBlock) {
		$arIBlock_id = $arIBlock["ID"];
		$arIBlock_date_payed = $arIBlock["DATE_PAYED"];
		$strSql1 = "SELECT * FROM b_sale_basket WHERE ((ORDER_ID='$arIBlock_id') AND (PRODUCT_ID='$id_el_vid'))";
		$res = $DB->Query($strSql1);
			$date = date("Y-m-d H:i:s");

		while ($row = $res->Fetch())
		{
		 //echo "<pre>"; print_r($row); echo "</pre>";
			$quantity = $row["QUANTITY"] + 0;
				$time_1 = strtotime("-".$quantity." hours");
				$date_1 = date("Y-m-d H:G:i", $time_1);

			if ($arIBlock_date_payed>=$date_1) {
				$row["DATE_PAYED"] = $arIBlock_date_payed;
				array_push($name_array_2, $row);
				}
		}
	}
	 echo "<pre>"; print_r($name_array_2); echo "</pre>";
	if (count($name_array_2)>0) {return true;} else {return false;}
}

function market_video($id_user, $name_video, $code_video, $url_video_site) {
  global $DB;
  $strSql1 = "SELECT ID FROM b_iblock_element WHERE (CODE='$code_video')";
		$res = $DB->Query($strSql1);
			$name_array_1=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array_1, $row);
	}

 // echo "<pre>"; print_r($code_video); echo "</pre>";
 // echo "<pre>"; print_r($name_array_1); echo "</pre>";
  if (count($name_array_1)==0) {
  $strSql1 = "SELECT ID FROM b_iblock_element ORDER BY ID DESC LIMIT 1";
		$res = $DB->Query($strSql1);
			$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$id_video = $name_array[0]['ID'] + 1;

	$date = date("Y-m-d H:i:s");

// добавляем цену
$strSql = "
		INSERT INTO b_catalog_price (PRODUCT_ID, CATALOG_GROUP_ID, PRICE, CURRENCY, TIMESTAMP_X)
		VALUES ('$id_video', '1', '10.00', 'RUB', '$date')
		";
		$res = $DB->Query($strSql, false);

// создаем элемент-товар (видео)
$strSql = "
		INSERT INTO b_iblock_element (ID, TIMESTAMP_X, MODIFIED_BY, DATE_CREATE, CREATED_BY, IBLOCK_ID, IBLOCK_SECTION_ID, NAME, CODE, IN_SECTIONS, WF_STATUS_ID, XML_ID)
		VALUES ('$id_video', '$date', '$id_user', '$date', '$id_user', '63', '1519', '$name_video', '$code_video', 'Y', '1', '$id_video')
		";
		$res = $DB->Query($strSql, false);

// создаем элемент-товар (видео)
$strSql = "
		INSERT INTO b_catalog_product (ID, QUANTITY, QUANTITY_TRACE, WEIGHT, TIMESTAMP_X, PRICE_TYPE, RECUR_SCHEME_LENGTH, RECUR_SCHEME_TYPE, WITHOUT_ORDER, SELECT_BEST_PRICE, VAT_ID, VAT_INCLUDED, CAN_BUY_ZERO, NEGATIVE_AMOUNT_TRACE, BARCODE_MULTI, QUANTITY_RESERVED, SUBSCRIBE, TYPE)
		VALUES ('$id_video', '0', 'D', '0', '$date', 'S', '0', 'D', 'N', 'Y', '0', 'N', 'D', 'D', 'N', '0', 'D', '1')
		";
		$res = $DB->Query($strSql, false);


// добавляем в раздел элемент
$strSql = "
		INSERT INTO b_iblock_section_element (IBLOCK_SECTION_ID, IBLOCK_ELEMENT_ID)
		VALUES ('1519', '$id_video')
		";
		$res = $DB->Query($strSql, false);
	}
	else
	{
		$id_video = $name_array_1[0]['ID'];
	}

CModule::IncludeModule("sale");
if (CModule::IncludeModule("sale"))
{
  $arFields = array(
    "PRODUCT_ID" => $id_video,
    "PRODUCT_PRICE_ID" => 0,
    "PRICE" => 10.00,
    "CURRENCY" => "RUB",
    "WEIGHT" => 0,
    "QUANTITY" => 1,
    "LID" => 'vp',
    "DELAY" => "N",
    "CAN_BUY" => "Y",
    "NAME" => "$name_video",
    "CALLBACK_FUNC" => "",
    "MODULE" => "catalog",
    "NOTES" => "",
    "ORDER_CALLBACK_FUNC" => "",
    "DETAIL_PAGE_URL" => $url_video_site,
  );

  $arProps = array();

  $arProps[] = array();

  $arFields["PROPS"] = $arProps;

  CSaleBasket::Add($arFields);
  LocalRedirect("http://market.plusworld.ru/personal/cart_video/");
}
}


/*
function user_online_counter_1($SITE_ID) {
//Количество пользователей просматривающих страницу
	$date = date("Y-m-d H:i:s");
	$time_1 = strtotime("-20 minute");
	$date_1 = date("Y-m-d H:G:i", $time_1);

  global $DB;
  $strSql1 = "SELECT URL, SESSION_ID FROM b_stat_hit WHERE ((SITE_ID='$SITE_ID') AND (URL LIKE '%daily%') AND (DATE_HIT>='$date_1') AND (DATE_HIT<='$date'))";
		$res = $DB->Query($strSql1);
			$name_array_1=array();
	while ($row = $res->Fetch())
	{
		array_push($name_array_1, $row);
	}

	//echo "<pre>"; print_r($name_array_1); echo "</pre>";
	return $name_array_1;
}
*/
function user_online_counter($SITE_ID, $url) {
/* Количество пользователей просматривающих страницу */
	$date = date("Y-m-d H:i:s");
	$time_1 = strtotime("-20 minute");
	$date_1 = date("Y-m-d H:G:i", $time_1);

  global $DB;
  $strSql1 = "SELECT ID, SESSION_ID FROM b_stat_hit WHERE ((SITE_ID='$SITE_ID') AND (URL LIKE '%$url%') AND ((DATE_HIT>='$date_1') AND (DATE_HIT<='$date')))";
		$res = $DB->Query($strSql1);
			$name_array_1=array();
			$SESSION_ID=array();
	while ($row = $res->Fetch())
	{
		if (!in_array($row["SESSION_ID"],$SESSION_ID)) {
			array_push($name_array_1, $row);
			array_push($SESSION_ID, $row["SESSION_ID"]);
		}
	}

	//echo "<pre>"; print_r($name_array_1); echo "</pre>";
	return count ($name_array_1);
}

function SaveFileOldSubscriptionUpdateHandler($arFields) {

    global $DB;
    $RUB_ID = array();
    $ID_SUBSCRIBER = $arFields["ID"];
    $strSql = "SELECT LIST_RUBRIC_ID FROM b_subscription_rubric WHERE (SUBSCRIPTION_ID='$ID_SUBSCRIBER')";
    $res = $DB->Query($strSql);
    while ($row = $res->Fetch())
    {
        array_push($RUB_ID, $row["LIST_RUBRIC_ID"]);
    }

    sort($RUB_ID);
    $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/include/subscribe_list/subscribe_".$arFields["ID"].".json", "w+"); // Открываем файл в режиме записи
    fwrite($fp, json_encode($RUB_ID)); // Запись в файл
    fclose($fp);
    return $arFields;
}

function SaveFileNewSubscriptionUpdateHandler($arFields) {
    global $DB;
    $arFieldsOldRUB_ID = array();
    $ID_SUBSCRIBER = $arFields["ID"];
    $strSql = "SELECT LIST_RUBRIC_ID FROM b_subscription_rubric WHERE (SUBSCRIPTION_ID='$ID_SUBSCRIBER')";
    $res = $DB->Query($strSql);
    while ($row = $res->Fetch())
    {
        array_push($arFieldsOldRUB_ID, $row["LIST_RUBRIC_ID"]);
    }

    sort($arFieldsOldRUB_ID);

    $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/include/subscribe_list/subscribe_OLD_".$arFields["ID"].".json", "w+"); // Открываем файл в режиме записи
    fwrite($fp, json_encode($arFieldsOldRUB_ID)); // Запись в файл
    fclose($fp);

        $arFieldsNewRUB_ID = $arFields["RUB_ID"];
        sort($arFieldsNewRUB_ID);

    $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/include/subscribe_list/subscribe_NEW_".$arFields["ID"].".json", "w+"); // Открываем файл в режиме записи
    fwrite($fp, json_encode($arFieldsNewRUB_ID)); // Запись в файл
    fclose($fp);

        $arRUB_IDDel = array();
        $arRUB_IDAdd = array();


    $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/include/subscribe_list/subscribe_SITE_".$arFields["ID"].".json", "w+"); // Открываем файл в режиме записи
    fwrite($fp, json_encode(SITE_ID)); // Запись в файл
    fclose($fp);

    global $APPLICATION;
    $page = $APPLICATION->GetCurPage();
    if ((SITE_ID=='s1')and($page == '/personal/subscribe/')) {
        $idRubricAdd = array(1,3,17,55);
    }
    elseif ((SITE_ID=='ip')and($page == '/personal/subscribe/')) {
        $idRubricAdd = array(6,18,73);
    }
    elseif ((SITE_ID=='ip')and($page == '/en/personal/subscribe/')) {
        $idRubricAdd = array(53);
    }
    elseif ((SITE_ID=='en')and($page == '/personal/subscribe/')) {
        $idRubricAdd = array(11,13,14);
    }
    else {
        $idRubricAdd = array(1,3,17,55, 6,18,73, 11,13,14);
    }

        if ($arFieldsOldRUB_ID != $arFieldsNewRUB_ID) {

            foreach ($arFieldsOldRUB_ID as $R_ID) {
                if (!in_array($R_ID, $arFieldsNewRUB_ID)) {
                    array_push($arRUB_IDDel,$R_ID);
                }
            }
            foreach ($arFieldsNewRUB_ID as $R_ID) {
                if (!in_array($R_ID, $arFieldsOldRUB_ID)) {
                    array_push($arRUB_IDAdd,$R_ID);
                }
            }

            $date = date("d.m.Y H:i:s");
            if (count($arRUB_IDAdd)>0) {
                CModule::IncludeModule('iblock');
                CModule::IncludeModule("subscribe");
                global $USER;
                foreach ($arRUB_IDAdd as $id) {
                    $Name = $arFields["ID"].'_'.date("d.m.Y_H:i:s");
                    $Name = $Name.'_'.$id;
                    $DELIVERY_ID = 0;
                    $db_enum_list = CIBlockProperty::GetPropertyEnum("DELIVERY", Array(), Array("IBLOCK_ID"=>96,"XML_ID" => $id));
                    if($ar_enum_list = $db_enum_list->GetNext())
                    {
                        $DELIVERY_ID = $ar_enum_list["ID"];
                    }

                    if (($id>0)and(in_array($id,$idRubricAdd)))
                    {
                        if (!$arFields["USER_ID"]) {
                            $USER_ID = "Анонимный подписчик";
                            $USER_FIO = "";
                            $USER_ORG = "";
                        }
                        else
                        {
                            $rsUser = CUser::GetByID($arFields["USER_ID"]);
                            $arUser = $rsUser->Fetch();

                            $USER_ID = $arFields["USER_ID"];
                            $USER_FIO = $arUser["NAME"].' '.$arUser["LAST_NAME"];
                            $USER_ORG = $arUser["WORK_COMPANY"];
                        }

                        $el = new CIBlockElement;

                        $PROP = array();
                        $PROP[539] = 238;          // Действие - Подписался
                        $PROP[540] = "";                    // Причина отписки
                        $PROP[541] = $USER_ID;              // Подписчик
                        $PROP[542] = $arFields["EMAIL"];    // Email подписки
                        $PROP[543] = $USER_FIO;             // ФИО
                        $PROP[544] = $USER_ORG;             // Организация
                        $PROP[545] = $DELIVERY_ID;           // Рассылка
                        $PROP[574] = $date;                 // Дата

                        $arLoadProductArray = Array(
                            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                            "IBLOCK_ID"      => 96,
                            "PROPERTY_VALUES"=> $PROP,
                            "NAME"           => $Name,
                            "ACTIVE"         => "Y"
                        );

                        $el->Add($arLoadProductArray);
                    }
                }
            }

            if (count($arRUB_IDDel)>0) {
                CModule::IncludeModule('iblock');
                CModule::IncludeModule("subscribe");
                global $USER;
                foreach ($arRUB_IDDel as $id) {
                    $Name = $arFields["ID"].'_'.date("d.m.Y_H:i:s");
                    $Name = $Name.'_'.$id;
                    $DELIVERY_ID = 0;
                    $db_enum_list = CIBlockProperty::GetPropertyEnum("DELIVERY", Array(), Array("IBLOCK_ID"=>96,"XML_ID" => $id));
                    if($ar_enum_list = $db_enum_list->GetNext())
                    {
                        $DELIVERY_ID = $ar_enum_list["ID"];
                    }
                    if (($id>0)and(in_array($id,$idRubricAdd)))
                    {
                        if (!$arFields["USER_ID"]) {
                            $USER_ID = "Анонимный подписчик";
                            $USER_FIO = "";
                            $USER_ORG = "";
                        }
                        else
                        {
                            $rsUser = CUser::GetByID($arFields["USER_ID"]);
                            $arUser = $rsUser->Fetch();

                            $USER_ID = $arFields["USER_ID"];
                            $USER_FIO = $arUser["NAME"].' '.$arUser["LAST_NAME"];
                            $USER_ORG = $arUser["WORK_COMPANY"];
                        }

                        $el = new CIBlockElement;

                        $PROP = array();
                        $PROP[539] = 239;          // Действие - Отписался
                        $PROP[540] = "";                    // Причина отписки
                        $PROP[541] = $USER_ID;              // Подписчик
                        $PROP[542] = $arFields["EMAIL"];    // Email подписки
                        $PROP[543] = $USER_FIO;             // ФИО
                        $PROP[544] = $USER_ORG;             // Организация
                        $PROP[545] = $DELIVERY_ID;           // Рассылка
                        $PROP[574] = $date;                 // Дата
                        if (isset($arFields["REASON_UNSUBSCRIBING"])) {
                            $PROP[540] = $arFields["REASON_UNSUBSCRIBING"];                 // Причина отписки
                        }

                        $arLoadProductArray = Array(
                            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                            "IBLOCK_ID"      => 96,
                            "PROPERTY_VALUES"=> $PROP,
                            "NAME"           => $Name,
                            "ACTIVE"         => "Y"
                        );

                        $el->Add($arLoadProductArray);
                    }
                }
            }
        }
    //}
    return $arFields;
}

// Перед изменением подписки
/*AddEventHandler("subscribe", "OnBeforeSubscriptionUpdate", "OnBeforeSubscriptionUpdateHandler");
function OnBeforeSubscriptionUpdateHandler($arFields)
{
    $arFields = SaveFileOldSubscriptionUpdateHandler($arFields);
    return $arFields;
}*/
// После изменения подписки
/*AddEventHandler("subscribe", "OnStartSubscriptionUpdate", "OnStartSubscriptionUpdateHandler");
function OnStartSubscriptionUpdateHandler($arFields)
{
    SaveFileNewSubscriptionUpdateHandler($arFields);
    return $arFields;
}*/

// быстрая отписка от рассылок
function delete_subscrib_id ($ID_SUBSCRIBER, $ID_SUBSCRIBE, $name_sub, $sf_EMAIL, $flag, $rsUser, $ArrPost) {
  global $DB;
  $strSql = "SELECT * FROM b_subscription_rubric WHERE ((SUBSCRIPTION_ID='$ID_SUBSCRIBER')  AND (LIST_RUBRIC_ID='$ID_SUBSCRIBE'))";
		$res = $DB->Query($strSql);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count2 = (count($name_array));

	if ($count2>0) {
	$strSql2 = "DELETE FROM b_subscription_rubric WHERE ((SUBSCRIPTION_ID='$ID_SUBSCRIBER')  AND (LIST_RUBRIC_ID='$ID_SUBSCRIBE'))";
		$res = $DB->Query($strSql2);
			$name_array=array();
		while ($row = $res->Fetch())
		{
			array_push($name_array, $row);
		}
		//$to     ='v.mokin@ceteralabs.com';
		$to      = 'marketing@plus-alliance.com, podpiska@plus-alliance.com';
		$subject = 'Отписка от рассылки';
		$message = 'Подписчик ID = '.$ID_SUBSCRIBER.'
		e-mail - '.$sf_EMAIL;
		if ($flag) {
	//	echo "<pre>"; print_r($rsUser); echo "</pre>";

		$message = $message.'
		ФИО - '.$rsUser['NAME'].' '.$rsUser['LAST_NAME'].'
		организация - '.$rsUser['WORK_COMPANY'];
		}
		$message = $message.'
		отказался от подписки на рассылку "'.$name_sub.'" ';
		$message = $message.'
		Причины:
		';
        $reason = '';
		if ($ArrPost["reason_1"]) {
            $reason = $reason.'
            '.$ArrPost["reason_1"];
		$message = $message.$ArrPost["reason_1"].'

		';
		}
		if ($ArrPost["reason_2"]) {
            $reason = $reason.'
            '.$ArrPost["reason_2"];
		$message = $message.$ArrPost["reason_2"].'

		';
		}
		if ($ArrPost["reason_3"]) {
            $reason = $reason.'
            '.$ArrPost["reason_3"];
		$message = $message.$ArrPost["reason_3"].'

		';
		}
		if ($ArrPost["reason_4"]) {
            $reason = $reason.'
            '.$ArrPost["reason_4"];
		$message = $message.$ArrPost["reason_4"].'

		';
		}
		if ($ArrPost["reason_5"]) {
            $reason = $reason.'
            '.$ArrPost["reason_5"];
		$message = $message.$ArrPost["reason_5"].'
		';
		}
		if ($ArrPost["reason_6"]) {
            $reason = $reason.'
            '.$ArrPost["reason_6"];
            $reason = $reason.'
            '.$ArrPost["other"];
		$message = $message.$ArrPost["reason_6"].'
		';
		$message = $message.$ArrPost["other"];
		}
		$headers = 'From: subscribe@plusworld.ru' . "\r\n";
		$headers.= 'Content-Type: text/plain; charset=utf-8';
		mail($to, $subject, $message, $headers);

        /*$idRubricAdd = array(1,3,17,55, 6,18,73, 11,13,14);
        if (($ID_SUBSCRIBE>0)and(in_array($ID_SUBSCRIBE,$idRubricAdd)))
        {

            CModule::IncludeModule('iblock');
            CModule::IncludeModule("subscribe");

            if (!$rsUser["ID"]) {
                $USER_ID = "Анонимный подписчик";
                $USER_FIO = "";
                $USER_ORG = "";
            }
            else
            {
                $USER_ID = $rsUser["ID"];
                $USER_FIO = $rsUser["NAME"].' '.$rsUser["LAST_NAME"];
                $USER_ORG = $rsUser["WORK_COMPANY"];
            }

            $Name = $ID_SUBSCRIBER.'_'.date("d.m.Y_H:i:s");
            $Name = $Name.'_'.$ID_SUBSCRIBE;
            $DELIVERY_ID = 0;
            $db_enum_list = CIBlockProperty::GetPropertyEnum("DELIVERY", Array(), Array("IBLOCK_ID"=>96,"XML_ID" => $ID_SUBSCRIBE));
            if($ar_enum_list = $db_enum_list->GetNext())
            {
                $DELIVERY_ID = $ar_enum_list["ID"];
            }

            $date = date("d.m.Y H:i:s");

            $el = new CIBlockElement;

            $PROP = array();
            $PROP[539] = 239;          // Действие - Подписался
            $PROP[540] = "";                    // Причина отписки
            $PROP[541] = $USER_ID;              // Подписчик
            $PROP[542] = $sf_EMAIL;    // Email подписки
            $PROP[543] = $USER_FIO;             // ФИО
            $PROP[544] = $USER_ORG;             // Организация
            $PROP[545] = $DELIVERY_ID;           // Рассылка
            $PROP[574] = $date;                                  // Дата
            $PROP[540] = $reason;                 // Причина отписки

            global $USER;
            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID"      => 96,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => $Name,
                "ACTIVE"         => "Y"
            );

            $el->Add($arLoadProductArray);
        }*/
    }
}

function add_material_rl_en($ID, $id_sessid) {
  global $DB;

  $strSql5 = "SELECT ID FROM counter_display_materials_RL_EN WHERE ((ID_r='$ID')  AND (sessid='$id_sessid'))";
		$res = $DB->Query($strSql5);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count2 = (count($name_array));

	if ($count2==0) {

   $date = date("Y-m-d H:i:s");
	$strSql = "
		INSERT INTO counter_display_materials_RL_EN (ID_r, DATE, sessid)
		VALUES ('$ID', '$date', '$id_sessid')
		";
		$res = $DB->Query($strSql, false);
		}
}

function count_material_rl_en($ID) {
//подсчитыват сколько было просмотров за определенный переод
 global $DB;
 $date = date("Y-m-d H:i:s");
	$time_1 = strtotime("-1 day");
	$time_7 = strtotime("-7 day");
	$time_30 = strtotime("-30 day");
	$time_180 = strtotime("-180 day");
	$time_366 = strtotime("-366 day");
$date_1 = date("Y-m-d H:i:s", $time_1);
$date_7 = date("Y-m-d H:i:s", $time_7);
$date_30 = date("Y-m-d H:i:s", $time_30);
$date_180 = date("Y-m-d H:i:s", $time_180);
$date_366 = date("Y-m-d H:i:s", $time_366);

	$strSql_1 = "SELECT DATE FROM counter_display_materials_RL_EN WHERE ((ID_r='$ID') AND (DATE>='$date_366') AND (DATE<='$date'))";
		$res = $DB->Query($strSql_1);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count_366 = (count($name_array));

	$name_array_180=array();
	for ($i=0; $i<count($name_array); $i++) {
			if ($name_array[$i]['DATE']>=$date_180) {
				array_push($name_array_180, $name_array[$i]['DATE']);
			}
	}
	$count_180 = (count($name_array_180));

	$name_array_30=array();
	for ($i=0; $i<count($name_array_180); $i++) {
			if ($name_array_180[$i]>=$date_30) {
				array_push($name_array_30, $name_array_180[$i]);
			}
	}
	$count_30 = (count($name_array_30));

	$name_array_7=array();
	for ($i=0; $i<count($name_array_30); $i++) {
			if ($name_array_30[$i]>=$date_7) {
				array_push($name_array_7, $name_array_30[$i]);
			}
	}
	$count_7 = (count($name_array_7));

	$name_array_1=array();
	for ($i=0; $i<count($name_array_7); $i++) {
			if ($name_array_7[$i]>=$date_1) {
				array_push($name_array_1, $name_array_7[$i]);
			}
	}
	$count_1 = (count($name_array_1));

	return array (
		"count_1" =>$count_1,
		"count_7" =>$count_7,
		"count_30" =>$count_30,
		"count_180" =>$count_180,
		"count_366" =>$count_366
	)	;
}

function add_material_rl_ru($ID, $id_sessid) {
  global $DB;
  $strSql5 = "SELECT ID FROM counter_display_materials_RL_RU WHERE ((ID_r='$ID')  AND (sessid='$id_sessid'))";
		$res = $DB->Query($strSql5);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count2 = (count($name_array));

	if ($count2==0) {

   $date = date("Y-m-d H:i:s");
	$strSql = "
		INSERT INTO counter_display_materials_RL_RU (ID_r, DATE, sessid)
		VALUES ('$ID', '$date', '$id_sessid')
		";
		$res = $DB->Query($strSql, false);
		}
}

function count_material_rl_ru($ID) {
//подсчитыват сколько было просмотров за определенный переод
 global $DB;
 $date = date("Y-m-d H:i:s");
	$time_1 = strtotime("-1 day");
	$time_7 = strtotime("-7 day");
	$time_30 = strtotime("-30 day");
	$time_180 = strtotime("-180 day");
	$time_366 = strtotime("-366 day");
$date_1 = date("Y-m-d H:i:s", $time_1);
$date_7 = date("Y-m-d H:i:s", $time_7);
$date_30 = date("Y-m-d H:i:s", $time_30);
$date_180 = date("Y-m-d H:i:s", $time_180);
$date_366 = date("Y-m-d H:i:s", $time_366);

	$strSql_1 = "SELECT DATE FROM counter_display_materials_RL_RU WHERE ((ID_r='$ID') AND (DATE>='$date_366') AND (DATE<='$date'))";
		$res = $DB->Query($strSql_1);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count_366 = (count($name_array));

	$name_array_180=array();
	for ($i=0; $i<count($name_array); $i++) {
			if ($name_array[$i]['DATE']>=$date_180) {
				array_push($name_array_180, $name_array[$i]['DATE']);
			}
	}
	$count_180 = (count($name_array_180));

	$name_array_30=array();
	for ($i=0; $i<count($name_array_180); $i++) {
			if ($name_array_180[$i]>=$date_30) {
				array_push($name_array_30, $name_array_180[$i]);
			}
	}
	$count_30 = (count($name_array_30));

	$name_array_7=array();
	for ($i=0; $i<count($name_array_30); $i++) {
			if ($name_array_30[$i]>=$date_7) {
				array_push($name_array_7, $name_array_30[$i]);
			}
	}
	$count_7 = (count($name_array_7));

	$name_array_1=array();
	for ($i=0; $i<count($name_array_7); $i++) {
			if ($name_array_7[$i]>=$date_1) {
				array_push($name_array_1, $name_array_7[$i]);
			}
	}
	$count_1 = (count($name_array_1));

	return array (
		"count_1" =>$count_1,
		"count_7" =>$count_7,
		"count_30" =>$count_30,
		"count_180" =>$count_180,
		"count_366" =>$count_366
	)	;
}

function add_material_org($ID, $id_sessid) {
  global $DB;

  $strSql5 = "SELECT ID FROM counter_display_materials_ORG WHERE ((ID_r='$ID')  AND (sessid='$id_sessid'))";
		$res = $DB->Query($strSql5);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count2 = (count($name_array));

	if ($count2==0) {

   $date = date("Y-m-d H:i:s");
	$strSql = "
		INSERT INTO counter_display_materials_ORG (ID_r, DATE, sessid)
		VALUES ('$ID', '$date', '$id_sessid')
		";
		$res = $DB->Query($strSql, false);
		}
}

function count_material_org($ID) {
//подсчитыват сколько было просмотров за определенный переод
 global $DB;
 $date = date("Y-m-d H:i:s");
	$time_1 = strtotime("-1 day");
	$time_7 = strtotime("-7 day");
	$time_30 = strtotime("-30 day");
	$time_180 = strtotime("-180 day");
	$time_366 = strtotime("-366 day");
$date_1 = date("Y-m-d H:i:s", $time_1);
$date_7 = date("Y-m-d H:i:s", $time_7);
$date_30 = date("Y-m-d H:i:s", $time_30);
$date_180 = date("Y-m-d H:i:s", $time_180);
$date_366 = date("Y-m-d H:i:s", $time_366);

	$strSql_1 = "SELECT DATE FROM counter_display_materials_ORG WHERE ((ID_r='$ID') AND (DATE>='$date_366') AND (DATE<='$date'))";
		$res = $DB->Query($strSql_1);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count_366 = (count($name_array));

	$name_array_180=array();
	for ($i=0; $i<count($name_array); $i++) {
			if ($name_array[$i]['DATE']>=$date_180) {
				array_push($name_array_180, $name_array[$i]['DATE']);
			}
	}
	$count_180 = (count($name_array_180));

	$name_array_30=array();
	for ($i=0; $i<count($name_array_180); $i++) {
			if ($name_array_180[$i]>=$date_30) {
				array_push($name_array_30, $name_array_180[$i]);
			}
	}
	$count_30 = (count($name_array_30));

	$name_array_7=array();
	for ($i=0; $i<count($name_array_30); $i++) {
			if ($name_array_30[$i]>=$date_7) {
				array_push($name_array_7, $name_array_30[$i]);
			}
	}
	$count_7 = (count($name_array_7));

	$name_array_1=array();
	for ($i=0; $i<count($name_array_7); $i++) {
			if ($name_array_7[$i]>=$date_1) {
				array_push($name_array_1, $name_array_7[$i]);
			}
	}
	$count_1 = (count($name_array_1));

	return array (
		"count_1" =>$count_1,
		"count_7" =>$count_7,
		"count_30" =>$count_30,
		"count_180" =>$count_180,
		"count_366" =>$count_366
	)	;
}

function add_material_4427($ID, $id_sessid) {
  global $DB;

  $strSql5 = "SELECT ID FROM counter_display_materials_4427 WHERE ((ID_r='$ID')  AND (sessid='$id_sessid'))";
		$res = $DB->Query($strSql5);
		$name_array=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}
	$count2 = (count($name_array));

	if ($count2==0) {

   $date = date("Y-m-d H:i:s");
	$strSql = "
		INSERT INTO counter_display_materials_4427 (ID_r, DATE, sessid)
		VALUES ('$ID', '$date', '$id_sessid')
		";
		$res = $DB->Query($strSql, false);
		}
}

function count_material_4427($ID) {
//подсчитыват сколько было просмотров за определенный переод
 global $DB;
 $date = date("Y-m-d H:i:s");
	$time_1 = strtotime("-1 day");
	$time_7 = strtotime("-7 day");
	$time_30 = strtotime("-30 day");
	$time_180 = strtotime("-180 day");
	$time_366 = strtotime("-366 day");
$date_1 = date("Y-m-d H:i:s", $time_1);
$date_7 = date("Y-m-d H:i:s", $time_7);
$date_30 = date("Y-m-d H:i:s", $time_30);
$date_180 = date("Y-m-d H:i:s", $time_180);
$date_366 = date("Y-m-d H:i:s", $time_366);
	$strSql_366 = "SELECT DATE FROM counter_display_materials_4427 WHERE ((ID_r='$ID') AND (DATE>='$date_366') AND (DATE<='$date'))";
		$res = $DB->Query($strSql_366);
		$name_array=array();
		$count_all1=array();
	while ($row = $res->Fetch())
	{
	array_push($name_array, $row);
	}

	$count_366 = (count($name_array));

	$name_array_180=array();
	for ($i=0; $i<count($name_array); $i++) {
			if ($name_array[$i]['DATE']>=$date_180) {
				array_push($name_array_180, $name_array[$i]['DATE']);
			}
	}
	$count_180 = (count($name_array_180));

	$name_array_30=array();
	for ($i=0; $i<count($name_array_180); $i++) {
			if ($name_array_180[$i]>=$date_30) {
				array_push($name_array_30, $name_array_180[$i]);
			}
	}
	$count_30 = (count($name_array_30));

	$name_array_7=array();
	for ($i=0; $i<count($name_array_30); $i++) {
			if ($name_array_30[$i]>=$date_7) {
				array_push($name_array_7, $name_array_30[$i]);
			}
	}
	$count_7 = (count($name_array_7));

	$name_array_1=array();
	for ($i=0; $i<count($name_array_7); $i++) {
			if ($name_array_7[$i]>=$date_1) {
				array_push($name_array_1, $name_array_7[$i]);
			}
	}
	$count_1 = (count($name_array_1));

	return array (
		"count_1" =>$count_1,
		"count_7" =>$count_7,
		"count_30" =>$count_30,
		"count_180" =>$count_180,
		"count_366" =>$count_366
	)	;
}

//выбираем 200 материалов самых просматриваемых за последний месяц

function statSpeechPlusRu($string) {
    /* Количество слов в материалах */

    global $DB;
    //$strSql = "SELECT * FROM stat_speech_new_PLUS_RU WHERE (speech='$string')";
    $strSql = "SELECT * FROM stat_speech_new_RL_RU WHERE (speech='$string')";

    $res = $DB->Query($strSql);

    $i = 0;
    while ($row = $res->Fetch())
    {
        $i++;
        $idSpeech = $row["ID"];
    }

    if ($i == 0) {
        // добавляем слово
        //$strSqlNew = "INSERT INTO stat_speech_new_PLUS_RU (speech, count_speech) VALUES ('$string', 1)";
        $strSqlNew = "INSERT INTO stat_speech_new_RL_RU (speech, count_speech) VALUES ('$string', 1)";
        $resNew = $DB->Query($strSqlNew, false);
    }
    else
    {
        //$strSqlNew = "UPDATE stat_speech_new_PLUS_RU SET count_speech = count_speech+1 WHERE (ID ='$idSpeech')";
        $strSqlNew = "UPDATE stat_speech_new_RL_RU SET count_speech = count_speech+1 WHERE (ID ='$idSpeech')";
        $resNew = $DB->Query($strSqlNew, false);
    }
}



function speech_count() {
    global $DB;
    $time_1month = strtotime("-1 month");
    $date_1month = date("Y-m-d H:i:s", $time_1month);

    //$strSql_1year = "SELECT ID_r, COUNT(ID_r) AS COUNT_ID_r FROM counter_display_materials_4427 WHERE (DATE>='$date_1month') GROUP BY ID_r";
    $strSql_1year = "SELECT ID_r, COUNT(ID_r) AS COUNT_ID_r FROM counter_display_materials_RL_RU WHERE (DATE>='$date_1month') GROUP BY ID_r";

    $res = $DB->Query($strSql_1year);
    $count_all=array();
    while ($row = $res->Fetch())
    {
        array_push($count_all, $row);
    }
    $countNewAll=array();
    foreach($count_all as $item) {
        $countNewAll[$item['ID_r']] = $item['COUNT_ID_r'];
    }
    arsort($countNewAll);
    $i=0;
    $countArr250 = array();
    foreach ($countNewAll as $key => $val) {
        if ($i<=250) {
            $countArr1 = array();
            $countArr1["ID"] = $key;
            $countArr1["COUNT"] = $val;
            array_push($countArr250,$countArr1);
        }
        else break;
        $i++;
    }

    $arNotADD = array(
        "как",
        "это",
        "его",
        "без",
        "или",
        "над",
        "под",
        "из-за",
        "что",
        "где",
        "все",
        "всё",
        "есть",
        "уже",
        "либо",
        "нужно",
        "такого",
        "он",
        "также",
        "так",
        "пока",
        "того",
        "для",
        "всех",
        "быть",
        "будут",
        "буду",
        "будем",
        "будет",
        "почти",
        "тыс",
        "тысяч",
        "свои",
        "свою",
        "себе",
        "своих",
        "когда",
        "был",
        "еще",
        "при",
        "будет",
        "только",
        "можно",
        "может",
        "чем",
        "этом",
        "после",
        "год",
        "всего",
        "года",
        "если",
        "лет",
        "могут",
        "было",
        "себя",
        "через",
        "млрд",
        "руб",
        "были",
        "сейчас",
        "они",
        "около",
        "других",
        "другие",
        "другим",
        "этот",
        "между",
        "нам",
        "наших",
        "нашим",
        "там",
        "каждый",
        "них",
        "рубля",
        "таких",
        "чаще",
        "имеет",
        "млн",
        "сразу",
        "другие",
        "таких",
        "даже",
        "тех",
        "такой",
        "своей",
        "наш",
        "ваш",
        "вам",
        "нам",
        "всей",
        "нас",
        "вас",
        "скорее",
        "была",
        "было",
        "были",
        "очень",
        "мало",
        "много",
        "перед",
        "после",
        "возле",
        "около",
        "этих",
        "раз",
        "раза",
        "два",
        "три",
        "свыше",
        "весь",
        "нет",
        "ними",
        "должно",
        "нашей",
        "дня",
        "дней",
        "тогда",
        "выше",
        "ниже",
        "том",
        "день",
        "кроме",
        "тем",
        "новый",
        "новые",
        "рыблях",
        "среди",
        "мая",
        "просто",
        "сложно",
        "новой",
        "многие",
        "самых",
        "самые",
        "всем",
        "ранее",
        "свое",
        "своё",
        "свои",
        "она",
        "прежде",
        "менее",
        "более",
        "одна",
        "здесь",
        "свой",
        "такая",
        "эту",
        "эта",
        "эти",
        "часто",
        "котором",
        "котороыми",
        "своего",
        "такие",
        "лишь",
        "наши",
        "каждой",
        "быстрее",
        "кто",
        "нашего",
        "вашего",
        "всегда",
        "чтобы",
        "году",
        "которые",
        "июля",
        "июль",
        "июня",
        "июнь",
        "сегодня",
        "которых",
        "однако",
        "теперь",
        "один",
        "этой",
        "больше",
        "быстро",
        "именно",
        "поэтому",
        "про",
        "которой",
        "любой",
        "мае",
        "самом",
        "несколько",
        "начала",
        "начало",
        "мне",
        "вам",
        "собой",
        "своем",
        "своём",
        "например",
        "одной",
        "августа",
        "август",
        "августе",
        "необходимо",
        "июне",
        "июле",
        "and",
        "другой",
        "трех",
        "новая",
        "всему",
        "рублей",
        "который",
        "случае",
        "будущем",
        "первом",
        "двух",
        "месяц",
        "своим",
        "иметь",
        "этому",
        "этим",
        "чья",
        "чью",
        "чьем",
        "чуть",
        "что-то",
        "чего-то",
        "чего",
        "чего",
        "той",
        "тоже",
        "тому",
        "впервые",
        "недавно",
        "The",
        "сентября",
        "первый",
        "среднем",
        "среднем",
        "меньше",
        "последние",
        "первые",
    );

    $arNotADDO = array(
        "щие",
        "щее",
        "щую",
        "ную",
        "нюю",
        "ных",
        "ные",
        "ная",
        "мую",
        "вую",
        "рую",
        "ого",
        "ься",
        "лых",
        "ыми",
        "рая",
        "лее",
        "вых",
        "яет",
        "тся",
        "ной",
        "ный",
        "ным",
        "ний",
        "ких",
        "щих",
        "ему",
        "йся",
        "нее",
        "вые",
    );
    $arRes = array();

    CModule::IncludeModule('iblock');
    foreach($countArr250 as $item) {
        $res = CIBlockElement::GetByID($item["ID"]);
        if($ar_res = $res->GetNext()) {
            //echo "<pre> ID - "; print_r($ar_res['ID']); echo "</pre>";
            //echo "<pre> LID - "; print_r($ar_res['LID']); echo "</pre>";
            //echo "<pre> IBLOCK_ID - "; print_r($ar_res['IBLOCK_ID']); echo "</pre>";
            //echo "<pre> DATE_CREATE - "; print_r($ar_res['DATE_CREATE']); echo "</pre>";
            //echo "<pre> DETAIL_PAGE_URL - "; print_r($ar_res['DETAIL_PAGE_URL']); echo "</pre>";
            // echo "<pre> LID - "; print_r($ar_res); echo "</pre>";
            $arSpeech = array();

            //$arFields = $ob->GetFields();
            $textDetail = $ar_res["DETAIL_TEXT"];
            //echo "<pre>"; print_r($arFields["DATE_CREATE"]); echo "</pre>";

            $textDetail = str_replace(array("\r","\n"),"",$textDetail);
            $textDetail = str_replace(array("&ndash","&middot","&laquo","&raquo","&amp","&mdash","&quot"),"",$textDetail);
            $textDetail = strip_tags($textDetail);
            $textDetail = str_replace(array(",","%",".","!","?",";",":",")","(","{","}","[","]",'"','"',"'","`","«","»"),"",$textDetail);
            $textDetail = str_replace("  "," ",$textDetail);

            $arSpeech = explode(' ',$textDetail);

            $arSpeechNew = array();

            foreach($arSpeech as $row) {
                $row = str_replace(" ","",$row);
                if (((strlen($row)>=3)AND(!is_numeric($row))AND(!in_array(mb_strtolower($row),$arNotADD)))
                    OR(($row=="РФ") OR($row=="ЦБ"))
                ) {
                    if (!in_array(mb_strtolower(substr($row,strlen($row)-3,3)),$arNotADDO)) {
                        array_push($arSpeechNew,$row);
                    }
                }
            }

            foreach($arSpeechNew as $row) {
                //echo "<pre>"; print_r($row); echo "</pre>";
                //$arRes = arRes($arRes, $row);
                statSpeechPlusRu($row);
            }
        }
    }
}

//Удалить все элементы старше 1 года

function count_material_del_RL_RU() {
    global $DB;
    $time_370 = strtotime("-370 day");
    $date_370 = date("Y-m-d H:i:s", $time_370);

    $strSql_1year = "DELETE FROM counter_display_materials_RL_RU WHERE (DATE<'$date_370')";
    $res = $DB->Query($strSql_1year);

    return "count_material_del_RL_RU();";
}
function count_material_del_RL_EN() {
    global $DB;
    $time_370 = strtotime("-370 day");
    $date_370 = date("Y-m-d H:i:s", $time_370);

    $strSql_1year = "DELETE FROM counter_display_materials_RL_EN WHERE (DATE<'$date_370')";
    $res = $DB->Query($strSql_1year);

    return "count_material_del_RL_EN();";
}
function count_material_del_PLUS_ORG() {
    global $DB;
    $time_370 = strtotime("-370 day");
    $date_370 = date("Y-m-d H:i:s", $time_370);

    $strSql_1year = "DELETE FROM counter_display_materials_ORG WHERE (DATE<'$date_370')";
    $res = $DB->Query($strSql_1year);

    return "count_material_del_PLUS_ORG();";
}
function count_material_del_PLUS_RU() {
    global $DB;
    $time_370 = strtotime("-370 day");
    $date_370 = date("Y-m-d H:i:s", $time_370);

    $strSql_1year = "DELETE FROM counter_display_materials_4427 WHERE (DATE<='$date_370')";
    $res = $DB->Query($strSql_1year);

    return "count_material_del_PLUS_RU();";
}



function wl($data, $dump = false) { //
  if($dump)
    $data = var_export($data, 1);
  $fp = fopen($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/debug.log", 'at+');
  fwrite($fp, $data);
  fputs($fp, "\n-----------------------------------------------------------------\n");
  fflush($fp);
  fclose($fp);
}

function writeLog()
{
  $data = func_get_args();
  if(count($data) == 0)
    return;
  elseif(count($data) == 1)
    $data = current($data);

  if(!is_string($data) && !is_numeric($data))
    $data = var_export($data, 1);
  //AddMessage2Log($data . "\n-----------------------------------------------------------------\n", 'writeLog');
}


AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "OnBeforeElementHandler");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterAddElementHandler");



AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");

function OnAfterUserRegisterHandler(&$arFields)
{
    if ((SITE_ID == 's1')or(SITE_ID =='ip')) {
        $arEventFields = array(
            "LOGIN" => $arFields["LOGIN"],
            "NAME" => $arFields["NAME"],
            "LAST_NAME" => $arFields["LAST_NAME"],
            "EMAIL" => $arFields["EMAIL"],
            "SERVER_NAME" => $_SERVER['SERVER_NAME']
        );
        CEvent::Send("USER_REGISTER_CETERA", array('s1', 'ip'), $arEventFields);
    }

    //Отправляем сообщение об успешной регистрации
    $message = "Успешная регистрацуия на сайте retail-loyalty.org\n";
    $message.="Ваш логин: ".$arFields["LOGIN"]."\nВаш парол: ".$arFields["PASSWORD"]."\n";
    mail($arFields["EMAIL"], 'Регистрационные данные с сайта shop.ru', $message, 'From: marketing@retail-loyalty.org');
}


function OnBeforeElementHandler(&$arFields) {
    global $USER;

    if($arFields["IBLOCK_ID"] == '23')
    {
        if ($arFields['PROPERTY_VALUES'][637]['n0']['VALUE'] == "") {
            $fullname=$USER->GetFullName();
            $arFields['PROPERTY_VALUES'][637]['n0']['VALUE'] = $fullname;
        }
    }

    if($arFields["IBLOCK_ID"] == '9' || $arFields["IBLOCK_ID"] == '32')
    {
        if ($arFields["IBLOCK_ID"] == '9' && !$USER->IsAdmin()) $arFields["IBLOCK_SECTION"] = 929;
        if ($arFields["IBLOCK_ID"] == '32' && !$USER->IsAdmin()) $arFields["IBLOCK_SECTION"] = 933;

        if (trim($arFields["NAME"]) != '')
        {
            $arFields["CODE"] = code_translit($arFields["NAME"]);

            $uniq = false;
            $sfx=1;
            $elm_code = $arFields["CODE"];
            while($uniq === false)
            {
                $obElement = CIBlockElement::GetList(array(), array(
                    "IBLOCK_ID" => $arFields["IBLOCK_ID"],
                    "CODE" => $elm_code,
                ), false, false, array());

                if ($arElement = $obElement->GetNext()) // существующая
                {
                    $elm_code = $arFields["CODE"].'-'.$sfx;
                }
                else
                {
                    $uniq = true;
                }
                $sfx++;
            }
            $arFields["CODE"] = $elm_code;
        }

    }
    return $arFields;
}
function OnAfterAddElementHandler(&$arFields) {
    global $USER, $DB;
    if($arFields["IBLOCK_ID"] == '9' || $arFields["IBLOCK_ID"] == '32')
    {
        if ( !$USER->isAdmin() ) {

            $arMail['ID'] = $arFields["ID"];
            $arMail['NAME'] = $arFields["NAME"];
            $arMail['DETAIL_TEXT'] = $arFields["DETAIL_TEXT"];

            $rsUser = CUser::GetByID($arFields["MODIFIED_BY"]); //берем пользователя, созд сообщение
			$arUser = $rsUser->Fetch();

            $arMail["USER_ID"] = $arUser["ID"];
            $arMail["USER_NAME"] = $arUser["NAME"];
            $arMail["USER_LNAME"] = $arUser["LAST_NAME"];

			CEvent::Send("USER_ADD_NEWS", array('s1','en'), $arMail);
        }
    }
    // send notify to mobile app users
    $arIBlocks = array(9,38,39);
    if (in_array($arFields["IBLOCK_ID"], $arIBlocks))
    {
        //include_once("include/push_notifier.php");
        //SendNotify($arFields);

        COption::SetOptionInt("main","last_element_add", time());
    }

    return $arFields;
}



/**
 * truncate()
 *
 * @param mixed $string
 * @param integer $simbols - количество символов
 * @param string $addition - дополнение к строке
 * @return string
 */
function truncate($string, $simbols = 0, $addition = '')
{
    if ($simbols == '0') return $string;
    if (strlen($string) <= $simbols) return $string;

    $new_string = substr($string, 0, $simbols);
    $last_space = strripos($new_string, " ");
    $new_string = substr($new_string, 0, $last_space);

    if ($addition != '')
    {
        $last_char = substr($new_string, -1);
        if (in_array($last_char, array('.',',','-',':',';','(')))
        {
            $new_string = substr($new_string, 0, -1).$addition;
        }
        else
        {
            $new_string .= $addition;
        }
    }
    return $new_string;
}

/**
 * BuildCountText()
 *
 * @param int $Counter - количество
 * @param string $txtBase - основа слова (комментари (й, я, в))
 * @param string $txt1 - окончание для 1 (1 комментари"й")
 * @param string $txt2 - окончание для 2 (2 комментари"я")
 * @param string $txt5 - окончание для 5 (5 комментари"ев")
 * @param bool $ShowNum - добавлять число к слову
 * @return string
 */
function BuildCountText($Counter, $txtBase = "", $txt1 = "", $txt2 = "", $txt5 = "", $ShowNum = true)
{
    if(($Counter<=14) && ($Counter>=5)) $str = $txt5;
    else
    {
        $num = $Counter - (floor($Counter/10)*10);
        if($num == 1) { $str = $txt1; }
        elseif($num == 0) { $str = $txt5; }
        elseif(($num>=2) && ($num<=4)) { $str = $txt2; } elseif(($num>=5) && ($num<=9)) { $str = $txt5; }
    }
    if($ShowNum) return $Counter . " " . $txtBase . $str ; else return $txtBase . $str ;
}

function code_translit($str)
{
    $alias = trim($str);
    if (strlen($str) > 0)
    {
        $eng = Array ('a', 'b', 'v', 'g', 'd', 'e', 'e', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'i', '', '', 'e', 'u', 'ya','a', 'b', 'v', 'g', 'd', 'e', 'e',
            'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch',
            'i', '', '', 'e', 'u', 'ya');
        $rus = Array ('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с',
            'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ы', 'ъ', 'ь', 'э', 'ю', 'я','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж',
            'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы', 'Ъ',
            'Ь', 'Э', 'Ю', 'Я');


        $alias = str_replace($rus, $eng, $alias);

        $alias = str_replace(array(" ","_",","), "-", $alias);
        $alias = str_replace(array("«","»","№",".","","\"","'","`","!","?","/","\\","~","@","#","$","%","^","&","*","(",")","+",":",";","|",">","<"), "", $alias);
        //$alias = preg_replace("/\W+/","", $alias);
        $alias = str_replace("---", "-", $alias);
        $alias = str_replace("--", "-", $alias);


        return substr(strtolower($alias),0,150);
    }
    return '';
}


include_once("include/mobile_detector_new.php");



//Отчет по рассылке
AddEventHandler("subscribe", "BeforePostingSendMail", "BeforePostingSendMailHandler");

function BeforePostingSendMailHandler($arFields)
{
	global $DB, $USER;

	$query = $DB->Query("SELECT MAX(`ID`) FROM `b_posting_email` WHERE `POSTING_ID`='{$arFields['POSTING_ID']}'");
	if ($row = $query->Fetch())	{
		$max_id = $row['MAX(`ID`)'];
	}
	$query = $DB->Query("SELECT `EMAIL` FROM `b_posting_email` WHERE `ID`='{$max_id}'");
	if ($row = $query->Fetch())	{
		$final_mail = $row['EMAIL'];
	}
	if ($arFields['EMAIL'] == $final_mail) {
		$query = $DB->Query("SELECT COUNT(*) FROM `b_posting_email` WHERE `POSTING_ID`='{$arFields['POSTING_ID']}'");
		if ($row = $query->Fetch())	{
			$in_all_mail = $row['COUNT(*)'];
		}
		$query = $DB->Query("SELECT COUNT(*) FROM `b_posting_email` WHERE `POSTING_ID`='{$arFields['POSTING_ID']}' AND `STATUS`='N'");
		if ($row = $query->Fetch())	{
			$ok_mail = $row['COUNT(*)'] + 1;
		}
		$query = $DB->Query("SELECT COUNT(*) FROM `b_posting_email` WHERE `POSTING_ID`='{$arFields['POSTING_ID']}' AND `STATUS`='E'");
		if ($row = $query->Fetch())	{
			$error_mail = $row['COUNT(*)'];
		}
		$rsPosting = CPosting::GetByID($arFields['POSTING_ID']);
		$arPosting = $rsPosting->Fetch();

		$admin_name = $USER->GetFullName();
		$to      ='marketing@plus-alliance.com'; //'v.mokin@ceteralabs.com';   //'test@plus-alliance.com';	//'marketing@plus-alliance.com'; //'a.nikonorov@ceteralabs.com';
		$subject = 'Отчет о рассылке выпуска #'.$arFields['POSTING_ID'];
		$message = 'Название выпуска: '.$arPosting['SUBJECT']."\r\n"
		//.'Время отправки : '.$arPosting['TIMESTAMP_X']."\r\n"
		//.'Отправленно: '.$in_all_mail - $error_mail."\r\n"
		.'Ошибки при отправке: '.$error_mail."\r\n"
		.'Всего адресов для отправки: '.$in_all_mail."\r\n"
		.'Кто сформировал и отправил рассылку: '.$admin_name."\r\n"
		.'Отчет: http://www.retail-loyalty.org/bitrix/admin/posting_bcc.php?ID='.$arFields['POSTING_ID'].'&lang=ru';
		$headers = 'From: subscribe@plusworld.ru' . "\r\n";
		$headers.= 'Content-Type: text/plain; charset=utf-8';
		mail($to, $subject, $message, $headers);
		//mail('egorlebedevrtest@gmail.com', $subject, $message, $headers);
		//mail('a.moksheeva@ceteralabs.com', $subject, $message, $headers);
		//mail('a.nikonorov@ceteralabs.com', $subject, $message, $headers);
	}

    # добавить спец картинку в текст письма, для отслеживания событий
    $content_begin = "<!--Content begin-->";
    $event3 = $arFields["EMAIL"]."|".$arFields["POSTING_ID"];
    $pic = '<!--Content begin-->
    <img src="http://www.retail-loyalty.org/local/redirect.php?event1=mail&event2=read&event3='.$event3.'&goto=/upload/pic1.jpg" width="1" height="1" />';
    $arFields["BODY"] = str_replace($content_begin, $pic, $arFields["BODY"]);

    $arFields["BODY"] = str_replace('#POSTING_ID#', $arFields["POSTING_ID"], $arFields["BODY"]);

	# добавить ссылку для быстрой отписки от рассылки

	//в какие рубрики отправлять
	$aPostRub = array();
	$post_rub = CPosting::GetRubricList($arFields['POSTING_ID']);
	while($post_rub_arr = $post_rub->Fetch())
    $aPostRub[] = $post_rub_arr["ID"];

    $content_begin_1 = "personal/subscribe/";
    $email_1 = $arFields["EMAIL"];
	if ($aPostRub[0]) {
    $sub_1 = 'personal/subscribe.php?email='.$email_1.'&id_subscribe='.$aPostRub[0];
	} else {
	$sub_1 = 'personal/subscribe/';
	}
    $arFields["BODY"] = str_replace($content_begin_1, $sub_1, $arFields["BODY"]);

    return $arFields;
}

/////////////////////// Добавление кнопки словаря в визуальный редактор //////////////////////////



AddEventHandler("fileman", "OnBeforeHTMLEditorScriptsGet", "HTMLEditorPersInsert");
function HTMLEditorPersInsert($editorName, $arEditorParams)
{
   return Array(
      "JS" => Array('pers.php')
   );
}



//////////////////////////////////////////////////////////////////////////////////////////////////
?><?
/*Version 0.3 2011-04-25*/
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "BXIBlockAfterSave");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "BXIBlockAfterSave");
AddEventHandler("catalog", "OnPriceAdd", "BXIBlockAfterSave");
AddEventHandler("catalog", "OnPriceUpdate", "BXIBlockAfterSave");
function BXIBlockAfterSave($arg1, $arg2 = false)
{
$ELEMENT_ID = false;
	$IBLOCK_ID = false;
	$OFFERS_IBLOCK_ID = false;
	$OFFERS_PROPERTY_ID = false;

	//Check for catalog event
	if(is_array($arg2) && $arg2["PRODUCT_ID"] > 0)
	{
		//Get iblock element
		$rsPriceElement = CIBlockElement::GetList(
			array(),
			array(
				"ID" => $arg2["PRODUCT_ID"],
			),
			false,
			false,
			array("ID", "IBLOCK_ID")
		);
		if($arPriceElement = $rsPriceElement->Fetch())
		{
			$arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
			if(is_array($arCatalog))
			{
				//Check if it is offers iblock
				if($arCatalog["OFFERS"] == "Y")
				{
					//Find product element
					$rsElement = CIBlockElement::GetProperty(
						$arPriceElement["IBLOCK_ID"],
						$arPriceElement["ID"],
						"sort",
						"asc",
						array("ID" => $arCatalog["SKU_PROPERTY_ID"])
					);
					$arElement = $rsElement->Fetch();
					if($arElement && $arElement["VALUE"] > 0)
					{
						$ELEMENT_ID = $arElement["VALUE"];
						$IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
						$OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
						$OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
					}
				}
				//or iblock wich has offers
				elseif($arCatalog["OFFERS_IBLOCK_ID"] > 0)
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
					$OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
				}
				//or it's regular catalog
				else
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = false;
					$OFFERS_PROPERTY_ID = false;
				}
			}
		}
	}
	//Check for iblock event
	elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0)
	{
		//Check if iblock has offers
		$arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
		if(is_array($arOffers))
		{
			$ELEMENT_ID = $arg1["ID"];
			$IBLOCK_ID = $arg1["IBLOCK_ID"];
			$OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
			$OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
		}
	}

	if($ELEMENT_ID)
	{
		static $arPropCache = array();
		if(!array_key_exists($IBLOCK_ID, $arPropCache))
		{
			//Check for MINIMAL_PRICE property
			$rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
			$arProperty = $rsProperty->Fetch();
			if($arProperty)
				$arPropCache[$IBLOCK_ID] = $arProperty["ID"];
			else
				$arPropCache[$IBLOCK_ID] = false;
		}

		if($arPropCache[$IBLOCK_ID])
		{
			//Compose elements filter
			$arProductID = array($ELEMENT_ID);
			if($OFFERS_IBLOCK_ID)
			{
				$rsOffers = CIBlockElement::GetList(
					array(),
					array(
						"IBLOCK_ID" => $OFFERS_IBLOCK_ID,
						"PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
					),
					false,
					false,
					array("ID")
				);
				while($arOffer = $rsOffers->Fetch())
					$arProductID[] = $arOffer["ID"];
			}

			$minPrice = false;
			$maxPrice = false;
			//Get prices
			$rsPrices = CPrice::GetList(
				array(),
				array(
					"BASE" => "Y",
					"PRODUCT_ID" => $arProductID,
				)
			);
			while($arPrice = $rsPrices->Fetch())
			{
				$PRICE = $arPrice["PRICE"];

				if($minPrice === false || $minPrice > $PRICE)
					$minPrice = $PRICE;

				if($maxPrice === false || $maxPrice < $PRICE)
					$maxPrice = $PRICE;
			}

			//Save found minimal price into property
			if($minPrice !== false)
			{
				CIBlockElement::SetPropertyValuesEx(
					$ELEMENT_ID,
					$IBLOCK_ID,
					array(
						"MINIMUM_PRICE" => $minPrice,
						"MAXIMUM_PRICE" => $maxPrice,
					)
				);
			}
		}
	}
}


AddEventHandler("main", "OnEndBufferContent", "GlossaryReplace");
function GlossaryReplace(&$content)
{
    if(!$_SERVER["REQUEST_URI"] || strpos($_SERVER["REQUEST_URI"], "/bitrix/") === 0 || $_SERVER["SERVER_NAME"]!="www.plusworld.ru" || $_SERVER["REDIRECT_URL"]!="/daily/novaya-kreditnaya-karta-mobilnie-dengi-ot-alfa-banka/") return;
    $tmp_content = $content;
    $positions = array();
    $position = 0;
    while(($pos = strpos($tmp_content, "<!--glossary_end-->")) !== false) {
        $tmp_content = substr($tmp_content, $pos + 19);
        $position += $pos + 19;
        $positions[$position] = 1;
    }
    $tmp_content = $content;
    $position = 0;
    while(($pos = strpos($tmp_content, "<!--glossary_start-->")) !== false) {
        $tmp_content = substr($tmp_content, $pos + 21);
        $position += $pos + 21;
        $positions[$position] = 2;
    }
    ksort($positions);
    $marker = array();
    foreach($positions as $key => $value) {
        if($value == 2)
        {
            if(!$marker) {
                $marker["type"] = 2;
                $marker["position"] = $key;
            } elseif($marker["type"] == 1) {
                $marker["type"] = 2;
                $marker["position"] = $key;
            } else {
                unset($positions[$key]);
            }
        }
        if($value == 1) {
            if(!$marker) unset($positions[$key]);
            elseif($marker["type"] == 2) {
                $marker["type"] = 1;
                $marker["position"] = $key;
            } else {
                unset($positions[$marker["position"]]);
                $marker["type"] = 1;
                $marker["position"] = $key;
            }
        }
    }
    if(end($positions) == 2) unset($positions[key($positions)]);
    $terms = GetTerms();
    if($terms) {
        if($positions) {
            $new_content = "";
            $start = 0;
            foreach($positions as $key => $value) {
                $end = $key;
                $text = substr($content, $start, $end - $start);
                if($value == 1) $new_content .= ProcessReplace($text, $terms);
                else $new_content .= $text;
                $start = $end;
            }
            $new_content .= substr($content, $start);
        } else {
            $new_content = ProcessReplace($content, $terms);
        }
    }
    $content = $new_content;
}

function GetTerms() {
    CModule::IncludeModule("iblock");
    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "ACTIVE_FROM",
        "DETAIL_PAGE_URL",
        "DETAIL_TEXT",
        "DETAIL_TEXT_TYPE",
        "PREVIEW_TEXT",
        "PREVIEW_TEXT_TYPE",
        "PROPERTY_SYNONYMS"
    );
    $arFilter = array (
        "IBLOCK_ID" => "17",
        "IBLOCK_LID" => SITE_ID,
        "ACTIVE" => "Y",

    );
    $arSort = array("LENGTH(NAME)" => "ASC");
    $rsElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
    $arResult = array();
    while($obElement = $rsElement->GetNextElement())
    {
        $arItem = $obElement->GetFields();
        $PROPERTIES = $obElement->GetProperties();
        $arItem["SYNONYMS"] = $PROPERTIES["SYNONYMS"]["VALUE"];
        $arResult[] = $arItem;
    }
    return $arResult;
}

function ProcessReplace($text, $input_terms) {
    $text = preg_replace('/\s+/', ' ', $text);
    $text_tmp = ToLower($text);
    $termsAll = array();
    foreach($input_terms as $row) {
        $terms = array();
        if($row['SYNONYMS']) foreach($row['SYNONYMS'] as $value) $terms[] = trim(ToLower($value));
        $terms[] = trim(ToLower($row['NAME']));
        $new_terms=array();
        foreach($terms as $idx => $word)
        {
            if(!$word) continue;
            if(($match_res = strpos($text_tmp, $word)) !== false)
            {
                if(!isset($new_terms[$match_res]) || mb_strlen($new_terms[$match_res]) < mb_strlen($word))
                    $new_terms[$match_res] = $word;
            }
        }
        if($new_terms)
        {
            ksort($new_terms);
            $row['PREVIEW_TEXT'] = htmlspecialchars(strip_tags(wordwrap($row['PREVIEW_TEXT'], 150, '   ')));
            $replace = '<abbr title="'.$row['PREVIEW_TEXT'].'">\\3</abbr>';
			if(trim($row['DETAIL_TEXT'])) {
			$text11 = TruncateText($row['DETAIL_TEXT'],50);
			$text11 = iconv("UTF-8", "Windows-1251", $text11);
			$text11 = iconv("Windows-1251", "UTF-8",  $text11);
			$replace = '<a class="tooltip" href="'.$row['DETAIL_PAGE_URL'].'">\\3<span class="classic">'.$text11."...".'</span></a>';}
            $flag = 0;
            foreach($new_terms as $key => $value)
            {
                if($flag) {
                    $termsAll[] = $value;
                    continue;
                }
                if(!in_array($value, $termsAll) && $value)
                {
                    //$text = preg_replace("/([^a-zA-Z0-9а-яА-Я<\/])".$value."([^a-zA-Z0-9а-яА-Я>\/])/iu", "\\1".$replace."\\2", $text);
                    $before = mb_strlen($text);

                    $text = preg_replace("/(>([^<]*?[^a-z0-9а-я<]*\s)?)(".$value.")(([^-a-z0-9а-я>][^>]*)?<(?(?=(<?\/?big>|<?\/?em>|<?\/?font>|<?\/?del>|<?\/?ins>|<?\/?kbd>|<?\/?samp>|<?\/?small>|<?\/?strike>|<?\/?wbr>|<?\/?nobr>|<?\/?sup>|<?\/?sub>|<?\/?span>|<?\/?s>|<?\/?q>|<?\/?i>|<?\/?u>|<?\/?strong>|<?\/?b>|[^<>])*<?\/a>)[^\/]))/i", "\\1".$replace."\\4", $text, 1);

                    $termsAll[] = $value;
                    if(mb_strlen($text) != $before) $flag=1;
                }
            }
        }
    }
    return $text;
}

////////////////

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterAddEventHandler");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterUpdateEventHandler");
AddEventHandler("iblock", "OnAfterIBlockElementDelete", "OnAfterDeleteEventHandler");

function OnAfterAddEventHandler(&$arFields){
	if($arFields["IBLOCK_ID"] == '13')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend.txt");
	elseif($arFields["IBLOCK_ID"] == '34')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend-org.txt");
	elseif($arFields["IBLOCK_ID"] == '58')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend-rl.txt");
    // Проставим свойство "EXPERT_FORUM"
    if($arFields["IBLOCK_ID"] == '91') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 91, 199, "EXPERT_FORUM");
    }
    if($arFields["IBLOCK_ID"] == '87') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 87, 204, "EXPERT_FORUM");
    }

    // Проставим свойство "В раздел Статьи"
    if($arFields["IBLOCK_ID"] == '90') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 90, 207, "TO_ARTICLES");
    }
    if($arFields["IBLOCK_ID"] == '92') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 92, 209, "TO_ARTICLES");
    }

    // Проставим свойство "FEATURES"
    if($arFields["IBLOCK_ID"] == '93') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 93, 213, "FEATURES");
    }
}
function OnAfterUpdateEventHandler(&$arFields){
	if($arFields["IBLOCK_ID"] == '13')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend.txt");
	elseif($arFields["IBLOCK_ID"] == '34')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend-org.txt");
	elseif($arFields["IBLOCK_ID"] == '58')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend-rl.txt");

    // Проставим свойство "EXPERT_FORUM"
    if($arFields["IBLOCK_ID"] == '91') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 91, 199, "EXPERT_FORUM");
    }
    if($arFields["IBLOCK_ID"] == '87') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 87, 204, "EXPERT_FORUM");
    }


// Проставим свойство "В раздел Статьи"
    if($arFields["IBLOCK_ID"] == '90') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 90, 207, "TO_ARTICLES");
    }

    if($arFields["IBLOCK_ID"] == '92') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 92, 209, "TO_ARTICLES");
    }

    // Проставим свойство "FEATURES"
    if($arFields["IBLOCK_ID"] == '93') {
        $ELEMENT_ID = $arFields["ID"];
        CIBlockElement::SetPropertyValues($ELEMENT_ID, 93, 213, "FEATURES");
    }
}
function OnAfterDeleteEventHandler(&$arFields){
	if($arFields["IBLOCK_ID"] == '13')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend.txt");
	elseif($arFields["IBLOCK_ID"] == '34')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend-org.txt");
	elseif($arFields["IBLOCK_ID"] == '58')
		unlink($_SERVER["DOCUMENT_ROOT"]."/bitrix/tools/calend-rl.txt");
}

/*// Добавляем к ЧПУ новостей произвольное 3-значное число - требование Гугл Новостей
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("MyClass", "beforeElementAdd"));
class MyClass
{
    function beforeElementAdd(&$arFields)
    {

        CModule::IncludeModule('iblock');

        if($arFields['IBLOCK_ID']==9){

          $arFields["CODE"] .= ('-'.rand(100, 999));

        }
    }
}*/


// запрет на удаление элементов со свойством SEO_MATERIAL
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("Class_Delete", "OnBeforeIBlockElementDeleteHandler"));

class Class_Delete
{
    function OnBeforeIBlockElementDeleteHandler($ID)
    {
		$res=CIBlockElement::GetById($ID);
		$arRes=$res->GetNext();
		if($arRes['IBLOCK_ID'])
		{
			$db_props = CIBlockElement::GetProperty($arRes['IBLOCK_ID'], $ID, array("sort" => "asc"), Array("CODE"=>"SEO_MATERIAL"));
			$ar_props = $db_props->Fetch();
			if ($ar_props["VALUE"]){
				global $APPLICATION;
				$APPLICATION->throwException("ЭТОТ МАТЕРИАЛ УЧАВСТВУЕТ В SEO-ПРОДВИЖЕНИИ. ЕГО УДАЛЕНИЕ ЗАПРЕЩЕНО. ЕСЛИ ВЫ ХОТИТЕ УДАЛИТЬ ЭЛЕМЕНТ, СНИМИТЕ ЧЕКБОКС: 'МАТЕРИАЛ ЯВЛЯЕТСЯ ПРОДВИГАЕМЫМ' В ФОРМЕ РЕДАКТИРОВАНИЯ ЭЛЕМЕНТА");
				return false;
			}
		}
	}
}

function getBannersKeywords()
{
    global $APPLICATION;
    if ($APPLICATION->GetCurPage() == '/daily/podvedeni-itogi-iii-mejdunarodnogo-foruma-vsya-bankovskaya-avtomatizaciya-2016/') return false;
    if ($APPLICATION->GetCurPage() == '/daily/obyavlena-programma-foruma-vsya-bankovskaya-avtomatizaciya-2016/') return false;
    if (!CModule::IncludeModule("advertising")) return false;
	//if ($_SERVER['SERVER_NAME']=="www.plusworld.ru") {}
	if ($_SERVER['SERVER_NAME']=="www.plusworld.ru") {$TYPE_ban="INTEXT_250x250";}
	elseif ($_SERVER['SERVER_NAME']=="www.plusworld.org"){$TYPE_ban="INTEXT_250x250_ORG";}
	elseif
	($_SERVER['SERVER_NAME']=="www.retail-loyalty.org")
	{
		if (strpos($_SERVER['REQUEST_URI'], '/en/')===false)
		{$TYPE_ban="INTEXT_250x250_RL_RU";}
		else
		{{$TYPE_ban="INTEXT_250x250_RL_EN";}}
	}
    $arFilter = Array("TYPE_SID"=>$TYPE_ban, "ACTIVE"=>"Y", "STATUS_SID"=>"PUBLISHED");

    $by="s_weight";
    $order="asc";
    $is_filtered=true;
    $keys = array();
    $uniq_keys = array();

    $rsBanners = CAdvBanner::GetList($by, $order, $arFilter, $is_filtered, "N");
    $curTime = strtotime(date("Y-m-d H:s:i"));
    while($arBanner = $rsBanners->NavNext(true, "f_"))
    {
        $rsBanner = CAdvBanner::GetByID($arBanner["ID"],"N");
        $arBannerGet = $rsBanner->Fetch();
        $DATE_SHOW_FROM = strtotime($arBannerGet["DATE_SHOW_FROM"]);
        $DATE_SHOW_TO = strtotime($arBannerGet["DATE_SHOW_TO"]);
        if (($DATE_SHOW_FROM<=$curTime)and($DATE_SHOW_TO>=$curTime)) {
            if ($arRes = array_filter(explode("\r\n", $arBannerGet["KEYWORDS"])))
            {
                foreach ($arRes AS $k=>$v)
                {
                    if (!in_array($v, $uniq_keys))
                    {
                        $uniq_keys[] = $v;
                        $keys[] = array("id"=>$arBanner["ID"] , "key" => $v);
                    }
                }
            }
        }
    }

    return $keys;
}

function markBannersKeywords($text, $keys)
{
    if (trim($text) == '') return false;
    if (empty($keys)) return $text;

    foreach($keys AS $k=>$v)
    {
        $replace = '<span class="padv" id="padv-'.$v['id'].'"><i>'.$v['key'].'</i></span>';

       //$text = preg_replace("/([^a-zA-Z0-9а-яА-Я])(".$v['key'].")([^a-zA-Z0-9а-яА-Я])/i", "\\1".$replace."\\3", $text);
      // $text = preg_replace("/[().!;:?%$=\-_#@*\[\]\{\} ]".$v['key']."[().!;:?%$=\-_#@*\[\]\{\} ]/i", "\\1".$replace."\\4", $text);
       //$text = preg_replace($v['key'].")(([^-a-z0-9а-я>][^>]*)?<(?(?=(<?\/?big>|<?\/?em>|<?\/?font>|<?\/?del>|<?\/?ins>|<?\/?kbd>|<?\/?samp>|<?\/?small>|<?\/?strike>|<?\/?wbr>|<?\/?nobr>|<?\/?sup>|<?\/?sub>|<?\/?span>|<?\/?s>|<?\/?q>|<?\/?i>|<?\/?u>|<?\/?strong>|<?\/?b>|[^<>])*<?\/a>)[^\/]))/i", "\\1".$replace."\\4", $text);
      // $text = preg_replace("/([>(]?([^<]*?[^a-zA-Z0-9а-яА-Я<]*\s)?)(".$v['key'].")(([^-a-z0-9а-я>][^>]*)?<(?(?=(<?\/?big>|<?\/?em>|<?\/?font>|<?\/?del>|<?\/?ins>|<?\/?kbd>|<?\/?samp>|<?\/?small>|<?\/?strike>|<?\/?wbr>|<?\/?nobr>|<?\/?sup>|<?\/?sub>|<?\/?span>|<?\/?s>|<?\/?q>|<?\/?i>|<?\/?u>|<?\/?strong>|<?\/?b>|[^<>])*<?\/a>)[^\/]))/i", "\\1".$replace."\\4", $text);
        $text = preg_replace("/(>([^<]*?[^a-z0-9а-я<]*\s)?)(".$v['key'].")(([^-a-z0-9а-я>][^>]*)?<(?(?=(<?\/?big>|<?\/?em>|<?\/?font>|<?\/?del>|<?\/?ins>|<?\/?kbd>|<?\/?samp>|<?\/?small>|<?\/?strike>|<?\/?wbr>|<?\/?nobr>|<?\/?sup>|<?\/?sub>|<?\/?span>|<?\/?s>|<?\/?q>|<?\/?i>|<?\/?u>|<?\/?strong>|<?\/?b>|[^<>])*<?\/a>)[^\/]))/i", "\\1".$replace."\\4", $text, 1, $count);
        //$text = preg_replace("/(".$v['key'].")/si",$replace,$text);
        //$text = str_replace($v['key'], $replace, $text);

    }
    return $text;
}


/**
 * Удалить из GET параметр SHOWALL (отображает все элементы на 1 странице)
 * почти всегда это приводит к полному зависанию сервака
 */
/*function clearShowAll()
{
  if(!empty($_GET))
    foreach ($_GET as $key => $value)
    {
      if(strpos($key, 'SHOWALL') === 0)
        unset($_GET[$key]);
    }
}
AddEventHandler("main", "OnBeforeProlog", "clearShowAll");*/


$pos = strpos($_SERVER['SERVER_NAME'], 'ceteralabs');

if ($pos === false) {
    function xml2array($url, $get_attributes = 1, $priority = 'tag')
    {
        $contents = "";
        if (!function_exists('xml_parser_create'))
        {
            return array ();
        }
        $parser = xml_parser_create('');
        if (!($fp = @ fopen($url, 'rb')))
        {
            return array ();
        }
        while (!feof($fp))
        {
            $contents .= fread($fp, 8192);
        }
        fclose($fp);
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);
        if (!$xml_values)
            return; //Hmm...
        $xml_array = array ();
        $parents = array ();
        $opened_tags = array ();
        $arr = array ();
        $current = & $xml_array;
        $repeated_tag_index = array ();
        foreach ($xml_values as $data)
        {
            unset ($attributes, $value);
            extract($data);
            $result = array ();
            $attributes_data = array ();
            if (isset ($value))
            {
                if ($priority == 'tag')
                    $result = $value;
                else
                    $result['value'] = $value;
            }
            if (isset ($attributes) and $get_attributes)
            {
                foreach ($attributes as $attr => $val)
                {
                    if ($priority == 'tag')
                        $attributes_data[$attr] = $val;
                    else
                        $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                }
            }
            if ($type == "open")
            {
                $parent[$level -1] = & $current;
                if (!is_array($current) or (!in_array($tag, array_keys($current))))
                {
                    $current[$tag] = $result;
                    if ($attributes_data)
                        $current[$tag . '_attr'] = $attributes_data;
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    $current = & $current[$tag];
                }
                else
                {
                    if (isset ($current[$tag][0]))
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                        $repeated_tag_index[$tag . '_' . $level]++;
                    }
                    else
                    {
                        $current[$tag] = array (
                            $current[$tag],
                            $result
                        );
                        $repeated_tag_index[$tag . '_' . $level] = 2;
                        if (isset ($current[$tag . '_attr']))
                        {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                    }
                    $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                    $current = & $current[$tag][$last_item_index];
                }
            }
            elseif ($type == "complete")
            {
                if (!isset ($current[$tag]))
                {
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $attributes_data)
                        $current[$tag . '_attr'] = $attributes_data;
                }
                else
                {
                    if (isset ($current[$tag][0]) and is_array($current[$tag]))
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                        if ($priority == 'tag' and $get_attributes and $attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag . '_' . $level]++;
                    }
                    else
                    {
                        $current[$tag] = array (
                            $current[$tag],
                            $result
                        );
                        $repeated_tag_index[$tag . '_' . $level] = 1;
                        if ($priority == 'tag' and $get_attributes)
                        {
                            if (isset ($current[$tag . '_attr']))
                            {
                                $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                                unset ($current[$tag . '_attr']);
                            }
                            if ($attributes_data)
                            {
                                $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                    }
                }
            }
            elseif ($type == 'close')
            {
                $current = & $parent[$level -1];
            }
        }
        return ($xml_array);
    }


    $dateVal = 0;
    $xml_file = $_SERVER['DOCUMENT_ROOT']."/bitrix/cache/currency_rates.xml";
    if (filemtime($xml_file)+3600*6 < time() OR !file_exists($xml_file)) { // ????????? ?????????? ?????? 6 ?????
        $xml_data = file_get_contents("http://www.cbr.ru/scripts/XML_daily.asp");
        $xml_data = iconv('windows-1251', 'utf-8', $xml_data);

        if ($xml_data) {


            file_put_contents($xml_file, $xml_data);
            $data = xml2array($xml_file);
            $data_values = array();
            foreach ($data['ValCurs']['Valute'] as $valute) {
                $data_values[$valute['CharCode']] = $valute['Nominal'];
                $data_nominal[$valute['CharCode']] = $valute['Value'];
            }
            $dateVal = $data['ValCurs_attr']['Date'];
            if (CModule::IncludeModule("currency") /*AND date("N") != 6 AND date("N") != 7*/ AND $data) { // ?? ????????? ???? ????? ?? ????????

                $currencies = array();
                $rsCurrency = CCurrency::GetList($by, $order);
                $base_currency = CCurrency::GetBaseCurrency();
                while ($arCurrency = $rsCurrency->GetNext()) {
                    if ($arCurrency['CURRENCY'] != $base_currency) {
                        $arCurrency['TIMESTAMP'] = MakeTimeStamp($arCurrency['DATE_UPDATE'], "YYYY-MM-DD HH:MI:SS");
                        $data_nominal[$arCurrency['CURRENCY']] = str_replace (",", ".", $data_nominal[$arCurrency['CURRENCY']]);

                        $arFilter = array(
                            'CURRENCY' => $arCurrency['CURRENCY'],
                            'DATE_RATE' => $data['ValCurs_attr']['Date'],
                            'RATE_CNT' => $data_values[$arCurrency['CURRENCY']],
                            'RATE' => floatval($data_nominal[$arCurrency['CURRENCY']]),
                        );
                        $r = CCurrencyRates::Add($arFilter);

                    }
                }
            }
        }
    }

    /**
     * composer autoloader
     * конфигурация - ./include/composer.json
     * после внесения изменений в конфигурацию выполнить php composer.phar install
     * @link https://getcomposer.org/
     */
    /* @noinspection PhpIncludeInspection */
    require(__DIR__ . "/include/vendor/autoload.php");
}


function pluralMain($n, $form1, $form2, $form5)
{
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $form5;
    if ($n1 > 1 && $n1 < 5) return $form2;
    if ($n1 == 1) return $form1;
    return $form5;
}
?>
