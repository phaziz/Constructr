<?php

    /*
     * BENUTZERVERWALTUNG START
     * */
    $constructr -> get('/constructr/user(/)', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $COUNTR = 0;

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
               $BACKENDUSER = $DBCON -> query('SELECT * FROM constructr_backenduser ORDER BY beu_id');
               $COUNTR = $BACKENDUSER -> rowCount();
            }
            catch (PDOException $e) 
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            
            $constructr -> render('user.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'BACKENDUSER' => $BACKENDUSER,
                    'COUNTR' => $COUNTR,
                    'SUBTITLE' => 'Admin-Dashboard / Benutzerverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/user/success(/)', $ADMIN_CHECK, function () use ($constructr)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('user_success.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Benutzerverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/user/error(/)', $ADMIN_CHECK, function () use ($constructr)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('user_error.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Benutzerverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/user/new(/)', $ADMIN_CHECK, function () use ($constructr)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('user_new.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Neuer Benutzer',
                    'FORM_ACTION' => _BASE_URL . '/constructr/user/new/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/user/new/check-username/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            $USERNAME = $constructr -> request() -> get('username');
            
            if($USERNAME != '')
            {
                try
                {
                    $BACKENDUSER = $DBCON -> prepare('SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME LIMIT 1;');

                    $BACKENDUSER -> execute(
                        array
                        (
                            ':USERNAME' => $USERNAME
                        )
                    );

                    $COUNTR = $BACKENDUSER -> rowCount();

                    if($COUNTR != 1)
                    {
                        if(_LOGGING == true)
                        {
                            $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/TRUE/');                
                        }

                        die();
                    }
                    else
                    {
                        if(_LOGGING == true)
                        {
                            $log = $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                        }

                        die();
                    }
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');

                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                }

                die();
            }
        }
    );

    $constructr -> get('/constructr/user/edit/:user_id/check-single-username/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USERNAME = $constructr -> request() -> get('username');

            if($USERNAME != '')
            {
                try
                {
                    $BACKENDUSER = $DBCON -> prepare('SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME LIMIT 1;');

                    $BACKENDUSER -> execute(
                        array
                        (
                            ':USERNAME' => $USERNAME
                        )
                    );

                    $COUNTR = $BACKENDUSER -> rowCount();

                    if($COUNTR == 1 || $COUNTR == 0)
                    {
                        if(_LOGGING == true)
                        {
                            $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/TRUE/');                
                        }

                        die();
                    }
                    else
                    {
                        if(_LOGGING == true)
                        {
                            $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                        }

                        die();
                    }
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                }
                die();
            }
        }
    );

    $constructr -> post('/constructr/user/new/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USERNAME = $constructr -> request() -> post('username');
            $PASSWORD = crypt($constructr -> request() -> post('password'),_SALT);
            $PASSWORD_RT = crypt($constructr -> request() -> post('password_retype'),_SALT);
            $EMAIL = $constructr -> request() -> post('email');
            $ART = $constructr -> request() -> post('art');
            $ACTIVE = 1;

            if($PASSWORD != $PASSWORD_RT)
            {
                $constructr -> redirect(_BASE_URL . 'admin/user/error/');
                die();
            }

            if($ART == 'intern')
            {
                $ART = 0;
            }
            else if($ART == 'extern')
            {
                $ART = 1;
            }

            if($USERNAME != '' && $PASSWORD != '' && EMAIL != '' && ART != '' && ACTIVE != '')
            {
                try
                {
                    $QUERY = $DBCON -> prepare('INSERT INTO constructr_backenduser SET beu_username = :USERNAME,beu_password = :PASSWORD,beu_email = :EMAIL,beu_art = :ART,beu_last_login  = :LAST_LOGIN,beu_active = :ACTIVE;');

                    $QUERY -> execute( 
                        array
                        (
                            'USERNAME' => $USERNAME,
                            'PASSWORD' => $PASSWORD,
                            'EMAIL' => $EMAIL,
                            'ART' => $ART,
                            'LAST_LOGIN' => '0000-00-00 00:00:00',
                            'ACTIVE' => $ACTIVE
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/success/');                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/success/');
                die();
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/error/');                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                die();
            }
        }
    );
    
    $constructr -> get('/constructr/user/edit/:USER_ID(/)', $ADMIN_CHECK, function ($USER_ID) use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
                $BACKENDUSER = $DBCON -> prepare('SELECT * FROM constructr_backenduser WHERE beu_id = :USER_ID LIMIT 1;');

                $BACKENDUSER -> execute(
                    array
                    (
                        ':USER_ID' => $USER_ID
                    )
                );

                $COUNTR = $BACKENDUSER -> rowCount();
                $BACKENDUSER = $BACKENDUSER -> fetch();

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            if($COUNTR == 1)
            {
                $constructr -> render('user_edit.php',
                    array
                    (
                        'MEM' => $MEM,
                        'USERNAME' => $USERNAME,
                        'BACKENDUSER' => $BACKENDUSER,
                        'SUBTITLE' => 'Admin-Dashboard / Benutzer editieren',
                        'FORM_ACTION' => _BASE_URL . '/constructr/user/edit/' . $USER_ID . '/',
                        'FORM_METHOD' => 'post',
                        'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                        'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                    )
                );
                die();
            }
            else
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                die();
            }
        }
    );

    $constructr -> post('/constructr/user/edit/:USER_ID(/)', $ADMIN_CHECK, function ($USER_ID) use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USERNAME = $constructr -> request() -> post('username');
            $PASSWORD = crypt($constructr -> request() -> post('password'),_SALT);
            $PASSWORD_RT = crypt($constructr -> request() -> post('password_retype'),_SALT);
            $EMAIL = $constructr -> request() -> post('email');
            $ART = $constructr -> request() -> post('art');
            $ACTIVE = 1;

            if($PASSWORD != $PASSWORD_RT)
            {
                $constructr -> redirect(_BASE_URL . 'admin/user/error/');
            }

            if($ART == 'intern')
            {
                $ART = 0;
            }
            else if($ART == 'extern')
            {
                $ART = 1;
            }

            if($USERNAME != '' && $PASSWORD != '' && EMAIL != '' && ART != '' && ACTIVE != '')
            {
                try
                {
                    $QUERY = 'UPDATE constructr_backenduser SET beu_username = :USERNAME,beu_password = :PASSWORD,beu_email = :EMAIL,beu_art = :ART,beu_active = :ACTIVE WHERE beu_id = :USER_ID LIMIT 1;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':USERNAME',$USERNAME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PASSWORD',$PASSWORD,PDO::PARAM_STR);
                    $STMT -> bindParam(':EMAIL',$EMAIL,PDO::PARAM_STR);
                    $STMT -> bindParam(':ART',$ART,PDO::PARAM_INT);                    
                    $STMT -> bindParam(':ACTIVE',$ACTIVE,PDO::PARAM_INT);
                    $STMT -> bindParam(':USER_ID',$USER_ID,PDO::PARAM_INT);
                    $STMT -> execute();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/success/');                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/success/');
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/error/');                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
            }
        }
    );

    $constructr -> get('/constructr/user/set-inactive/:USER_ID/', function ($USER_ID) use ($constructr,$DBCON)
        {
            if(USER_ID != '')
            {
                try
                {
                    $QUERY = $DBCON -> prepare('UPDATE constructr_backenduser SET beu_active = :INACTIVE WHERE beu_id = :USER_ID LIMIT 1;');
                    $QUERY -> execute( 
                        array
                        (
                            'INACTIVE' => 0,
                            'USER_ID' => $USER_ID
                        ) 
                    );

                    if(_LOGGING == true)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }

                    $constructr -> redirect(_BASE_URL . '/constructr/user/');
                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Error: No User_id (set-inactive): ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/');
                die();
            }
        }
    );

    $constructr -> get('/constructr/user/set-active/:USER_ID/', function ($USER_ID) use ($constructr,$DBCON)
        {
            if(USER_ID != '')
            {
                try
                {
                    $QUERY = $DBCON -> prepare('UPDATE constructr_backenduser SET beu_active = :INACTIVE WHERE beu_id = :USER_ID LIMIT 1;');

                    $QUERY -> execute( 
                        array
                        (
                            'INACTIVE' => 1,
                            'USER_ID' => $USER_ID
                        ) 
                    );

                    if(_LOGGING == true)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }

                    $constructr -> redirect(_BASE_URL . '/constructr/user/');
                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Error: No User_id (set-inactive): ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/');
                die();
            }
        }
    );

    $constructr -> get('/constructr/user/delete/:USER_ID/', function ($USER_ID) use ($constructr,$DBCON)
        {
            if(USER_ID != '')
            {
                try
                {
                    $QUERY = 'DELETE FROM backenduser WHERE beu_id = :USER_ID LIMIT 1;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':USER_ID', $USER_ID, PDO::PARAM_INT);   
                    $STMT -> execute();

                    if(_LOGGING == true)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }

                    $constructr -> redirect(_BASE_URL . '/constructr/user/');
                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Error: No User_id (set-inactive): ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/user/');
                die();
            }
        }
    );
    /*
     * BENUTZERVERWALTUNG ENDE
     * */