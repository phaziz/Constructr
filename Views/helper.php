<?php

    function create_guid() {static $guid = '';$uid = uniqid("", true);$data = $_SERVER['REQUEST_TIME'];$data .= $_SERVER['HTTP_USER_AGENT'];$data .= $_SERVER['PHP_SELF'];$data .= $_SERVER['SCRIPT_NAME'];$data .= $_SERVER['REMOTE_ADDR'];$data .= $_SERVER['REMOTE_PORT'];$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));$guid = substr($hash,0,2) . substr($hash,2,2) . substr($hash,4,2) . substr($hash,8,2);return $guid;}

    $constructr -> notFound(function () use ($constructr,$_CONSTRUCTR_CONF) 
        {
            $constructr -> getLog() -> error('404 - Not found: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL']);
        }
    );

    $constructr -> error(function (\Exception $e) use ($constructr) 
        {
            $constructr -> getLog() -> error('Exception: ' . $e . ' / ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL']);
        }
    );

    $ADMIN_CHECK = function() use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
    {
        if(!isset($_SESSION['backend-user-username']) || !isset($_SESSION['backend-user-password']) || $_SESSION['backend-user-username'] == '' || $_SESSION['backend-user-password'] == '')
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 0: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
            die();
        }
        else
        {
            try
            {
                $ACTIVE = 1;
                $QUERY = 'SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_active = :ACTIVE LIMIT 1;';
                $STMT = $DBCON -> prepare($QUERY);
                $STMT -> bindParam(':USERNAME',$_SESSION['backend-user-username'],PDO::PARAM_STR);
                $STMT -> bindParam(':ACTIVE',$ACTIVE,PDO::PARAM_INT);
                $STMT -> execute();

                $COUNTR = $STMT -> rowCount();
                
                if($COUNTR != 1)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 1: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                    die();
                }
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 2: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                die();
            }
        }
    };