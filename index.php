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
        0. YOU JUST DO WHAT THE FUCK YOU WANT TO MIT-LICENSE-STYLE!

        +++ Visit http://phaziz.com +++
    ***************************************************************************
    */

    // Your main config-file - edit for your needs :)
    require_once('./Config/constructr.conf.php');

    if(!defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
    {
        echo "CRYPT_BLOWFISH is not available";
        die();
    }

    require_once './Slim/Slim.php';
    require_once './Slim/Log/DateTimeFileWriter.php';

    \Slim\Slim::registerAutoloader();

    try
    {
        $DBCON = new PDO('mysql:host=' . $HOSTNAME . ';dbname=' . $DATABASE,$USERNAME,$PASSWORD,array(PDO::ATTR_PERSISTENT => true));
        $DBCON -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $_SERVE_STATIC = $DBCON -> query('SELECT constructr_config_value FROM constructr_config WHERE constructr_config_expression = "_SERVE_STATIC" LIMIT 1;');
        $_SERVE_STATIC = $_SERVE_STATIC -> fetch();
        $_SERVE_STATIC = $_SERVE_STATIC['constructr_config_value'];
    }
    catch (PDOException $e)
    {
        echo '<p>Error establishing Database-Connection!</p>';
        die();
    }

    $constructr = new \Slim\Slim(
        array
        (
            'mode' => 'development',
            'debug' => true,
            'http.version' => '1.1',
            'templates.path' => './Templates',
            'session.handler' => null,
            'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(
                array
                (
                    'path' => './Logfiles',
                    'name_format' => 'Ymd',
                    'message_format' => '%label% // %date%: %message%',
                    'extension' => 'log'
                )
            ),
            'log.level' => \Slim\Log::DEBUG,
            'log.enabled' => true
        )
    );

    $constructr -> add(
        new \Slim\Middleware\SessionCookie(
            array
            (
                'secret' => 'h5/823!65$%4jc/)$3_fè4()480HD3d',
                'cipher' => MCRYPT_RIJNDAEL_256,
                'cipher_mode' => MCRYPT_MODE_CBC,
                'name' => 'app-sssession',
                'expires' => '8 hours',
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
        $view = $constructr -> view();
        $view -> setTemplatesDirectory('./Website-Template');        

        if($_SERVE_STATIC == "true")
        {
            $constructr -> get('(:ROUTE+)', function ($ROUTE) use ($constructr)
                {
                    $URL = '';

                    foreach($ROUTE as $ROUTE)
                    {
                        $URL .= '/' . $ROUTE;
                    }

                    $URL = str_replace('//','/',$URL);
                    $STATIC_DIR = str_replace('./','/',_STATIC_DIR);
                    $URL = _BASE_URL . $STATIC_DIR . $URL . 'index.php';
                    $constructr -> getLog() -> info('ConstructrCMS serves static ' . date('d.m.Y, H:i:s') . ':' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect($URL,301);
                }
            );
            
            $constructr -> run();
            die();
        }

        if(_EXT_WWW != '')
        {
            $constructr -> get('(:ROUTE+)', function () use ($constructr)
                {
                    $constructr -> redirect(_BASE_URL . '/Web/index.php',301);
                    die();        
                }
            );
            
            $constructr -> run();
        }

        $START = microtime(true);
        
        $constructr -> get('(:ROUTE+)', function ($ROUTE) use ($constructr,$DBCON)
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
                    $PAGES = $DBCON -> query('
                        SELECT n.*,
                                 round((n.pages_rgt-n.pages_lft-1)/2,0) AS pages_subpages_countr,
                                 count(*)-1+(n.pages_lft>1) AS pages_level,
                                 ((min(p.pages_rgt)-n.pages_rgt-(n.pages_lft>1))/2) > 0 AS pages_lower,
                                 (((n.pages_lft-max(p.pages_lft)>1))) AS pages_upper
                            FROM constructr_pages n,
                                 constructr_pages p
                           WHERE n.pages_lft BETWEEN p.pages_lft AND p.pages_rgt
                             AND (p.pages_id != n.pages_id OR n.pages_lft = 1)
                             AND n.pages_active = 1
                             AND p.pages_active = 1
                        GROUP BY n.pages_id
                        ORDER BY n.pages_lft;
                    ');

                    $PAGES = $PAGES -> fetchAll();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
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
                                $HOMEPAGE = $DBCON -> prepare('
                                    SELECT * FROM constructr_pages WHERE pages_lft = :NESTED_SETS_INIT AND pages_active = 1 LIMIT 1;
                                ');
    
                                $INIT = 1;

                                $HOMEPAGE -> execute(
                                    array(
                                        ':NESTED_SETS_INIT' => $INIT 
                                    )
                                );
                                $HOMEPAGE = $HOMEPAGE -> fetch();
                                $PAGE_DATA = $HOMEPAGE;
                            }
                            catch (PDOException $e)
                            {
                                $constructr -> getLog() -> error('1 ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                die();
                            }

                            $PAGE_ID = $HOMEPAGE['pages_id'];
                            
                            try
                            {
                                $CONTENT = $DBCON -> prepare('
                                    SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_active = 1 ORDER BY content_order ASC;
                                ');

                                $CONTENT -> execute(
                                    array(
                                        ':PAGE_ID' => $PAGE_ID
                                    )
                                );
                            }
                            catch (PDOException $e)
                            {
                                $constructr -> getLog() -> error('2 ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                die();
                            }
                        }
                        else
                        {
                            if('/' . $PAGE['pages_url'] . '/' == $FULL_ROUTE)
                            {
                                try
                                {
                                    $ACT_PAGE = $DBCON -> prepare('
                                        SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID AND pages_active = 1 LIMIT 1;
                                    ');

                                    $ACT_PAGE -> execute(
                                        array(
                                            ':PAGE_ID' => $PAGE['pages_id'] 
                                        )
                                    );

                                    $PAGE_DATA = $ACT_PAGE -> fetch();

                                    $CONTENT = $DBCON -> prepare('
                                        SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_active = 1 ORDER BY content_order ASC;
                                    ');
    
                                    $CONTENT -> execute(
                                        array(
                                            ':PAGE_ID' => $PAGE['pages_id']
                                        )
                                    );
                                }
                                catch (PDOException $e)
                                {
                                    $constructr -> getLog() -> error('3 ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                    die();
                                }
                            }    
                        }                        
                    }
                }

                $constructr -> render('index.php',
                    array(
                        'PAGES' => $PAGES,
                        'PAGE_DATA' => $PAGE_DATA,
                        'CONTENT' => $CONTENT,
                    )
                );

                if(_DEBUGGING == true)
                {
                    echo '<div class="debugging"><h2>Debugging</h2>';
                    echo '<br><h4>Actual Route:</h4>';
                    echo '<pre>';
                    var_dump($FULL_ROUTE);
                    echo '</pre>';
                    echo '<br><h4>Generation Time:</h4>';
                    echo '<pre>';
                    echo 'TIMER: ' . substr(microtime(true) - $START,0,6) . ' Millisec.';
                    echo '</pre>';
                    echo '<br><h4>Memory Usage:</h4>';
                    echo '<pre>';
                    $MEM = 0;
                    $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
                    echo $MEM;
                    echo '</pre>';
                    echo '</div>';
                }

                die();
            }
        );

        $constructr -> run();
        $DBCON = null;
    }
    else
    {
        require_once './Views/backenduser.php';
        require_once './Views/backenduser-rights.php';
        require_once './Views/login.php';
        require_once './Views/logout.php';
        require_once './Views/admin.php';
        require_once './Views/pages.php';
        require_once './Views/content.php';
        require_once './Views/media.php';
        require_once './Views/image-test.php';

        $constructr -> run();
    }
    
    $DBCON = null;