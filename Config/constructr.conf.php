<?php 

    /*
     * CONSTRUCTR MAIN AND ONLY ONE CONFIGURATION FILE
     */

    // CONSTRUCTR DATABASE SETTINGS    
    define('_CONSTRUCTR_DATABASE_HOST','');
    define('_CONSTRUCTR_DATABASE_NAME','');
    define('_CONSTRUCTR_DATABASE_USER','');
    define('_CONSTRUCTR_DATABASE_PASSWORD','');

    // CONSTRUCTR ENCRYPTION AVAILABLE?
    if(!defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH)
    {
        echo 'CRYPT_BLOWFISH ist nicht verf&uuml;gbar!';
        die();
    }

    // MINIMAL PHP-VERSION 5.3.x AVAILABLE?
    if (version_compare(phpversion(),'5.3.0','<='))
    {
        echo 'PHP ist kleiner als Version 5.3.0';
        die();
    }

    // MAIN CONFIGURATION ARRAY
    $_CONSTRUCTR_CONF = array(
        '_CONSTRUCTR_DATABASE_HOST' => '',
        '_CONSTRUCTR_DATABASE_NAME' => '',
        '_CONSTRUCTR_DATABASE_USER' => '',
        '_CONSTRUCTR_DATABASE_PASSWORD' => '',
        '_BASE_URL' => 'http://' . $_SERVER['HTTP_HOST'],
        '_VERSION' => '20140612',
        '_SALT' => '$2y$07$R.gJb2U2N.FmZ4hPp1y2CN$',
        '_SECRET' => 'h5/823!65$%4jc/)$3_fè4()480HD3d',
        '_CONSTRUCTR_COOKIE_LIFETIME' => '8 hours',
        '_LOGGING' => true,
        '_TITLE' => 'CONSTRUCTR',
        '_EXT_WWW' => '',
        '_SERVE_STATIC' => true,
        '_CREATE_STATIC' => true,
        '_STATIC_DIR' => './Static',
        '_CONSTRUCTR_BACKEND' => './Constructr',
        '_CONSTRUCTR_LOGFILES_PATH' => './Logfiles',
        '_CONSTRUCTR_LOG_ENABLED' => true,
        '_CONSTRUCTR_MODE' => 'development',
        '_CONSTRUCTR_DEBUG_MODE' => true,
        '_CONSTRUCTR_SESSION_NAME' => 'constructr-sssession',
        '_CONSTRUCTR_INCLUDR' => true
    );