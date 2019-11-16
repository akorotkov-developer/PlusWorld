<?

if ( !defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) 
{
	die();
}

if ( file_exists($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/payonline/payment/payonline/.description.php') )
{
	include($_SERVER['DOCUMENT_ROOT'] .'/bitrix/modules/payonline/payment/payonline/.description.php');
}