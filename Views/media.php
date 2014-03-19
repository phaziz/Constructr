<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $constructr -> get('/constructr/media(/)', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $MEDIA_COUNTER = 0;

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
               $MEDIA = $DBCON -> query('SELECT * FROM constructr_media ORDER BY media_datetime DESC;');
               $MEDIA_COUNTER = $MEDIA -> rowCount();
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $constructr -> redirect(_BASE_URL . '/constructr/');             
                die();
            }

            $IMAGES = array('.jpg','.jepg','.JPG','.JPEG','.gif','.GIF','.png','.PNG');
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            $constructr -> render('media.php',
                array
                (
                    'MEM' => $MEM,
                    'MEDIA' => $MEDIA,
                    'IMAGES' => $IMAGES,
                    'MEDIA_COUNTER' => $MEDIA_COUNTER,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / Medienverwaltung',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
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

    $constructr -> get('/constructr/media/new(/)', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
    
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
    
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
    
            $constructr -> render('media_new.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'FORM_ACTION' => _BASE_URL . '/constructr/media/new/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'multipart/form-data',
                    'SUBTITLE' => 'Admin-Dashboard / Medienverwaltung - Neuer Upload',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
            die();
        }
    );
    
    $constructr -> post('/constructr/media/new/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $DATETIME = date('Y-m-d H:i:s');
            $MEDIA_USER = 0;
            $FILEUPLOAD = $_FILES['fileupload']['name'];
            $ORIGINALNAME = $FILEUPLOAD;
            $FILE_TYPE = strrchr($FILEUPLOAD,'.');
            $UNIQUE_ID = md5(microtime());
            $NEW_UPLOAD = 'Uploads/' . date('Y-m-d') . '-' . $UNIQUE_ID . $FILE_TYPE;
            $UPLOAD = copy($_FILES['fileupload']['tmp_name'], $NEW_UPLOAD);
            @chmod($NEW_UPLOAD, 0777);

            if($FILEUPLOAD == true)
            {
                try
                {
                    $QUERY = 'INSERT INTO constructr_media SET media_datetime = :DATETIME,media_file = :MEDIA_FILE,media_originalname = :ORIGINALNAME;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':DATETIME',$DATETIME,PDO::PARAM_STR);
                    $STMT -> bindParam(':MEDIA_FILE',$NEW_UPLOAD,PDO::PARAM_STR);
                    $STMT -> bindParam(':ORIGINALNAME',$ORIGINALNAME,PDO::PARAM_STR);
                    $STMT -> execute();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/media/?res=create-media-false');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/media/?res=create-media-true');
                die();
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }

                $constructr -> redirect(_BASE_URL . '/constructr/media/?res=create-media-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/media/delete/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($MEDIA_ID != '')
            {
                try
                {
                    $DELETER = $DBCON -> prepare('
                        DELETE FROM constructr_media
                        WHERE media_id = :MEDIA_ID
                        LIMIT 1;
                    ');
                    
                    $DELETER -> execute(
                        array
                        (
                            ':MEDIA_ID' => $MEDIA_ID
                        )
                    );
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/media/?res=del-media-false');
                    die();
                }

                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/media/?res=del-media-true');
                die();
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/media/?res=del-media-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/media/details/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($constructr,$DBCON)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($MEDIA_ID != '')
            {
                try
                {
                    $DETAILS = $DBCON -> prepare('SELECT * FROM constructr_media WHERE media_id = :MEDIA_ID LIMIT 1;');

                    $DETAILS -> execute(
                        array
                        (
                            ':MEDIA_ID' => $MEDIA_ID
                        )
                    );

                    $DETAILS = $DETAILS -> fetch();
                }
                catch (PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect(_BASE_URL . '/constructr/media/?res=del-media-false');
                    die();
                }
                
                $constructr -> render('media-details.php',
                    array
                    (
                        'MEM' => $MEM,
                        'DETAILS' => $DETAILS,
                        'USERNAME' => $USERNAME,
                        'SUBTITLE' => 'Admin-Dashboard / Medienverwaltung - Detailansicht',
                        'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                    )
                );

                die();
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/media/?res=details-media-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/media/trash(/)', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $MEDIA_COUNTER = 0;

            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            try
            {
                $MEDIA = $DBCON -> query('SELECT * FROM constructr_media ORDER BY media_datetime DESC;');
                $MEDIA_COUNTER = $MEDIA -> rowCount();
                $ALL_FILES = scandir('./Uploads');
                $DIR_FILES = array();
                $i = 0;
                foreach ($ALL_FILES as $FILE)
                {
                    if($FILE != '.' && $FILE != '..' && $FILE != 'index.php')
                    {
                         $DIR_FILES[] = 'Uploads/' . $FILE;
                    }
                    $i++;
                };
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $constructr -> redirect(_BASE_URL . '/constructr/');             
                die();
            }

            $IMAGES = array('.jpg','.jepg','.JPG','.JPEG','.gif','.GIF','.png','.PNG');

            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('media-trashcan.php',
                array
                (
                    'MEM' => $MEM,
                    'MEDIA' => $MEDIA,
                    'DIR_FILES' => $DIR_FILES,
                    'IMAGES' => $IMAGES,
                    'MEDIA_COUNTER' => $MEDIA_COUNTER,
                    'USERNAME' => $USERNAME,
                    'SUBTITLE' => 'Admin-Dashboard / M&uuml;lleimer',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
            die();
        }
    );

    $constructr -> get('/constructr/media/trash/delete/:MEDIA_FILE/', $ADMIN_CHECK, function ($MEDIA_FILE) use ($constructr,$DBCON)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($MEDIA_FILE != '')
            {
                unlink('./' . base64_decode($MEDIA_FILE));
                $constructr -> redirect(_BASE_URL . '/constructr/media/trash/?res=del-media-true');
                die();
            }
            else
            {
                if(_LOGGING == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect(_BASE_URL . '/constructr/media/trash/?res=del-media-false');
                die();
            }
        }
    );