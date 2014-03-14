<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $constructr -> get('/constructr/content/:PAGE_ID/', $ADMIN_CHECK, function ($PAGE_ID) use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $CONTENT_COUNTER = 0;
            $CONTENT = '';

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try 
            {
                $PAGE_NAME = $DBCON -> prepare('SELECT pages_name FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');

                $PAGE_NAME -> execute(
                    array
                    (
                        ':PAGE_ID' => $PAGE_ID
                    )
                );

                $PAGE_NAME = $PAGE_NAME -> fetch();
                $CONTENT = $DBCON -> prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID ORDER BY content_order ASC;');

                $CONTENT -> execute(
                    array
                    (
                        ':PAGE_ID' => $PAGE_ID
                    )
                );

                $CONTENT_COUNTER = $CONTENT -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            
            $constructr -> render('content.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'PAGE_ID' => $PAGE_ID,
                    'PAGE_NAME' => $PAGE_NAME,
                    'CONTENT' => $CONTENT,
                    'CONTENT_COUNTER' => $CONTENT_COUNTER,
                    'SUBTITLE' => 'Admin-Dashboard - Seiteninhalte &Uuml;bersicht',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );
    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */

    $constructr -> get('/constructr/get-image-list/', $ADMIN_CHECK, function () use ($constructr)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $IMAGE_LIST .= '[';
            $EXTENSIONS = array("jpg","JPG", "bmp", "BMP", "gif", "GIF", "jpeg","JPEG", "png","PNG");

            if ($HANDLE = opendir('./Uploads/'))
            {
                while (false !== ($IMAGE = readdir($HANDLE)))
                {
                    if(in_array(pathinfo($IMAGE,PATHINFO_EXTENSION), $EXTENSIONS)) 
                    {
                        $IMAGE_LIST .=  '{"image":"' . _BASE_URL . '/Uploads/' . $IMAGE . '","thumb": "' . _BASE_URL . '/Uploads/' . $IMAGE . '","folder": "Uploads"},';
                    }
                }
                closedir($HANDLE);
            }

            $IMAGE_LIST .= ']';
            $IMAGES_JSON = str_replace('"},]','"}]',$IMAGE_LIST);
            echo $IMAGES_JSON;

            die();
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:NEW_CONTENT_ORDER/new/', $ADMIN_CHECK, function ($PAGE_ID,$NEW_CONTENT_ORDER) use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
                $PAGE_NAME = $DBCON -> prepare('SELECT pages_name FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');

                $PAGE_NAME -> execute(
                    array
                    (
                        ':PAGE_ID' => $PAGE_ID
                    )
                );

                $PAGE_NAME = $PAGE_NAME -> fetch();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());                
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('content_new.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'PAGE_NAME' => $PAGE_NAME,
                    'PAGE_ID' => $PAGE_ID,
                    'NEW_CONTENT_ORDER' => $NEW_CONTENT_ORDER,
                    'FORM_ACTION' => _BASE_URL . '/constructr/content/' . $PAGE_ID . '/new/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Admin-Dashboard / Neuen Inhalt erstellen',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );

            die();
        }
    );

    $constructr -> post('/constructr/content/:PAGE_ID/new/', $ADMIN_CHECK, function ($PAGE_ID) use ($constructr,$DBCON)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $CONTENT_DATETIME = date('Y-m-d H:i:s');
            $CONTENT = $constructr -> request() -> post('content');
            $CONTENT_ORDER = $constructr -> request() -> post('content_order');
            $CONTENT_ACTIVE = 1;

            if($CONTENT != '' && $CONTENT_ORDER != '')
            {
                try
                {
                    $QUERY = 'INSERT INTO constructr_content SET content_datetime = :CONTENT_DATETIME,content_order = :CONTENT_ORDER,content_page_id = :PAGE_ID,content_content = :CONTENT,content_active = :CONTENT_ACTIVE;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':CONTENT',$CONTENT,PDO::PARAM_STR);
                    $STMT -> bindParam(':CONTENT_DATETIME',$CONTENT_DATETIME,PDO::PARAM_STR);
                    $STMT -> bindParam(':CONTENT_ORDER',$CONTENT_ORDER,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_ID',$PAGE_ID,PDO::PARAM_INT);
                    $STMT -> bindParam(':CONTENT_ACTIVE',$CONTENT_ACTIVE,PDO::PARAM_INT);
                    $STMT -> execute();
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=create-content-true');
                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=create-content-false');
                    die();
                }
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=create-content-false');
                die();
            }
            die();
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:CONTENT_ID/edit/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID) use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            
            try
            {
                $CONTENT = $DBCON -> prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_id = :CONTENT_ID LIMIT 1;');

                $CONTENT -> execute(
                    array
                    (
                        ':PAGE_ID' => $PAGE_ID,
                        ':CONTENT_ID' => $CONTENT_ID
                    )
                );

                $CONTENT = $CONTENT -> fetch();
                $PAGE_NAME = $DBCON -> prepare('SELECT pages_name FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');

                $PAGE_NAME -> execute(
                    array
                    (
                        ':PAGE_ID' => $PAGE_ID
                    )
                );

                $PAGE_NAME = $PAGE_NAME -> fetch();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=edit-content-false');
                echo 'nep';
                die();
            }

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('content_edit.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'CONTENT' => $CONTENT,
                    'PAGE_NAME' => $PAGE_NAME,
                    'PAGE_ID' => $PAGE_ID,
                    'FORM_ACTION' => _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT_ID . '/edit/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Admin-Dashboard / Inhalt bearbeiten',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
            die();
        }
    );

    $constructr -> post('/constructr/content/:PAGE_ID/:CONTENT_ID/edit/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID) use ($constructr,$DBCON)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $CONTENT_DATETIME = date('Y-m-d H:i:s');
            $CONTENT = $constructr -> request() -> post('content');

            if($CONTENT != '' && $CONTENT_ID != '')
            {
                try
                {
                    $UPDATE_PAGES = $DBCON -> prepare('UPDATE constructr_content SET content_content = :CONTENT, content_datetime = :CONTENT_DATETIME WHERE content_id = :CONTENT_ID AND content_page_id = :PAGE_ID LIMIT 1;');

                    $UPDATE_PAGES -> execute(
                        array
                        (
                            ':CONTENT' => $CONTENT,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_DATETIME' => $CONTENT_DATETIME,
                            ':CONTENT_ID' => $CONTENT_ID
                        )
                    );

                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=edit-content-true');
                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=edit-content-false');
                    die();
                }
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=edit-content-false');
                die();
            }
            
            die();
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:CONTENT_ID/:ACT_ORDER/up/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID,$ACT_ORDER) use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '' && $CONTENT_ID != '' && $ACT_ORDER != '')
            {
                $NEW_ORDER = ($ACT_ORDER - 1);

                try 
                {
                    $UPDATE_CONTENT = $DBCON -> prepare('
                        UPDATE constructr_content 
                        SET 
                        content_order = :TEMP_ORDER 
                        WHERE content_order = :NEW_ORDER 
                        AND content_page_id = :PAGE_ID 
                        LIMIT 1;
                        UPDATE constructr_content 
                        SET 
                        content_order = :NEW_ORDER 
                        WHERE content_order = :ACT_ORDER 
                        AND content_id = :CONTENT_ID
                        AND content_page_id = :PAGE_ID 
                        LIMIT 1;
                        UPDATE constructr_content 
                        SET 
                        content_order = :ACT_ORDER 
                        WHERE content_order = :TEMP_ORDER 
                        AND content_page_id = :PAGE_ID 
                        LIMIT 1;
                    ');

                    $UPDATE_CONTENT -> execute(
                        array
                        (
                            ':TEMP_ORDER' => 0,
                            ':NEW_ORDER' => $NEW_ORDER,
                            ':ACT_ORDER' => $ACT_ORDER,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=activate-content-false');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=reorder-content-true');
                die();
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=reorder-content-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:CONTENT_ID/:ACT_ORDER/down/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID,$ACT_ORDER) use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '' && $CONTENT_ID != '' && $ACT_ORDER != '')
            {
                $NEW_ORDER = ($ACT_ORDER + 1);

                try
                {
                    $UPDATE_CONTENT = $DBCON -> prepare('
                        UPDATE constructr_content 
                        SET 
                        content_order = :TEMP_ORDER 
                        WHERE content_order = :NEW_ORDER 
                        AND content_page_id = :PAGE_ID 
                        LIMIT 1;
                        UPDATE constructr_content 
                        SET 
                        content_order = :NEW_ORDER 
                        WHERE content_order = :ACT_ORDER 
                        AND content_id = :CONTENT_ID
                        AND content_page_id = :PAGE_ID 
                        LIMIT 1;
                        UPDATE constructr_content 
                        SET 
                        content_order = :ACT_ORDER 
                        WHERE content_order = :TEMP_ORDER 
                        AND content_page_id = :PAGE_ID 
                        LIMIT 1;
                    ');

                    $UPDATE_CONTENT -> execute(
                        array
                        (
                            ':TEMP_ORDER' => 0,
                            ':NEW_ORDER' => $NEW_ORDER,
                            ':ACT_ORDER' => $ACT_ORDER,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=activate-content-false');
                    die();
                }
                
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=reorder-content-true');
                die();
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=reorder-content-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:CONTENT_ID/activate/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID) use ($constructr,$DBCON)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '' && $CONTENT_ID != '')
            {
                try
                {
                    $UPDATE_CONTENT = $DBCON -> prepare('UPDATE constructr_content SET content_active = :CONTENT_ACTIVE WHERE content_page_id = :PAGE_ID AND content_id = :CONTENT_ID LIMIT 1;');

                    $UPDATE_CONTENT -> execute(
                        array
                        (
                            ':CONTENT_ACTIVE' => 1,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=activate-content-false');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=activate-content-true');
                die();
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=activate-content-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:CONTENT_ID/deactivate/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID) use ($constructr,$DBCON)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '' && $CONTENT_ID != '')
            {
                try
                {
                    $UPDATE_CONTENT = $DBCON -> prepare('UPDATE constructr_content SET content_active = :CONTENT_ACTIVE WHERE content_page_id = :PAGE_ID AND content_id = :CONTENT_ID LIMIT 1;');

                    $UPDATE_CONTENT -> execute(
                        array
                        (
                            ':CONTENT_ACTIVE' => 0,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=deactivate-content-false');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=deactivate-content-true');
                die();
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=deactivate-content-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/content/:PAGE_ID/:CONTENT_ID/delete/', $ADMIN_CHECK, function ($PAGE_ID,$CONTENT_ID) use ($constructr,$DBCON)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            if($PAGE_ID != '' && $CONTENT_ID != '')
            {
                try
                {
                    $DELETER = $DBCON -> prepare('
                        DELETE FROM constructr_content
                        WHERE content_id = :CONTENT_ID
                        LIMIT 1;
                    ');

                    $DELETER -> execute(array(':CONTENT_ID' => $CONTENT_ID));
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=del-content-true');
                    die();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=del-content-false');
                    die();
                }
            }
            else
            {
                $constructr -> redirect(_BASE_URL . '/constructr/content/' . $PAGE_ID . '/?res=del-content-false');
                die();
            }
        }
    );