<?php

// REV. 20140826
require_once "Z:/home/gapireport.local/php/gapi.class.php";

abstract class RequestGA
{
    protected static $gaLogin = "YOUR_LOGIN";
    protected static $gaPass = "YOUR_PASSWORD";
    protected static $gaID = "YOUR_GA_ID";

    protected static $ga;

    public function __construct()
    {
        self::$ga = new gapi(self::$gaLogin, self::$gaPass);
    }
}

?>