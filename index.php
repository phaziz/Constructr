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
        0. YOU JUST DO WHAT THE FUCK YOU WANT TO MIT-LICENSE-STYLE!
    ***************************************************************************/

    session_cache_limiter(false);
    session_start();

    define('_BASE_URL','http://' . $_SERVER['HTTP_HOST'] . '');
    define('_VERSION','20140227');
    define('_SALT','$2y$07$R.gJb2U2N.FmZ4hPp1y2CN$');
    define('_LOGGING',true);
    define('_DEBUGGING',true);
    define('_TITLE','CONSTRUCTR');

    if(!defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)
    {
        echo "CRYPT_BLOWFISH is not available";
        die();
    }

    require_once './Slim/Slim.php';
    require_once './Slim/Log/DateTimeFileWriter.php';

    \Slim\Slim::registerAutoloader();

    $HOSTNAME = "";
    $DATABASE = "";
    $USERNAME = "";
    $PASSWORD = "";

    try
    {
        $DBCON = new PDO('mysql:host=' . $HOSTNAME . ';dbname=' . $DATABASE,$USERNAME,$PASSWORD,
            array(
                PDO::ATTR_PERSISTENT => true
            )
        );
        
        $DBCON -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        echo '<p>Error establishing Database-Connection!</p>';
        die();
    }

    $app = new \Slim\Slim(
        array(
            'mode'                  => 'development',
            'debug'                 => true,
            'http.version'          => '1.1',
            'templates.path'        => './Templates',
            'session.handler'       => null,
            'log.writer'            => new \Slim\Extras\Log\DateTimeFileWriter(
                array(
                    'path'              => './Logfiles',
                    'name_format'       => 'Ymd',
                    'message_format'    => '%label% // %date%: %message%',
                    'extension'         => 'log'
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
                'httponly'      => false
            )
        )
    );

    require_once './Views/helper.php';

    $REQUEST = $app -> request -> getPath();
    $FINDR = strpos($REQUEST, 'admin');

    if ($FINDR === false)
    {
        // FRONTEND
        $app -> get('(:ROUTE+)', function ($ROUTE) use ($app,$DBCON)
            {
                $FULL_ROUTE;
                $PAGES;
                $CONTENT;

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
                   $PAGES = $DBCON -> query('SELECT * FROM pages ORDER BY pages_lft ASC;');
                   $PAGES = $PAGES -> fetchAll();
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
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
                                    SELECT pages_id FROM pages WHERE pages_lft = :NESTED_SETS_INIT LIMIT 1;
                                ');
    
                                $INIT = 1;

                                $HOMEPAGE -> execute(
                                    array(
                                        ':NESTED_SETS_INIT' => $INIT 
                                    )
                                );
                                $HOMEPAGE = $HOMEPAGE -> fetch();
                            }
                            catch (PDOException $e)
                            {
                                $app -> getLog() -> error('1 ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                die();
                            }

                            $PAGE_ID = $HOMEPAGE['pages_id'];
                            
                            try
                            {
                                $CONTENT = $DBCON -> prepare('
                                    SELECT * FROM content WHERE content_page_id = :PAGE_ID;
                                ');

                                $CONTENT -> execute(
                                    array(
                                        ':PAGE_ID' => $PAGE_ID
                                    )
                                );
                            }
                            catch (PDOException $e)
                            {
                                $app -> getLog() -> error('2 ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                die();
                            }
                        }
                        else
                        {
                            if('/' . $PAGE['pages_url'] . '/' == $FULL_ROUTE)
                            {
                                try
                                {
                                    $CONTENT = $DBCON -> prepare('
                                        SELECT * FROM content WHERE content_page_id = :PAGE_ID;
                                    ');
    
                                    $CONTENT -> execute(
                                        array(
                                            ':PAGE_ID' => $PAGE['pages_id']
                                        )
                                    );
                                }
                                catch (PDOException $e)
                                {
                                    $app -> getLog() -> error('3 ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                    die();
                                }
                            }    
                        }                        
                    }    
                }

                $app -> render('index.php',
                    array(
                        'PAGES' => $PAGES,
                        'CONTENT' => $CONTENT,
                    )
                );

                // APPEND DEBUGGING OUTPUT
                if(_DEBUGGING == true)
                {
                    echo '<div class="debugging"><h2>Debugging</h2>';
                    echo '<br><h4>Actual Route:</h4>';
                    echo '<pre>';
                    var_dump($FULL_ROUTE);
                    echo '</pre>';
                    echo '</div>';
                }
                // APPEND DEBUGGING OUTPUT
                
                die();
            }
        );

        $app -> run();
        $DBCON = null;
        // FRONTEND
    }
    else
    {
        // BACKEND
        require_once './Views/backenduser.php';
        require_once './Views/login.php';
        require_once './Views/logout.php';
        require_once './Views/admin.php';
        require_once './Views/pages.php';
        require_once './Views/content.php';
        require_once './Views/media.php';

        $app -> run();
        $DBCON = null;
        // BACKEND
    }