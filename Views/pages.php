<?php

    $constructr -> get('/constructr/pages/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $PAGES_COUNTR = 0;

            $constructr -> view -> setData('BackendUserRight',10);            

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
               $PAGES = $DBCON -> query('SELECT n.*, round((n.pages_rgt-n.pages_lft-1)/2,0) AS pages_subpages_countr, count(*)-1+(n.pages_lft>1) AS pages_level, ((min(p.pages_rgt)-n.pages_rgt-(n.pages_lft>1))/2) > 0 AS pages_lower, (((n.pages_lft-max(p.pages_lft)>1))) AS pages_upper FROM constructr_pages n, constructr_pages p WHERE n.pages_lft BETWEEN p.pages_lft AND p.pages_rgt AND (p.pages_id != n.pages_id OR n.pages_lft = 1) GROUP BY n.pages_id ORDER BY n.pages_lft;');
               $PAGES_COUNTR = $PAGES -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');             
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('pages.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'PAGES' => $PAGES,
                    'NEW_PAGES' => $NEW_PAGES,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'SUBTITLE' => 'Seitenverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );

            die();
        }
    );

    $constructr -> get('/constructr/pages/new/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);

            $constructr -> view -> setData('BackendUserRight',11);

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

            $USERNAME = $_SESSION['backend-user-username'];

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $PAGES_COUNTR = 0;

            try
            {
               $PAGES = $DBCON -> query('SELECT * FROM constructr_pages;');
               $PAGES_COUNTR = $PAGES -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');             
                die();
            }

            $GUID = create_guid();
            $TEMPLATES = array_diff(scandir($_CONSTRUCTR_CONF['_TEMPLATES_DIR']), array('..', '.'));
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('pages_new.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'GUID' => $GUID,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'TEMPLATES' => $TEMPLATES,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/new/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Neue Seite',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );

            die();
        }
    );

    $constructr -> post('/constructr/pages/new/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $constructr -> view -> setData('BackendUserRight',11);

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

            $USER_FORM_GUID = $constructr -> request() -> post('user_form_guid');
            if($GUID != $USER_FORM_GUID)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            $PAGE_DATETIME = date('Y-m-d H:i:s');
            $PAGE_NAME = constructr_sanitization($constructr -> request() -> post('page_name'));
            $PAGE_URL = constructr_sanitization($constructr -> request() -> post('page_url'));
            $PAGE_URL = preg_replace("[^A-Za-z0-9_-\/]", "", $PAGE_URL);
            $PAGE_URL = strtolower($PAGE_URL);
            $PAGE_TEMPLATE = constructr_sanitization($constructr -> request() -> post('page_template'));
            $PAGE_TITLE = constructr_sanitization($constructr -> request() -> post('page_title'));
            $PAGE_DESCRIPTION = constructr_sanitization($constructr -> request() -> post('page_description'));
            $PAGE_KEYWORDS = constructr_sanitization($constructr -> request() -> post('page_keywords'));
            $PAGE_VISIBILITY = constructr_sanitization($constructr -> request() -> post('page_nav_visible'));
            $SEARCHR = strripos($PAGE_URL, '/');

            if ($SEARCHR !== false)
            {
                if($SEARCHR == (strlen($PAGE_URL) - 1))
                {
                    $PAGE_URL = substr($PAGE_URL,0,($SEARCH - 1));
                }
            }
            
            $PAGE_LFT = 0;
            $PAGE_RGT = 0;
            $PAGE_ACTIVE = 0;
            $PAGES_COUNTR = 0;

            if($PAGE_URL == 'constructr')
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                die();
            }

            if($PAGE_TEMPLATE == '')
            {
                $PAGE_TEMPLATE = 'index.php';                
            }

            try 
            {
                $URL = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_url = :PAGE_URL;');
                $URL -> execute(
                    array
                    (
                        ':PAGE_URL' => $PAGE_URL
                    )
                );

                $URL_COUNTR = $URL -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                die();
            }

            if($URL_COUNTR != 0)
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=url-exists');
                die();
            }

            try 
            {
                $PAGES = $DBCON -> query('SELECT pages_id FROM constructr_pages;');
                $PAGES_COUNTR = $PAGES -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                die();
            }

            if($PAGES_COUNTR == 0) 
            {
                $PAGE_LFT = 1;
                $PAGE_RGT = 2;
            }
            else
            {
                try
                {
                    $PAGES = $DBCON -> query('SELECT * FROM constructr_pages ORDER BY pages_lft ASC LIMIT 1;');
                    $PAGES = $PAGES -> fetch();
                    $PAGE_LFT = $PAGES['pages_rgt'];
                    $PAGE_RGT = ($PAGES['pages_rgt'] + 1);
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                    die();
                }
            }

            if($PAGE_NAME != '' && $PAGE_LFT != '' && $PAGE_RGT != '' && $PAGE_DATETIME != '' && $PAGE_ACTIVE == 0)
            {
                try
                {
                    $UPDATE_PAGES = $DBCON -> prepare('UPDATE constructr_pages SET pages_rgt = pages_rgt+2  WHERE pages_rgt >= :PAGE_LFT;');
                    $UPDATE_PAGES -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                    die();
                }

                try
                {
                    $QUERY = 'INSERT INTO constructr_pages SET pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_nav_visible = ::PAGE_VISIBILITY,pages_url = :PAGE_URL,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_lft = :PAGE_LFT,pages_rgt = :PAGE_RGT,pages_active = :PAGE_ACTIVE;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_LFT',$PAGE_LFT,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_RGT',$PAGE_RGT,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
                    $STMT -> execute();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                    die();
                }

                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $NEW_LINE = "\n";
                $SITEMAP_FILE = './sitemap.xml';
                $CREATE_SITEMAP = fopen($SITEMAP_FILE,'w+');
                $SITEMAP_CONTENT = '<?xml version="1.0" encoding="UTF-8"?>' . $NEW_LINE . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $NEW_LINE;

                try
                {
                    $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_lft ASC;');
                    $SITEMAP_PAGES = $SITEMAP_PAGES -> fetchAll();

                    $START_PRIORITY = 0.8;
                    $MIN_PRIORITY = 0.3;

                    if($SITEMAP_PAGES)
                    {
                        if($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] == '')
                        {
                            $_SITEMAP_BASE_URL = $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'];    
                        }
                        else
                        {
                            $_SITEMAP_BASE_URL = $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'];
                        }

                        $OLD_PRIORITY = ($START_PRIORITY + 0.1);

                        foreach($SITEMAP_PAGES AS $SITEMAP_PAGE)
                        {
                            $PRIORITY = ($OLD_PRIORITY - 0.1);
                            
                            if($PRIORITY < $MIN_PRIORITY)
                            {
                                $PRIORITY = $MIN_PRIORITY;
                            }

                            $SITEMAP_CONTENT .= '<url>' . $NEW_LINE . '<loc>' . $_SITEMAP_BASE_URL . $SITEMAP_PAGE['pages_url'] . '</loc>' . $NEW_LINE . '<lastmod>' . date('Y-m-d') . '</lastmod>' . $NEW_LINE . '<changefreq>monthly</changefreq>' . $NEW_LINE . '<priority>' . $PRIORITY . '</priority>' . $NEW_LINE . '</url>' . $NEW_LINE;

                            $OLD_PRIORITY = $PRIORITY;
                        }                        
                    }
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                    die();
                }

                $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
                @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
                @fclose($CREATE_SITEMAP);
                @chmod(0777,$SITEMAP_FILE);

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');
                die();
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');

                die();
            }
        }
    );

    $constructr -> get('/constructr/pages/new/sub/:ID_MOTHER/:MOTHER_LFT/', $ADMIN_CHECK, function ($MOTHER_ID,$MOTHER_LFT) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',12);

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

            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $GUID = create_guid();
            $TEMPLATES = array_diff(scandir($_CONSTRUCTR_CONF['_TEMPLATES_DIR']), array('..', '.'));
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('pages_new_sub.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'GUID' => $GUID,
                    'TEMPLATES' => $TEMPLATES,
                    'MOTHER_ID' => $MOTHER_ID,
                    'MOTHER_LFT' => $MOTHER_LFT,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/new/sub/' . $GUID .'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Neue Unterseite',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );

            die();
        }
    );

    $constructr -> post('/constructr/pages/new/sub/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',12);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USER_FORM_GUID = $constructr -> request() -> post('user_form_guid');
            if($GUID != $USER_FORM_GUID)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            $PAGE_TMP_MARKER = '';
            $PAGE_DATETIME = date('Y-m-d H:i:s');
            $PAGE_MOTHER_ID = ($constructr -> request() -> post('mother_id'));
            $PAGE_MOTHER_LFT = ($constructr -> request() -> post('mother_lft'));
            $PAGE_NAME = ($constructr -> request() -> post('page_name'));
            $PAGE_URL = ($constructr -> request() -> post('page_url'));
            $PAGE_TEMPLATE = ($constructr -> request() -> post('page_template'));
            $PAGE_TITLE = ($constructr -> request() -> post('page_title'));
            $PAGE_DESCRIPTION = ($constructr -> request() -> post('page_description'));
            $PAGE_KEYWORDS = ($constructr -> request() -> post('page_keywords'));
            $PAGE_VISIBILITY = ($constructr -> request() -> post('page_nav_visible'));
            $PAGE_URL = str_replace('//','/',$PAGE_URL);
            $PAGE_URL = preg_replace("[^A-Za-z0-9_-\/]", "", $PAGE_URL);
            $PAGE_URL = strtolower($PAGE_URL);
            $PAGE_LFT = ($PAGE_MOTHER_LFT + 1);
            $PAGE_RGT = ($PAGE_LFT + 1);
            $PAGE_ACTIVE = 0;
            $PAGES_COUNTR = 0;

            if($PAGE_URL == 'constructr')
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                die();
            }

            if($PAGE_TEMPLATE == '')
            {
                $PAGE_TEMPLATE = 'index.php';
            }

            try
            {
                $URL = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_url = :PAGE_URL;');
                $URL -> execute(
                    array
                    (
                        ':PAGE_URL' => $PAGE_URL
                    )
                );

                $URL_COUNTR = $URL -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                die();
            }

            if($URL_COUNTR != 0)
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=url-exists');
                die();
            }

            if($PAGE_MOTHER_ID != '' && $PAGE_MOTHER_LFT != '' && $PAGE_NAME != '' && $PAGE_URL != '' && $PAGE_LFT != '' && $PAGE_RGT != '' && $PAGE_DATETIME != '' && $PAGE_ACTIVE == 0)
            {
                try
                {
                    $UPDATE_PAGES_LFT = $DBCON -> prepare('UPDATE constructr_pages SET pages_lft = pages_lft+2 WHERE pages_lft >= :PAGE_LFT ');
                    $UPDATE_PAGES_LFT -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT
                        )
                    );

                    $UPDATE_PAGES_RGT = $DBCON -> prepare('UPDATE constructr_pages SET pages_rgt = pages_rgt+2 WHERE pages_rgt >= :PAGE_LFT');
                    $UPDATE_PAGES_RGT -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');

                    die();
                }

                try
                {
                    $QUERY = 'INSERT INTO constructr_pages SET pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_url = :PAGE_URL,pages_nav_visible = :PAGE_VISIBILITY,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_lft = :PAGE_LFT,pages_rgt = :PAGE_RGT,pages_active = :PAGE_ACTIVE;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_LFT',$PAGE_LFT,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_RGT',$PAGE_RGT,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
                    $STMT -> execute();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                    die();
                }

                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');

                die();
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');

                die();
            }
        }
    );

    $constructr -> get('/constructr/pages/edit/:PAGE_ID/', $ADMIN_CHECK, function ($PAGE_ID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);

            $constructr -> view -> setData('BackendUserRight',13);

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

            $USERNAME = $_SESSION['backend-user-username'];

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
                $PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');

                $PAGE -> execute(
                    array(
                        ':PAGE_ID' => $PAGE_ID
                    )
                );

                $PAGE = $PAGE -> fetch();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=edit-page-false');
                echo 'nep';
                die();
            }

            $GUID = create_guid();
            $TEMPLATES = array_diff(scandir($_CONSTRUCTR_CONF['_TEMPLATES_DIR']), array('..', '.'));
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('pages_edit.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'GUID' => $GUID,
                    'PAGE' => $PAGE,
                    'TEMPLATES' => $TEMPLATES,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/edit/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Seite bearbeiten',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );

            die();
        }
    );

    $constructr -> post('/constructr/pages/edit/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',13);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $USER_FORM_GUID = $constructr -> request() -> post('user_form_guid');
            if($GUID != $USER_FORM_GUID)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            $PAGE_DATETIME = date('Y-m-d H:i:s');
            $PAGE_ID = constructr_sanitization($constructr -> request() -> post('page_id'));
            $PAGE_NAME = constructr_sanitization($constructr -> request() -> post('page_name'));
            $PAGE_URL = constructr_sanitization($constructr -> request() -> post('page_url'));
            $PAGE_TEMPLATE = constructr_sanitization($constructr -> request() -> post('page_template'));
            $PAGE_TITLE = constructr_sanitization($constructr -> request() -> post('page_title'));
            $PAGE_DESCRIPTION = constructr_sanitization($constructr -> request() -> post('page_description'));
            $PAGE_KEYWORDS = constructr_sanitization($constructr -> request() -> post('page_keywords'));
            $PAGE_VISIBILITY = constructr_sanitization($constructr -> request() -> post('page_nav_visible'));
            $PAGE_URL = str_replace('//','/',$PAGE_URL);
            $PAGE_URL = preg_replace("[^A-Za-z0-9_-\/]", "", $PAGE_URL);
            $PAGE_URL = strtolower($PAGE_URL);
            $SEARCHR = strripos($PAGE_URL, '/');

            if ($SEARCHR !== false)
            {
                if($SEARCHR == (strlen($PAGE_URL) - 1))
                {
                    $PAGE_URL = substr($PAGE_URL,0,($SEARCH - 1));
                }
            }

            if($PAGE_TEMPLATE == '')
            {
                $PAGE_TEMPLATE = 'index.php';
            }

            if($PAGE_NAME != '' && $PAGE_TEMPLATE != '' && $PAGE_ID != '')
            {
                try
                {
                    $QUERY = 'UPDATE constructr_pages SET pages_name = :PAGE_NAME, pages_url = :PAGE_URL, pages_nav_visible = :PAGE_VISIBILITY, pages_template = :PAGE_TEMPLATE, pages_title = :PAGE_TITLE, pages_description = :PAGE_DESCRIPTION, pages_keywords = :PAGE_KEYWORDS WHERE pages_id >= :PAGE_ID LIMIT 1;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':PAGE_ID',$PAGE_ID,PDO::PARAM_INT); - 
                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR); - 
                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR); - 
                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR); - 
                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR); - 
                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR); - 
                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR); - 
                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT); - 
                    $STMT -> execute();

                    if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                    }

                    $NEW_LINE = "\n";
                    $SITEMAP_FILE = './sitemap.xml';
                    $CREATE_SITEMAP = fopen($SITEMAP_FILE,'w+');
                    $SITEMAP_CONTENT = '<?xml version="1.0" encoding="UTF-8"?>' . $NEW_LINE . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $NEW_LINE;
    
                    try
                    {
                        $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_lft ASC;');
                        $SITEMAP_PAGES = $SITEMAP_PAGES -> fetchAll();
    
                        $START_PRIORITY = 0.8;
                        $MIN_PRIORITY = 0.3;
    
                        if($SITEMAP_PAGES)
                        {
                            if($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] == '')
                            {
                                $_SITEMAP_BASE_URL = $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'];    
                            }
                            else
                            {
                                $_SITEMAP_BASE_URL = $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'];
                            }
    
                            $OLD_PRIORITY = ($START_PRIORITY + 0.1);
    
                            foreach($SITEMAP_PAGES AS $SITEMAP_PAGE)
                            {
                                $PRIORITY = ($OLD_PRIORITY - 0.1);
                                
                                if($PRIORITY < $MIN_PRIORITY)
                                {
                                    $PRIORITY = $MIN_PRIORITY;
                                }
    
                                $SITEMAP_CONTENT .= '<url>' . $NEW_LINE . '<loc>' . $_SITEMAP_BASE_URL . $SITEMAP_PAGE['pages_url'] . '</loc>' . $NEW_LINE . '<lastmod>' . date('Y-m-d') . '</lastmod>' . $NEW_LINE . '<changefreq>monthly</changefreq>' . $NEW_LINE . '<priority>' . $PRIORITY . '</priority>' . $NEW_LINE . '</url>' . $NEW_LINE;
    
                                $OLD_PRIORITY = $PRIORITY;
                            }                        
                        }
                    }
                    catch (PDOException $e)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                        die();
                    }
    
                    $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
                    @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
                    @fclose($CREATE_SITEMAP);
                    @chmod(0777,$SITEMAP_FILE);

                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=edit-page-true');

                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());

                    if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                    }

                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=edit-page-false');
                    die();
                }
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=edit-page-false');

                die();
            }
        }
    );

    $constructr -> get('/constructr/pages/activate/:PAGE_ID/', $ADMIN_CHECK, function ($PAGE_ID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',14);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '')
            {
                try
                {
                    $UPDATE_PAGES = $DBCON -> prepare('UPDATE constructr_pages SET pages_active = :PAGE_ACTIVE WHERE pages_id = :PAGE_ID LIMIT 1;');
                    $UPDATE_PAGES -> execute(
                        array(
                            ':PAGE_ACTIVE' => 1,
                            ':PAGE_ID' => $PAGE_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=activate-page-false');
                    die();
                }
                
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=activate-page-true');

                die();
            }
            else
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=activate-page-false');

                die();
            }
        }
    );
    
    $constructr -> get('/constructr/pages/deactivate/:PAGE_ID/', $ADMIN_CHECK, function ($PAGE_ID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',14);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '')
            {
                try
                {
                    $UPDATE_PAGES = $DBCON -> prepare('UPDATE constructr_pages SET pages_active = :PAGE_ACTIVE WHERE pages_id = :PAGE_ID LIMIT 1;');
                    $UPDATE_PAGES -> execute(
                        array
                        (
                            ':PAGE_ACTIVE' => 0,
                            ':PAGE_ID' => $PAGE_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=activate-page-false');

                    die();
                }
                
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=activate-page-true');

                die();
            }
            else
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=activate-page-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/pages/delete-single/:PAGE_ID/:PAGE_LFT/:PAGE_RGT/', $ADMIN_CHECK, function ($PAGE_ID,$PAGE_LFT,$PAGE_RGT) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',15);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($PAGE_ID != '' && $PAGE_LFT != '' && $PAGE_RGT != '')
            {
                try
                {
                    $CONTENT = $DBCON -> prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID LIMIT 1;');
                    $CONTENT -> execute(
                        array
                        (
                            ':PAGE_ID' => $PAGE_ID
                        )
                    );

                    $CONTENT_COUNTR = $CONTENT -> rowCount();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }

                if($CONTENT_COUNTR != 0)
                {
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=content-not-empty');
                    die();
                }

                try
                {
                    $DELETER = $DBCON -> prepare('DELETE FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                    $DELETER -> execute(
                        array
                        (
                            ':PAGE_ID' => $PAGE_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }

                try
                {
                    $UPDATEER = $DBCON -> prepare('UPDATE constructr_pages SET pages_lft = pages_lft-1, pages_rgt = pages_rgt-1 WHERE pages_lft BETWEEN :PAGE_LFT AND :PAGE_RGT;');
                    $UPDATEER -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT,
                            ':PAGE_RGT' => $PAGE_RGT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }

                try
                {
                    $UPDATEER = $DBCON -> prepare('UPDATE constructr_pages SET pages_lft = pages_lft-2 WHERE pages_lft > :PAGE_RGT;');
                    $UPDATEER -> execute(
                        array
                        (
                            ':PAGE_RGT' => $PAGE_RGT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }

                try
                {
                    $UPDATEER = $DBCON -> prepare('UPDATE constructr_pages SET pages_rgt = pages_rgt-2 WHERE pages_rgt > :PAGE_RGT;');
                    $UPDATEER -> execute(
                        array
                        (
                            ':PAGE_RGT' => $PAGE_RGT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }

                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-true');
                die();
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                die();
            }
        }
    );
    
    $constructr -> get('/constructr/pages/delete-recursive/:PAGE_ID/:PAGE_LFT/:PAGE_RGT/', $ADMIN_CHECK, function ($PAGE_ID,$PAGE_LFT,$PAGE_RGT) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',16);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($PAGE_ID != '' && $PAGE_LFT != '' && $PAGE_RGT != '')
            {
                try
                {
                    $CONTENT = $DBCON -> prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID LIMIT 1;');
                    $CONTENT -> execute(
                        array
                        (
                            ':PAGE_ID' => $PAGE_ID
                        )
                    );

                    $CONTENT_COUNTR = $CONTENT -> rowCount();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-recursive-false');
                    die();
                }

                if($CONTENT_COUNTR != 0)
                {
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=content-not-empty');
                    die();
                }

                try
                {
                    $DELETER = $DBCON -> prepare('DELETE FROM constructr_pages WHERE pages_lft BETWEEN :PAGE_LFT AND :PAGE_RGT;');
                    $DELETER -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT,
                            ':PAGE_RGT' => $PAGE_RGT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-recursive-false');
                    die();
                }

                try
                {
                    $UPDATEER = $DBCON -> prepare('UPDATE constructr_pages SET pages_lft = pages_lft - ROUND((:PAGE_RGT-:PAGE_LFT+1)) WHERE pages_lft > :PAGE_RGT;');
                    $UPDATEER -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT,
                            ':PAGE_RGT' => $PAGE_RGT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-recursive-false');
                    die();
                }

                try
                {
                    $UPDATEER = $DBCON -> prepare('UPDATE constructr_pages SET pages_rgt = pages_rgt - ROUND((:PAGE_RGT-:PAGE_LFT+1)) WHERE pages_rgt > :PAGE_RGT;');
                    $UPDATEER -> execute(
                        array
                        (
                            ':PAGE_LFT' => $PAGE_LFT,
                            ':PAGE_RGT' => $PAGE_RGT
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-recursive-false');
                    die();
                }

                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-recursive-true');
                die();
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-recursive-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/pages/reorder/:METHOD/:PAGE_ID/', $ADMIN_CHECK, function ($METHOD,$PAGE_ID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',17);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($METHOD != '' && $PAGE_ID != '')
            {
                try
                {
                    $SELEKTOR = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                    $SELEKTOR -> execute(array(':PAGE_ID' => $PAGE_ID));
                    $SELEKTOR = $SELEKTOR -> fetch();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug('1) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                    die();
                }

                $PAGE_ID = $SELEKTOR['pages_id'];
                $PAGE_LFT = $SELEKTOR['pages_lft'];
                $PAGE_RGT = $SELEKTOR['pages_rgt'];
                $CHILDREN_COUNTER = (($PAGE_RGT - $PAGE_LFT - 1) / 2);

                if($METHOD == 'up')
                {
                    try
                    {
                        $SELECT_TARGET_PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_rgt = :TARGET_PAGE LIMIT 1;');
                        $SELECT_TARGET_PAGE -> execute(array(':TARGET_PAGE' => ($PAGE_LFT - 1)));
                        $SELECT_TARGET_PAGE = $SELECT_TARGET_PAGE -> fetch();
                        $TARGET_PAGE_ID = $SELECT_TARGET_PAGE['pages_id'];
                        $TARGET_PAGE_LFT = $SELECT_TARGET_PAGE['pages_lft'];
                        $TARGET_PAGE_RGT = $SELECT_TARGET_PAGE['pages_rgt'];
                        $TARGET_CHILDREN_COUNTER = (($TARGET_PAGE_RGT - $TARGET_PAGE_LFT - 1) / 2);
                    }
                    catch (PDOException $e)
                    {
                        $constructr -> getLog() -> debug('3) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                        die();
                    }
                }
                else if($METHOD == 'down')
                {
                    try
                    {
                        $SELECT_TARGET_PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_lft = :TARGET_PAGE LIMIT 1;');
                        $SELECT_TARGET_PAGE -> execute(array(':TARGET_PAGE' => ($PAGE_RGT + 1)));
                        $SELECT_TARGET_PAGE = $SELECT_TARGET_PAGE -> fetch();
                        $TARGET_PAGE_ID = $SELECT_TARGET_PAGE['pages_id'];
                        $TARGET_PAGE_LFT = $SELECT_TARGET_PAGE['pages_lft'];
                        $TARGET_PAGE_RGT = $SELECT_TARGET_PAGE['pages_rgt'];
                        $TARGET_CHILDREN_COUNTER = (($TARGET_PAGE_RGT - $TARGET_PAGE_LFT - 1) / 2);
                    }
                    catch (PDOException $e)
                    {
                        $constructr -> getLog() -> debug('3) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                        die();
                    }
                }

                if($CHILDREN_COUNTER == 0 && $TARGET_CHILDREN_COUNTER == 0)
                {
                    try
                    {
                        $UPDATE_PAGES = $DBCON -> prepare('
                            UPDATE constructr_pages SET pages_lft = :TARGET_PAGE_LFT, pages_rgt = :TARGET_PAGE_RGT WHERE pages_id = :PAGE_ID LIMIT 1;
                            UPDATE constructr_pages SET pages_lft = :PAGE_LFT, pages_rgt = :PAGE_RGT WHERE pages_id = :TARGET_PAGE_ID LIMIT 1;
                        ');

                        $UPDATE_PAGES -> execute(
                            array
                            (
                                ':PAGE_ID' => $PAGE_ID,
                                ':PAGE_LFT' => $PAGE_LFT,
                                ':PAGE_RGT' => $PAGE_RGT,
                                ':TARGET_PAGE_ID' => $TARGET_PAGE_ID,
                                ':TARGET_PAGE_LFT' => $TARGET_PAGE_LFT,
                                ':TARGET_PAGE_RGT' => $TARGET_PAGE_RGT
                            )
                        );
                    }
                    catch (PDOException $e)
                    {
                        $constructr -> getLog() -> debug('5) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                        die();
                    }

                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-success');
                    die();
                }
                else
                {
                    $CHILDREN_COUNTER = $CHILDREN_COUNTER + 1;
                    $TARGET_CHILDREN_COUNTER = $TARGET_CHILDREN_COUNTER + 1;
                    $TEMP_MARKER = 1;
                    $EMPTY_VALUE = 0;

                    if($METHOD == 'up')
                    {
                        try
                        {
                            $UPDATE_PAGES = $DBCON -> prepare('
                                UPDATE constructr_pages SET pages_temp_marker = :TEMP_MARKER WHERE pages_lft BETWEEN :TARGET_PAGE_LFT AND :TARGET_PAGE_RGT;
                                UPDATE constructr_pages SET pages_lft = (pages_lft - (:TARGET_CHILDREN_COUNTER * 2)), pages_rgt = (pages_rgt - (:TARGET_CHILDREN_COUNTER * 2)) WHERE pages_lft BETWEEN :PAGE_LFT AND :PAGE_RGT AND pages_temp_marker = :EMPTY_VALUE;
                                UPDATE constructr_pages SET pages_lft = (pages_lft + (:CHILDREN_COUNTER * 2)), pages_rgt = (pages_rgt + (:CHILDREN_COUNTER * 2)) WHERE pages_lft BETWEEN :TARGET_PAGE_LFT AND :TARGET_PAGE_RGT AND pages_temp_marker = :TEMP_MARKER;
                                UPDATE constructr_pages SET pages_temp_marker = :EMPTY_VALUE WHERE pages_temp_marker = :TEMP_MARKER;
                            ');

                            $UPDATE_PAGES -> execute(
                                array
                                (
                                    ':PAGE_ID' => $PAGE_ID,
                                    ':PAGE_LFT' => $PAGE_LFT,
                                    ':PAGE_RGT' => $PAGE_RGT,
                                    ':CHILDREN_COUNTER' => $CHILDREN_COUNTER,
                                    ':TARGET_PAGE_ID' => $TARGET_PAGE_ID,
                                    ':TARGET_PAGE_LFT' => $TARGET_PAGE_LFT,
                                    ':TARGET_PAGE_RGT' => $TARGET_PAGE_RGT,
                                    ':TARGET_CHILDREN_COUNTER' => $TARGET_CHILDREN_COUNTER,
                                    ':EMPTY_VALUE' => $EMPTY_VALUE,
                                    ':TEMP_MARKER' => $TEMP_MARKER
                                )
                            );
                        }
                        catch (PDOException $e)
                        {
                            $constructr -> getLog() -> debug('5) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                            die();
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-success');
                        die();
                    }
                    else
                    {
                        try
                        {
                            $UPDATE_PAGES = $DBCON -> prepare('
                                UPDATE constructr_pages SET pages_temp_marker = :TEMP_MARKER WHERE pages_lft BETWEEN :TARGET_PAGE_LFT AND :TARGET_PAGE_RGT;
                                UPDATE constructr_pages SET pages_lft = (pages_lft + (:TARGET_CHILDREN_COUNTER * 2)), pages_rgt = (pages_rgt + (:TARGET_CHILDREN_COUNTER * 2)) WHERE pages_lft BETWEEN :PAGE_LFT AND :PAGE_RGT AND pages_temp_marker = :EMPTY_VALUE;
                                UPDATE constructr_pages SET pages_lft = (pages_lft - (:CHILDREN_COUNTER * 2)), pages_rgt = (pages_rgt - (:CHILDREN_COUNTER * 2)) WHERE pages_lft BETWEEN :TARGET_PAGE_LFT AND :TARGET_PAGE_RGT AND pages_temp_marker = :TEMP_MARKER;
                                UPDATE constructr_pages SET pages_temp_marker = :EMPTY_VALUE WHERE pages_temp_marker = :TEMP_MARKER;
                            ');

                            $UPDATE_PAGES -> execute(
                                array
                                (
                                    ':PAGE_ID' => $PAGE_ID,
                                    ':PAGE_LFT' => $PAGE_LFT,
                                    ':PAGE_RGT' => $PAGE_RGT,
                                    ':CHILDREN_COUNTER' => $CHILDREN_COUNTER,
                                    ':TARGET_PAGE_ID' => $TARGET_PAGE_ID,
                                    ':TARGET_PAGE_LFT' => $TARGET_PAGE_LFT,
                                    ':TARGET_PAGE_RGT' => $TARGET_PAGE_RGT,
                                    ':TARGET_CHILDREN_COUNTER' => $TARGET_CHILDREN_COUNTER,
                                    ':EMPTY_VALUE' => $EMPTY_VALUE,
                                    ':TEMP_MARKER' => $TEMP_MARKER
                                )
                            );
                        }
                        catch (PDOException $e)
                        {
                            $constructr -> getLog() -> debug('5) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                            die();
                        }

                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-success');
                        die();
                    }
                }
                die();
            }
            else
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                die();
            }
        }
    );