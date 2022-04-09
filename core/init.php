<?php
session_start(); // Starting the session.

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1', // If we use "localhost" we would also need to do a DNS lookup, which increases time for page to be loaded.
        'username' => 'root', // Default MySQL DB username.
        'password' => '', // Default MySQL DB has no password.
        'db' => 'prj010' // This is the name of a database we are connecting to.
    ), // MySQL settings.
    'remember' => array(
        'cookie_name' => 'hash', // You may call it the way you want.
        'cookie_expiry' => 604800 // We need to use seconds here. 604800 seconds equals 1 week. Just go to google and search how long in seconds is day, week, or month, etc.
    ), // Cookie name, cookie expiration data if we want to know for holng users can be remembered for if they check that little box on the login page.
    'session' => array(
        'session_name' => 'user'
    ) // Session name and the token we use.
);

// Because we work with lots of different classes, we want to autoload them to simplify inclusions when they are actually required.

// Usually we do it like this (see below), including everything we want in this init.php file, which we don't want to do. Also it will be difficalt to maintain.
// require_once 'classes/config.php';
// require_once 'classes/cookie.php';
// require_once 'classes/db.php';

// Instead we will use this:
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

// This one we inclued separately because it is stored in different folder.
require_once 'functions/sanitize.php';