<?php
AddEventHandler("main", "OnBeforeProlog", "MyUserOnline");
function MyUserOnline()
{
    if($GLOBALS["USER"]->IsAuthorized())
        \CUser::SetLastActivityDate($GLOBALS["USER"]->GetID());

    /*
     * Проверяем Гугл reCaptcha
     */
/*    $context = \Bitrix\Main\Application::getInstance()->getContext();

    $request = $context->getRequest();
    $captchaResponse = $request->getPost("g-recaptcha-response");

    if($captchaResponse)
    {
        if(!\GoogleReCaptcha::checkClientResponse())
        {
            $captchaSid = $request->getPost("captcha_sid");
            if($captchaSid)
            {
                //Т.к. нет API, позволяющего получить слово капчи по ID, делаем запрос напрямую к БД
                $dbRes = \Bitrix\Main\Application::getConnection()->query("SELECT CODE FROM b_captcha WHERE id='".$captchaSid."'");
                if($res = $dbRes->fetch())
                {
                    if($res['CODE'])
                    {
                        $_REQUEST['captcha_word'] = $_POST['captcha_word'] = $res['CODE'];
                    }
                }
            }
        }
    }*/
}