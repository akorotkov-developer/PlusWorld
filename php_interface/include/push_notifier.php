<?
date_default_timezone_set('Europe/Moscow');

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/ApnsPHP/Autoload.php';


function SendNotify($arFields)
{
    global $DB;
    // Instanciate a new ApnsPHP_Push object
    $push = new ApnsPHP_Push(
    	ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,//ENVIRONMENT_SANDBOX ENVIRONMENT_PRODUCTION
    	$_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/ApnsPHP/server_certificates_bundle_sandbox.pem'
    );


    // Set the Root Certificate Autority to verify the Apple remote peer
    $push->setRootCertificationAuthority($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/ApnsPHP/entrust_root_certification_authority.pem');

    $strSql = "SELECT * FROM tokens WHERE ACTIVE =  '1' ";

	$res = $DB->Query($strSql, false, __LINE__);


    // Connect to the Apple Push Notification Service
    $push->connect();

    while($arResult = $res->GetNext()):
        // Instantiate a new Message with a single recipient
        $message = new ApnsPHP_Message($arResult['TOKEN']);

        // Set a custom identifier. To get back this identifier use the getCustomIdentifier() method
        // over a ApnsPHP_Message object retrieved with the getErrors() message.
        $message->setCustomIdentifier("Message-Badge-1");

        // Set badge icon to "3"
        $message->setBadge(1);

        // Set a simple welcome text
        $message->setText('New element added ID '.$arFields["ID"]);

        // Play the default sound
        $message->setSound();

        // Set a custom property
        $message->setCustomProperty('acme2', array('bang', 'whiz'));


        // Set the expiry value to 30 seconds
        $message->setExpiry(30);

        // Add the message to the message queue
        $push->add($message);

    endwhile;

    // Send all messages in the message queue
    $push->send();

    // Disconnect from the Apple Push Notification Service
    $push->disconnect();

    // Examine the error message container
    $aErrorQueue = $push->getErrors();
    if (!empty($aErrorQueue)) {
        wl($aErrorQueue, 1);
    }

}