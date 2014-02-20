<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $app -> get('/', function () use ($app)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            $GUID = create_guid();
            $app -> render('index.php', array(
                    'GUID' => $GUID,
                    'SUBTITLE' => 'Frontend',
                )
            );
        }
    );
    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */