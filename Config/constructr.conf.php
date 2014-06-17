<?php 

    /*
     * CONSTRUCTR MAIN CONFIGURATION FILE - HANDLE WITH CARE!!!
     */

    // CONSTRUCTR ENCRYPTION AVAILABLE?
    if(!defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH)
    {
        echo 'Fehler CRYPT_BLOWFISH ist nicht verf&uuml;gbar!';
        die();
    }

    // MINIMAL PHP-VERSION 5.3.x AVAILABLE?
    if (version_compare(phpversion(),'5.3.0','<='))
    {
        echo 'PHP ist kleiner als Version 5.3.0';
        die();
    }

    $_CONSTRUCTR_CONF = array(
        '_CONSTRUCTR_DATABASE_HOST' => '', // DATABASE HOST localhost f.e.
        '_CONSTRUCTR_DATABASE_NAME' => '', // DATABASE NAME OF CONSTRUCTR INSTALLATION
        '_CONSTRUCTR_DATABASE_USER' => '', // DATABASE USER 
        '_CONSTRUCTR_DATABASE_PASSWORD' => '', // DATABASE PASSWORD
        '_BASE_URL' => 'http://' . $_SERVER['HTTP_HOST'], // INSTALLATION BASE_URL FOR FILE REFERENCIES AND ROUTING 'http://' . $_SERVER['HTTP_HOST']
        '_VERSION_DATE' => '20140617', // VERSION DATE OF CONSTRUCTR CMS
        '_VERSION' => '1.00.1', // VERSION OF CONSTRUCTR CMS
        '_SALT' => '', // SECURITY SALT
        '_SECRET' => '', // SECURITY SECRET
        '_CONSTRUCTR_COOKIE_LIFETIME' => '8 Hours', // COOKIE LIFETIME
        '_LOGGING' => true, // CONSTRUCTR LOGGING
        '_TITLE' => 'CONSTRUCTR', // BASE BACKEND TITLE
        '_EXT_WWW' => '', // ROUTING TO A SPECIAL FRONTEND
        '_TEMPLATES_DIR' => './Website-Template', // PUBLIC WEBSITE-TEMPLATE DIRECTORY
        '_SERVE_STATIC' => false, // OUTPUT ONLY STATIC GENERATED PAGES IN FRONTEND
        '_STATIC_DIR' => './Static', // DIRECTORY FOR STATIC OUTPUT
        '_CREATE_STATIC_DOMAIN' => '', // SET SPECIFIC DOMAIN FOR CREATION OF STATIC WEBPAGES / ./Website-Template create navigation logic
        '_MAGIC_GENERATION_KEY' => 'simsalabim', // MAGIC KEY FOR READING CONSTRUCTR FRONTEND OUTPUT - STATIC WEBPAGE GENERATION
        '_CONSTRUCTR_BACKEND' => './Constructr', // WHERE IS THE BACKEND LOCATED
        '_CONSTRUCTR_LOGFILES_PATH' => './Logfiles', // DIRECTORY FOR LOGFILES
        '_CONSTRUCTR_LOG_ENABLED' => true, // ENABLE LOG IN CONSTRUCTR APP
        '_CONSTRUCTR_MODE' => 'development', // CONSTRUCTR APP MODE f.e. development, production, ...
        '_CONSTRUCTR_DEBUG_MODE' => true, // ACTIVATE DEBUGGING IN CONSTRUCTR BACKEND
        '_CONSTRUCTR_SESSION_NAME' => 'constructr', // CONSTRUCTR APP SESSION NAME
    );