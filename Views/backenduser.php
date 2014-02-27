<?php

    /*
     * BENUTZERVERWALTUNG START
     * */
    $app -> get('/admin/user(/)', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $COUNTR = 0;

            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
               $BACKENDUSER = $DBCON -> query('SELECT * FROM backenduser ORDER BY beu_id');
               $COUNTR = $BACKENDUSER -> rowCount();
            }
            catch (PDOException $e) 
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            
            $app -> render('user.php',
                array(
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'BACKENDUSER' => $BACKENDUSER,
                    'COUNTR' => $COUNTR,
                    'SUBTITLE' => 'Admin-Dashboard / Benutzerverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
        }
    );

    $app -> get('/admin/user/success(/)', $ADMIN_CHECK, function () use ($app)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $app -> render('user_success.php',
                array(
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Benutzerverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
        }
    );

    $app -> get('/admin/user/error(/)', $ADMIN_CHECK, function () use ($app)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $app -> render('user_error.php',
                array(
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Benutzerverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
        }
    );

    $app -> get('/admin/user/new(/)', $ADMIN_CHECK, function () use ($app)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $app -> render('user_new.php',
                array(
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Neuer Benutzer',
                    'FORM_ACTION' => _BASE_URL . '/admin/user/new/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
        }
    );

    $app -> get('/admin/user/new/check-username/', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            $USERNAME       = $app -> request() -> get('username');
            
            if($USERNAME != '')
            {
                try
                {
                    $BACKENDUSER = $DBCON -> prepare('SELECT * FROM backenduser WHERE beu_username = :USERNAME LIMIT 1;');

                    $BACKENDUSER -> execute(
                        array(
                            ':USERNAME' => $USERNAME
                        )
                    );

                    $COUNTR = $BACKENDUSER -> rowCount();

                    if($COUNTR != 1)
                    {
                        if(_LOGGING == true)
                        {
                            $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/TRUE/');                
                        }

                        die();
                    }
                    else
                    {
                        if(_LOGGING == true)
                        {
                            $log = $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                        }

                        die();
                    }
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');

                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                }

                die();
            }
        }
    );

    $app -> get('/admin/user/edit/:user_id/check-single-username/', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USERNAME       = $app -> request() -> get('username');

            if($USERNAME != '')
            {
                try
                {
                    $BACKENDUSER = $DBCON -> prepare('SELECT * FROM backenduser WHERE beu_username = :USERNAME LIMIT 1;');

                    $BACKENDUSER -> execute(
                        array(
                            ':USERNAME' => $USERNAME
                        )
                    );

                    $COUNTR = $BACKENDUSER -> rowCount();

                    if($COUNTR == 1 || $COUNTR == 0)
                    {
                        if(_LOGGING == true)
                        {
                            $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/TRUE/');                
                        }

                        die();
                    }
                    else
                    {
                        if(_LOGGING == true)
                        {
                            $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                        }

                        die();
                    }
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/FALSE/');                
                }
                die();
            }
        }
    );

    $app -> post('/admin/user/new/', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USERNAME       = $app -> request() -> post('username');
            $PASSWORD       = crypt($app -> request() -> post('password'),_SALT);
            $PASSWORD_RT    = crypt($app -> request() -> post('password_retype'),_SALT);
            $EMAIL          = $app -> request() -> post('email');
            $ART            = $app -> request() -> post('art');
            $ACTIVE         = 1;

            if($PASSWORD != $PASSWORD_RT)
            {
                $app -> redirect(_BASE_URL . 'admin/user/error/');
                die();
            }

            if($ART == 'intern'){
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
                    $QUERY = $DBCON -> prepare('INSERT INTO backenduser SET beu_username = :USERNAME,beu_password = :PASSWORD,beu_email = :EMAIL,beu_art = :ART,beu_last_login  = :LAST_LOGIN,beu_active = :ACTIVE;');

                    $QUERY -> execute( 
                        array(
                            'USERNAME' => $USERNAME,
                            'PASSWORD' => $PASSWORD,
                            'EMAIL' => $EMAIL,
                            'ART' => $ART,
                            'LAST_LOGIN' => '0000-00-00 00:00:00',
                            'ACTIVE' => $ACTIVE,
                            )
                    );
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');
                    die();
                }

                if(_LOGGING == true)
                {
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/success/');                
                }

                $app -> redirect(_BASE_URL . '/admin/user/success/');
                die();
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/error/');                
                }

                $app -> redirect(_BASE_URL . '/admin/user/error/');
                die();
            }
        }
    );
    
    $app -> get('/admin/user/edit/:USER_ID(/)', $ADMIN_CHECK, function ($USER_ID) use ($app,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
                $BACKENDUSER = $DBCON -> prepare('SELECT * FROM backenduser WHERE beu_id = :USER_ID LIMIT 1;');

                $BACKENDUSER -> execute(
                    array(
                        ':USER_ID' => $USER_ID
                    )
                );

                $COUNTR = $BACKENDUSER -> rowCount();
                $BACKENDUSER = $BACKENDUSER -> fetch();

                if(_LOGGING == true)
                {
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
            }
            catch (PDOException $e)
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $app -> redirect(_BASE_URL . '/admin/user/error/');
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            if($COUNTR == 1)
            {
                $app -> render('user_edit.php',
                    array(
                        'MEM' => $MEM,
                        'USERNAME' => $USERNAME,
                        'BACKENDUSER' => $BACKENDUSER,
                        'SUBTITLE' => 'Admin-Dashboard / Benutzer editieren',
                        'FORM_ACTION' => _BASE_URL . '/admin/user/edit/' . $USER_ID . '/',
                        'FORM_METHOD' => 'post',
                        'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                        'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                    )
                );
                die();
            }
            else
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $app -> redirect(_BASE_URL . '/admin/user/error/');
                die();
            }
        }
    );

    $app -> post('/admin/user/edit/:USER_ID(/)', $ADMIN_CHECK, function ($USER_ID) use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USERNAME       = $app -> request() -> post('username');
            $PASSWORD       = crypt($app -> request() -> post('password'),_SALT);
            $PASSWORD_RT    = crypt($app -> request() -> post('password_retype'),_SALT);
            $EMAIL          = $app -> request() -> post('email');
            $ART            = $app -> request() -> post('art');
            $ACTIVE         = 1;

            if($PASSWORD != $PASSWORD_RT)
            {
                $app -> redirect(_BASE_URL . 'admin/user/error/');
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
                    $QUERY = 'UPDATE backenduser SET beu_username = :USERNAME,beu_password = :PASSWORD,beu_email = :EMAIL,beu_art = :ART,beu_active = :ACTIVE WHERE beu_id = :USER_ID LIMIT 1;';
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
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');
                    die();
                }

                if(_LOGGING == true)
                {
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/success/');                
                }

                $app -> redirect(_BASE_URL . '/admin/user/success/');
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $USERNAME . '/create/error/');                
                }

                $app -> redirect(_BASE_URL . '/admin/user/error/');
            }
        }
    );

    $app -> get('/admin/user/set-inactive/:USER_ID/', function ($USER_ID) use ($app,$DBCON)
        {
            if(USER_ID != '')
            {
                try
                {
                    $QUERY = $DBCON -> prepare('UPDATE backenduser SET beu_active = :INACTIVE WHERE beu_id = :USER_ID LIMIT 1;');
                    $QUERY -> execute( 
                        array(
                            'INACTIVE' => 0,
                            'USER_ID' => $USER_ID,
                            ) 
                    );

                    if(_LOGGING == true)
                    {
                        $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }

                    $app -> redirect(_BASE_URL . '/admin/user/');
                    die();
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Error: No User_id (set-inactive): ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $app -> redirect(_BASE_URL . '/admin/user/');
                die();
            }
        }
    );

    $app -> get('/admin/user/set-active/:USER_ID/', function ($USER_ID) use ($app,$DBCON)
        {
            if(USER_ID != '')
            {
                try
                {
                    $QUERY = $DBCON -> prepare('UPDATE backenduser SET beu_active = :INACTIVE WHERE beu_id = :USER_ID LIMIT 1;');

                    $QUERY -> execute( 
                        array(
                            'INACTIVE' => 1,
                            'USER_ID' => $USER_ID,
                            ) 
                    );

                    if(_LOGGING == true)
                    {
                        $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }

                    $app -> redirect(_BASE_URL . '/admin/user/');
                    die();
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Error: No User_id (set-inactive): ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $app -> redirect(_BASE_URL . '/admin/user/');
                die();
            }
        }
    );

    $app -> get('/admin/user/delete/:USER_ID/', function ($USER_ID) use ($app,$DBCON)
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
                        $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }

                    $app -> redirect(_BASE_URL . '/admin/user/');
                    die();
                }
                catch (PDOException $e)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/user/error/');
                    die();
                }
            }
            else
            {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . 'Error: No User_id (set-inactive): ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $app -> redirect(_BASE_URL . '/admin/user/');
                die();
            }
        }
    );
    /*
     * BENUTZERVERWALTUNG ENDE
     * */