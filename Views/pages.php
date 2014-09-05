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

    $constructr -> get('/constructr/pages/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
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

            try
            {
               $PAGES = $DBCON -> query('SELECT * FROM constructr_pages ORDER BY pages_order ASC;');
               $PAGES_COUNTR = $PAGES -> rowCount();
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');
                die();
            }

            $constructr -> render('pages.php',
                array
                (
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'PAGES' => $PAGES,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'SUBTITLE' => 'Seitenverwaltung'
                )
            );
        }
    );

    $constructr -> get('/constructr/pages/new/', $ADMIN_CHECK, function () use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
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

            $PAGES_COUNTR = 0;

            try
            {
               $PAGES = $DBCON -> query('SELECT * FROM constructr_pages ORDER BY pages_order ASC;');
               $PAGES_COUNTR = $PAGES -> rowCount();
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/');
                die();
            }

            $GUID = create_guid();
            $TEMPLATES = array_diff(scandir($_CONSTRUCTR_CONF['_TEMPLATES_DIR']), array('..', '.'));

            $constructr -> render('pages_new.php',
                array
                (
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    'PAGES' => $PAGES,
                    'PAGES_COUNTR' => $PAGES_COUNTR,
                    'TEMPLATES' => $TEMPLATES,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/new/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Neue Seite'
                )
            );
        }
    );

    $constructr -> post('/constructr/pages/new/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = filter_var(trim($GUID),FILTER_SANITIZE_STRING);

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

            $USER_FORM_GUID = $constructr -> request() -> post('user_form_guid');

            if($GUID != $USER_FORM_GUID)
            {
                $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ' - USER_FORM_GUID ERROR: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/logout/');
                die();
            }

			$PAGES_COUNTR = constructr_sanitization($constructr -> request() -> post('pages_countr'));
			$NEW_PAGE_ORDER = constructr_sanitization($constructr -> request() -> post('new_page_order'));
			$NEW_PAGE_ORDER_PAGE_ID = constructr_sanitization($constructr -> request() -> post('new_page_order_page_id'));
            $PAGE_DATETIME = date('Y-m-d H:i:s');
            $PAGE_NAME = constructr_sanitization($constructr -> request() -> post('page_name'));
            $PAGE_URL = constructr_sanitization($constructr -> request() -> post('page_url'));
            $PAGE_URL = str_replace(" ","-", $PAGE_URL);
            $PAGE_URL = str_replace("//","/", $PAGE_URL);
            $PAGE_URL = str_replace("ü","ue", $PAGE_URL);
            $PAGE_URL = str_replace("Ü","ue", $PAGE_URL);
            $PAGE_URL = str_replace("ä","ae", $PAGE_URL);
            $PAGE_URL = str_replace("Ä","ae", $PAGE_URL);
            $PAGE_URL = str_replace("ö","oe", $PAGE_URL);
            $PAGE_URL = str_replace("Ö","oe", $PAGE_URL);
            $PAGE_URL = str_replace("ß","ss", $PAGE_URL);
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
            catch(PDOException $e)
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

			$PAGE_ACTIVE = 1;

			if($PAGE_NAME != '')
            {
				if($NEW_PAGE_ORDER == '' && $PAGES_COUNTR > 0 || $NEW_PAGE_ORDER_PAGE_ID == '' && $PAGES_COUNTR > 0)
				{
					$PAGE_LEVEL = 1;
					$PAGE_MOTHER = 0;
					$PAGE_ORDER = ($PAGES_COUNTR + 1);

	                try
	                {
	                    $QUERY = 'INSERT INTO constructr_pages SET pages_level = :PAGE_LEVEL,pages_mother = :PAGE_MOTHER,pages_order= :PAGE_ORDER,pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_nav_visible = :PAGE_VISIBILITY,pages_url = :PAGE_URL,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_active = :PAGE_ACTIVE;';
	                    $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':PAGE_LEVEL', $PAGE_LEVEL,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_MOTHER', $PAGE_MOTHER,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_ORDER', $PAGE_ORDER,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
	                    $STMT -> execute();
	                }
	                catch(PDOException $e)
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
	                    $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
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
	                catch(PDOException $e)
	                {
	                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
	                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
	                    die();
	                }

	                $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
	                @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
	                @fclose($CREATE_SITEMAP);
	                @chmod($SITEMAP_FILE,0777);

	                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');
	                die();
				}				
				else if($NEW_PAGE_ORDER == 1 && $NEW_PAGE_ORDER_PAGE_ID != '')
				{
	                try
	                {
						$QUERY = 'SELECT pages_order, pages_level, pages_mother FROM constructr_pages WHERE pages_id = :NEW_PAGE_ORDER_PAGE_ID LIMIT 1;';
		                $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':NEW_PAGE_ORDER_PAGE_ID', $NEW_PAGE_ORDER_PAGE_ID,PDO::PARAM_INT);
		                $STMT -> execute();
						$RES = $STMT -> fetch();

						$QUERY2 = 'UPDATE constructr_pages SET pages_order = (pages_order + 1) WHERE pages_order >= :ACT_PAGE_ORDER;';
		                $STMT2 = $DBCON -> prepare($QUERY2);
						$STMT2 -> bindParam(':ACT_PAGE_ORDER', $RES['pages_order'], \PDO::PARAM_INT);
		                $STMT2 -> execute();

						$PAGE_LEVEL = $RES['pages_level'];
						$PAGE_MOTHER = $RES['pages_mother'];
						$PAGE_ORDER = $RES['pages_order'];

	                    $QUERY = 'INSERT INTO constructr_pages SET pages_level = :PAGE_LEVEL,pages_mother = :PAGE_MOTHER,pages_order= :PAGE_ORDER,pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_nav_visible = :PAGE_VISIBILITY,pages_url = :PAGE_URL,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_active = :PAGE_ACTIVE;';
	                    $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':PAGE_LEVEL', $PAGE_LEVEL,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_MOTHER', $PAGE_MOTHER,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_ORDER', $PAGE_ORDER,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
	                    $STMT -> execute();
	                }
	                catch(PDOException $e)
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
	                    $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
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
	                catch(PDOException $e)
	                {
	                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
	                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
	                    die();
	                }

	                $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
	                @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
	                @fclose($CREATE_SITEMAP);
	                @chmod($SITEMAP_FILE,0777);

	                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');
	                die();
				}				
				else if($NEW_PAGE_ORDER == 2 && $NEW_PAGE_ORDER_PAGE_ID != '')
				{
	                try
	                {
						$QUERY = 'SELECT pages_order, pages_level, pages_mother FROM constructr_pages WHERE pages_id = :NEW_PAGE_ORDER_PAGE_ID LIMIT 1;';
		                $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':NEW_PAGE_ORDER_PAGE_ID', $NEW_PAGE_ORDER_PAGE_ID,PDO::PARAM_INT);
		                $STMT -> execute();
						$RES = $STMT -> fetch();

						$QUERY2 = 'UPDATE constructr_pages SET pages_order = (pages_order + 1) WHERE pages_order > :ACT_PAGE_ORDER;';
		                $STMT2 = $DBCON -> prepare($QUERY2);
						$STMT2 -> bindParam(':ACT_PAGE_ORDER',$RES['pages_order'],PDO::PARAM_INT);
		                $STMT2 -> execute();

						$PAGE_LEVEL = ($RES['pages_level'] + 1);
						$PAGE_MOTHER = $NEW_PAGE_ORDER_PAGE_ID;
						$PAGE_ORDER = ($RES['pages_order'] + 1);

	                    $QUERY = 'INSERT INTO constructr_pages SET pages_level = :PAGE_LEVEL,pages_mother = :PAGE_MOTHER,pages_order= :PAGE_ORDER,pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_nav_visible = :PAGE_VISIBILITY,pages_url = :PAGE_URL,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_active = :PAGE_ACTIVE;';
	                    $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':PAGE_LEVEL',$PAGE_LEVEL,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_MOTHER',$PAGE_MOTHER,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_ORDER',$PAGE_ORDER,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
	                    $STMT -> execute();
	                }
	                catch(PDOException $e)
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
	                    $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
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
	                catch(PDOException $e)
	                {
	                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
	                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
	                    die();
	                }

	                $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
	                @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
	                @fclose($CREATE_SITEMAP);
	                @chmod($SITEMAP_FILE,0777);

	                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');
	                die();
				}
				else if($NEW_PAGE_ORDER == 3 && $NEW_PAGE_ORDER_PAGE_ID != '')
				{
	                try
	                {
						$QUERY = 'SELECT pages_order, pages_level, pages_mother FROM constructr_pages WHERE pages_id = :NEW_PAGE_ORDER_PAGE_ID LIMIT 1;';
		                $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':NEW_PAGE_ORDER_PAGE_ID', $NEW_PAGE_ORDER_PAGE_ID,PDO::PARAM_INT);
		                $STMT -> execute();
						$RES = $STMT -> fetch();

						$QUERY2 = 'UPDATE constructr_pages SET pages_order = (pages_order + 1) WHERE pages_order > :ACT_PAGE_ORDER;';
		                $STMT2 = $DBCON -> prepare($QUERY2);
						$STMT2 -> bindParam(':ACT_PAGE_ORDER',$RES['pages_order'],PDO::PARAM_INT);
		                $STMT2 -> execute();

						$PAGE_LEVEL = $RES['pages_level'];
						$PAGE_MOTHER = $RES['pages_mother'];
						$PAGE_ORDER = ($RES['pages_order'] + 1);

	                    $QUERY = 'INSERT INTO constructr_pages SET pages_level = :PAGE_LEVEL,pages_mother = :PAGE_MOTHER,pages_order= :PAGE_ORDER,pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_nav_visible = :PAGE_VISIBILITY,pages_url = :PAGE_URL,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_active = :PAGE_ACTIVE;';
	                    $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':PAGE_LEVEL',$PAGE_LEVEL,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_MOTHER',$PAGE_MOTHER,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_ORDER',$PAGE_ORDER,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
	                    $STMT -> execute();
	                }
	                catch(PDOException $e)
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
	                    $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
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
	                catch(PDOException $e)
	                {
	                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
	                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
	                    die();
	                }

	                $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
	                @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
	                @fclose($CREATE_SITEMAP);
	                @chmod($SITEMAP_FILE,0777);

	                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');
	                die();
				}
				else
				{
					$PAGE_LEVEL = 1;
					$PAGE_MOTHER = 0;
					$PAGE_ORDER = ($PAGES_COUNTR + 1);

	                try
	                {
	                    $QUERY = 'INSERT INTO constructr_pages SET pages_level = :PAGE_LEVEL,pages_mother = :PAGE_MOTHER,pages_order= :PAGE_ORDER,pages_datetime = :PAGE_DATETIME,pages_name = :PAGE_NAME,pages_nav_visible = :PAGE_VISIBILITY,pages_url = :PAGE_URL,pages_template = :PAGE_TEMPLATE,pages_title = :PAGE_TITLE,pages_description = :PAGE_DESCRIPTION,pages_keywords = :PAGE_KEYWORDS,pages_active = :PAGE_ACTIVE;';
	                    $STMT = $DBCON -> prepare($QUERY);
						$STMT -> bindParam(':PAGE_LEVEL', $PAGE_LEVEL,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_MOTHER', $PAGE_MOTHER,PDO::PARAM_INT);
						$STMT -> bindParam(':PAGE_ORDER', $PAGE_ORDER,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_DATETIME',$PAGE_DATETIME,PDO::PARAM_STR);
	                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
	                    $STMT -> bindParam(':PAGE_ACTIVE',$PAGE_ACTIVE,PDO::PARAM_INT);
	                    $STMT -> execute();
	                }
	                catch(PDOException $e)
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
	                    $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY pages_order ASC;');
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
	                catch(PDOException $e)
	                {
	                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
	                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
	                    die();
	                }

	                $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;
	                @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
	                @fclose($CREATE_SITEMAP);
	                @chmod($SITEMAP_FILE,0777);

	                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-true');
	                die();
				}
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
            $PAGE_ID = filter_var(trim($PAGE_ID),FILTER_SANITIZE_NUMBER_INT);
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
            catch(PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=edit-page-false');
                die();
            }

            $GUID = create_guid();
            $TEMPLATES = array_diff(scandir($_CONSTRUCTR_CONF['_TEMPLATES_DIR']), array('..', '.'));

            $constructr -> render('pages_edit.php',
                array
                (
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    'PAGE' => $PAGE,
                    'TEMPLATES' => $TEMPLATES,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/edit/' . $GUID . '/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Seite bearbeiten'
                )
            );
        }
    );

    $constructr -> post('/constructr/pages/edit/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $GUID = filter_var(trim($GUID),FILTER_SANITIZE_STRING);
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
                    $STMT -> bindParam(':PAGE_ID',$PAGE_ID,PDO::PARAM_INT);
                    $STMT -> bindParam(':PAGE_NAME',$PAGE_NAME,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_URL',$PAGE_URL,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_TEMPLATE',$PAGE_TEMPLATE,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_TITLE',$PAGE_TITLE,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_KEYWORDS',$PAGE_KEYWORDS,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_DESCRIPTION',$PAGE_DESCRIPTION,PDO::PARAM_STR);
                    $STMT -> bindParam(':PAGE_VISIBILITY',$PAGE_VISIBILITY,PDO::PARAM_INT);
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
                        $SITEMAP_PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_active = 1 ORDER BY PAGES_ORDER ASC;');
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
                    catch(PDOException $e)
                    {
                        $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=create-page-false');
                        die();
                    }

                    $SITEMAP_CONTENT .= '</urlset>' . $NEW_LINE;

                    @fwrite($CREATE_SITEMAP,$SITEMAP_CONTENT);
                    @fclose($CREATE_SITEMAP);
                    @chmod($SITEMAP_FILE,0777);

                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=edit-page-true');

                    die();
                }
                catch(PDOException $e)
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
            $PAGE_ID = filter_var(trim($PAGE_ID),FILTER_SANITIZE_NUMBER_INT);
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
                catch(PDOException $e)
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
            $PAGE_ID = filter_var(trim($PAGE_ID),FILTER_SANITIZE_NUMBER_INT);
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
                catch(PDOException $e)
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

    $constructr -> get('/constructr/pages/delete-single/:PAGE_ID/:PAGE_ORDER/', $ADMIN_CHECK, function ($PAGE_ID,$PAGE_ORDER) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $PAGE_ID = filter_var(trim($PAGE_ID),FILTER_SANITIZE_NUMBER_INT);
            $PAGE_ORDER = filter_var(trim($PAGE_ORDER),FILTER_SANITIZE_NUMBER_INT);
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

            if($PAGE_ID != '' && $PAGE_ORDER != '')
            {
				// AKTUELLE SEITE LÖSCHEN WENN KEINE INHALTE MEHR DA SIND UND WENN KEINE KINDER VORHANDEN SIND
                try
                {
                    $CONTENT = $DBCON -> prepare('SELECT content_id FROM constructr_content WHERE content_page_id = :PAGE_ID LIMIT 1;');
                    $CONTENT -> execute(array(':PAGE_ID' => $PAGE_ID));
                    $CONTENT_COUNTR = $CONTENT -> rowCount();
                }
                catch(PDOException $e)
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
                    $SUB_PAGES = $DBCON -> prepare('SELECT pages_id FROM constructr_pages WHERE pages_mother = :PAGE_ID LIMIT 1;');
                    $SUB_PAGES -> execute(array(':PAGE_ID' => $PAGE_ID));
                    $SUB_PAGES_COUNTR = $SUB_PAGES -> rowCount();
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }

                if($SUB_PAGES_COUNTR != 0)
                {
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=subpages-not-empty');
                    die();
                }

                try
                {
                    $DELETER = $DBCON -> prepare('DELETE FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                    $DELETER -> execute(array(':PAGE_ID' => $PAGE_ID));
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }
				// AKTUELLE SEITE LÖSCHEN WENN KEINE INHALTE MEHR DA SIND UND WENN KEINE KINDER VORHANDEN SIND

				// UPDATE DER NACHFOLGENDEN SEITEN
                try
                {
                    $DELETER = $DBCON -> prepare('UPDATE constructr_pages SET pages_order = (pages_order-1) WHERE pages_order >= :PAGE_ORDER;');
                    $DELETER -> execute(array(':PAGE_ORDER' => $PAGE_ORDER));
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> debug($_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=del-single-false');
                    die();
                }
				// UPDATE DER NACHFOLGENDEN SEITEN

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

    $constructr -> get('/constructr/pages/reorder/:METHOD/:PAGE_ID/', $ADMIN_CHECK, function ($METHOD,$PAGE_ID) use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
        {
            $PAGE_ID = filter_var(trim($PAGE_ID),FILTER_SANITIZE_NUMBER_INT);
            $METHOD = filter_var(trim($METHOD),FILTER_SANITIZE_STRING);
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

            if($METHOD != '' && $PAGE_ID != '')
            {
                try
                {
                    $SELEKTOR = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                    $SELEKTOR -> execute(array(':PAGE_ID' => $PAGE_ID));
                    $SELEKTOR = $SELEKTOR -> fetch();
                }
                catch(PDOException $e)
                {
                    $constructr -> getLog() -> debug('1) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                    die();
                }

                $PAGE_ID = $SELEKTOR['pages_id'];
                $PAGE_ORDER = $SELEKTOR['pages_order'];
                $PAGE_LEVEL = $SELEKTOR['pages_level'];
				$PAGE_MOTHER = $SELEKTOR['pages_mother'];

                if($METHOD == 'up')
                {
                    try
                    {
                    	$TARGET_PAGE_ORDER = ($SELEKTOR['pages_order'] - 1);
                        $SELECT_TARGET_PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_order = :TARGET_PAGE_ORDER LIMIT 1;');
                        $SELECT_TARGET_PAGE -> execute(array(':TARGET_PAGE_ORDER' => $TARGET_PAGE_ORDER));
                        $SELECT_TARGET_PAGE = $SELECT_TARGET_PAGE -> fetch();
                        $TARGET_PAGE_ID = $SELECT_TARGET_PAGE['pages_id'];
                        $TARGET_PAGE_ORDER = $SELECT_TARGET_PAGE['pages_order'];
                        $TARGET_PAGE_LEVEL = $SELECT_TARGET_PAGE['pages_level'];
						$TARGET_PAGE_MOTHER = $SELECT_TARGET_PAGE['pages_mother'];
                    }
                    catch(PDOException $e)
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
                    	$TARGET_PAGE_ORDER = ($SELEKTOR['pages_order'] + 1);
                        $SELECT_TARGET_PAGE = $DBCON -> prepare('SELECT * FROM constructr_pages WHERE pages_order = :TARGET_PAGE_ORDER LIMIT 1;');
                        $SELECT_TARGET_PAGE -> execute(array(':TARGET_PAGE_ORDER' => $TARGET_PAGE_ORDER));
                        $SELECT_TARGET_PAGE = $SELECT_TARGET_PAGE -> fetch();
                        $TARGET_PAGE_ID = $SELECT_TARGET_PAGE['pages_id'];
                        $TARGET_PAGE_ORDER = $SELECT_TARGET_PAGE['pages_order'];
                        $TARGET_PAGE_LEVEL = $SELECT_TARGET_PAGE['pages_level'];
						$TARGET_PAGE_MOTHER = $SELECT_TARGET_PAGE['pages_mother'];
                    }
                    catch(PDOException $e)
                    {
                        $constructr -> getLog() -> debug('3) ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ': ' . $e -> getMessage());
                        $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                        die();
                    }
                }

                try
                {
                    $UPDATE_PAGES = $DBCON -> prepare('
						UPDATE constructr_pages SET pages_order = :TARGET_PAGE_ORDER, pages_level = :TARGET_PAGE_LEVEL, pages_mother = :TARGET_PAGE_MOTHER WHERE pages_id = :PAGE_ID LIMIT 1;
						UPDATE constructr_pages SET pages_order = :PAGE_ORDER, pages_level = :PAGE_LEVEL, pages_mother = :PAGE_MOTHER WHERE pages_id = :TARGET_PAGE_ID LIMIT 1;
                    ');

                    $UPDATE_PAGES -> execute(
                        array
                        (
                            ':PAGE_ID' => $PAGE_ID,
                            ':PAGE_ORDER' => $PAGE_ORDER,
                            ':PAGE_LEVEL' => $PAGE_LEVEL,
                            ':PAGE_MOTHER' => $PAGE_MOTHER,
                            ':TARGET_PAGE_ID' => $TARGET_PAGE_ID,
                            ':TARGET_PAGE_ORDER' => $TARGET_PAGE_ORDER,
                            ':TARGET_PAGE_LEVEL' => $TARGET_PAGE_LEVEL,
                            ':TARGET_PAGE_MOTHER' => $TARGET_PAGE_MOTHER
                        )
                    );
                }
                catch(PDOException $e)
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
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/?res=reorder-error');
                die();
            }
        }
    );
