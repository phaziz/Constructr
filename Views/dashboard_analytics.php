<?php

    $constructr -> get('/constructr/dashboard/analytics/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $BACKEND_USER_COUNTR = 0;
            $PAGES_COUNTR = 0;

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('analytics.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Constructr Analytics',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );