<?php

    $constructr -> get('/constructr/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $BACKEND_USER_COUNTR = 0;
            $PAGES_COUNTR = 0;

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
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

            $GUID = create_guid();

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            $constructr -> render('admin.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'GUID' => $GUID,
                    'BACKEND_USER_COUNTR' => $BACKEND_USER_COUNTR,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'UPLOADS_COUNTR' => $UPLOADS_COUNTR,
                    'SUBTITLE' => 'Admin-Dashboard',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    '_SERVE_STATIC' => true,
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/optimization/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            if($GUID == '')
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

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
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?optimized=true');
            }
            catch (PDOException $e) 
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }
        }
    );

    $constructr -> get('/constructr/generate-static/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            $constructr -> view -> setData('BackendUserRight',100);            

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
                catch (PDOException $e) 
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

            if($GUID == '')
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            try
            {
                $PAGE_CONTENT = $DBCON -> query('SELECT n.*, round((n.pages_rgt-n.pages_lft-1)/2,0) AS pages_subpages_countr, count(*)-1+(n.pages_lft>1) AS pages_level, ((min(p.pages_rgt)-n.pages_rgt-(n.pages_lft>1))/2) > 0 AS pages_lower, (((n.pages_lft-max(p.pages_lft)>1))) AS pages_upper FROM constructr_pages n, constructr_pages p WHERE n.pages_lft BETWEEN p.pages_lft AND p.pages_rgt AND (p.pages_id != n.pages_id OR n.pages_lft = 1) GROUP BY n.pages_id ORDER BY n.pages_lft;');
                $PAGE_CONTENT = $PAGE_CONTENT -> fetchAll();

                foreach($PAGE_CONTENT as $PAGE_CONTENT)
                {
                    $TARGET_DIR = $PAGE_CONTENT['pages_url'];
                    $BASE_DIR = $_CONSTRUCTR_CONF['_STATIC_DIR'];
                    $DIRS = explode('/',$TARGET_DIR);
                    $TMP_DIR = '';
                    $ACT_DIR = '';

                    if($PAGE_CONTENT['pages_lft'] != 1)
                    {
                        foreach($DIRS as $DIR)
                        {
                            if($TMP_DIR != '')
                            {
                                $ACT_DIR =  $BASE_DIR . '/' . $TMP_DIR . '/' . $DIR;
                                $TMP_DIR = $TMP_DIR .'/'. $DIR;

                                if(!is_dir($ACT_DIR))
                                {
                                    mkdir($ACT_DIR,0777,false);
                                }
                            }
                            else
                            {
                                $ACT_DIR = $BASE_DIR . '/' . $DIR;
                                $TMP_DIR = $DIR;
            
                                if(!is_dir($ACT_DIR))
                                {
                                    @mkdir($ACT_DIR,0777,false);
                                }
                            }
                        }
                    }

                    if(count($PAGE_CONTENT) != 0 && count($PAGE_CONTENT != ''))
                    {
                        $_HTML_CONTENT = file_get_contents($_CONSTRUCTR_CONF['_BASE_URL'] . '/' . $PAGE_CONTENT['pages_url'] . '?static-generation=true');
                        $_HTML_CONTENT = $_HTML_CONTENT . "\n<!-- ConstructrCMS generated static-file " . date('d.m.Y, H:i:s') . " -->";

                        if($_HTML_CONTENT != '')
                        {
                            if($PAGE_CONTENT['pages_lft'] == 1)
                            {
                                $PHYSICAL_FILE = fopen($BASE_DIR . '/' . 'index.php',"w+");
                                fwrite($PHYSICAL_FILE, $_HTML_CONTENT);
                                fclose($PHYSICAL_FILE);
                            }
                            else
                            {
                                $PHYSICAL_FILE = fopen($ACT_DIR . '/' . 'index.php',"w+");
                                fwrite($PHYSICAL_FILE, $_HTML_CONTENT);
                                fclose($PHYSICAL_FILE);
                            }
                        }
                    }
                }

                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?created-static=true');
                die();                
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?created-static=false');
                die();
            }
        }
    );