<?php

	/**
	 * Constructr CMS - a Slim-PHP-Framework based full-stack Content-Management-System (CMS).
	 * 
	 * Built with:
	 * Slim-PHP-Framework (http://www.slimframework.com/)
	 * Bootstrap Frontend Framework (http://getbootstrap.com/)
	 * PHP PDO (http://php.net/manual/de/book.pdo.php)
	 * jQuery (http://jquery.com/)
	 * ckEditor (http://ckeditor.com/)
	 * Codemirror (http://codemirror.net/)
	 * ...
	 * 
	 * LICENCE 
	 * 
	 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	 * Version 1, February 2015
	 * Copyright (C) 2015 Christian Becher | phaziz.com <christian@phaziz.com>
	 * Everyone is permitted to copy and distribute verbatim or modified
	 * copies of this license document, and changing it is allowed as long
	 * as the name is changed.
	 *
	 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
	 * 0. YOU JUST DO WHAT THE FUCK YOU WANT TO!
	 *
	 * Visit http://constructr-cms.org
	 * Visit http://blog.phaziz.com/category/constructr-cms/
	 * Visit http://phaziz.com 
	 *
	 * @author Christian Becher | phaziz.com <phaziz@gmail.com>
	 * @copyright 2015 Christian Becher | phaziz.com
	 * @license DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	 * @link http://constructr-cms.org/
	 * @link http://blog.phaziz.com/category/constructr-cms/
	 * @link http://phaziz.com/
	 * @package ConstructrCMS
	 * @version 1.04.4 / 17.02.2015  
	 *
	 */

	/**
	 * Main Backend-Route @ your-domain.tld/constructr - Your Admin Dashboard.
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 */
    $constructr -> get('/constructr/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $BACKEND_USER_COUNTR = 0;
            $PAGES_COUNTR = 0;

            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            try
            {
                $BACKEND_USER_COUNTR = $DBCON -> query('SELECT beu_id FROM constructr_backenduser;') -> rowCount();
                $PAGES_COUNTR = $DBCON -> query('SELECT pages_id FROM constructr_pages;') -> rowCount();
                $CONTENT_COUNTR = $DBCON -> query('SELECT content_id FROM constructr_content;') -> rowCount();
                $CONTENT_HISTORY_COUNTR = $DBCON -> query('SELECT content_id FROM constructr_content_history;') -> rowCount();
                $UPLOADS_COUNTR = $DBCON -> query('SELECT media_id FROM constructr_media;') -> rowCount();
                $TEMPLATES_COUNTR = 0;
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
                $TEMPLATES_COUNTR = count($DIR_FILES);
                $ALL_C_FILES = scandir($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE_DIR']);
                $DIR_C_FILES = array();
                foreach($ALL_C_FILES as $DIR_C_FILE)
                {
                    if($DIR_C_FILE != '.'  && $DIR_C_FILE != '..')
                    {
                        $DIR_C_FILES[] = $DIR_C_FILE;
                    }
                }
                $DIR_C_FILES = array_unique($DIR_C_FILES);
                $C_FILE_COUNTR = count($DIR_C_FILES);
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                die();
            }

            $GUID = create_guid();

            $constructr -> render('admin.php',
                array
                (
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/searchr/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'BACKEND_USER_COUNTR' => (int) $BACKEND_USER_COUNTR,
                    'PAGES_COUNTR' => (int) $PAGES_COUNTR,
                    'CONTENT_COUNTR' => (int) $CONTENT_COUNTR,
                    'CONTENT_HISTORY_COUNTR' => (int) $CONTENT_HISTORY_COUNTR,
                    'UPLOADS_COUNTR' => (int) $UPLOADS_COUNTR,
                    'TEMPLATES_COUNTR' => (int) $TEMPLATES_COUNTR,
                    'C_FILE_COUNTR' => (int) $C_FILE_COUNTR,
                    'SUBTITLE' => 'Dashboard',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    '_SERVE_STATIC' => true
                )
            );
        }
    );

	/**
	 * Backend Searchengine POST-Route.
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 * @param $GUID - Constructr CMS CSRF-Guard
	 */
    $constructr -> post('/constructr/searchr/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);

            $constructr -> view -> setData('BackendUserRight',30);

            if(isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '')
            {
                try
                {
                    $RIGHT_CHECKER = $DBCON -> prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER -> execute(
                        array
                        (
                            ':USER_ID' => (int) $_SESSION['backend-user-id'],
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

            try
            {
                $BACKEND_USER_COUNTR = $DBCON -> query('SELECT beu_id FROM constructr_backenduser;') -> rowCount();
                $PAGES_COUNTR = $DBCON -> query('SELECT pages_id FROM constructr_pages;') -> rowCount();
                $CONTENT_COUNTR = $DBCON -> query('SELECT content_id FROM constructr_content;') -> rowCount();
                $CONTENT_HISTORY_COUNTR = $DBCON -> query('SELECT content_id FROM constructr_content_history;') -> rowCount();
                $UPLOADS_COUNTR = $DBCON -> query('SELECT media_id FROM constructr_media;') -> rowCount();
                $TEMPLATES_COUNTR = 0;

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
                $TEMPLATES_COUNTR = count($DIR_FILES);

                $ALL_C_FILES = scandir($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE_DIR']);
                $DIR_C_FILES = array();

                foreach($ALL_C_FILES as $DIR_C_FILE)
                {
                    if($DIR_C_FILE != '.'  && $DIR_C_FILE != '..')
                    {
                        $DIR_C_FILES[] = $DIR_C_FILE;
                    }
                }

                $DIR_C_FILES = array_unique($DIR_C_FILES);
                $C_FILE_COUNTR = count($DIR_C_FILES);
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                die();
            }

            $NEEDLES = constructr_sanitization($constructr -> request() -> post('needles'),true,true);
            $NEEDLES = constructr_sanitization($NEEDLES,true,true);
            $USER_FORM_GUID = constructr_sanitization($constructr -> request() -> post('user_form_guid'));

            if($NEEDLES && $NEEDLES != false)
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
                    catch(PDOException $e)
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
                    catch(PDOException $e)
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
                    catch(PDOException $e)
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
                    catch(PDOException $e)
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
                    catch(PDOException $e)
                    {
                        $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');
                        die();
                    }
                }
            }

            $GUID = create_guid();

            $constructr -> render('admin.php',
                array
                (
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    'SEARCHR' => $SEARCHR,
                    'SEARCHR_COUNTR' => count($SEARCHR),
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/searchr/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'BACKEND_USER_COUNTR' => (int) $BACKEND_USER_COUNTR,
                    'PAGES_COUNTR' => (int) $PAGES_COUNTR,
                    'CONTENT_COUNTR' => (int) $CONTENT_COUNTR,
                    'CONTENT_HISTORY_COUNTR' => (int) $CONTENT_HISTORY_COUNTR,
                    'UPLOADS_COUNTR' => (int) $UPLOADS_COUNTR,
                    'TEMPLATES_COUNTR' => (int) $TEMPLATES_COUNTR,
                    'C_FILE_COUNTR' => (int) $C_FILE_COUNTR,
                    'SUBTITLE' => 'Suchergebnisse',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    '_SERVE_STATIC' => true
                )
            );
        }
    );

	/**
	 * Administrator Dashboard optimize Database Route.
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 * @param $GUID - Constructr CMS CSRF-Guard
	 */
    $constructr -> get('/constructr/optimization/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);

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
            catch(PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                die();
            }
        }
    );

	/**
	 * Dashboard Content-History-Route to clear all History Entries.
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 * @param $GUID - Constructr CMS CSRF-Guard
	 */
    $constructr -> get('/constructr/content-history/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);

            $constructr -> view -> setData('BackendUserRight',25);

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

            if($GUID == '')
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            try
            {
                $OPTIMIZER = $DBCON -> query('TRUNCATE TABLE constructr_content_history;');
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?content-history=true');
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                die();
            }
        }
    );

	/**
	 * FTP-Transfer of your static Website Route. 
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 * @param $GUID - Constructr CMS CSRF-Guard
	 */
    $constructr -> get('/constructr/transfer-static/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);

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

            if($GUID == '')
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            try
            {
                $PAGE_CONTENT = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
                $PAGE_CONTENT = $PAGE_CONTENT -> fetchAll();

                foreach($PAGE_CONTENT as $PAGE_CONTENT)
                {
                    $TARGET_DIR = $PAGE_CONTENT['pages_url'];
                    $BASE_DIR = constructr_sanitization($_CONSTRUCTR_CONF['_STATIC_DIR']);
                    $DIRS = explode('/',$TARGET_DIR);
                    $TMP_DIR = '';
                    $ACT_DIR = '';

                    if($PAGE_CONTENT['pages_order'] != 1)
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

                        if($PAGE_CONTENT['pages_order'] == 1)
                        {
                            $_HTML_CONTENT = file_get_contents($_CONSTRUCTR_CONF['_BASE_URL']) or die ('FTP-DATA ERROR1');
                        }
                        else
                        {
                            $_HTML_CONTENT = file_get_contents($_CONSTRUCTR_CONF['_BASE_URL'] . '/' . $PAGE_CONTENT['pages_url']) or die ('FTP-DATA ERROR2');
                        }

                        $_HTML_CONTENT = $_HTML_CONTENT . "\n\n<!-- ConstructrCMS (http://phaziz.com) generated " . date('d.m.Y, H:i:s') . " -->\n\n";

                        if($_HTML_CONTENT != '')
                        {
                            if($PAGE_CONTENT['pages_order'] == 1)
                            {
                                $PHYSICAL_FILE = @fopen($BASE_DIR . '/' . 'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],"w+") or die ('FTP-DATA ERROR3');
                                @fwrite($PHYSICAL_FILE, $_HTML_CONTENT);
                                @fclose($PHYSICAL_FILE);
                                @chmod($PHYSICAL_FILE,0777);
                            }
                            else
                            {
                                $PHYSICAL_FILE = @fopen($ACT_DIR . '/' . 'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],"w+") or die ('FTP-DATA ERROR4');
                                @fwrite($PHYSICAL_FILE, $_HTML_CONTENT);
                                @fclose($PHYSICAL_FILE);
                                @chmod($PHYSICAL_FILE,0777);
                            }
                        }
                    }
                }

                if($_CONSTRUCTR_CONF['_TRANSFER_STATIC'] == 'true' && $_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'] != '' && $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE'] != '' && $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'] != '' && $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD'] != '')
                {
                    try
                    {
                        $PAGE_CONTENT = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
                        $PAGE_CONTENT = $PAGE_CONTENT -> fetchAll();

                        foreach($PAGE_CONTENT as $PAGE_CONTENT)
                        {
                            if($PAGE_CONTENT['pages_order'] != 1)
                            {
                                $FTP_CON = @ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']) or die ('FTP-DATA ERROR5');
                                @ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']) or die ('FTP-DATA ERROR6');

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

                                @ftp_close($FTP_CON);
                            }

                            if($PAGE_CONTENT['pages_order'] == 1)
                            {
                                if(is_file($_CONSTRUCTR_CONF['_STATIC_DIR'] . '/index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']))
                                {
                                    $FTP_CON = @ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']) or die ('FTP-DATA ERROR7');
                                    @ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']) or die ('FTP-DATA ERROR8');
                                    @ftp_chmod($FTP_CON, 0777,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_delete($FTP_CON,'./index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE']);
                                    @ftp_put($FTP_CON,'index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'],$_CONSTRUCTR_CONF['_STATIC_DIR'] . '/index' . $_CONSTRUCTR_CONF['_STATIC_FILETYPE'], $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']) or die ('FTP-DATA ERROR11');
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
                        }

                        $FTP_CON = @ftp_connect($_CONSTRUCTR_CONF['_FTP_REMOTE_HOST'],$_CONSTRUCTR_CONF['_FTP_REMOTE_PORT']);
                        @ftp_login($FTP_CON, $_CONSTRUCTR_CONF['_FTP_REMOTE_USERNAME'], $_CONSTRUCTR_CONF['_FTP_REMOTE_PASSWORD']);

                        @ftp_chmod($FTP_CON, 0777,'sitemap.xml');
                        @ftp_delete($FTP_CON,'sitemap.xml');
                        @ftp_put($FTP_CON,'sitemap.xml',$_CONSTRUCTR_CONF['_BASE_URL'] . '/sitemap.xml', $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']);
                        @ftp_chmod($FTP_CON, 0777,'sitemap.xml');

                        @ftp_chmod($FTP_CON, 0777,'.htaccess');
                        @ftp_delete($FTP_CON,'.htaccess');
                        @ftp_put($FTP_CON,'.htaccess',$_CONSTRUCTR_CONF['_STATIC_DIR'] . '/.htaccess', $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']);
                        @ftp_chmod($FTP_CON, 0777,'.htaccess');

                        @ftp_chmod($FTP_CON, 0777,'robots.txt');
                        @ftp_delete($FTP_CON,'robots.txt');
                        @ftp_put($FTP_CON,'robots.txt',$_CONSTRUCTR_CONF['_STATIC_DIR'] . '/robots.txt', $_CONSTRUCTR_CONF['_FTP_REMOTE_MODE']);
                        @ftp_chmod($FTP_CON, 0777,'robots.txt');
                        @ftp_close($FTP_CON);
                    }
                    catch(PDOException $e)
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
            catch(PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?transfered-static=false');
                die();
            }
        }
    );

	/**
	 * Administrator Dashboard clear your Website Cache-Route. 
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 * @param $GUID - Constructr CMS CSRF-Guard
	 */
    $constructr -> get('/constructr/clear-cache/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);

            $constructr -> view -> setData('BackendUserRight',70);

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

            if($GUID == '')
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            $_CACHE_FILES = getFilesFromDir($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE_DIR']);

            if($_CACHE_FILES)
            {
                foreach($_CACHE_FILES as $_CACHE_FILE)
                {
                    @chmod($_CACHE_FILE,0777);
                    @unlink($_CACHE_FILE);
                }
            }

            $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/?cleared-cache=true');
            die();
        }
    );

	/**
	 * Administrator Dashboard clear your Website Cache-Route for a specific Page.
	 * @param $ADMIN_CHECK - User Rights Function
	 * @param $constructr - Constructr CMS application
	 * @param $DB_CON - main database connection via PDO
	 * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
	 * @param $GUID - Constructr CMS CSRF-Guard
	 * @param $PAGE_ID - to clear the cache of a specific page
	 */
    $constructr -> get('/constructr/clear-cache-page/:GUID/:PAGE_ID/', $ADMIN_CHECK, function ($GUID,$PAGE_ID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = constructr_sanitization($GUID,true,true);
            $PAGE_ID = constructr_sanitization($PAGE_ID,true,true);

            $constructr -> view -> setData('BackendUserRight',70);

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

            if($GUID == '')
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

            try
            {
                $PAGE = $DBCON -> prepare('SELECT pages_url FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                $PAGE -> execute(array(':PAGE_ID' => (int) $PAGE_ID));
                $PAGE = $PAGE -> fetch();

                $_PAGES_URL = '/' . $PAGE['pages_url'];
                $_CACHE_FILES = getFilesFromDir($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE_DIR']);

                if($_CACHE_FILES)
                {
                    foreach($_CACHE_FILES as $_CACHE_FILE)
                    {
                        $_ORIGIN_C_FILE = $_CACHE_FILE;
                        $_CACHE_FILE = str_replace($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE_DIR'],'',$_CACHE_FILE);
                        $_CACHE_FILE = str_replace('.php','',$_CACHE_FILE);
                        $_CACHE_FILE = str_replace('/','',$_CACHE_FILE);
                        $_CACHE_FILE = base64_decode($_CACHE_FILE);

                        if($_CACHE_FILE == $_PAGES_URL)
                        {
                            @chmod($_ORIGIN_C_FILE,0777);
                            @unlink($_ORIGIN_C_FILE);
                        }
                    }
                }

                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/?res=cleared-page-cache-true');
                die();
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/?res=cleared-page-cache-false');
                die();
            }
        }
    );