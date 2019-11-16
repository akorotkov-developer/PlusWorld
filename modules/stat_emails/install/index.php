<?
global $MESS;
$PathInstall = str_replace("\\", "/", __FILE__);
$PathInstall = substr($PathInstall, 0, strlen($PathInstall) - strlen("/index.php"));
IncludeModuleLangFile($PathInstall . "/install.php");

if(class_exists("stat_emails")) return;

Class stat_emails extends CModule
{
  var $MODULE_ID = "stat_emails";
  var $MODULE_VERSION;
  var $MODULE_VERSION_DATE;
  var $MODULE_NAME;
  var $MODULE_DESCRIPTION;
  var $MODULE_GROUP_RIGHTS = "Y";

  function stat_emails()
  {
    $this->MODULE_VERSION = '1.0.0';
    $this->MODULE_VERSION_DATE = '2012-07-27';
    $this->MODULE_NAME = "Статистика открытых писем";
    $this->MODULE_DESCRIPTION = '';
  }

  function DoInstall()
  {
    global $DOCUMENT_ROOT, $APPLICATION;
    //$this->InstallFiles();
    RegisterModule("stat_emails");

    //$APPLICATION->IncludeAdminFile("Установка модуля stat_emails", $DOCUMENT_ROOT . "/bitrix/modules/stat_emails/install/step.php");
  }


  function InstallFiles($arParams = array())
  {

    CopyDirFiles($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/stat_emails/install/admin', $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin', true, true);
    CopyDirFiles($_SERVER['DOCUMENT_ROOT'].'/local/modules/stat_emails/install/admin', $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin', true, true);

    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/stat_emails/install/images",  $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/stat_emails", true, true);
    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/stat_emails/install/images",  $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/stat_emails", true, true);

    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/stat_emails/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes", true, true);
    CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/stat_emails/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes", true, true);

    //CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/stat_emails/install/components", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/ru.cetera/", true, true);
    return true;
  }

  function UnInstallFiles()
  {
    //DeleteDirFilesEx("/bitrix/components/ru.cetera/");
    return true;
  }

  function DoUninstall()
  {
    global $DOCUMENT_ROOT, $APPLICATION;
    //$this->UnInstallDB();
    //$this->UnInstallFiles();
    UnRegisterModule("stat_emails");

    DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/stat_emails/install/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin");
    //DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/local/modules/stat_emails/install/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin");

    //DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/stat_emails/install/themes/.default/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes/.default"); //css
    //DeleteDirFilesEx("/bitrix/themes/.default/icons/stat_emails/"); //icons

    DeleteDirFilesEx("/bitrix/images/stat_emails/"); //images

    /*unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/stat_emails.php');
    unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/stat_emails.css');
    unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/icons/stat_emails/icon_18.jpg');
    unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/icons/stat_emails/icon_32.jpg');*/

    //$APPLICATION->IncludeAdminFile("Деинсталляция модуля stat_emails", $DOCUMENT_ROOT . "/bitrix/modules/stat_emails/install/unstep.php");
  }

  function UnInstallDB()
  {
    global $DB, $DBType, $APPLICATION;
    $this->errors = false;

    $this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/stat_emails/install/db/" . $DBType . "/uninstall.sql");

    if($this->errors !== false)
    {
      $APPLICATION->ThrowException(implode("", $this->errors));
      return false;
    }

    return true;
  }
}

?>