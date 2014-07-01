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
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/searchr/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
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

    $constructr -> post('/constructr/searchr/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            
            $constructr -> view -> setData('BackendUserRight',30);

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

            $NEEDLES = constructr_sanitization($constructr -> request() -> post('needles'),true,true);
            $USER_FORM_GUID = constructr_sanitization($constructr -> request() -> post('user_form_guid'));

            if($NEEDLES)
            {
                if($GUID != $USER_FORM_GUID)
                {
                    $constructr -> getLog() -> error('SearchForm GUID Error - ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');
                    die();
                }

                $NEEDLES = explode(' ',trim($NEEDLES));
                $SEARCHR = array();

                foreach($NEEDLES AS $NEEDLE)
                {
                    $NEEDLE = '%' . $NEEDLE . '%';

                    try
                    {
                        $SEARCH_QUERY_PAGES = 'SELECT * FROM constructr_pages WHERE pages_name LIKE :NEEDLE OR pages_url LIKE :NEEDLE OR pages_template LIKE :NEEDLE OR pages_title LIKE :NEEDLE OR pages_description LIKE :NEEDLE OR pages_keywords LIKE :NEEDLE;';
                        $STMT = $DBCON -> prepare($SEARCH_QUERY_PAGES);
                        $STMT -> bindParam(':NEEDLE',$NEEDLE,PDO::PARAM_STR);
                        $STMT -> execute();
                        $SEARCH_QUERY_PAGES = $STMT -> fetchAll();

                        if($SEARCH_QUERY_PAGES)
                        {
                            foreach($SEARCH_QUERY_PAGES AS $SEARCH_QUERY_PAGES)
                            {
                                $SEARCHR['pages_' . $SEARCH_QUERY_PAGES['pages_id']] = array
                                (
                                    'id' => $SEARCH_QUERY_PAGES['pages_id'],
                                    'name' => 'Seite "' . $SEARCH_QUERY_PAGES['pages_name'] . '" ansehen &#8250;&#8250;&#8250;',
                                    'result_link' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/edit/' . $SEARCH_QUERY_PAGES['pages_id'] . '/'
                                );
                            }
                        }
                    }
                    catch (PDOException $e) 
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');                
                        die();
                    }

                    try
                    {
                        
                        $SEARCH_QUERY_CONTENT = 'SELECT * FROM constructr_content WHERE content_content LIKE :NEEDLE;';
                        $STMT = $DBCON -> prepare($SEARCH_QUERY_CONTENT);
                        $STMT -> bindParam(':NEEDLE',$NEEDLE,PDO::PARAM_STR);
                        $STMT -> execute();
                        $SEARCH_QUERY_CONTENT = $STMT -> fetchAll();

                        if($SEARCH_QUERY_CONTENT)
                        {
                            foreach($SEARCH_QUERY_CONTENT AS $SEARCH_QUERY_CONTENT)
                            {
                                $SEARCHR['content_' . $SEARCH_QUERY_CONTENT['content_id']] = array
                                (
                                    'id' => $SEARCH_QUERY_CONTENT['content_id'],
                                    'name' => 'Inhalt "' . htmlentities($SEARCH_QUERY_CONTENT['content_content']) . '" ansehen &#8250;&#8250;&#8250;',
                                    'result_link' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' .  $SEARCH_QUERY_CONTENT['content_page_id'] . '/' .  $SEARCH_QUERY_CONTENT['content_id'] . '/edit/'
                                );
                            }
                        }
                    }
                    catch (PDOException $e) 
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');                
                        die();
                    }

                    try
                    {
                        $SEARCH_QUERY_CONTENT = 'SELECT * FROM constructr_content_history WHERE content_content LIKE :NEEDLE;';
                        $STMT = $DBCON -> prepare($SEARCH_QUERY_CONTENT);
                        $STMT -> bindParam(':NEEDLE',$NEEDLE,PDO::PARAM_STR);
                        $STMT -> execute();
                        $SEARCH_QUERY_CONTENT = $STMT -> fetchAll();

                        if($SEARCH_QUERY_CONTENT)
                        {
                            foreach($SEARCH_QUERY_CONTENT AS $SEARCH_QUERY_CONTENT)
                            {
                                $SEARCHR['content_' . $SEARCH_QUERY_CONTENT['content_id']] = array
                                (
                                    'id' => $SEARCH_QUERY_CONTENT['content_id'],
                                    'name' => 'Inhalts Historie-Eintrag "' . htmlentities($SEARCH_QUERY_CONTENT['content_content']) . '" ansehen &#8250;&#8250;&#8250;',
                                    'result_link' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' .  $SEARCH_QUERY_CONTENT['content_page_id'] . '/' .  $SEARCH_QUERY_CONTENT['content_content_id'] . '/edit/'
                                );
                            }
                        }
                    }
                    catch (PDOException $e) 
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');                
                        die();
                    }

                    try
                    {
                        $SEARCH_QUERY_MEDIA = 'SELECT * FROM constructr_media WHERE media_file LIKE :NEEDLE OR media_originalname LIKE :NEEDLE;';
                        $STMT = $DBCON -> prepare($SEARCH_QUERY_MEDIA);
                        $STMT -> bindParam(':NEEDLE',$NEEDLE,PDO::PARAM_STR);
                        $STMT -> execute();
                        $SEARCH_QUERY_MEDIA = $STMT -> fetchAll();

                        if($SEARCH_QUERY_MEDIA)
                        {
                            foreach($SEARCH_QUERY_MEDIA AS $SEARCH_QUERY_MEDIA)
                            {
                                $SEARCHR['files_' . $SEARCH_QUERY_MEDIA['media_id']] = array
                                (
                                    'id' => $SEARCH_QUERY_MEDIA['media_id'],
                                    'name' => 'Datei "' . $SEARCH_QUERY_MEDIA['media_file'] . '" ansehen &#8250;&#8250;&#8250;',
                                    'result_link' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/media/details/' .  $SEARCH_QUERY_MEDIA['media_id'] . '/'
                                );
                            }
                        }
                    }
                    catch (PDOException $e) 
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');                
                        die();
                    }

                    try
                    {
                        $SEARCH_QUERY_USER = 'SELECT * FROM constructr_backenduser WHERE beu_username LIKE :NEEDLE OR beu_email LIKE :NEEDLE;';
                        $STMT = $DBCON -> prepare($SEARCH_QUERY_USER);
                        $STMT -> bindParam(':NEEDLE',$NEEDLE,PDO::PARAM_STR);
                        $STMT -> execute();
                        $SEARCH_QUERY_USER = $STMT -> fetchAll();

                        if($SEARCH_QUERY_USER)
                        {
                            foreach($SEARCH_QUERY_USER AS $SEARCH_QUERY_USER)
                            {
                                $SEARCHR['files_' . $SEARCH_QUERY_USER['beu_id']] = array
                                (
                                    'id' => $SEARCH_QUERY_USER['beu_id'],
                                    'name' => 'Benutzer "' . $SEARCH_QUERY_USER['beu_username'] . '" ansehen &#8250;&#8250;&#8250;',
                                    'result_link' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/user/edit/' .  $SEARCH_QUERY_USER['beu_id'] . '/'
                                );
                            }
                        }
                    }
                    catch (PDOException $e) 
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');                
                        die();
                    }
                }
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
                    'SEARCHR' => $SEARCHR,
                    'SEARCHR_COUNTR' => count($SEARCHR),
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/searchr/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'BACKEND_USER_COUNTR' => $BACKEND_USER_COUNTR,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'UPLOADS_COUNTR' => $UPLOADS_COUNTR,
                    'SUBTITLE' => 'Admin-Dashboard / Suchergebnisse',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    '_SERVE_STATIC' => true,
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/optimization/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            $constructr -> view -> setData('BackendUserRight',31);

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
                $OPTIMIZER = $DBCON -> query('OPTIMIZE TABLE constructr_backenduser, constructr_backenduser_rights, constructr_content, constructr_content_history, constructr_media, constructr_pages;');
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

    $constructr -> get('/constructr/transfer-static/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
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
                $PAGE_CONTENT = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_lft;');
                $PAGE_CONTENT = $PAGE_CONTENT -> fetchAll();

                foreach($PAGE_CONTENT as $PAGE_CONTENT)
                {
                    $TARGET_DIR = $PAGE_CONTENT['pages_url'];
                    $BASE_DIR = constructr_sanitization($_CONSTRUCTR_CONF['_STATIC_DIR']);
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
                                    @mkdir($ACT_DIR,0777,false);
                                    @chmod($ACT_DIR,0777);
                                }
                            }
                            else
                            {
                                $ACT_DIR = $BASE_DIR . '/' . $DIR;
                                $TMP_DIR = $DIR;
            
                                if(!is_dir($ACT_DIR))
                                {
                                    @mkdir($ACT_DIR,0777,false);
                                    @chmod($ACT_DIR,0777);
                                }
                            }
                        }
                    }

                    if(count($PAGE_CONTENT) != 0 && count($PAGE_CONTENT != ''))
                    {
                        $_HTML_CONTENT = '';

                        if($PAGE_CONTENT['pages_lft'] == 1)
                        {
                            $_HTML_CONTENT = file_get_contents(constructr_sanitization($_CONSTRUCTR_CONF['_BASE_URL'] . '/?key=' . $_CONSTRUCTR_CONF['_MAGIC_GENERATION_KEY']));    
                        }
                        else
                        {
                            $_HTML_CONTENT = file_get_contents(constructr_sanitization($_CONSTRUCTR_CONF['_BASE_URL']) . '/' . $PAGE_CONTENT['pages_url'] . '/?key=' . $_CONSTRUCTR_CONF['_MAGIC_GENERATION_KEY']);
                        }

                        $_HTML_CONTENT = $_HTML_CONTENT . "\n\n<!-- ConstructrCMS (http://phaziz.com) generated " . date('d.m.Y, H:i:s') . " -->\n\n";

                        if($_HTML_CONTENT != '')
                        {
                            if($PAGE_CONTENT['pages_lft'] == 1)
                            {
                                $PHYSICAL_FILE = fopen($BASE_DIR . '/' . 'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],"w+");
                                fwrite($PHYSICAL_FILE, $_HTML_CONTENT);
                                fclose($PHYSICAL_FILE);
                                @chmod($PHYSICAL_FILE,0777);
                            }
                            else
                            {
                                $PHYSICAL_FILE = fopen($ACT_DIR . '/' . 'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],"w+");
                                fwrite($PHYSICAL_FILE, $_HTML_CONTENT);
                                fclose($PHYSICAL_FILE);
                                @chmod($PHYSICAL_FILE,0777);
                            }
                        }
                    }
                }

                if($_CONSTRUCTR_CONF['_TRANSFER_STATIC'] == 'true' && $_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'] != '' && $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE'] != '' && $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'] != '' && $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD'] != '')
                {
                    try
                    {
                        $PAGE_CONTENT = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_lft;');
                        $PAGE_CONTENT = $PAGE_CONTENT -> fetchAll();
    
                        foreach($PAGE_CONTENT as $PAGE_CONTENT)
                        {
                            if($PAGE_CONTENT['pages_lft'] != 1)
                            {
                                $FTP_CON = ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']);
                                ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']);
    
                                $PARTS = array();
                                $PARTS = explode('/',$PAGE_CONTENT['pages_url']);
    
                                foreach($PARTS as $PART)
                                {
                                    if(@ftp_chdir($FTP_CON,$PART))
                                    {
                                        @ftp_chmod($ftpcon,0777,$PART);
                                    }
                                    else
                                    {
                                        @ftp_mkdir($FTP_CON,$PART);
                                        @ftp_chmod($ftpcon,0777,$PART);
                                        @ftp_chdir($FTP_CON,$PART);
                                    }
                                }
    
                                ftp_close($FTP_CON);
                            }
    
                            if($PAGE_CONTENT['pages_lft'] == 1)
                            {
                                if(is_file($_CONSTRUCTR_CONF['_STATIC_DIR'] . '/index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']))
                                {
                                    $FTP_CON = @ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']);
                                    @ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']);
                                    @ftp_chmod($FTP_CON, 0777,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_delete($FTP_CON,'./index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_put($FTP_CON,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],$_CONSTRUCTR_CONF['_STATIC_DIR'] . '/index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'], $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']);
                                    @ftp_chmod($FTP_CON, 0777,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_close($FTP_CON);
                                }
                            }
                            else
                            {
                                if(is_file($_CONSTRUCTR_CONF['_STATIC_DIR'] . '/'. $PAGE_CONTENT['pages_url'] . '/index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']))
                                {
                                    $FTP_CON = @ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']);
                                    @ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']);
                                    @ftp_chdir($FTP_CON,$PAGE_CONTENT['pages_url']);
                                    @ftp_chmod($FTP_CON, 0777,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_delete($FTP_CON,'./index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_put($FTP_CON,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],$_CONSTRUCTR_CONF['_STATIC_DIR'] . '/'. $PAGE_CONTENT['pages_url'] . '/index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'], $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']);
                                    @ftp_chmod($FTP_CON, 0777,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_close($FTP_CON);
                                }
                            }

                            $FTP_CON = @ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']);
                            @ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']);
                            @ftp_chmod($FTP_CON, 0777,'sitemap.xml');
                            @ftp_delete($FTP_CON,'sitemap.xml');
                            @ftp_put($FTP_CON,'sitemap.xml',$_CONSTRUCTR_CONF['_BASE_URL'] . '/sitemap.xml', $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']);
                            @ftp_chmod($FTP_CON, 0777,'sitemap.xml');
                            @ftp_close($FTP_CON);
                        }
                    }
                    catch (PDOException $e)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?transfered-static=false');
                        die();
                    }
    
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?transfered-static=true');
                    die();
                }
                else
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?transfered-static=false');
                    die();
                }

                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?transfered-static=true');
                die();                
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?transfered-static=false');
                die();
            }
        }
    );