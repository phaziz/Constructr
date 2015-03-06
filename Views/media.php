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
     * AssetCenter (Uploads) View in your Backend.
     *
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/media/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $MEDIA_COUNTER = 0;

            $constructr->view->setData('BackendUserRight', 40);

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
                $MEDIA = $DBCON->query('SELECT * FROM constructr_media ORDER BY media_datetime DESC;');
                $MEDIA_COUNTER = $MEDIA->rowCount();
            } catch (PDOException $e) {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/');
                die();
            }

            $IMAGES = array('.jpg', '.jepg', '.JPG', '.JPEG', '.gif', '.GIF', '.png', '.PNG');

            $constructr->render('media.php',
                array(
                    'MEDIA' => $MEDIA,
                    'IMAGES' => $IMAGES,
                    'MEDIA_COUNTER' => $MEDIA_COUNTER,
                    'USERNAME' => $_SESSION['backend-user-username'],
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Medienverwaltung',
                )
            );
        }
    );

    /**
     * New Uplaod-Form.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/media/new/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $constructr->view->setData('BackendUserRight', 41);

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

            $GUID = create_guid();

            $constructr->render('media-new.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/new/'.$GUID.'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'multipart/form-data',
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Neuer Upload',
                )
            );
        }
    );

    /**
     * New Media Post-Processing View.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $GUID - Constructr CMS CSRF-Guard
     */
    $constructr->post('/constructr/media/new/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $GUID = constructr_sanitization($GUID, true, true);
            $constructr->view->setData('BackendUserRight', 41);

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

            $USER_FORM_GUID = $constructr->request()->post('user_form_guid');

            if ($GUID != $USER_FORM_GUID) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' - USER_FORM_GUID ERROR: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $DATETIME = date('Y-m-d H:i:s');
            $MEDIA_USER = 0;
            $FILEUPLOAD = $_FILES['fileupload']['name'];
            $ORIGINALNAME = constructr_sanitization($FILEUPLOAD);
            $ORIGINALNAME = str_replace(' ', '-', $ORIGINALNAME);
            $ORIGINALNAME = htmlentities($ORIGINALNAME);
            $ORIGINALNAME = str_replace('&Uuml;', 'Ue', $ORIGINALNAME);
            $ORIGINALNAME = str_replace('&Auml;', 'Ae', $ORIGINALNAME);
            $ORIGINALNAME = str_replace('&Ouml;', 'Oe', $ORIGINALNAME);
            $ORIGINALNAME = str_replace('&uuml;', 'ue', $ORIGINALNAME);
            $ORIGINALNAME = str_replace('&auml;', 'ae', $ORIGINALNAME);
            $ORIGINALNAME = str_replace('&ouml;', 'oe', $ORIGINALNAME);
            $ORIGINALNAME = str_replace('&szlig;', 'ss', $ORIGINALNAME);
            $BASE_TITLE = constructr_sanitization($_CONSTRUCTR_CONF['_MEDIA_BASE_TITLE']);
            $BASE_KEYWORDS = constructr_sanitization($_CONSTRUCTR_CONF['_MEDIA_BASE_KEYWORDS']);
            $BASE_DESCRIPTION = constructr_sanitization($_CONSTRUCTR_CONF['_MEDIA_BASE_DESCRIPTION']);
            $BASE_COPYRIGHT = constructr_sanitization($_CONSTRUCTR_CONF['_MEDIA_BASE_COPYRIGHT']);
            $FILE_TYPE = strrchr($FILEUPLOAD, '.');
            $NEW_UPLOAD = 'Uploads/'.$ORIGINALNAME;
            $UPLOAD = copy($_FILES['fileupload']['tmp_name'], $NEW_UPLOAD);
            @chmod($NEW_UPLOAD, 0777);

            if ($FILEUPLOAD == true) {
                try {
                    $QUERY = 'INSERT INTO constructr_media SET media_datetime = :DATETIME,media_file = :MEDIA_FILE,media_originalname = :ORIGINALNAME ,media_title = :BASE_TITLE,media_description = :BASE_DESCRIPTION,media_copyright = :BASE_COPYRIGHT,media_keywords = :BASE_KEYWORDS;';
                    $STMT = $DBCON->prepare($QUERY);
                    $STMT->bindParam(':DATETIME', $DATETIME, PDO::PARAM_STR);
                    $STMT->bindParam(':MEDIA_FILE', $NEW_UPLOAD, PDO::PARAM_STR);
                    $STMT->bindParam(':ORIGINALNAME', $ORIGINALNAME, PDO::PARAM_STR);
                    $STMT->bindParam(':BASE_TITLE', $BASE_TITLE, PDO::PARAM_STR);
                    $STMT->bindParam(':BASE_DESCRIPTION', $BASE_DESCRIPTION, PDO::PARAM_STR);
                    $STMT->bindParam(':BASE_COPYRIGHT', $BASE_COPYRIGHT, PDO::PARAM_STR);
                    $STMT->bindParam(':BASE_KEYWORDS', $BASE_KEYWORDS, PDO::PARAM_STR);
                    $STMT->execute();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=create-media-false');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=create-media-true');
                die();
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=create-media-false');
                die();
            }
        }
    );

    /**
     * Media Trashcan recovery View.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $FILE - Media recovery from trashcan File
     */
    $constructr->get('/constructr/media/re-create/:FILE/', $ADMIN_CHECK, function ($FILE) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $USER_FORM_GUID = $constructr->request()->post('user_form_guid');

            $DATETIME = date('Y-m-d H:i:s');
            $MEDIA_FILE = 'Uploads/'.$FILE;

            try {
                $QUERY = 'INSERT INTO constructr_media SET media_datetime = :DATETIME,media_file = :MEDIA_FILE,media_originalname = :ORIGINALNAME;';
                $STMT = $DBCON->prepare($QUERY);
                $STMT->bindParam(':DATETIME', $DATETIME, PDO::PARAM_STR);
                $STMT->bindParam(':MEDIA_FILE', $MEDIA_FILE, PDO::PARAM_STR);
                $STMT->bindParam(':ORIGINALNAME', $FILE, PDO::PARAM_STR);
                $STMT->execute();
            } catch (PDOException $e) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=returned-to-media-false');
                die();
            }

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=returned-to-media');
            die();
        }
    );

    /**
     * Delete a Upload.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $MEDIA_ID - Constructr CMS upload file id
     */
    $constructr->get('/constructr/media/delete/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $MEDIA_ID = constructr_sanitization($MEDIA_ID, true, true);
            $constructr->view->setData('BackendUserRight', 42);

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

            if ($MEDIA_ID != '') {
                try {
                    $DELETER = $DBCON->prepare('DELETE FROM constructr_media WHERE media_id = :MEDIA_ID LIMIT 1;');
                    $DELETER->execute(
                        array(
                            ':MEDIA_ID' => $MEDIA_ID,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=del-media-false');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=del-media-true');
                die();
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=del-media-false');
                die();
            }
        }
    );

    /**
     * Uploads-Details View.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $MEDIA_ID - Constructr CMS upload media file ID
     */
    $constructr->get('/constructr/media/details/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $MEDIA_ID = constructr_sanitization($MEDIA_ID, true, true);
            $constructr->view->setData('BackendUserRight', 43);

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

            if ($MEDIA_ID != '') {
                try {
                    $DETAILS = $DBCON->prepare('SELECT * FROM constructr_media WHERE media_id = :MEDIA_ID LIMIT 1;');
                    $DETAILS->execute(
                        array(
                            ':MEDIA_ID' => $MEDIA_ID,
                        )
                    );

                    $DETAILS = $DETAILS->fetch();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=del-media-false');
                    die();
                }

                $constructr->render('media-details.php',
                    array(
                        'DETAILS' => $DETAILS,
                        'USERNAME' => $_SESSION['backend-user-username'],
                        'MEDIA_ID' => $MEDIA_ID,
                        'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/details/'.$MEDIA_ID.'/',
                        'FORM_METHOD' => 'post',
                        'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                        '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                        'SUBTITLE' => 'Detailansicht',
                    )
                );
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=details-media-false');
                die();
            }
        }
    );

    /**
     * Post-Processing new Media-Details.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $MEDIA_ID - Constructr CMS upload media file ID
     */
    $constructr->post('/constructr/media/details/:MEDIA_ID/', $ADMIN_CHECK, function ($MEDIA_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $MEDIA_ID = constructr_sanitization($MEDIA_ID, true, true);
            $constructr->view->setData('BackendUserRight', 43);

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

            $MEDIA_TITLE = constructr_sanitization($constructr->request()->post('title'));
            $MEDIA_DESCRIPTION = constructr_sanitization($constructr->request()->post('description'));
            $MEDIA_COPYRIGHT = constructr_sanitization($constructr->request()->post('copyright'));
            $MEDIA_KEYWORDS = constructr_sanitization($constructr->request()->post('keywords'));

            if ($MEDIA_ID != '') {
                try {
                    $QUERY = 'UPDATE constructr_media SET media_title = :MEDIA_TITLE, media_description = :MEDIA_DESCRIPTION, media_copyright = :MEDIA_COPYRIGHT, media_keywords = :MEDIA_KEYWORDS WHERE media_id = :MEDIA_ID LIMIT 1;';
                    $STMT = $DBCON->prepare($QUERY);
                    $STMT->bindParam(':MEDIA_ID', $MEDIA_ID, PDO::PARAM_INT);
                    $STMT->bindParam(':MEDIA_TITLE', $MEDIA_TITLE, PDO::PARAM_STR);
                    $STMT->bindParam(':MEDIA_COPYRIGHT', $MEDIA_COPYRIGHT, PDO::PARAM_STR);
                    $STMT->bindParam(':MEDIA_DESCRIPTION', $MEDIA_DESCRIPTION, PDO::PARAM_STR);
                    $STMT->bindParam(':MEDIA_KEYWORDS', $MEDIA_KEYWORDS, PDO::PARAM_STR);
                    $STMT->execute();

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/details/'.$MEDIA_ID.'/?details=updated');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                }
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/?res=details-media-false');
                die();
            }
        }
    );

    /**
     * Trashcan View.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/media/trash/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $constructr->view->setData('BackendUserRight', 44);

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

            $MEDIA_COUNTER = 0;

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            try {
                $ALL_FILES = scandir('./Uploads');
                $DIR_FILES = array();

                foreach ($ALL_FILES as $DIR_FILE) {
                    try {
                        $CHECKER = $DBCON->prepare('SELECT * FROM constructr_media WHERE media_file = :MEDIA_FILE LIMIT 1;');
                        $CHECKER->execute(
                            array(
                                ':MEDIA_FILE' => 'Uploads/'.$DIR_FILE,
                            )
                        );

                        $COUNTR = $CHECKER->rowCount();

                        if ($COUNTR == 0) {
                            if ($DIR_FILE != '.'  && $DIR_FILE != '..' && $DIR_FILE != 'index.php' && $DIR_FILE != 'robots.txt') {
                                $DIR_FILES[] = 'Uploads/'.$DIR_FILE;
                            }
                        }
                    } catch (PDOException $e) {
                        $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                        die();
                    }
                }

                $DIR_FILES = array_unique($DIR_FILES);
            } catch (PDOException $e) {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/');
                die();
            }

            $IMAGES = array('.jpg', '.jepg', '.JPG', '.JPEG', '.gif', '.GIF', '.png', '.PNG');
            $constructr->render('media-trashcan.php',
                array(
                    'DIR_FILES' => $DIR_FILES,
                    'IMAGES' => $IMAGES,
                    'MEDIA_COUNTER' => $MEDIA_COUNTER,
                    'USERNAME' => $_SESSION['backend-user-username'],
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'M&uuml;lleimer',
                )
            );
        }
    );

    /**
     * Delete a Media-Upload.
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $MEDIA_FILE - Constructr CMS upload media file ID
     */
    $constructr->get('/constructr/media/trash/delete/:MEDIA_FILE/', $ADMIN_CHECK, function ($MEDIA_FILE) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $constructr->view->setData('BackendUserRight', 45);

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

            if ($MEDIA_FILE != '') {
                @unlink('./'.base64_decode($MEDIA_FILE));
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/trash/?res=del-media-true');
                die();
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/trash/?res=del-media-false');
                die();
            }
        }
    );