<?php

!defined("D2LWS_MANUAL_AUTOLOADER") && define("D2LWS_MANUAL_AUTOLOADER", true);
require_once __DIR__ . "/../../library/D2LWS/Instance.php";

try
{
    new D2LWS_Grade_Object_Model();
    echo '<h1>Autoloader Configured Properly</h1>';
}
catch ( Exception $ex )
{
    echo '<h1>Autoloader Not Configured Properly</h1>';
    echo '<pre>';
    var_dump($ex);
    echo '</pre>';
}