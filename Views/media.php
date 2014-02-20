<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $app -> get('/admin/media(/)', $ADMIN_CHECK, function () use ($app)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            $app -> render('media.php',array(
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Medienverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
            die();
        }
    );
    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */