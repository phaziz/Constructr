<?php

    if(!defined('CONSTRUCTR_INCLUDR'))
    {
        die('Direkter Zugriff nicht erlaubt');
    }

    $constructr -> get('/constructr/config/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
                $CONFIG_DATA = $DBCON -> prepare('SELECT * FROM constructr_config;');
                $CONFIG_DATA -> execute();
            }
            catch (PDOException $e) 
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $GUID = create_guid();
            $_SESSION['tmp_form_guid'] = $GUID;

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            
            $constructr -> render('config.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'GUID' => $GUID,
                    'CONFIG_DATA' => $CONFIG_DATA,
                    'SUBTITLE' => 'Admin-Dashboard // Systemkonfiguration',
                    'FORM_ACTION' => _BASE_URL . '/constructr/update-config/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> post('/constructr/update-config/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USER_FORM_GUID = $constructr -> request() -> post('user_form_guid');
            if($GUID != $USER_FORM_GUID || $_SESSION['tmp_form_guid'] != $GUID)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect(_BASE_URL . '/constructr/logout/');
                die();
            }

            $_SALT = $constructr -> request() -> post('_SALT');
            $_LOGGING = $constructr -> request() -> post('_LOGGING');
            $_DEBUGGING = $constructr -> request() -> post('_DEBUGGING');
            $_TITLE = $constructr -> request() -> post('_TITLE');
            $_EXT_WWW = $constructr -> request() -> post('_EXT_WWW');
            $_SERVE_STATIC = $constructr -> request() -> post('_SERVE_STATIC');
            $_CREATE_STATIC = $constructr -> request() -> post('_CREATE_STATIC');
            $_STATIC_DIR = $constructr -> request() -> post('_STATIC_DIR');
            $_BASE_URL = $constructr -> request() -> post('_BASE_URL');
            $_VERSION = $constructr -> request() -> post('_VERSION');

            try
            {
                $UPDATE = $DBCON -> prepare('
                    UPDATE constructr_config SET constructr_config_value = :_SALT WHERE constructr_config_id = 1 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_LOGGING WHERE constructr_config_id = 2 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_DEBUGGING WHERE constructr_config_id = 3 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_TITLE WHERE constructr_config_id = 4 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_EXT_WWW WHERE constructr_config_id = 5 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_SERVE_STATIC WHERE constructr_config_id = 6 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_CREATE_STATIC WHERE constructr_config_id = 7 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_STATIC_DIR WHERE constructr_config_id = 8 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_BASE_URL WHERE constructr_config_id = 9 LIMIT 1;
                    UPDATE constructr_config SET constructr_config_value = :_VERSION WHERE constructr_config_id = 10 LIMIT 1;
                ');

                $UPDATE -> execute(
                    array
                    (
                        ':_SALT' => $_SALT,
                        ':_LOGGING' => $_LOGGING,
                        ':_DEBUGGING' => $_DEBUGGING,
                        ':_TITLE' => $_TITLE,
                        ':_EXT_WWW' => $_EXT_WWW,
                        ':_SERVE_STATIC' => $_SERVE_STATIC,
                        ':_CREATE_STATIC' => $_CREATE_STATIC,
                        ':_STATIC_DIR' => $_STATIC_DIR,
                        ':_BASE_URL' => $_BASE_URL,
                        ':_VERSION' => $_VERSION
                    )
                );
            }
            catch (PDOException $e) 
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect(_BASE_URL . '/constructr/config/?updated=false');                
                die();
            }

            $constructr -> redirect(_BASE_URL . '/constructr/config/?updated=true');
        }
    );
