<?php
// This is our config class. This file contains the SQL passwords and API keys and the version of the app. 
// You can add other things as needed here as well. Make sure to update the details inside of here, if you update the apps keys/passwords, or are just cloning from git yourself.
class Config
{
    use Singleton;

    /* MYSQL CONNECTION */
    private static $SQL = [
        'user' => 'sxtdbu_devapp',
        'pass' => '7c664c0578db69c2',
        'default_database' => 'sxtdb_devapp',
    ];

    // App version. Remember to change this when you update your app, to not have caching of your assets be messed up.
    private static $Version = '1.0.0';
    // Is the app in development?
    private static $InDevelopment = true;

    // Stavox API key
    private static $SxApiKey = '879c8dc95b595090513f770a7e111a281c48d9fc862b32905bae707d67c245f646708eacdedeb23225ec55dc38c7acfd53a840e77e9952654a8056466dbcb3c8';

    // Everything below is simply some functions to get the data out from this file

    public function getSQL()
    {
        return self::$SQL;
    }

    public function getSXApiKey()
    {
        return self::$SxApiKey;
    }

    public function getVersion()
    {
        if (self::$InDevelopment) {
            $this->Version = bin2hex(random_bytes(8));
        }

        return $this->Version;
    }

    public function isDevelopment()
    {
        return self::$InDevelopment;
    }
    public function getVer()
    {
        return self::$Version;
    }
}
