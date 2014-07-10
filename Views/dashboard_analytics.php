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

    $constructr -> get('/constructr/dashboard/analytics/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            $constructr -> view -> setData('BackendUserRight',90);

            if(isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '')
            {
                try
                {
                    $RIGHT_CHECKER = $DBCON -> prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER -> execute(
                        array
                        (
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr -> view -> getData('BackendUserRight'),
                            ':CBR_VALUE' => 1
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER -> rowCount();

                    if($RIGHTS_COUNTR != 1)
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ' User-Rights-Error ' . $constructr -> view -> getData('BackendUserRight') . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?no-rights=true');
                        die();
                    }
                    else
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ' User-Rights-Success ' . $constructr -> view -> getData('BackendUserRight') . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    }
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    die();
                }
            }
            else
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': Error User-Rights-Check: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            $BACKEND_USER_COUNTR = 0;
            $PAGES_COUNTR = 0;

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $LOGS_DIR = $_CONSTRUCTR_CONF['_CONSTRUCTR_LOGFILES_PATH'];
            $ALL_LOGS = getFilesFromDir($LOGS_DIR);
            $ANALYTICS_ARRAY = array();
            $ANALYTICS_COUNTR = 0;

            if($ALL_LOGS)
            {
                foreach($ALL_LOGS as $ALL_LOGS_KEY => $ALL_LOGS_VALUE)
                {
                    $LOGS_CONTENT = file_get_contents($ALL_LOGS_VALUE);
                    $LOGS_LINES_ARRAY = explode("\n",$LOGS_CONTENT);

                    foreach($LOGS_LINES_ARRAY as $KEY => $VALUE)
                    {
                        $pos = strpos($VALUE,'###CONSTRUCTR_ANALYTICS###');

                        if ($pos !== false)
                        {
                            $VALUE = explode('###CONSTRUCTR_ANALYTICS###',$VALUE);                                                        
                            $DATA = explode(':::',$VALUE[1]);

                            $URI = $DATA[0];
                            $TIMESTAMP = $DATA[0];
                            $UUID = $DATA[0];
                            $BROWSER = $DATA[0];
                            $BROWSER_NICKNAME = $DATA[0];
                            $BROWSER_VERSION = $DATA[0];
                            $BROWSER_HTTP_STRING = $DATA[0];
                            $BROWSER_PLATTFORM = $DATA[0];
                            $BROWSER_LANGUAGE = $DATA[0];
                            $SCREEN_PIXELDEPTH = $DATA[0];
                            $SCREEN_COLORDEPTH = $DATA[0];
                            $SCREEN_AVAIL_HEIGHT = $DATA[0];
                            $SCREEN_AVAIL_WIDTH = $DATA[0];
                            $SCREEN_HEIGHT = $DATA[0];
                            $SCREEN_WIDTH = $DATA[0];

                            $ANALYTICS_ARRAY[$KEY] = array
                            (
                                'uri' => $DATA[0],
                                'referrer' => $DATA[15],
                                'timestamp' => $DATA[1],
                                'date_day' => $datum = date("d",$DATA[1]),
                                'date_month' => $datum = date("m",$DATA[1]),
                                'date_year' => $datum = date("Y",$DATA[1]),
                                'date_hour' => $datum = date("H",$DATA[1]),
                                'date_minutes' => $datum = date("m",$DATA[1]),
                                'date_seconds' => $datum = date("s",$DATA[1]),
                                'uuid' => $DATA[2],
                                'browser' => $DATA[3],
                                'browser_nickname' => $DATA[4],
                                'browser_version' => $DATA[5],
                                'browser_http_string' => $DATA[6],
                                'plattform' => $DATA[7],
                                'language' => $DATA[8],
                                'pixeldepth' => $DATA[9],
                                'colordepth' => $DATA[10],
                                'avail_height' => $DATA[11],
                                'avail_width' => $DATA[12],
                                'screen_height' => $DATA[13],
                                'screen_width' => $DATA[14]
                            );
                        }
                    }

                    $ANALYTICS_ARRAY = array_orderby($ANALYTICS_ARRAY, 'timestamp', SORT_DESC);
                    $ANALYTICS_COUNTR = count($ANALYTICS_ARRAY);
                }
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('analytics.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'ANALYTICS_ARRAY' => $ANALYTICS_ARRAY,
                    'ANALYTICS_COUNTR' => $ANALYTICS_COUNTR,
                    'SUBTITLE' => 'Constructr Analytics',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );