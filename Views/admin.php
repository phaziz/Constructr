<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $constructr -> get('/constructr(/)', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $BACKEND_USER_COUNTR = 0;
            $PAGES_COUNTR = 0;

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
               $BACKENDUSER = $DBCON -> query('SELECT beu_id FROM constructr_backenduser;');
               $BACKEND_USER_COUNTR = $BACKENDUSER -> rowCount();               
               $PAGES = $DBCON -> query('SELECT pages_id FROM constructr_pages;');
               $PAGES_COUNTR = $PAGES -> rowCount();
               $UPLOADS = $DBCON -> query('SELECT media_id FROM constructr_media;');
               $UPLOADS_COUNTR = $UPLOADS -> rowCount();
            }
            catch (PDOException $e) 
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            $constructr -> render('admin.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'BACKEND_USER_COUNTR' => $BACKEND_USER_COUNTR,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'UPLOADS_COUNTR' => $UPLOADS_COUNTR,
                    'SUBTITLE' => 'Admin-Dashboard',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/optimization/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            try
            {
                $OPTIMIZER = $DBCON -> query('
                    OPTIMIZE TABLE constructr_backenduser;
                    OPTIMIZE TABLE constructr_backenduser_rights;
                    OPTIMIZE TABLE constructr_content;
                    OPTIMIZE TABLE constructr_media;
                    OPTIMIZE TABLE constructr_pages;
                ');
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect('../?optimized=true');
            }
            catch (PDOException $e) 
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }
        }
    );
    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */