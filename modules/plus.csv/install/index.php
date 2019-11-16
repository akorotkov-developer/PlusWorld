<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if(class_exists("plus_csv"))
	return;

Class plus_csv extends CModule
{
	var $MODULE_ID = "plus.csv";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_GROUP_RIGHTS = "Y";

	function plus_csv()
	{
		$arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)){
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }else{
            $this->MODULE_VERSION=TASKFROMEMAIL_MODULE_VERSION;
            $this->MODULE_VERSION_DATE=TASKFROMEMAIL_MODULE_VERSION_DATE;
        }

        $this->MODULE_NAME = Loc::getMessage("PLUS_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("PLUS_MODULE_DESCRIPTION");
        
        $this->PARTNER_NAME = Loc::getMessage("PLUS_PARTNER_NAME");
        $this->PARTNER_URI  = "http://cetera.ru/";
	}
	
	function DoInstall()
	{
		if (!IsModuleInstalled("plus.csv"))
		{
			$this->InstallFiles();
		}

		//Проверяем есть ли почтовое событие, если нет то создаем
		$arFilter = array(
			"TYPE_ID" => "ADD_NEW_SUBSCRIBE_USER",
			"LID"     => "ru"
			);
		$rsET = CEventType::GetList($arFilter);

		while ($arET = $rsET->Fetch())
		{
			$ID_MAIL_TAMPLATE = $arET["ID"];
		}

		if ($ID_MAIL_TAMPLATE == "") {
			$obEventType = new CEventType;
			$obEventType->Add(array(
				"EVENT_NAME"    => "ADD_NEW_SUBSCRIBE_USER",
				"NAME"          => "Создан новый подписчик",
				"LID"       	=> "ru"
				));
				


			$arLid = array();
			$rsSites = CSite::GetList($by="sort", $order="desc", Array("ACTIVE" => "Y"));
			while ($arSite = $rsSites->Fetch())
			{
				$arLid[] = $arSite["LID"];
			}	
				
			$arr["ACTIVE"] = "Y";
			$arr["EVENT_NAME"] = "ADD_NEW_SUBSCRIBE_USER";
			$arr["LID"] = $arLid;
			$arr["EMAIL_FROM"] = "#DEFAULT_EMAIL_FROM#";
			$arr["EMAIL_TO"] = "#EMAIL_TO#";
			$arr["SUBJECT"] = "Подписка на рассылки";
			$arr["MESSAGE"] = "Ваш email: #USER_TO# был подписан на рассылку.
			#MESSAGE#
			";

			$emess = new CEventMessage;
			$emess->Add($arr);		
		} 

		return true;
	}

	function DoUninstall()
	{
	
		//Ищем почтовый шаблон привязанный к почтовому событию ADD_NEW_SUBSCRIBE_USER и удаляем
		$arLid = array();
		$rsSites = CSite::GetList($by="sort", $order="desc", Array("ACTIVE" => "Y"));
		while ($arSite = $rsSites->Fetch())
		{
			$arLid[] = $arSite["LID"];
		}		
		$arFilter = Array(
			"TYPE_ID"       => array("ADD_NEW_SUBSCRIBE_USER"),
		);

		$rsMess = CEventMessage::GetList($by=$arLid, $order="desc", $arFilter);

		$ID_MAIL_TEMPLATE;
		while($arMess = $rsMess->GetNext())
		{
			$ID_MAIL_TEMPLATE = $arMess["ID"];
		}	
			
		if(intval($ID_MAIL_TEMPLATE)>0)
		{
			$emessage = new CEventMessage;
			$emessage->Delete(intval($ID_MAIL_TEMPLATE));
		}

		// Ищем и удаляем почтовое событие
		$arFilter = array(
			"TYPE_ID" => "ADD_NEW_SUBSCRIBE_USER",
			"LID"     => "ru"
			);
		$rsET = CEventType::GetList($arFilter);

		while ($arET = $rsET->Fetch())
		{
			$ID_EVENT = $arET["ID"];
		}

		$event_i = new CEventType;
		$event_i->Delete("ADD_NEW_SUBSCRIBE_USER"); 
	
		$this->UnInstallFiles();			
		return true;
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/plus.csv/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
		
		RegisterModule("plus.csv");
		return true;
	}
	
	function UnInstallFiles()
	{	
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/plus.csv/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");

		UnRegisterModule("plus.csv");
		return true;
	}
}
?>