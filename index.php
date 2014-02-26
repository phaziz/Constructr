<?php

    /**************************************************************************
        DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
        Version 1, December 2012
        Copyright (C) 2012 Christian Becher | phaziz.com <christian@phaziz.com>
        Everyone is permitted to copy and distribute verbatim or modified
        copies of this license document, and changing it is allowed as long
        as the name is changed.
        DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
        TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
        0. You just DO WHAT THE FUCK YOU WANT TO.
    ***************************************************************************/

    session_cache_limiter(false);
    session_start();

    define('_BASE_URL','http://' . $_SERVER['HTTP_HOST'] . '');
    define('_VERSION','20140226');
    define('_SALT','$2y$07$R.gJb2U2N.FmZ4hPp1y2CN$');
    define('_LOGGING',true);
    define('_TITLE','CONSTRUCTR');

    if(!defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
    {
        echo "CRYPT_BLOWFISH is not available";
        die();
    }

    require_once './Slim/Slim.php';
    require_once './Slim/Log/DateTimeFileWriter.php';

    \Slim\Slim::registerAutoloader();

    $HOSTNAME = ""; // localhost
    $DATABASE = ""; // Your Database
    $USERNAME = ""; // Your Username
    $PASSWORD = ""; // Your Password

    try {
        $DBCON = new PDO('mysql:host=' . $HOSTNAME . ';dbname=' . $DATABASE,$USERNAME,$PASSWORD, array(PDO::ATTR_PERSISTENT => true));
        $DBCON -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die();
    }

    $app = new \Slim\Slim(
        array(
            'mode'                  => 'development',
            'debug'                 => true,
            'http.version'          => '1.1',
            'templates.path'        => './Templates',
            'session.handler'       => null,
            'log.writer'            => new \Slim\Extras\Log\DateTimeFileWriter(array(
                    'path'              => './Logfiles',
                    'name_format'       => 'Ymd',
                    'message_format'    => '%label% // %date%: %message%',
                    'extension'         => 'log',
                    )
            ),
            'log.level'         => \Slim\Log::DEBUG,
            'log.enabled'       => true
        )
    );

    $app -> add(
        new \Slim\Middleware\SessionCookie(
            array(
                'secret'        => 'h5/823565$%4jc/)$3kfè4()487HD3d',
                'cipher'        => MCRYPT_RIJNDAEL_256,
                'cipher_mode'   => MCRYPT_MODE_CBC,
                'name'          => 'app-sssession',
                'expires'       => '8 hours',
                'path'          => '/',
                'domain'        => null,
                'secure'        => false,
                'httponly'      => false,
            )
        )
    );

    require_once './Views/helper.php';
    require_once './Views/backenduser.php';
    require_once './Views/pages.php';
    require_once './Views/login.php';
    require_once './Views/logout.php';
    require_once './Views/admin.php';
    require_once './Views/media.php';
    require_once './Views/index.php';

    $app -> run();

    $DBCON = null;