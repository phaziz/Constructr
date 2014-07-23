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

    $constructr -> get('/constructr/templates/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
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

            $constructr -> render('templates.php',
                array
                (
                    'DIR_FILES' => $DIR_FILES,
                    'COUNTR' => $COUNTR,
                    'USERNAME' => $_SESSION['backend-user-username'],
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Templates'
                )
            );
        }
    );

    $constructr -> get('/constructr/templates/edit/:TEMPLATE/', $ADMIN_CHECK, function ($TEMPLATE) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
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
            $TEMPLATE = file_get_contents($TEMPLATE);
            $TEMPLATE = htmlspecialchars($TEMPLATE);

            $constructr -> render('templates-edit.php', array
                (
                    'TEMPLATE' => $TEMPLATE,
                    'ORIGIN_TEMPLATE' => $ORIGIN_TEMPLATE,
                    'GUID' => $GUID,
                    'USERNAME' => $_SESSION['backend-user-username'],
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Template bearbeiten',
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/edit/' . $ORIGIN_TEMPLATE . '/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded'
                )
            );
        }
    );

    $constructr -> post('/constructr/templates/edit/:TEMPLATE/:GUID/', $ADMIN_CHECK, function ($TEMPLATE,$GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = filter_var(trim($GUID),FILTER_SANITIZE_STRING);

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

            $constructr -> render('templates-new.php',
                array
                (
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'NEW_CONTENT_ORDER' => $NEW_CONTENT_ORDER,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/templates/new/' . $GUID .'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Neues Template'
                )
            );
        }
    );

    $constructr -> post('/constructr/templates/new/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = filter_var(trim($GUID),FILTER_SANITIZE_STRING);

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
