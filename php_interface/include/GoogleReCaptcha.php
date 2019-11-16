<?
class GoogleReCaptcha
{
    public static function getPublicKey() { return '6Lc2s64UAAAAAGUUj-rA8KWkeHhS0SwE_byZQLPT';}
    public static function getSecretKey() { return '6Lc2s64UAAAAANl9zGNQ6WaGALS9p2jai5lgyT0v';}

    /**
     * @return array - if validation is failed, returns an array with errors, otherwise - empty array. This format is expected by component.
     */

    public static function checkClientResponse()
    {
        $context = \Bitrix\Main\Application::getInstance()->getContext();

        $request = $context->getRequest();
        $captchaResponse = $request->getPost("g-recaptcha-response");

        if($captchaResponse)
        {
            $url = ' https://www.google.com/recaptcha/api/siteverify ';
            $data = array('secret' => static::getSecretKey(), 'response' => $captchaResponse);
            $httpClient = new HttpClient();
            $response = $httpClient->post($url,$data);

            if($response)
                $response = \Bitrix\Main\Web\Json::decode($response,true);

            if(!$response['success']) {
                return $response['error-codes'];
            }

            return array();
        }
        return array('Подтвердите, что вы не робот');
  }
}