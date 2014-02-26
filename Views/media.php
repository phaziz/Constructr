<?php

    /*
     * 
     * DER ANFANG ALLEN ÜBELS...
     * 
     * */
    $app -> get('/admin/media(/)', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $MEDIA_COUNTER = 0;
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }
            try {
               $MEDIA = $DBCON -> query('SELECT * FROM media ORDER BY media_datetime DESC;');
               $MEDIA_COUNTER = $MEDIA -> rowCount();
            } catch (PDOException $e) {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());   
                $app -> redirect(_BASE_URL . '/admin/');             
                die();
            }
            $IMAGES = array('.jpg','.jepg','.JPG','.JPEG','.gif','.GIF','.png','.PNG');
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
            $app -> render('media.php',array(
                    'MEM' => $MEM,
                    'MEDIA' => $MEDIA,
                    'IMAGES' => $IMAGES,
                    'MEDIA_COUNTER' => $MEDIA_COUNTER,
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

    $app -> get('/admin/media/new(/)', $ADMIN_CHECK, function () use ($app,$DBCON)
    {
        $START = microtime(true);
        $USERNAME = $_SESSION['backend-user-username'];
        if(_LOGGING == true)
        {
            $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
        }
        $MEM = 0;
        $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';
        $app -> render('media_new.php',array(
                'MEM' => $MEM,
                'USERNAME' => $USERNAME,
                'FORM_ACTION' => _BASE_URL . '/admin/media/new/',
                'FORM_METHOD' => 'post',
                'FORM_ENCTYPE' => 'multipart/form-data',
                'SUBTITLE' => 'Admin-Dashboard / Medienverwaltung - Neuer Upload',
                'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                )
            );
            die();
        }
    );
    
    $app -> post('/admin/media/new/', $ADMIN_CHECK, function () use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
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
            if($FILEUPLOAD == true){
                try {
                    $QUERY = 'INSERT INTO media SET media_datetime = :DATETIME,media_file = :MEDIA_FILE,media_originalname = :ORIGINALNAME;';
                    $STMT = $DBCON -> prepare($QUERY);
                    $STMT -> bindParam(':DATETIME',$DATETIME,PDO::PARAM_STR);
                    $STMT -> bindParam(':MEDIA_FILE',$NEW_UPLOAD,PDO::PARAM_STR);
                    $STMT -> bindParam(':ORIGINALNAME',$ORIGINALNAME,PDO::PARAM_STR);
                    $STMT -> execute();
                } catch (PDOException $e){
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/media/?res=create-media-false');
                    die();
                }
                if(_LOGGING == true)
                {
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }
                $app -> redirect(_BASE_URL . '/admin/media/?res=create-media-true');
                die();
            } else {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
                }
                $app -> redirect(_BASE_URL . '/admin/media/?res=create-media-false');
                die();
            }
        }
    );

    $app -> get('/admin/media/delete/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($MEDIA_ID != ''){
                try {
                    $DELETER = $DBCON -> prepare('
                        DELETE FROM media
                        WHERE media_id = :MEDIA_ID
                        LIMIT 1;
                    ');
                    $DELETER -> execute(array(':MEDIA_ID' => $MEDIA_ID));
                } catch (PDOException $e){
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/media/?res=del-media-false');
                    die();
                }

                if(_LOGGING == true)
                {
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
                $app -> redirect(_BASE_URL . '/admin/media/?res=del-media-true');
                die();
            } else {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
                $app -> redirect(_BASE_URL . '/admin/media/?res=del-media-false');
                die();
            }
        }
    );

    $app -> get('/admin/media/details/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($app,$DBCON)
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }
            if($MEDIA_ID != ''){
                try {
                    $DETAILS = $DBCON -> prepare('SELECT * FROM media WHERE media_id = :MEDIA_ID LIMIT 1;');
                    $DETAILS -> execute(
                                        array(
                                            ':MEDIA_ID' => $MEDIA_ID
                                        )
                                    );
                    $DETAILS = $DETAILS -> fetch();
                } catch (PDOException $e){
                    $app -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $app -> redirect(_BASE_URL . '/admin/media/?res=del-media-false');
                    die();
                }
                $app -> render('media-details.php',array(
                        'MEM' => $MEM,
                        'DETAILS' => $DETAILS,
                        'USERNAME' => $USERNAME,
                        'SUBTITLE' => 'Admin-Dashboard / Medienverwaltung - Detailansicht',
                        'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.',
                    )
                );
                die();
            } else {
                if(_LOGGING == true)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }
                $app -> redirect(_BASE_URL . '/admin/media/?res=details-media-false');
                die();
            }
        }
    );