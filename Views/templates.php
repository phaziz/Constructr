<?php

    $constructr -> get('/constructr/templates/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $MEDIA_COUNTER = 0;

            $constructr -> view -> setData('BackendUserRight',50);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $COUNTR = 0;
            $ALL_FILES = scandir($_CONSTRUCTR_CONF['_TEMPLATES_DIR']);
            $DIR_FILES = array();

            foreach($ALL_FILES as $DIR_FILE)
            {
                if($DIR_FILE != '.'  && $DIR_FILE != '..')
                {
                    $DIR_FILES[] = $DIR_FILE;
                }
            }

            $DIR_FILES = array_unique($DIR_FILES);
            $COUNTR = count($DIR_FILES);
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('templates.php',
                array
                (
                    'MEM' => $MEM,
                    'DIR_FILES' => $DIR_FILES,
                    'COUNTR' => $COUNTR,
                    'USERNAME' => $USERNAME,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Templates',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> get('/constructr/templates/edit/:TEMPLATE/', $ADMIN_CHECK, function ($TEMPLATE) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];
            $MEDIA_COUNTER = 0;

            $constructr -> view -> setData('BackendUserRight',51);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $GUID = create_guid();
            $ORIGIN_TEMPLATE = $TEMPLATE;
            $TEMPLATE = base64_decode($TEMPLATE);
            $TEMPLATE = $_CONSTRUCTR_CONF['_TEMPLATES_DIR'] . '/' . $TEMPLATE;
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('templates-edit.php',
                array
                (
                    'MEM' => $MEM,
                    'TEMPLATE' => $TEMPLATE,
                    'ORIGIN_TEMPLATE' => $ORIGIN_TEMPLATE,
                    'GUID' => $GUID,
                    'USERNAME' => $USERNAME,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Template bearbeiten',
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/edit/' . $ORIGIN_TEMPLATE . '/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> post('/constructr/templates/edit/:TEMPLATE/:GUID/', $ADMIN_CHECK, function ($TEMPLATE,$GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            $constructr -> view -> setData('BackendUserRight',51);

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

            $TEMPLATE_FILE = $constructr -> request() -> post('template_file');
            $TEMPLATE = $constructr -> request() -> post('template');

            if($TEMPLATE_FILE != '')
            {
                $PHYSICAL_FILE = $_CONSTRUCTR_CONF['_TEMPLATES_DIR'] . '/' . base64_decode($TEMPLATE_FILE);
                $PHYSICAL_FILE = fopen($PHYSICAL_FILE,"w+");

                @fwrite($PHYSICAL_FILE, $TEMPLATE);
                @fclose($PHYSICAL_FILE);
                @chmod($PHYSICAL_FILE,0777);

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=edit-template-true');
                die();
            }
            else
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=edit-template-false');
                die();
            }
        }
    );

    $constructr -> get('/constructr/templates/delete/:TEMPLATE/', $ADMIN_CHECK, function ($TEMPLATE) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $constructr -> view -> setData('BackendUserRight',52);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            if($TEMPLATE != '')
            {
                @chmod($_CONSTRUCTR_CONF['_TEMPLATES_DIR'] . '/' . base64_decode($TEMPLATE),0777);
                @unlink($_CONSTRUCTR_CONF['_TEMPLATES_DIR'] . '/' . base64_decode($TEMPLATE));
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=del-template-true');
                die();
            }
            else
            {
                if($_CONSTRUCTR_CONF['_LOGGING'] == true)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                }

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=del-template-false');
                die();
            }
        }
    );
    
    $constructr -> get('/constructr/templates/new/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $START = microtime(true);
            $USERNAME = $_SESSION['backend-user-username'];

            $constructr -> view -> setData('BackendUserRight',53);

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

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);                
            }

            $GUID = create_guid();
            $MEM = 0;
            $MEM = number_format(((memory_get_usage()/1014)/1024),2,',','.') . ' MB';

            $constructr -> render('templates-new.php',
                array
                (
                    'MEM' => $MEM,
                    'USERNAME' => $USERNAME,
                    'GUID' => $GUID,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'NEW_CONTENT_ORDER' => $NEW_CONTENT_ORDER,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/new/' . $GUID .'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Neues Template',
                    'TIMER' => substr(microtime(true) - $START,0,6) . ' Sek.'
                )
            );
        }
    );

    $constructr -> post('/constructr/templates/new/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $USERNAME = $_SESSION['backend-user-username'];

            $constructr -> view -> setData('BackendUserRight',53);

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

            $TEMPLATE_NAME = $constructr -> request() -> post('template_name');

            if($TEMPLATE_NAME != '')
            {
                if(is_file($_CONSTRUCTR_CONF['_TEMPLATES_DIR'] . '/' . trim($TEMPLATE_NAME)))
                {
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=create-template-false');
                    die();
                }

                $PHYSICAL_FILE = $_CONSTRUCTR_CONF['_TEMPLATES_DIR'] . '/' . trim($TEMPLATE_NAME);
                $PHYSICAL_FILE = fopen($PHYSICAL_FILE,"w+");

                @fwrite($PHYSICAL_FILE,'<!-- Template-Datei: ' . $TEMPLATE_NAME . ' erstellt am: ' . date('d.m.Y, H:i:s') . ' Uhr -->');
                @fclose($PHYSICAL_FILE);
                @chmod($PHYSICAL_FILE,0777);

                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=create-template-true');
                die();
            }
            else
            {
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/?res=create-template-false');
                die();
            }
        }
    );