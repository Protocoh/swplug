<?php

namespace ModulesGarden\SWPlug;

class Registry
{
    private static $appConfig = [];
    
    public static function init()
    {
        self::define("DS", DIRECTORY_SEPARATOR);
        self::define("WHMCS_MAIN_DIR", dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR);
        self::define("GATEWAYS_MAIN_DIR", dirname(__DIR__));
        self::define("GATEWAY_ASSETS_DIR", "./modules/gateways/SWPlug/App/Assets");
        self::define("CLIENTAREA", true);
    }
    
    public static function getAll()
    {   
        return self::$appConfig;
    }
    
    public static function define($key, $value)
    {
        if(array_key_exists($key, self::$appConfig))
        {
            return;
        }
        
        self::$appConfig[$key] = $value;
        
        if(defined($key))
        {
            return;
        }
        
        define($key, $value);
    }
}
