<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $app -> get('/admin(/)', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $BACKEND_USER_COUNTR = 0;
            $PAGES_COUNTR = 0;

            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try {
               $BACKENDUSER = $DBCON -> query('SELECT beu_id FROM backenduser;');
               $BACKEND_USER_COUNTR = $BACKENDUSER -> rowCount();               
               $PAGES = $DBCON -> query('SELECT pages_id FROM pages;');
               $PAGES_COUNTR = $PAGES -> rowCount();
               $UPLOADS = $DBCON -> query('SELECT media_id FROM media;');
               $UPLOADS_COUNTR = $UPLOADS -> rowCount();
            }
            catch (PDOException $e) 
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            $app -> render('admin.php',
                array(
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'BACKEND_USER_COUNTR' => $BACKEND_USER_COUNTR,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'UPLOADS_COUNTR' => $UPLOADS_COUNTR,
                    'SUBTITLE' => 'Admin-Dashboard',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
        }
    );
    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */