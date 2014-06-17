<?php

    $constructr -> get('/constructr/login/', function () use ($constructr,$_CONSTRUCTR_CONF)
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $GUID = create_guid();

            $constructr -> render('admin_login.php', 
                array
                (
                    '_METHOD' => 'post',
                    'GUID' => $GUID,
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/' . $GUID . '/',
                    'SUBTITLE' => 'Login',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF
                )
            );
        }
    );

    $constructr -> get('/constructr/login-error/', function () use ($constructr,$_CONSTRUCTR_CONF)
        {
            if(isset($_SESSION['constructr_login_blocked']) && $_SESSION['constructr_login_blocked'] != '')
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                die();
            }

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $GUID = create_guid();

            $constructr -> render('admin_login_error.php', 
                array
                (
                    '_METHOD' => 'post',
                    'GUID' => $GUID,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/' . $GUID . '/',
                    'SUBTITLE' => 'Login'
                )
            );
        }
    );

    $constructr -> post('/constructr/login/:GUID/', function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            session_regenerate_id(true); 

            if(isset($_SESSION['constructr_login_blocked']) && $_SESSION['constructr_login_blocked'] != '')
            {
                $constructr -> redirect('LOGIN BLOCKED: ' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                die();
            }

            if(!isset($_SESSION['constructr_login_attempt']) || $_SESSION['constructr_login_attempt'] == '')
            {
                $_SESSION['constructr_login_attempt'] = '1';
            }
            else
            {
                $ATTEMPT_TRY = $_SESSION['constructr_login_attempt'];

                if($ATTEMPT_TRY >= 5)
                {
                    $_SESSION['constructr_login_blocked'] = time();
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                    die();
                }

                $_SESSION['constructr_login_attempt'] = ($ATTEMPT_TRY + 1);
            }

            $_ADMIN_USERNAME = $constructr -> request() -> post('_admin_username');
            $_ADMIN_PASSWORD = $constructr -> request() -> post('_admin_password');
            $_ADMIN_PASSWORD = crypt($_ADMIN_PASSWORD,$_CONSTRUCTR_CONF['_SALT']);
            $_ADMIN_GUID = $constructr -> request() -> post('_admin_guid');

            if($_ADMIN_GUID != $GUID)
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_ADMIN_USERNAME . ': ' . 'Login (GUID) error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                die();
            }

            if($_ADMIN_USERNAME != '' && $_ADMIN_PASSWORD != '')
            {
                try 
                {
                    $QUERY = $DBCON -> prepare('SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_password = :PASSWORD AND beu_active = :ACTIVE AND beu_art = :ART LIMIT 1;');
                    $QUERY -> execute( 
                        array
                        (
                            'USERNAME' => $_ADMIN_USERNAME,
                            'PASSWORD' => $_ADMIN_PASSWORD,
                            'ACTIVE' => 1,
                            'ART' => 0
                        ) 
                    );

                    $COUNTR = $QUERY -> rowCount();
                    $USER = $QUERY -> fetch();

                    if($COUNTR == 1)
                    {
                        $_SESSION['constructr_login_attempt'] = '';
                        $_SESSION['constructr_login_blocked'] = '';
                        $_SESSION['backend-user-username'] = $_ADMIN_USERNAME;
                        $_SESSION['backend-user-password'] = $_ADMIN_PASSWORD;
                        $USER_ID = $USER['beu_id'];
                        $_SESSION['backend-user-id'] = $USER_ID;
                        $LAST_LOGIN = date('Y-m-d H:i:s');

                        try 
                        {
                            $QUERY = 'UPDATE constructr_backenduser SET beu_last_login = :LAST_LOGIN WHERE beu_id = :USER_ID LIMIT 1;';
                            $STMT = $DBCON -> prepare($QUERY);
                            $STMT -> bindParam(':LAST_LOGIN',$LAST_LOGIN,PDO::PARAM_STR);
                            $STMT -> bindParam(':USER_ID',$USER_ID,PDO::PARAM_INT);
                            $STMT -> execute();
                        }
                        catch (PDOException $e)
                        {
                            $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                            die();
                        }

                        if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                        {
                            $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . 'Successful login ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');
                        die();
                    }
                    else
                    {
                        if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                        {
                            $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                        die();
                    }
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                    die();
                }
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                die();
            }
        }
    );