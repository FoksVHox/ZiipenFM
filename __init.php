<?php
// This file defines our used traits and autoloading for our classes, and should be included in all other PHP files in the project.

// Singleton trait for classes. Read here for more info on Singleton patterns in PHP https://stackoverflow.com/a/24852235
trait Singleton 
{
    private static $instance;
    
    private final function __construct() {}
    private final function __clone() {}
    private final function __wakeup() {}
    
    public final static function i()
    {
        if(!self::$instance) {
            self::$instance = new self;    
        }
        
        return self::$instance;
    }
}

// Set our timezone
date_default_timezone_set('Europe/Copenhagen');

// Register the class autoloading function
spl_autoload_register(function ($class_name) {
    include 'classes/' . strtolower($class_name) . '.php';
});

// Cookie parameters
session_set_cookie_params(
    0, // Time
    '/', // Location
    $_SERVER['HTTP_HOST'], // Domain
    1, // Secure
    1 // Httponly
);

// Create new session
if (!isset($_SESSION)) {
    session_name('SXAPP_SESSION');
    session_start();
}

// If app is in development, echo all errors
if (Config::i()->isDevelopment()) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

SQL::i()->MakeTable('CREATE TABLE if not exists `Programs` (
	`ID` INT NOT NULL AUTO_INCREMENT,
	`Name` VARCHAR(50) NOT NULL,
	`Host` TEXT NOT NULL,
	`SmallDescription` VARCHAR(190) NOT NULL,
	`Description` TEXT NOT NULL,
	`Icon` INT,
	`When` TEXT,
	PRIMARY KEY (`ID`)
);');