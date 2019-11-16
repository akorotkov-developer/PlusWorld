<?php
use Bitrix\Main\Loader;

Loader::registerAutoloadClasses(
    "plus.csv",
    array(
        "plus\\csv\\WorkWithSubscribe" => "lib/workwithsubscribe.php",
    )
);
?>