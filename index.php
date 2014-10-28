<?php

    /*
    ***************************************************************************

        DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
        Version 1, December 2012
        Copyright (C) 2012 Christian Becher | phaziz.com <christian@phaziz.com>
        Everyone is permitted to copy and distribute verbatim or modified
        copies of this license document, and changing it is allowed as long
        as the name is changed.

        DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
        TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
        0. YOU JUST DO WHAT THE FUCK YOU WANT TO!

        +++ Visit http://phaziz.com +++

    ***************************************************************************
    */

    require_once './Config/constructr.conf.php';
    require_once './Config/constructr_user_rights.conf.php';

    $_CONSTRUCTR_CONF['_VERSION_DATE'] = '20141028';
    $_CONSTRUCTR_CONF['_VERSION'] = '1.03.8';

    require_once './Slim/Slim.php';
    require_once './Slim/Log/DateTimeFileWriter.php';

    \Slim\Slim::registerAutoloader();

    try
    {
        $DBCON = new PDO('mysql:host=' . $_CONSTRUCTR_CONF['_CONSTRUCTR_DATABASE_HOST'] . ';dbname=' . $_CONSTRUCTR_CONF['_CONSTRUCTR_DATABASE_NAME'],$_CONSTRUCTR_CONF['_CONSTRUCTR_DATABASE_USER'],$_CONSTRUCTR_CONF['_CONSTRUCTR_DATABASE_PASSWORD'],array(PDO::ATTR_PERSISTENT => true));
        $DBCON -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die('<p>Fehler bei der Datenbankverbindung!</p>');
    }

    $constructr = new \Slim\Slim(
        array
        (
            'mode' => $_CONSTRUCTR_CONF['_CONSTRUCTR_MODE'],
            'debug' => $_CONSTRUCTR_CONF['_CONSTRUCTR_DEBUG_MODE'],
            'http.version' => '1.1',
            'templates.path' => $_CONSTRUCTR_CONF['_CONSTRUCTR_BACKEND'],
            'session.handler' => null,
            'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(
                array
                (
                    'path' => $_CONSTRUCTR_CONF['_CONSTRUCTR_LOGFILES_PATH'],
                    'name_format' => 'Ymd',
                    'message_format' => '%label% // %date%: %message%',
                    'extension' => 'txt'
                )
            ),
            'log.level' => \Slim\Log::DEBUG,
            'log.enabled' => $_CONSTRUCTR_CONF['_CONSTRUCTR_LOG_ENABLED']
        )
    );

    $constructr -> add(
        new \Slim\Middleware\SessionCookie(
            array
            (
                'secret' => $_CONSTRUCTR_CONF['_SECRET'],
                'cipher' => MCRYPT_RIJNDAEL_256,
                'cipher_mode' => $_CONSTRUCTR_CONF['_SESSION_CYPHER_METHOD'],
                'name' => $_CONSTRUCTR_CONF['_CONSTRUCTR_SESSION_NAME'],
                'expires' => $_CONSTRUCTR_CONF['_CONSTRUCTR_COOKIE_LIFETIME'],
                'path' => '/',
                'domain' => null,
                'secure' => false,
                'httponly' => false
            )
        )
    );

    require_once './Views/helper.php';

    $REQUEST = $constructr -> request -> getPath();
    $FINDR = strpos($REQUEST, 'constructr');

    if($FINDR === false)
    {
        try
        {
            $URLS = $DBCON -> prepare('SELECT pages_url FROM constructr_pages WHERE pages_active = 1;');
            $URLS -> execute();
            $URLS = $URLS -> fetchAll();
        }
        catch (PDOException $e)
        {
            $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
            die();
        }

        if($URLS)
        {
            $URLS_ARRAY = array();
            $i = 0;
            foreach($URLS AS $URL)
            {
                $URLS_ARRAY[$i] =  '/' . $URL['pages_url'];
                $i++;
                $URLS_ARRAY[$i] =  '/' . $URL['pages_url'] . '/';
                $i++;
            }
        }
        else
        {
            die('Keine Seiten gefunden!');
        }

        if(!in_array($REQUEST,$URLS_ARRAY) && $REQUEST != '/' && $REQUEST != '')
        {
            $constructr -> getLog() -> error('404 - URL NOT FOUND: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            header("HTTP/1.0 404 Not Found");
            header("Location: " . $_CONSTRUCTR_CONF["_BASE_URL"] . '/404');
            die();
        }

        $view = $constructr -> view();
        $view -> setTemplatesDirectory($_CONSTRUCTR_CONF['_TEMPLATES_DIR']);

        $_METHOD = $constructr -> request -> getMethod();

        require_once './Postmaster/constructr_postmaster.php';

        switch ($_METHOD)
        {
            case 'GET':

                $constructr -> get('(:ROUTE+)', function ($ROUTE) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
                    {
                        if($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE'] == true)
                        {
                            $C_FILE = $_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE_DIR'] . base64_encode($_SERVER['REQUEST_URI']) . '.php';
                            $C_TIME = 18000;
                            if (file_exists($C_FILE) && time() - $C_TIME < filemtime($C_FILE))
                            {
                                include($C_FILE);
                                exit();
                            }
                            ob_start();
                        }

                        $FULL_ROUTE;
                        $PAGES;
                        $CONTENT;
                        $PAGE_DATA;

                        foreach($ROUTE as $ROUTE)
                        {
                            $FULL_ROUTE .= $ROUTE . '/';
                        }

                        if(strpos($FULL_ROUTE, '//') !== false)
                        {
                            $FULL_ROUTE = preg_replace("#//+#", "/", $FULL_ROUTE);
                        }

                        try
                        {
                            $PAGES = $DBCON -> query('SELECT * FROM constructr_pages ORDER BY pages_order ASC;');
                            $PAGES = $PAGES -> fetchAll();
                        }
                        catch (PDOException $e)
                        {
                            $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            die();
                        }

                        if($PAGES)
                        {
                            foreach($PAGES as $PAGE)
                            {
                                if($FULL_ROUTE == '/')
                                {
                                    try
                                    {
										$PAGES_INIT_ORDER = 1;
                                        $HOMEPAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_order = :PAGES_INIT_ORDER AND pages_active = 1 LIMIT 1;');
                                        $HOMEPAGE -> execute(array(':PAGES_INIT_ORDER' => $PAGES_INIT_ORDER));
                                        $HOMEPAGE = $HOMEPAGE -> fetch();
                                    }
                                    catch (PDOException $e)
                                    {
                                        $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                        die();
                                    }

                                    $PAGE_ID = $HOMEPAGE['pages_id'];
                                    $TEMPLATE = $HOMEPAGE['pages_template'];

                                    try
                                    {
                                        $CONTENT_ACTIVE = 1;
                                        $DELETED = 0;
                                        $CONTENT = $DBCON -> prepare('SELECT content_content FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_deleted = :DELETED AND content_active = :CONTENT_ACTIVE ORDER BY content_order ASC;');
                                        $CONTENT -> execute(array(':PAGE_ID' => $PAGE_ID,':DELETED' => $DELETED,':CONTENT_ACTIVE' => $CONTENT_ACTIVE));
                                    }
                                    catch (PDOException $e)
                                    {
                                        $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                        die();
                                    }
                                }
                                else
                                {
                                    if('/' . $PAGE['pages_url'] . '/' == $FULL_ROUTE)
                                    {
                                        try
                                        {
                                            $DELETED = 0;
                                            $CONTENT_ACTIVE = 1;
                                            $ACT_PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID AND pages_active = 1 LIMIT 1;');
                                            $ACT_PAGE -> execute(array(':PAGE_ID' => $PAGE['pages_id']));
                                            $PAGE_DATA = $ACT_PAGE -> fetch();
                                            $TEMPLATE = $PAGE_DATA['pages_template'];
                                            $CONTENT = $DBCON -> prepare('SELECT content_content FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_deleted = :DELETED AND content_active = :CONTENT_ACTIVE ORDER BY content_order ASC;');
                                            $CONTENT -> execute(array(':PAGE_ID' => $PAGE['pages_id'],':DELETED' => $DELETED,':CONTENT_ACTIVE' => $CONTENT_ACTIVE));
                                        }
                                        catch (PDOException $e)
                                        {
                                            $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                            die();
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            die('<p>Keine Seiten vorhanden!</p>');
                        }

                        $POSTMASTER_GUID = create_guid();
                        $constructr -> render($TEMPLATE,array('PAGES' => $PAGES,'PAGE_DATA' => $PAGE_DATA,'CONTENT' => $CONTENT,'_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,'POSTMASTER_GUID' => $POSTMASTER_GUID));

                        if($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE'] == true)
                        {
                            $fp = @fopen($C_FILE, 'w');
                            @fwrite($fp,ob_get_contents());
                            @fwrite($fp,'<!-- CONSTRUCTR CACHE ' . date('Y-m-d H:i:s') . '-->');
                            @fclose($fp);
                            ob_end_flush();
                        }
                    }
                );

                break;

            case 'POST':

                $constructr -> post('(:ROUTE+)', function ($ROUTE) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
                    {
                        $FULL_ROUTE;
                        $PAGES;
                        $CONTENT;
                        $PAGE_DATA;

                        foreach($ROUTE as $ROUTE)
                        {
                            $FULL_ROUTE .= $ROUTE . '/';
                        }

                        if (strpos($FULL_ROUTE, '//') !== false)
                        {
                            $FULL_ROUTE = preg_replace("#//+#", "/", $FULL_ROUTE);
                        }

                        try
                        {
                            $PAGES = $DBCON -> query('SELECT * FROM constructr_pages ORDER BY pages_order ASC;');
                            $PAGES = $PAGES -> fetchAll();
                        }
                        catch (PDOException $e)
                        {
                            $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            die();
                        }

                        if($PAGES)
                        {
                            foreach($PAGES as $PAGE)
                            {
                                if($FULL_ROUTE == '/')
                                {
                                    try
                                    {
                                        $INIT = 1;
                                        $HOMEPAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_order = 1 AND pages_active = 1 LIMIT 1;');
                                        $HOMEPAGE = $HOMEPAGE -> fetch();
                                        $PAGE_DATA = $HOMEPAGE;
                                    }
                                    catch (PDOException $e)
                                    {
                                        $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                        die();
                                    }

                                    $PAGE_ID = $HOMEPAGE['pages_id'];
                                    $TEMPLATE = $HOMEPAGE['pages_template'];

                                    try
                                    {
                                        $CONTENT_ACTIVE = 1;
                                        $DELETED = 0;
                                        $CONTENT = $DBCON -> prepare('SELECT content_content FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_deleted = :DELETED AND content_active = :CONTENT_ACTIVE ORDER BY content_order ASC;');
                                        $CONTENT -> execute(array(':PAGE_ID' => $PAGE_ID,':DELETED' => $DELETED,':CONTENT_ACTIVE' => $CONTENT_ACTIVE));
                                    }
                                    catch (PDOException $e)
                                    {
                                        $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                        die();
                                    }
                                }
                                else
                                {
                                    if('/' . $PAGE['pages_url'] . '/' == $FULL_ROUTE)
                                    {
                                        try
                                        {
                                            $DELETED = 0;
                                            $CONTENT_ACTIVE = 1;
                                            $ACT_PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID AND pages_active = 1 LIMIT 1;');
                                            $ACT_PAGE -> execute(array(':PAGE_ID' => $PAGE['pages_id']));
                                            $PAGE_DATA = $ACT_PAGE -> fetch();
                                            $TEMPLATE = $PAGE_DATA['pages_template'];
                                            $CONTENT = $DBCON -> prepare('SELECT content_content FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_deleted = :DELETED AND content_active = :CONTENT_ACTIVE ORDER BY content_order ASC;');
                                            $CONTENT -> execute(array(':PAGE_ID' => $PAGE['pages_id'],':DELETED' => $DELETED,':CONTENT_ACTIVE' => $CONTENT_ACTIVE));
                                        }
                                        catch (PDOException $e)
                                        {
                                            $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                            die();
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            die('<p>Keine Seiten vorhanden!</p>');
                        }

                        $POSTMASTER_GUID = create_guid();
                        $constructr -> render($TEMPLATE,array('PAGES' => $PAGES,'PAGE_DATA' => $PAGE_DATA,'CONTENT' => $CONTENT,'_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,'POSTMASTER_GUID' => $POSTMASTER_GUID));
                    }
                );

                break;
        }
    }
    else
    {
        require_once './Views/backenduser.php';
        require_once './Views/backenduser-rights.php';
        require_once './Views/login.php';
        require_once './Views/logout.php';
        require_once './Views/admin.php';
        require_once './Views/pages.php';
        require_once './Views/templates.php';
        require_once './Views/content.php';
        require_once './Views/config.php';
        require_once './Views/media.php';
    }

    $constructr -> run();
    $DBCON = null;