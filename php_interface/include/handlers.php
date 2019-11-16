<?php
define('IBLOCK_ID_PARAMS_BANNERS_ADFOX', 116); // Инфоблок с параметрами для баннеров AdFox
define('ID_PARAMS_BANNERS_ADFOX', 2902957); // Элемент с параметрами для баннеров AdFox

AddEventHandler("main", "OnBeforeUserRegister", Array("OnBeforeUserRegisterClass", "OnBeforeUserRegisterHandler"));
class OnBeforeUserRegisterClass
{
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        $arFields["ACTIVE"] = "Y";

    }
}


AddEventHandler("main", "OnEndBufferContent", "deleteKernelCss");
AddEventHandler("main", "OnEndBufferContent", "deleteKernelJs");

//Заменяем все капчи на Гугл reCaptcha
/*AddEventHandler("main", "OnEndBufferContent", "changeCaptcha");
function changeCaptcha(&$content)
{
    global $APPLICATION;
    $curPage = $APPLICATION->GetCurPage();
    if ($curPage != "/bitrix/admin/") {
        //Для форм загружаемых по ajax добавляем вызов скрипта рендера рекапчи
        $renderScript = "";
        $htmlId = "";
        $context = \Bitrix\Main\Application::getInstance()->getContext();
        $request = $context->getRequest();

        if ($request->isAjaxRequest()) {
            $id = uniqid('r_');
            $renderScript = "<script>renderRecaptcha('$id');</script>";
            $htmlId = 'id="' . $id . '"';
        }

        //Убираем  поля для ввода слова
        $content = preg_replace('/<input[^<>]*name\s?=\s?.captcha_word.[^<>]*>/', '', $content);

        //Все изображения заменяем на рекапчу
        $content = preg_replace('/<img[^<>]*src\s?=\s?.\/bitrix\/tools\/captcha\.php\?(captcha_code|captcha_sid)=[^<>]*>/', "<div data-callback='onSubmitReCaptcha' class='g-recaptcha' data-sitekey='" . GoogleReCaptcha::getPublicKey() . "' " . $htmlId . "></div>" . $renderScript, $content);
    }
}*/

AddEventHandler("main", "OnBeforeUserLogin", Array("CheckAuthUsers", "OnBeforeUserLoginHandler"));
class CheckAuthUsers
{
    // создаем обработчик события "OnBeforeUserLogin"
    function OnBeforeUserLoginHandler(&$arFields)
    {
        //Получаем ID текщего пользователя
        $filter = Array(
            "LOGIN" => $arFields["LOGIN"],
        );
        $arSel = array(
            "ID",
            "UF_CHECKUSER"
        );
        $rsUsers = CUser::GetList(($by="name"), ($order="asc"), $filter, array("SELECT"=>$arSel)); // выбираем пользователей
        while($arr = $rsUsers->GetNext()) :
            $userID = $arr['ID'];
            if ($arr["UF_CHECKUSER"]) {
                $checkUser = $arr["UF_CHECKUSER"];
            }
        endwhile;

        $checkUser = (int)$checkUser;
        if ($checkUser > 0) {
            //Проверяем в той ли группе пользователь
            $arGroups = CUser::GetUserGroup($userID);
            if (in_array(13, $arGroups)) {

                //Получаем пользователей онлайн
                $by = "s_last_date";
                $order = "desc";
                $db = CUser::GetList($by, $order, array("LAST_ACTIVITY" => 3600));
                while ($dba = $db->Fetch()) {
                    $usersOnlinep[] = $dba['ID'];
                }

                //Проверяем онлайн пользователь или нет
                if (in_array($userID, $usersOnlinep)) {
                    //Проверяем в той ли группе пользователь
                    global $APPLICATION;
                    $APPLICATION->throwException("Вы уже авторизованы на другом устройстве. Следующая попытка авторизации будет доступна через час.");
                    return false;
                }
            }
        }

        //Авторизуем пользователя по e-mail
        //Получаем ID текщего пользователя
        $login = $arFields["LOGIN"];
        if (preg_match("/[0-9a-z]+@[a-z]/", $login)) {
            $filter = Array(
                "EMAIL" => $arFields["LOGIN"],
            );
            $arSel = array(
            );
            $rsUsers = CUser::GetList(($by="name"), ($order="asc"), $filter, array("SELECT"=>$arSel)); // выбираем пользователей
            while($arr = $rsUsers->GetNext()) :
                $userLogin = $arr["LOGIN"];
            endwhile;

            $arFields["LOGIN"] = $userLogin;
        }
    }
}

AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("RLHandler", "OnBeforeIBlockElementDeleteHandler"));

class RLHandler
{
    function OnBeforeIBlockElementDeleteHandler($ID)
    {
        if($ID==ID_PARAMS_BANNERS_ADFOX)
        {
            global $APPLICATION;
            $APPLICATION->throwException(" Настройки баннеров AdFox.<br> Данный элемент, удалять нельзя! ");
            return false;
        }
    }
}

/*function deleteKernelJs(&$content)
{
    global $USER;
    global $APPLICATION;
    $posBitrix = strpos($APPLICATION->GetCurPage(), '/bitrix/');
    if ((!$USER->IsAuthorized()) and ($posBitrix === false) and ($APPLICATION->GetCurPage() == '/')) {
        $arPatternsToRemove = Array(
            '/<script.+?src=".+?kernel_main\/kernel_main\.js\?\d+"><\/script\>/',
            '/<script.+?src=".+?bitrix\/js\/main\/core\/core[^"]+"><\/script\>/',
            '/<script.+?>BX\.(setCSSList|setJSList)\(\[.+?\]\).*?<\/script>/',
            '/<script.+?>if\(\!window\.BX\)window\.BX.+?<\/script>/',
            '/<script[^>]+?>\(window\.BX\|\|top\.BX\)\.message[^<]+<\/script>/',
        );

        $content = preg_replace($arPatternsToRemove, "", $content);
        $content = preg_replace("/\n{2,}/", "\n\n", $content);
    }
}

function deleteKernelCss(&$content)
{
    global $USER;
    global $APPLICATION;
    $posBitrix = strpos($APPLICATION->GetCurPage(), '/bitrix/');
    if ((!$USER->IsAuthorized()) and ($posBitrix === false)) {
        $arPatternsToRemove = Array(
            '/<link.+?href=".+?kernel_main\/kernel_main\.css\?\d+"[^>]+>/',
            '/<link.+?href=".+?bitrix\/js\/main\/core\/css\/core[^"]+"[^>]+>/',
            '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/styles.css[^"]+"[^>]+>/',
            '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/template_styles.css[^"]+"[^>]+>/',
            '/<link.+?href=".+?main\/popup.min\.css\?\d+"[^>]+>/',
        );

        $content = preg_replace($arPatternsToRemove, "", $content);
        $content = preg_replace("/\n{2,}/", "\n\n", $content);
    }
}*/
?>