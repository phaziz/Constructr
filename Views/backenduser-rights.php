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
      * Main View to edit the User-Rights of a specific User.
      *
      * @param $ADMIN_CHECK - User Rights Function
      * @param $constructr - Constructr CMS application
      * @param $DB_CON - main database connection via PDO
      * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
      * @param $USER_ID - Constructr CMS Backend User ID
      * @param $USER_NAME - Constructr CMS Backend User Name
      */
     $constructr->get('/constructr/user/edit-user-rights/:user_id/:user_name/', $ADMIN_CHECK, function ($USER_ID, $USER_NAME) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $USER_NAME = constructr_sanitization($USER_NAME, true, true);
            $USER_ID = constructr_sanitization($USER_ID, true, true);

            $constructr->view->setData('BackendUserRight', 80);

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
                $RIGHTS = $DBCON->prepare('SELECT * FROM constructr_backenduser_rights WHERE cbr_user_id = :USER_ID ORDER BY cbr_right ASC;');
                $RIGHTS->execute(
                    array(
                        ':USER_ID' => $USER_ID,
                    )
                );
            } catch (PDOException $e) {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                die();
            }

            $constructr->render('user-rights.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'USER_NAME' => $USER_NAME,
                    'USER_ID' => (int) $USER_ID,
                    'RIGHTS' => $RIGHTS,
                    'COUNTR' => (int) $RIGHTS_COUNTR,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Benutzerrechte von '.$USER_NAME,
                )
            );
        }
    );

    /**
     * Updateing the Rights of a specific User.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $USER_ID - Constructr CMS Backend User ID
     * @param $USER_NAME - Constructr CMS Backend User Name
     * @param $NEW_VALUE - Constructr CMS User Right 1 = true / 0 = false
     * @param $RIGHT_ID - Constructr CMS Backend User Right ID
     */
    $constructr->get('/constructr/user/set-user-right/:new_value/:right_id/:user_id/:user_name/', $ADMIN_CHECK, function ($NEW_VALUE, $RIGHT_ID, $USER_ID, $USER_NAME) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $NEW_VALUE = constructr_sanitization($NEW_VALUE, true, true);
            $RIGHT_ID = constructr_sanitization($RIGHT_ID, true, true);
            $USER_ID = constructr_sanitization($USER_ID, true, true);
            $USER_NAME = constructr_sanitization($USER_NAME, true, true);

            $constructr->view->setData('BackendUserRight', 81);

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

            if ($RIGHT_ID != '' && $NEW_VALUE != '') {
                try {
                    $RIGHTS = $DBCON->prepare('UPDATE constructr_backenduser_rights SET cbr_value = :NEW_VALUE WHERE cbr_id = :RIGHT_ID LIMIT 1;');
                    $RIGHTS->execute(
                        array(
                            ':NEW_VALUE' => $NEW_VALUE,
                            ':RIGHT_ID' => $RIGHT_ID,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/edit-user-rights/'.$USER_ID.'/'.$USER_NAME.'/?edited=false');
                    die();
                }
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/edit-user-rights/'.$USER_ID.'/'.$USER_NAME.'/?edited=false');
                die();
            }
            $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/edit-user-rights/'.$USER_ID.'/'.$USER_NAME.'/?edited=true');
        }
    );