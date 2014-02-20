<?php

    /*
     * LOGIN START
     * */
    $app -> get('/admin/login(/)', function () use ($app)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            $GUID = create_guid();
            $app -> render('login.php', array(
                    '_METHOD' => 'post',
                    'GUID' => $GUID,
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => _BASE_URL . '/admin/login/' . $GUID . '/',
                    'SUBTITLE' => 'Login',
                )
            );
        }
    );

    $app -> get('/admin/login-error(/)', function () use ($app)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            $GUID = create_guid();
            $app -> render('admin_login_error.php', array(
                    '_METHOD' => 'post',
                    'GUID' => $GUID,
                    '_ENCTYPE' => 'application/x-www-form-urlencoded',
                    '_ACTION' => _BASE_URL . '/admin/login/' . $GUID . '/',
                    'SUBTITLE' => 'Login',
                )
            );
        }
    );

    $app -> post('/admin/login/:GUID/', function ($GUID) use ($app,$DBCON)
        {
            $_ADMIN_USERNAME = $app -> request() -> post('_admin_username');
            $_ADMIN_PASSWORD = $app -> request() -> post('_admin_password');
            $_ADMIN_PASSWORD = crypt($_ADMIN_PASSWORD,_SALT);
            $_ADMIN_GUID = $app -> request() -> post('_admin_guid');

            if($_ADMIN_GUID != $GUID){
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Login (GUID) error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
                $app -> redirect(_BASE_URL . '/admin/login-error/');
                die();
            }

            if($_ADMIN_USERNAME != '' && $_ADMIN_PASSWORD != '')
            {
                try {
                    $QUERY = $DBCON -> prepare('SELECT * FROM backenduser WHERE beu_username = :USERNAME AND beu_password = :PASSWORD AND beu_active = :ACTIVE AND beu_art = :ART LIMIT 1;');
                    $QUERY -> execute( 
                        array(
                            'USERNAME' => $_ADMIN_USERNAME,
                            'PASSWORD' => $_ADMIN_PASSWORD,
                            'ACTIVE' => 1,
                            'ART' => 0,
                            ) 
                    );
                    $COUNTR = $QUERY -> rowCount();
                    $USER = $QUERY -> fetch();

                    if($COUNTR == 1)
                    {
                        $_SESSION['backend-user-username'] = $_ADMIN_USERNAME;
                        $_SESSION['backend-user-password'] = $_ADMIN_PASSWORD;
                        $USER_ID = $USER['beu_id'];
                        $LAST_LOGIN = date('Y-m-d H:i:s');

                        try {
                            $QUERY = 'UPDATE backenduser SET beu_last_login = :LAST_LOGIN WHERE beu_id = :USER_ID LIMIT 1;';
                            $STMT = $DBCON -> prepare($QUERY);
                            $STMT -> bindParam(':LAST_LOGIN',$LAST_LOGIN,PDO::PARAM_STR);
                            $STMT -> bindParam(':USER_ID',$USER_ID,PDO::PARAM_INT);
                            $STMT -> execute();
                        } catch (PDOException $e) {
                            $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            $app -> redirect(_BASE_URL . '/admin/login-error/');
                            die();
                        }

                        if(_LOGGING == true)
                        {
                            $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . 'Successful login ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        }
                        $app -> redirect(_BASE_URL . '/admin/');
                        die();
                    } else {
                        if(_LOGGING == true)
                        {
                            $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        }
                        $app -> redirect(_BASE_URL . '/admin/login-error/');
                        die();
                    }
                } catch (PDOException $e) {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/login-error/');
                    die();
                }
            } else {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Login error - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
                $app -> redirect(_BASE_URL . '/admin/login-error/');
                die();
            }
        }
    );
    /*
     * LOGIN ENDE
     * */