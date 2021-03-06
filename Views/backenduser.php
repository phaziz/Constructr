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
     * Administrator View of your Backend User-Accounts.
     *
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/user/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $COUNTR = 0;

            $constructr->view->setData('BackendUserRight', 66);

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
                $BACKENDUSER = $DBCON->query('SELECT * FROM constructr_backenduser ORDER BY beu_id');
                $COUNTR = $BACKENDUSER->rowCount();
            } catch (PDOException $e) {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                die();
            }

            $constructr->render('user.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'BACKENDUSER' => $BACKENDUSER,
                    'COUNTR' => $COUNTR,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Benutzerverwaltung',
                )
            );
        }
    );

    /**
     * Form-View to create a new User-Account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/user/new/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $constructr->view->setData('BackendUserRight', 67);

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

            $constructr->render('user-new.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    'GUID' => $GUID,
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Neuer Benutzer',
                    'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/new/'.$GUID.'/',
                    'FORM_METHOD' => 'post',
                    'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                )
            );
        }
    );

    /**
     * Hidden view to check if the username is unique
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/user/new/check-username/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $constructr->view->setData('BackendUserRight', 67);

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

            $USERNAME = constructr_sanitization($constructr->request()->get('username'));

            if ($USERNAME != '') {
                try {
                    $BACKENDUSER = $DBCON->prepare('SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME LIMIT 1;');
                    $BACKENDUSER->execute(
                        array(
                            ':USERNAME' => $USERNAME,
                        )
                    );

                    $COUNTR = $BACKENDUSER->rowCount();

                    if ($COUNTR == 0) {
                        if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                            $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/TRUE/');
                        }

                        echo 'jep';
                        die();
                    } else {
                        if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                            $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/FALSE/');
                        }

                        echo 'nep';
                        die();
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    echo 'nep';
                    die();
                }
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/FALSE/');
                }

                echo 'nep';
                die();
            }
        }
    );

    /**
     * Hidden Edit-View to check if the username is unique.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/user/edit/:user_id/check-single-username/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $constructr->view->setData('BackendUserRight', 68);

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

            $USERNAME = constructr_sanitization($constructr->request()->get('username'));

            if ($USERNAME != '') {
                try {
                    $BACKENDUSER = $DBCON->prepare('SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME LIMIT 1;');
                    $BACKENDUSER->execute(
                        array(
                            ':USERNAME' => $USERNAME,
                        )
                    );

                    $COUNTR = $BACKENDUSER->rowCount();

                    if ($COUNTR == 1 || $COUNTR == 0) {
                        if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                            $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/TRUE/');
                        }

                        echo 'jep';
                        die();
                    } else {
                        if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                            $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/FALSE/');
                        }

                        echo 'nep';
                        die();
                    }
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    echo 'nep';
                    die();
                }
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/FALSE/');
                }

                echo 'nep';
                die();
            }
        }
    );

    /**
     * Post View to create a new Backend User-Account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $_CONSTRUCTR_USER_RIGHTS_CONF - main Constructr CMS user rights configuration array
     * @param $GUID - Constructr CMS CSRF-Guard
     */
    $constructr->post('/constructr/user/new/:GUID/', $ADMIN_CHECK, function ($GUID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF, $_CONSTRUCTR_USER_RIGHTS_CONF) {
            $GUID = constructr_sanitization($GUID, true, true);

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $constructr->view->setData('BackendUserRight', 67);

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

            $USER_FORM_GUID = constructr_sanitization($constructr->request()->post('user_form_guid'), true, true);

            if ($GUID != $USER_FORM_GUID) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' - USER_FORM_GUID ERROR: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $USERNAME = trim($constructr->request()->post('username'));
            $FACTOR = '';
            $PASSWORD = crypt(trim($constructr->request()->post('password')), $_CONSTRUCTR_CONF['_SALT']);
            $PASSWORD_RT = crypt(trim($constructr->request()->post('password_retype')), $_CONSTRUCTR_CONF['_SALT']);
            $EMAIL = filter_var(constructr_sanitization(trim($constructr->request()->post('email')), FILTER_VALIDATE_EMAIL));
            $ART = 0;
            $ACTIVE = 1;

            if ($PASSWORD != $PASSWORD_RT) {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?create=error');
                die();
            }

            if ($USERNAME != '' && $PASSWORD != '' && $EMAIL != '') {
                try {
                    $QUERY = $DBCON->prepare('INSERT INTO constructr_backenduser SET beu_username = :USERNAME,beu_password = :PASSWORD,beu_factor = :FACTOR,beu_email = :EMAIL,beu_art = :ART,beu_last_login  = :LAST_LOGIN,beu_active = :ACTIVE;');
                    $QUERY->execute(
                        array(
                            ':USERNAME' => $USERNAME,
                            ':PASSWORD' => $PASSWORD,
                            ':FACTOR' => $FACTOR,
                            ':EMAIL' => $EMAIL,
                            ':ART' => $ART,
                            ':LAST_LOGIN' => '0000-00-00 00:00:00',
                            ':ACTIVE' => $ACTIVE,
                        )
                    );

                    $LAST_USER_INSERT_ID = $DBCON->lastInsertId();

                    $QUERY = 'INSERT INTO constructr_backenduser_rights (cbr_right,cbr_value,cbr_user_id,cbr_info) VALUES ';

                    if ($_CONSTRUCTR_USER_RIGHTS_CONF) {
                        foreach ($_CONSTRUCTR_USER_RIGHTS_CONF as $KEY => $WHAT) {
                            $QUERY .= '('.$KEY.',1, '.$LAST_USER_INSERT_ID.',"'.$WHAT.'"),';
                        }
                    }

                    $QUERY .= ';';
                    $QUERY = str_replace(',;', ';', $QUERY);

                    $RIGHTS = $DBCON->prepare($QUERY);
                    $RIGHTS->execute(
                        array(
                            ':USER_ID' => $LAST_USER_INSERT_ID,
                        )
                    );
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?create=error');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/create/success/');
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?create=success');
                die();
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$USERNAME.'/create/error/');
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?create=error');
                die();
            }
        }
    );

    /**
     * Form-View to edit a Backend User Account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $USER_ID - Constructr CMS Backend UserID
     */
    $constructr->get('/constructr/user/edit/:USER_ID/', $ADMIN_CHECK, function ($USER_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $USER_ID = constructr_sanitization($USER_ID, true, true);

            $constructr->view->setData('BackendUserRight', 68);

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
                $BACKENDUSER = $DBCON->prepare('SELECT * FROM constructr_backenduser WHERE beu_id = :USER_ID LIMIT 1;');
                $BACKENDUSER->execute(
                    array(
                        ':USER_ID' => $USER_ID,
                    )
                );

                $COUNTR = $BACKENDUSER->rowCount();
                $BACKENDUSER = $BACKENDUSER->fetch();

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }
            } catch (PDOException $e) {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                die();
            }

            $GUID = create_guid();

            if ($COUNTR == 1) {
                $constructr->render('user-edit.php',
                    array(
                        'USERNAME' => $_SESSION['backend-user-username'],
                        'BACKENDUSER' => $BACKENDUSER,
                        'GUID' => $GUID,
                        '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                        'SUBTITLE' => 'Benutzer bearbeiten',
                        'FORM_ACTION' => $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/edit/'.$USER_ID.'/'.$GUID.'/',
                        'FORM_METHOD' => 'post',
                        'FORM_ENCTYPE' => 'application/x-www-form-urlencoded',
                    )
                );
            } else {
                $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                die();
            }
        }
    );

    /**
     * Post-View to edit a Backend User Account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $GUID - Constructr CMS CSRF-Guard
     * @param $USER_ID - Constructr CMS Backend UserID
     */
    $constructr->post('/constructr/user/edit/:USER_ID/:GUID/', $ADMIN_CHECK, function ($USER_ID, $GUID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $GUID = constructr_sanitization($GUID, true, true);
            $USER_ID = constructr_sanitization($USER_ID, true, true);

            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }

            $constructr->view->setData('BackendUserRight', 68);

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

            $USER_FORM_GUID = constructr_sanitization($constructr->request()->post('user_form_guid'), true, true);

            if ($GUID != $USER_FORM_GUID) {
                $constructr->getLog()->debug($_SESSION['backend-user-username'].' - USER_FORM_GUID ERROR: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/logout/');
                die();
            }

            $USERNAME = constructr_sanitization(trim($constructr->request()->post('username')));
            $PASSWORD = crypt(constructr_sanitization(trim($constructr->request()->post('password'))), $_CONSTRUCTR_CONF['_SALT']);
            $PASSWORD_RT = crypt(constructr_sanitization(trim($constructr->request()->post('password_retype'))), $_CONSTRUCTR_CONF['_SALT']);
            $EMAIL = filter_var(constructr_sanitization(trim($constructr->request()->post('email')), FILTER_VALIDATE_EMAIL));
            $ART = 0;
            $ACTIVE = 1;

            if ($PASSWORD != $PASSWORD_RT) {
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
            }

            if ($USERNAME != '' && $PASSWORD != '' && $EMAIL != '') {
                try {
                    $QUERY = 'UPDATE constructr_backenduser SET beu_username = :USERNAME,beu_password = :PASSWORD,beu_email = :EMAIL,beu_art = :ART,beu_active = :ACTIVE WHERE beu_id = :USER_ID LIMIT 1;';
                    $STMT = $DBCON->prepare($QUERY);
                    $STMT->bindParam(':USERNAME', $USERNAME, PDO::PARAM_STR);
                    $STMT->bindParam(':PASSWORD', $PASSWORD, PDO::PARAM_STR);
                    $STMT->bindParam(':EMAIL', $EMAIL, PDO::PARAM_STR);
                    $STMT->bindParam(':ART', $ART, PDO::PARAM_INT);
                    $STMT->bindParam(':ACTIVE', $ACTIVE, PDO::PARAM_INT);
                    $STMT->bindParam(':USER_ID', $USER_ID, PDO::PARAM_INT);
                    $STMT->execute();
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                    die();
                }

                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/create/success/');
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=success');
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$USERNAME.'/create/error/');
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                die();
            }
        }
    );

    /**
     * Hidden View to deactivate a user account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $USER_ID - Constructr CMS Backend UserID
     */
    $constructr->get('/constructr/user/set-inactive/:USER_ID/', function ($USER_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $USER_ID = constructr_sanitization($USER_ID, true, true);
            $constructr->view->setData('BackendUserRight', 69);

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

            if ($USER_ID != '') {
                try {
                    $QUERY = $DBCON->prepare('UPDATE constructr_backenduser SET beu_active = :INACTIVE WHERE beu_id = :USER_ID LIMIT 1;');
                    $QUERY->execute(
                        array(
                            'INACTIVE' => 0,
                            'USER_ID' => $USER_ID,
                        )
                    );

                    if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                        $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=success');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                    die();
                }
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.'Error: No User_id (set-inactive): '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                die();
            }
        }
    );

    /**
     * Hidden View to activate a Backend User-Account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $USER_ID - Constructr CMS Backend UserID
     */
    $constructr->get('/constructr/user/set-active/:USER_ID/', function ($USER_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $USER_ID = constructr_sanitization($USER_ID, true, true);
            $constructr->view->setData('BackendUserRight', 69);

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

            if ($USER_ID != '' && $USER_ID != false) {
                try {
                    $QUERY = $DBCON->prepare('UPDATE constructr_backenduser SET beu_active = :INACTIVE WHERE beu_id = :USER_ID LIMIT 1;');
                    $QUERY->execute(
                        array(
                            'INACTIVE' => 1,
                            'USER_ID' => $USER_ID,
                        )
                    );

                    if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                        $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=success');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                    die();
                }
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.'Error: No User_id (set-inactive): '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?edit=error');
                die();
            }
        }
    );

    /**
     * Backend View to delete a User-Account.
     * @param $ADMIN_CHECK - User Rights Function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     * @param $USER_ID - Constructr CMS Backend UserID
     */
    $constructr->get('/constructr/user/delete/:USER_ID/', function ($USER_ID) use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $USER_ID = constructr_sanitization($USER_ID, true, true);
            $constructr->view->setData('BackendUserRight', 60);

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

            if ($USER_ID != '' && $USER_ID != false) {
                try {
                    $QUERY = 'DELETE FROM constructr_backenduser WHERE beu_id = :USER_ID LIMIT 1; DELETE FROM constructr_backenduser_rights WHERE cbr_user_id = :USER_ID;';
                    $STMT = $DBCON->prepare($QUERY);
                    $STMT->bindParam(':USER_ID', $USER_ID, PDO::PARAM_INT);
                    $STMT->execute();

                    if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                        $constructr->getLog()->debug($_SESSION['backend-user-username'].' '.$_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    }

                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?delete=success');
                    die();
                } catch (PDOException $e) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].': '.$e->getMessage());
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?delete=error');
                    die();
                }
            } else {
                if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' '.'Error: No User_id (set-inactive): '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }

                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/?delete=error');
                die();
            }
        }
    );