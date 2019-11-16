<?

if (isMobile() && substr($_SERVER['REQUEST_URI'],0,3) != '/m/' && $_SERVER['SERVER_NAME'] != 'www.retail-loyalty.org' && $_SERVER['SERVER_NAME'] != 'market.plusworld.ru')
{
    setcookie("mobile", "1", time()+3600,"/");
    header("Location:/m".$_SERVER['REQUEST_URI']);die();
}

function isMobile(){

    if (isset($_REQUEST['no_mobile']) || substr($_SERVER['REQUEST_URI'],0,8) == '/bitrix/')
    {
        setcookie("mobile", "0", time()+3600,"/");
        return false;
    }
    elseif (isset($_COOKIE['mobile']) && $_COOKIE['mobile'] == '1' ||
        substr($_SERVER['REQUEST_URI'],0,3) == '/m/')
    {
        return true;
    }
    elseif (isset($_COOKIE['mobile']) && $_COOKIE['mobile'] == '0')
    {
        return false;
    }


    include_once("Detector.php");
    $detector = new Yandex_Detector();

    if($detector->detect())
    {
        setcookie("mobile", "1", time()+3600,"/");
        return  true;
    }
    else
    {
        setcookie("mobile", "0", time()+3600,"/");
        return false;
    }
}
?>