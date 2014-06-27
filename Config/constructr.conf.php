<?php 

    /*
     * 
     * CONSTRUCTR MAIN CONFIGURATION FILE - HANDLE WITH CARE!!!
     * 
     */
    $_CONSTRUCTR_CONF = array
    (
        '_CONSTRUCTR_DATABASE_HOST' => '', // DATABASE HOST - localhost

        '_CONSTRUCTR_DATABASE_NAME' => '', // DATABASE NAME OF CONSTRUCTR INSTALLATION

        '_CONSTRUCTR_DATABASE_USER' => '', // DATABASE USER

        '_CONSTRUCTR_DATABASE_PASSWORD' => '', // DATABASE PASSWORD

        '_BASE_URL' => 'http://' . $_SERVER['HTTP_HOST'], // INSTALLATION BASE_URL FOR FILE REFERENCIES AND ROUTING IN BACKEND  - (char) 'http://' . $_SERVER['HTTP_HOST']

        '_SESSION_CYPHER_METHOD' => MCRYPT_MODE_CBC, // SESSION CYPHER METHOD - (char) MCRYPT_MODE_CBC

        '_SALT' => '', // SECURITY SALT FOR CRYPTING USER PASSWORDS - CREATE YOUR OWN _SALT

        '_SECRET' => '', // COOKIE SECURITY SECRET - CREATE YOUR OWN _SECRET

        '_CONSTRUCTR_COOKIE_LIFETIME' => '1 Hour', // COOKIE LIFETIME - ENGLISH TIME PHRASE 1 Hour, 3 Hours, ...

        '_LOGGING' => true, // CONSTRUCTR LOGGING - (boolean) true|false

        '_TITLE' => 'CONSTRUCTR CMS', // BASE BACKEND TITLE - UPDATE FOR WHITE LABELING - (char) WHATEVER YOU WISH

        '_TEMPLATES_DIR' => './Website-Template', // PUBLIC WEBSITE-TEMPLATE DIRECTORY - (char) './Website-Template'

        '_CONSTRUCTR_BACKEND' => './Constructr', // WHERE IS THE BACKEND LOCATED - (char) './Constructr'

        '_CONSTRUCTR_LOGFILES_PATH' => './Logfiles', // DIRECTORY FOR LOGFILES - (char) './Logfiles'

        '_CONSTRUCTR_LOG_ENABLED' => true, // ENABLE LOG IN CONSTRUCTR APP - (boolean) true|false

        '_CONSTRUCTR_MODE' => 'development', // CONSTRUCTR APP MODE f.e. development, production - (char) WHATEVER YOU WISH

        '_CONSTRUCTR_DEBUG_MODE' => true, // ACTIVATE DEBUGGING IN CONSTRUCTR BACKEND - (boolean) true|false

        '_CONSTRUCTR_SESSION_NAME' => 'constructr', // CONSTRUCTR APP SESSION NAME - (char) 'constructr'

        '_MEDIA_BASE_TITLE' => 'Media base title', // MEDIA BASE TITLE - (char) WHATEVER YOU WISH

        '_MEDIA_BASE_COPYRIGHT' => 'Media Base copyright', // MEDIA BASE COPYRIGHT - (char) WHATEVER YOU WISH

        '_MEDIA_BASE_DESCRIPTION' => 'Media base description', // MEDIA BASE DESCRIPTION - (char) WHATEVER YOU WISH

        '_MEDIA_BASE_KEYWORDS' => 'Media base keywords', // MEDIA BASE KEYWORDS - (char) WHATEVER YOU WISH

        '_RESET_LOGIN_PASSWORD' => false, // RESET PASSWORD FOR USERS - (boolean) true|false

        '_MAX_LOGIN_ATTEMPTS' => 5, // CONSTRUCTR MAXIMAL LOGIN ATTEMPTS - (int) 5

        '_LOGIN_BLOCKED_FOR' => 600, // CONSTRUCTR LOGIN BLOCKING TIME WHEN _MAX_LOGIN_ATTEMPTS IS REACHED - (int) 600

        '_CREATE_STATIC' => true, // ALLOW GENERATION OF STATIC PAGES - (boolean) true|false

        '_STATIC_FILETYPE' => '.html', // PREFERED FILE-TYPE OF STATIC PAGES - (char) .php,.html,...

        '_STATIC_DIR' => './Static', // DIRECTORY FOR STATIC OUTPUT - (char) './Static'

        '_CREATE_STATIC_DOMAIN' => '', // SETS SPECIFIC DOMAIN FOR CREATION OF STATIC WEBPAGES - (char) http://domain.tld
        
        '_CREATE_DYNAMIC_DOMAIN' => '', // SETS SPECIFIC DOMAIN FOR CREATION OF DYNAMIC WEBPAGES - (char) http://domain.tld

        '_MAGIC_GENERATION_KEY' => '', // MAGIC KEY FOR READING CONSTRUCTR FRONTEND OUTPUT - STATIC WEBPAGE GENERATION - (char) WHATEVER YOU WISH

        '_TRANSFER_STATIC' => true, // ALLOW FTP-TRANSFER OF STATIC PAGES - (boolean) true|false

        '_FTP_REMOTE_HOST' => '', // TRANSPORT STATIC WEBSITE-OUTPUT TO DESTINATION SERVER - (char)

        '_FTP_REMOTE_PORT' => 21, // REMOTE FTP-PORT - (int) 21

        '_FTP_REMOTE_DIR' => '', // DESTINATION DIRECTORY ON REMOTE FTP-SERVER - (char)

        '_FTP_REMOTE_MODE' => FTP_BINARY, // TRANSPORT METHOD - (char) FTP_BINARY | FTP_ASCII

        '_FTP_REMOTE_USERNAME' => '', // FTP USERNAME - (char)

        '_FTP_REMOTE_PASSWORD' => '', // FTP PASSWORD - (char)
    );

    if(!defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH)
    {
        die('Fehler CRYPT_BLOWFISH ist nicht verf&uuml;gbar!');
    }

    if (version_compare(phpversion(),'5.3.0','<='))
    {
        die('PHP ist kleiner als Version 5.3.0');
    }