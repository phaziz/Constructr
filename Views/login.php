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

    $constructr -> get('/constructr/login/', function () use ($constructr,$_CONSTRUCTR_CONF,$DBCON)
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($_CONSTRUCTR_CONF['_RESET_LOGIN_PASSWORD'] == true)
            {
                $constructr -> getLog() -> debug('Constructr resetting User-Passwords...');

                try
                {
                    $BACKENDUSER = $DBCON -> query('SELECT * FROM constructr_backenduser');
                    $BACKENDUSER = $BACKENDUSER -> fetchAll();

                    if($BACKENDUSER)
                    {
                        foreach($BACKENDUSER AS $BACKENDUSER)
                        {
                            $USER_ID = $BACKENDUSER['beu_id'] . '<br>';
                            $NEW_PASSWORD = create_guid() . create_guid();
                            $NEW_PASSWORD_CRYPTED = crypt($NEW_PASSWORD,$_CONSTRUCTR_CONF['_SALT']);

                            try
                            {
                                $QUERY = 'UPDATE constructr_backenduser SET beu_password = :NEW_PASSWORD_CRYPTED WHERE beu_id = :USER_ID LIMIT 1;';
                                $STMT = $DBCON -> prepare($QUERY);
                                $STMT -> bindParam(':NEW_PASSWORD_CRYPTED',$NEW_PASSWORD_CRYPTED,PDO::PARAM_STR);
                                $STMT -> bindParam(':USER_ID',$USER_ID,PDO::PARAM_INT);
                                $STMT -> execute();
                            }
                            catch(PDOException $e)
                            {
                                $constructr -> getLog() -> error('Error resetting passwords: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/user/?edit=error');
                                die();
                            }

                            @mail($BACKENDUSER['beu_email'],'Constructr Password-Reset',date('d.m.Y, H:i') . ' Uhr //  New Password for your User: ' . $NEW_PASSWORD . ' - Please update as soon as possible!');
                        }
                    }
                }
                catch(PDOException $e) 
                {
                    $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    die();
                }

                $constructr -> getLog() -> debug('Constructr resetting User-Passwords... done!');
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
                    'TMP_USERNAME' => $_SESSION['TMP_LOGIN_NAME'],
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/' . $GUID . '/',
                    'SUBTITLE' => 'Login'
                )
            );
        }
    );

    $constructr -> post('/constructr/login/:GUID/', function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);
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

                if($ATTEMPT_TRY >= $_CONSTRUCTR_CONF['_MAX_LOGIN_ATTEMPTS'])
                {
                    $_SESSION['constructr_login_blocked'] = time();
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                    die();
                }

                $_SESSION['constructr_login_attempt'] = ($ATTEMPT_TRY + 1);
            }

            $_ADMIN_USERNAME = constructr_sanitization($constructr -> request() -> post('_admin_username'),true,true);
			$_SESSION['TMP_LOGIN_NAME'] = $_ADMIN_USERNAME;
            $_ADMIN_PASSWORD = constructr_sanitization($constructr -> request() -> post('_admin_password'),true,true);
            $_ADMIN_PASSWORD = crypt($_ADMIN_PASSWORD,$_CONSTRUCTR_CONF['_SALT']);
            $_ADMIN_GUID = constructr_sanitization($constructr -> request() -> post('_admin_guid'),true,true);

            if($_ADMIN_GUID != $GUID)
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error('Login (GUID) error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                die();
            }

            if($_ADMIN_USERNAME != '' && $_ADMIN_PASSWORD != '')
            {
                try 
                {
                    $ACTIVE = 1;
                    $ART = 0;

                    $QUERY = 'SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_password = :PASSWORD AND beu_active = :ACTIVE AND beu_art = :ART LIMIT 1;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':USERNAME',$_ADMIN_USERNAME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PASSWORD',$_ADMIN_PASSWORD,PDO::PARAM_STR);
                    $STMT -> bindParam(':ART',$ART,PDO::PARAM_INT);
                    $STMT -> bindParam(':ACTIVE',$ACTIVE,PDO::PARAM_INT);
                    $STMT -> execute();
                    $COUNTR = $STMT -> rowCount();
                    $USER = $STMT -> fetch();

                    if($COUNTR == 1)
                    {
                        $_SESSION['constructr_login_attempt'] = '';
                        $_SESSION['constructr_login_blocked'] = '';
                        $_SESSION['backend-user-username'] = $_ADMIN_USERNAME;
                        $_SESSION['backend-user-password'] = $_ADMIN_PASSWORD;
                        $USER_ID = $USER['beu_id'];
                        $_SESSION['backend-user-id'] = $USER_ID;
                        $LAST_LOGIN = date('Y-m-d H:i:s');
						$USER_EMAIL = $USER['beu_email'];
						$NEW_FACTOR = create_guid();

						try
                        {
                            $QUERY = 'UPDATE constructr_backenduser SET beu_last_login = :LAST_LOGIN,beu_factor = :FACTOR WHERE beu_id = :USER_ID LIMIT 1;';
                            $STMT = $DBCON -> prepare($QUERY);
                            $STMT -> bindParam(':LAST_LOGIN',$LAST_LOGIN,PDO::PARAM_STR);
                            $STMT -> bindParam(':USER_ID',$USER_ID,PDO::PARAM_INT);
							$STMT -> bindParam(':FACTOR',$NEW_FACTOR,PDO::PARAM_STR);
                            $STMT -> execute();
                        }
                        catch(PDOException $e)
                        {
                            $constructr -> getLog() -> debug($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                            die();
                        }

                        if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                        {
                            $constructr -> getLog() -> debug('Successful login ' . $_SESSION['backend-user-username']);
                        }

						$TO = $USER_EMAIL;
						$WHAT = 'Constructr Login Code';
						$MAIL = 'Your Code: ' . $NEW_FACTOR;
						mail($TO, $WHAT, $MAIL);

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login/');
                        die();
                    }
                    else
                    {
                        if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                        {
                            $constructr -> getLog() -> error('Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                        die();
                    }
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                    die();
                }
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error('Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-error/');
                die();
            }
        }
    );

    $constructr -> get('/constructr/verify-login/', function () use ($constructr,$_CONSTRUCTR_CONF,$DBCON)
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            $GUID = create_guid();

            $constructr -> render('admin_login_verify.php', 
                array
                (
                    '_METHOD' => 'post',
                    'GUID' => $GUID,
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login/' . $GUID . '/',
                    'SUBTITLE' => '2Faktor-Login',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF
                )
            );
        }
    );

    $constructr -> get('/constructr/verify-login-error/', function () use ($constructr,$_CONSTRUCTR_CONF,$DBCON)
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            $GUID = create_guid();

            $constructr -> render('admin_login_verify_error.php', 
                array
                (
                    '_METHOD' => 'post',
                    'GUID' => $GUID,
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login/' . $GUID . '/',
                    'SUBTITLE' => '2Faktor-Login Fehler',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF
                )
            );
        }
    );

    $constructr -> post('/constructr/verify-login/:GUID/', function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);
			$CODE = constructr_sanitization($constructr -> request() -> post('_code'),true,true);
			$_VERIFY_GUID = constructr_sanitization($constructr -> request() -> post('_verify_guid'),true,true);
            $_ADMIN_USERNAME = $_SESSION['backend-user-username'];
            $_ADMIN_PASSWORD = $_SESSION['backend-user-password'];

            if($_VERIFY_GUID != $GUID)
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error('Verify-Login (GUID) error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login-verify-error/');
                die();
            }

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

                if($ATTEMPT_TRY >= $_CONSTRUCTR_CONF['_MAX_LOGIN_ATTEMPTS'])
                {
                    $_SESSION['constructr_login_blocked'] = time();
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                    die();
                }

                $_SESSION['constructr_login_attempt'] = ($ATTEMPT_TRY + 1);
            }

            if($_ADMIN_USERNAME != '' && $_ADMIN_PASSWORD != '' && $_VERIFY_GUID != '')
            {
                try 
                {
                    $ACTIVE = 1;
                    $ART = 0;

                    $QUERY = 'SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_password = :PASSWORD AND beu_factor = :FACTOR AND beu_active = :ACTIVE AND beu_art = :ART LIMIT 1;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':USERNAME',$_ADMIN_USERNAME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PASSWORD',$_ADMIN_PASSWORD,PDO::PARAM_STR);
                    $STMT -> bindParam(':ART',$ART,PDO::PARAM_INT);
                    $STMT -> bindParam(':ACTIVE',$ACTIVE,PDO::PARAM_INT);
					$STMT -> bindParam(':FACTOR',$CODE,PDO::PARAM_STR);
                    $STMT -> execute();
                    $COUNTR = $STMT -> rowCount();
                    $USER = $STMT -> fetch();

                    if($COUNTR == 1)
                    {
                        $_SESSION['constructr_login_attempt'] = '';
                        $_SESSION['constructr_login_blocked'] = '';
                        $USER_ID = $USER['beu_id'];
                        $_SESSION['backend-user-id'] = $USER_ID;
                        $LAST_LOGIN = date('Y-m-d H:i:s');
						$USER_EMAIL = $USER['beu_email'];
						$NEW_FACTOR = '';

						try
                        {
                            $QUERY = 'UPDATE constructr_backenduser SET beu_last_login = :LAST_LOGIN,beu_factor = :FACTOR WHERE beu_id = :USER_ID LIMIT 1;';
                            $STMT = $DBCON -> prepare($QUERY);
                            $STMT -> bindParam(':LAST_LOGIN',$LAST_LOGIN,PDO::PARAM_STR);
                            $STMT -> bindParam(':USER_ID',$USER_ID,PDO::PARAM_INT);
							$STMT -> bindParam(':FACTOR',$NEW_FACTOR,PDO::PARAM_STR);
                            $STMT -> execute();
                        }
                        catch(PDOException $e)
                        {
                            $constructr -> getLog() -> debug($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login/');
                            die();
                        }

                        if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                        {
                            $constructr -> getLog() -> debug('Successful verified login ' . $_SESSION['backend-user-username']);
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');
                        die();
                    }
                    else
                    {
                        if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                        {
                            $constructr -> getLog() -> error('Verify Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login-error/');
                        die();
                    }
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login-error/');
                    die();
                }
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error('Verify Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/verify-login-error/');
                die();
            }
        }
    );