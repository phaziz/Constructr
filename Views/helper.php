<?php

    function create_guid() {static $guid = '';$uid = uniqid("", true);$data = $_SERVER['REQUEST_TIME'];$data .= $_SERVER['HTTP_USER_AGENT'];$data .= $_SERVER['PHP_SELF'];$data .= $_SERVER['SCRIPT_NAME'];$data .= $_SERVER['REMOTE_ADDR'];$data .= $_SERVER['REMOTE_PORT'];$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));$guid = substr($hash,0,2) . substr($hash,2,2) . substr($hash,4,2) . substr($hash,8,2);return $guid;}

    $app -> notFound(function () use ($app) 
        {
            $app -> getLog() -> error('404 - Not found: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $app -> redirect(_BASE_URL);
        }
    );

    $app -> error(function (\Exception $e) use ($app) 
        {
            $app -> getLog() -> error('Exception: ' . $e . ' / ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $app -> redirect(_BASE_URL);
        }
    );

    /*
     * 
     * Zentrale Überprüfungen der Benutzerkonten Start
     * 
     * */
    $ADMIN_CHECK = function() use ($app,$DBCON)
    {
        if(!isset($_SESSION['backend-user-username']) || !isset($_SESSION['backend-user-password']) || $_SESSION['backend-user-username'] == '' || $_SESSION['backend-user-password'] == '')
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 0: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }
            $app -> redirect(_BASE_URL . '/admin/login/');
            die();
        } else {
            try {
                $QUERY = $DBCON -> prepare('SELECT * FROM backenduser WHERE beu_username = :USERNAME AND beu_active = :ACTIVE LIMIT 1;');
                $QUERY -> execute( 
                    array(
                        'USERNAME' => $_SESSION['backend-user-username'],
                        'ACTIVE' => 1,
                        ) 
                );
                $COUNTR = $QUERY -> rowCount();
                if($COUNTR != 1)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 1: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $app -> redirect(_BASE_URL . '/admin/login/');
                    die();
                }
            } catch (PDOException $e) {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 2: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $app -> redirect(_BASE_URL . '/admin/login/');
                die();
            }
        }
    };
    /*
     * 
     * Zentrale Überprüfungen der Benutzerkonten Ende
     * 
     * */