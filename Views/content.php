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
 *
 * @link http://constructr-cms.org/
 * @link http://blog.phaziz.com/category/constructr-cms/
 * @link http://phaziz.com/
 *
 * @version 1.04.5 / 25.02.2015
 */

    /**
     * Main Administrator View to list all Content-Elements of a specific Page.
     *
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     */
    $constructr->get('/constructr/content/:PAGE_ID/', $ADMIN_CHECK, function ($PAGE_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_COUNTER = 0;
            $CONTENT = '';

            $constructr->view->setData('BackendUserRight', 20);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            try {
                $PAGE_NAME = $DBCON->prepare('SELECT * FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                $PAGE_NAME->execute(array(':PAGE_ID' => $PAGE_ID));
                $PAGE_NAME = $PAGE_NAME->fetch();

                $CONTENT = $DBCON->prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_order != 0 ORDER BY content_order ASC;');
                $CONTENT->execute(array(':PAGE_ID' => $PAGE_ID));
                $CONTENT_COUNTER = $CONTENT->rowCount();

                if ($_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY'] == true) {
                    $DELETED_CONTENT = $DBCON->prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_deleted = 1 ORDER BY content_id ASC;');
                    $DELETED_CONTENT->execute(array(':PAGE_ID' => $PAGE_ID));
                    $DELETED_CONTENT_COUNTER = $DELETED_CONTENT->rowCount();
                } else {
                    $DELETED_CONTENT = null;
                    $DELETED_CONTENT_COUNTER = 0;
                }
            } catch (PDOException $e) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                die();
            }

            $GUID = create_guid();

            $constructr->render('content.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'PAGE_ID' => $PAGE_ID,
                    'PAGE_NAME' => $PAGE_NAME,
                    'CONTENT' => $CONTENT,
                    'GUID' => $GUID,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/update-page-data/'.$GUID.'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'CONTENT_COUNTER' => $CONTENT_COUNTER,
                    'DELETED_CONTENT' => $DELETED_CONTENT,
                    'DELETED_CONTENT_COUNTER' => $DELETED_CONTENT_COUNTER,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Seiteninhalte von Seite',
                )
            );
        }
    );

    /**
     * Main Administrator View to retrieve a Uploads-Image List within the Content-Editor.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @return JSON structure with all Image Files
     */
    $constructr->get('/constructr/get-image-list/', $ADMIN_CHECK, function () use ($constructr, $_CONSTRUCTR_CONF) {
            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }
			$IMAGE_LIST = NULL;
            $IMAGE_LIST .= '[';
            $EXTENSIONS = array("jpg", "JPG", "bmp", "BMP", "gif", "GIF", "jpeg", "JPEG", "png", "PNG");

            if ($HANDLE = @opendir('./Uploads/')) {
                while (false !== ($IMAGE = readdir($HANDLE))) {
                    if (in_array(pathinfo($IMAGE, PATHINFO_EXTENSION), $EXTENSIONS)) {
                        $IMAGE_LIST .=  '{"image":"'.$_CONSTRUCTR_CONF['_BASE_URL'].'/Uploads/'.$IMAGE.'","thumb": "'.$_CONSTRUCTR_CONF['_BASE_URL'].'/Uploads/'.$IMAGE.'","folder": "Uploads"},';
                    }
                }
                @closedir($HANDLE);
            }

            $IMAGE_LIST .= ']';
            $IMAGES_JSON = str_replace('"},]', '"}]', $IMAGE_LIST);
            echo $IMAGES_JSON;
            die();
        }
    );

    /**
     * Creating a new Content Element Form-View.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $NEW_CONTENT_ORDER - Sorting value of the new Content
     */
    $constructr->get('/constructr/content/:PAGE_ID/:NEW_CONTENT_ORDER/new/', $ADMIN_CHECK, function ($PAGE_ID, $NEW_CONTENT_ORDER) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $NEW_CONTENT_ORDER = constructr_sanitization($NEW_CONTENT_ORDER, true, true);

            $constructr->view->setData('BackendUserRight', 21);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            try {
                $PAGE_NAME = $DBCON->prepare('SELECT pages_name,pages_url FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                $PAGE_NAME->execute(array(':PAGE_ID' => $PAGE_ID));
                $PAGE_NAME = $PAGE_NAME->fetch();
            } catch (PDOException $e) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                die();
            }

            $GUID = create_guid();

            $constructr->render('content-new.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'PAGE_NAME' => $PAGE_NAME,
                    'GUID' => $GUID,
                    'PAGE_ID' => $PAGE_ID,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'NEW_CONTENT_ORDER' => $NEW_CONTENT_ORDER,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/new/'.$GUID.'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Neuer Inhalt',
                )
            );
        }
    );

    /**
     * Update the Page JS and CSS
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $GUID - Constructr CMS CSRF-Guard
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     */
    $constructr->post('/constructr/content/:PAGE_ID/update-page-data/:GUID/', $ADMIN_CHECK, function ($PAGE_ID, $GUID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $GUID = constructr_sanitization($GUID, true, true);
            $USER_FORM_GUID = constructr_sanitization($constructr->request()->post('user_form_guid'), true, true);

            if ($GUID != $USER_FORM_GUID) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' - USER_FORM_GUID ERROR ('.$USER_FORM_GUID.'|'.$GUID.'): '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $constructr->view->setData('BackendUserRight', 13);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $PAGE_CSS = $constructr->request()->post('page_css');
            $PAGE_JS = $constructr->request()->post('page_js');

            try {
                $QUERY = 'UPDATE constructr_pages SET pages_css = :PAGE_CSS, pages_js = :PAGE_JS WHERE pages_id >= :PAGE_ID LIMIT 1;';
                $STMT = $DBCON->prepare($QUERY);
                $STMT->bindParam(':PAGE_ID', $PAGE_ID, PDO::PARAM_INT);
                $STMT->bindParam(':PAGE_CSS', $PAGE_CSS, PDO::PARAM_STR);
                $STMT->bindParam(':PAGE_JS', $PAGE_JS, PDO::PARAM_STR);
                $STMT->execute();

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=update-page-data-true');
                die();
            } catch (PDOException $e) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=create-content-false');
                die();
            }
        }
    );

    /**
     * Creating a new Content Element Post-Form-View.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $GUID - Constructr CMS CSRF-Guard
     */
    $constructr->post('/constructr/content/:PAGE_ID/new/:GUID/', $ADMIN_CHECK, function ($PAGE_ID, $GUID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $GUID = constructr_sanitization($GUID, true, true);
            $USER_FORM_GUID = constructr_sanitization($constructr->request()->post('user_form_guid'), true, true);

            if ($GUID != $USER_FORM_GUID) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' - USER_FORM_GUID ERROR ('.$USER_FORM_GUID.'|'.$GUID.'): '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $constructr->view->setData('BackendUserRight', 21);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $CONTENT_DATETIME = date('Y-m-d H:i:s');
            $CONTENT = constructr_sanitization(trim($constructr->request()->post('content')));
            $CONTENT_ORDER = constructr_sanitization(trim((int) $constructr->request()->post('content_order')));
            $CONTENT_ACTIVE = 1;

            if ($CONTENT != '' && $CONTENT_ORDER != '') {
                try {
                    $MEDIA = $DBCON->prepare('SELECT * FROM constructr_media;');
                    $MEDIA->execute();
                    $MEDIA = $MEDIA->fetchAll();
                } catch (PDOException $e) {
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=edit-content-false');
                    die();
                }

                foreach ($MEDIA as $MEDIA) {
                	$CONTENT = str_replace('<img alt="'.$MEDIA['media_title'].'" data-original-title="'.$MEDIA['media_title'].'" title="'.$MEDIA['media_title'].'" data-original-copyright="'.$MEDIA['media_copyright'].'" data-original-description="'.$MEDIA['media_description'].'" data-keywords="'.$MEDIA['media_keywords'].'" src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$MEDIA['media_file'].'"', '<img alt="" src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$MEDIA['media_file'].'"', $CONTENT);
                    $CONTENT = str_replace('<img alt="" src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$MEDIA['media_file'].'"', '<img alt="'.$MEDIA['media_title'].'" data-original-title="'.$MEDIA['media_title'].'" title="'.$MEDIA['media_title'].'" data-original-copyright="'.$MEDIA['media_copyright'].'" data-original-description="'.$MEDIA['media_description'].'" data-keywords="'.$MEDIA['media_keywords'].'" src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$MEDIA['media_file'].'"', $CONTENT);
                }

                try {
                    $QUERY = 'INSERT INTO constructr_content SET content_datetime = :CONTENT_DATETIME,content_order = :CONTENT_ORDER,content_page_id = :PAGE_ID,content_content = :CONTENT,content_active = :CONTENT_ACTIVE;';
                    $STMT = $DBCON->prepare($QUERY);
                    $STMT->bindParam(':CONTENT', $CONTENT, PDO::PARAM_STR);
                    $STMT->bindParam(':CONTENT_DATETIME', $CONTENT_DATETIME, PDO::PARAM_STR);
                    $STMT->bindParam(':CONTENT_ORDER', $CONTENT_ORDER, PDO::PARAM_INT);
                    $STMT->bindParam(':PAGE_ID', $PAGE_ID, PDO::PARAM_INT);
                    $STMT->bindParam(':CONTENT_ACTIVE', $CONTENT_ACTIVE, PDO::PARAM_INT);
                    $STMT->execute();

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=create-content-true');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=create-content-false');
                    die();
                }
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=create-content-false');
                die();
            }
        }
    );

    /**
     * Editing a Content Element.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/edit/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);

            $constructr->view->setData('BackendUserRight', 22);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            try {
                $CONTENT = $DBCON->prepare('SELECT * FROM constructr_content WHERE content_page_id = :PAGE_ID AND content_id = :CONTENT_ID LIMIT 1;');
                $CONTENT->execute(
                    array(
                        ':PAGE_ID' => $PAGE_ID,
                        ':CONTENT_ID' => $CONTENT_ID,
                    )
                );
                $CONTENT = $CONTENT->fetch();

                if ($_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY'] == true) {
                    $CONTENT_HISTORY = $DBCON->prepare('SELECT * FROM constructr_content_history WHERE content_page_id = :PAGE_ID AND content_content_id = :CONTENT_ID ORDER BY content_datetime DESC;');
                    $CONTENT_HISTORY->execute(
                        array(
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID,
                        )
                    );
                    $CONTENT_HISTORY = $CONTENT_HISTORY->fetchAll();
                } else {
                    $CONTENT_HISTORY = null;
                }

                $PAGE_NAME = $DBCON->prepare('SELECT pages_name,pages_url FROM constructr_pages WHERE pages_id = :PAGE_ID LIMIT 1;');
                $PAGE_NAME->execute(
                    array(
                        ':PAGE_ID' => $PAGE_ID,
                    )
                );
                $PAGE_NAME = $PAGE_NAME->fetch();
            } catch (PDOException $e) {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=edit-content-false');
                echo 'nep';
                die();
            }

            $GUID = create_guid();

            $constructr->render('content-edit.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    'CONTENT' => $CONTENT,
                    'CONTENT_HISTORY' => $CONTENT_HISTORY,
                    'PAGE_NAME' => $PAGE_NAME,
                    'PAGE_ID' => $PAGE_ID,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT_ID.'/edit/'.$GUID.'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    'SUBTITLE' => 'Inhalt bearbeiten',
                )
            );
        }
    );

    /**
     * Post-View of editing a Content Element.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     * @param $GUID - Constructr CMS CSRF-Guard
     */
    $constructr->post('/constructr/content/:PAGE_ID/:CONTENT_ID/edit/:GUID/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID, $GUID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);
            $GUID = constructr_sanitization($GUID, true, true);
            $USER_FORM_GUID = constructr_sanitization($constructr->request()->post('user_form_guid'), true, true);

            if ($GUID != $USER_FORM_GUID) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' - USER_FORM_GUID ERROR ('.$USER_FORM_GUID.'|'.$GUID.'): '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $constructr->view->setData('BackendUserRight', 22);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $CONTENT_DATETIME = date('Y-m-d H:i:s');
            $CONTENT = constructr_sanitization(trim($constructr->request()->post('content')));

            if ($CONTENT != '' && $CONTENT_ID != '') {
                try {
                    $MEDIA = $DBCON->prepare('SELECT * FROM constructr_media;');
                    $MEDIA->execute();
                    $MEDIA = $MEDIA->fetchAll();
                } catch (PDOException $e) {
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=edit-content-false');
                    die();
                }

                foreach ($MEDIA as $MEDIA) {
                    $CONTENT = str_replace('<img alt="" src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$MEDIA['media_file'].'"', '<img alt="'.$MEDIA['media_title'].'" data-original-title="'.$MEDIA['media_title'].'" title="'.$MEDIA['media_title'].'" data-original-copyright="'.$MEDIA['media_copyright'].'" data-original-description="'.$MEDIA['media_description'].'" data-keywords="'.$MEDIA['media_keywords'].'" src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$MEDIA['media_file'].'"', $CONTENT);
                }

                try {
                    $UPDATE_PAGES = $DBCON->prepare('UPDATE constructr_content SET content_content = :CONTENT, content_datetime = :CONTENT_DATETIME WHERE content_id = :CONTENT_ID AND content_page_id = :PAGE_ID LIMIT 1;');
                    $UPDATE_PAGES->execute(
                        array(
                            ':CONTENT' => $CONTENT,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_DATETIME' => $CONTENT_DATETIME,
                            ':CONTENT_ID' => $CONTENT_ID,
                        )
                    );

                    if ($_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY'] == true) {
                        $QUERY = 'INSERT INTO constructr_content_history SET content_datetime = :CONTENT_DATETIME,content_page_id = :PAGE_ID,content_content = :CONTENT, content_content_id = :LAST_CONTENT_ID;';
                        $STMT = $DBCON->prepare($QUERY);
                        $STMT->bindParam(':CONTENT', $CONTENT, PDO::PARAM_STR);
                        $STMT->bindParam(':CONTENT_DATETIME', $CONTENT_DATETIME, PDO::PARAM_STR);
                        $STMT->bindParam(':PAGE_ID', $PAGE_ID, PDO::PARAM_INT);
                        $STMT->bindParam(':LAST_CONTENT_ID', $CONTENT_ID, PDO::PARAM_INT);
                        $STMT->execute();
                    }

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=edit-content-true');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=edit-content-false');
                    die();
                }
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=edit-content-false');
                die();
            }
        }
    );

    /**
     * Reordering of Content Elements in List-View.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     * @param $ACT_ORDER - Constructr CMS actual content sorting value
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/:ACT_ORDER/up/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID, $ACT_ORDER) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);
            $ACT_ORDER = constructr_sanitization($ACT_ORDER, true, true);

            $constructr->view->setData('BackendUserRight', 23);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $USERNAME = $_SESSION['backend-user-username'];

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '' && $ACT_ORDER != '') {
                $NEW_ORDER = ($ACT_ORDER - 1);
                $NULL_MARKER = 0;

                try {
                    $UPDATE_CONTENT = $DBCON->prepare('
                        UPDATE constructr_content SET content_order = :NEW_ORDER, content_temp_marker = :TEMP_MARKER WHERE content_order = :ACT_ORDER AND content_page_id = :PAGE_ID LIMIT 1;
                        UPDATE constructr_content SET content_order = :ACT_ORDER, content_temp_marker = :TEMP_MARKER WHERE content_order = :NEW_ORDER AND content_page_id = :PAGE_ID AND content_temp_marker = :NULL_MARKER LIMIT 1;
                        UPDATE constructr_content SET content_temp_marker = :NULL_MARKER WHERE content_temp_marker = :TEMP_MARKER AND content_page_id = :PAGE_ID;
                    ');
                    $UPDATE_CONTENT->execute(
                        array(
                            ':TEMP_MARKER' => 666,
                            ':NEW_ORDER' => $NEW_ORDER,
                            ':ACT_ORDER' => $ACT_ORDER,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':NULL_MARKER' => $NULL_MARKER,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=activate-content-false');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=reorder-content-true');
                die();
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=reorder-content-false');
                die();
            }
        }
    );

    /**
     * Reordering of Content Elements in List-View.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     * @param $ACT_ORDER - Constructr CMS content element sorting value
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/:ACT_ORDER/down/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID, $ACT_ORDER) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);
            $ACT_ORDER = constructr_sanitization($ACT_ORDER, true, true);

            $constructr->view->setData('BackendUserRight', 23);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $USERNAME = $_SESSION['backend-user-username'];

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '' && $ACT_ORDER != '') {
                $NEW_ORDER = ($ACT_ORDER + 1);
                $NULL_MARKER = 0;

                try {
                    $UPDATE_CONTENT = $DBCON->prepare('
                        UPDATE constructr_content SET content_order = :NEW_ORDER, content_temp_marker = :TEMP_MARKER WHERE content_order = :ACT_ORDER AND content_page_id = :PAGE_ID LIMIT 1;
                        UPDATE constructr_content SET content_order = :ACT_ORDER, content_temp_marker = :TEMP_MARKER WHERE content_order = :NEW_ORDER AND content_page_id = :PAGE_ID AND content_temp_marker = :NULL_MARKER LIMIT 1;
                        UPDATE constructr_content SET content_temp_marker = :NULL_MARKER WHERE content_temp_marker = :TEMP_MARKER AND content_page_id = :PAGE_ID;
                    ');
                    $UPDATE_CONTENT->execute(
                        array(
                            ':TEMP_MARKER' => 666,
                            ':NEW_ORDER' => $NEW_ORDER,
                            ':ACT_ORDER' => $ACT_ORDER,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':NULL_MARKER' => $NULL_MARKER,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=activate-content-false');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=reorder-content-true');
                die();
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=reorder-content-false');
                die();
            }
        }
    );

    /**
     * Activate an Content Element
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/activate/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);

            $constructr->view->setData('BackendUserRight', 24);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '') {
                try {
                    $UPDATE_CONTENT = $DBCON->prepare('UPDATE constructr_content SET content_active = :CONTENT_ACTIVE WHERE content_page_id = :PAGE_ID AND content_id = :CONTENT_ID LIMIT 1;');
                    $UPDATE_CONTENT->execute(
                        array(
                            ':CONTENT_ACTIVE' => 1,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=activate-content-false');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=activate-content-true');
                die();
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=activate-content-false');
                die();
            }
        }
    );

    /**
     * Deactivation of Content Elements in List-View.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/deactivate/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);

            $constructr->view->setData('BackendUserRight', 24);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '') {
                try {
                    $UPDATE_CONTENT = $DBCON->prepare('UPDATE constructr_content SET content_active = :CONTENT_ACTIVE WHERE content_page_id = :PAGE_ID AND content_id = :CONTENT_ID LIMIT 1;');
                    $UPDATE_CONTENT->execute(
                        array(
                            ':CONTENT_ACTIVE' => 0,
                            ':PAGE_ID' => $PAGE_ID,
                            ':CONTENT_ID' => $CONTENT_ID,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=deactivate-content-false');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=deactivate-content-true');
                die();
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=deactivate-content-false');
                die();
            }
        }
    );

    /**
     * Deleting a Content Element in List-View.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     * @param $ACT_ORDER - Constructr CMS content element sorting value
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/:ACT_ORDER/delete/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID, $ACT_ORDER) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);
            $ACT_ORDER = constructr_sanitization($ACT_ORDER, true, true);

            $constructr->view->setData('BackendUserRight', 25);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '') {
                try {
                    $DELETER = $DBCON->prepare('
                        UPDATE constructr_content SET content_deleted = 1, content_order = 0, content_active = 0 WHERE content_id = :CONTENT_ID AND content_page_id = :PAGE_ID LIMIT 1;
                        UPDATE constructr_content SET content_order = (content_order - 1) WHERE content_order > :ACT_ORDER AND content_page_id = :PAGE_ID;
                    ');
                    $DELETER->execute(
                        array(
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':PAGE_ID' => $PAGE_ID,
                            ':ACT_ORDER' => $ACT_ORDER,
                        )
                    );

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-true');
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                    die();
                }
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                die();
            }
        }
    );

    /**
     * Delete all Content-Elements of a specific Page.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/delete-complete/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);

            $constructr->view->setData('BackendUserRight', 25);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '') {
                try {
                    $DELETER = $DBCON->prepare('DELETE FROM constructr_content WHERE content_id = :CONTENT_ID AND content_page_id = :PAGE_ID LIMIT 1;');
                    $DELETER->execute(
                        array(
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':PAGE_ID' => $PAGE_ID,
                        )
                    );

                    $DELETER = $DBCON->prepare('DELETE FROM constructr_content_history WHERE content_page_id = :PAGE_ID AND content_content_id = :CONTENT_ID;');
                    $DELETER->execute(
                        array(
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':PAGE_ID' => $PAGE_ID,
                        )
                    );

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-true');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                    die();
                }
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                die();
            }
        }
    );

    /**
     * Delete the History-Content-Elements of a specific Page.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     * @param $CONTENT_HISTORY_ID - Constructr CMS content element history id
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_HISTORY_ID/:CONTENT_ID/delete-history-complete/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_HISTORY_ID, $CONTENT_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_HISTORY_ID = constructr_sanitization($CONTENT_HISTORY_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);

            $constructr->view->setData('BackendUserRight', 25);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '') {
                try {
                    $DELETER = $DBCON->prepare('DELETE FROM constructr_content_history WHERE content_id = :CONTENT_HISTORY_ID AND content_page_id = :PAGE_ID AND content_content_id = :CONTENT_ID LIMIT 1;');
                    $DELETER->execute(
                        array(
                            ':CONTENT_HISTORY_ID' => $CONTENT_HISTORY_ID,
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':PAGE_ID' => $PAGE_ID,
                        )
                    );

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT_ID.'/edit/?history=deleted-true');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                    die();
                }
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                die();
            }
        }
    );

    /**
     * Recover a deleted Content-Element.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $PAGE_ID - Constructr CMS Frontend PageID
     * @param $CONTENT_ID - Constructr CMS ContentID
     * @param $NEW_ORDER - Constructr CMS content element recover sorting value
     */
    $constructr->get('/constructr/content/:PAGE_ID/:CONTENT_ID/:NEW_ORDER/re-create/', $ADMIN_CHECK, function ($PAGE_ID, $CONTENT_ID, $NEW_ORDER) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $PAGE_ID = constructr_sanitization($PAGE_ID, true, true);
            $CONTENT_ID = constructr_sanitization($CONTENT_ID, true, true);
            $NEW_ORDER = constructr_sanitization($NEW_ORDER, true, true);

            $constructr->view->setData('BackendUserRight', 21);

            if (isset($_SESSION['backend-user-id']) && $_SESSION['backend-user-id'] != '') {
                try {
                    $RIGHT_CHECKER = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_right = :RIGHT_ID AND cbr_user_id = :USER_ID AND cbr_value = :CBR_VALUE LIMIT 1;');
                    $RIGHT_CHECKER->execute(
                        array(
                            ':USER_ID' => $_SESSION['backend-user-id'],
                            ':RIGHT_ID' => $constructr->view->getData('BackendUserRight'),
                            ':CBR_VALUE' => 1,
                        )
                    );

                    $RIGHTS_COUNTR = $RIGHT_CHECKER->rowCount();

                    if ($RIGHTS_COUNTR != 1) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Error '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                        $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/?no-rights=true');
                        die();
                    } else {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' User-Rights-Success '.$constructr->view->getData('BackendUserRight').': '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' Error User-Rights-Check: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            if ($PAGE_ID != '' && $CONTENT_ID != '') {
                try {
                    $UPDATER = $DBCON->prepare('
                        UPDATE constructr_content SET content_deleted = 0, content_order = :NEW_ORDER, content_active = 1 WHERE content_id = :CONTENT_ID AND content_page_id = :PAGE_ID LIMIT 1;
                    ');
                    $UPDATER->execute(
                        array(
                            ':CONTENT_ID' => $CONTENT_ID,
                            ':PAGE_ID' => $PAGE_ID,
                            ':NEW_ORDER' => $NEW_ORDER,
                        )
                    );

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=recreated-true');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=del-content-false');
                    die();
                }
            } else {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/?res=recreated-false');
                die();
            }
        }
    );