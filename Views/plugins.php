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
     * Main PluginView.
     *
     * @param $ADMIN_CHECK - Constructr CMS Admin chekker function
     * @param $constructr - Constructr CMS application
     * @param $DB_CON - main database connection via PDO
     * @param $_CONSTRUCTR_CONF - main Constructr CMS configuration array
     */
    $constructr->get('/constructr/plugins/', $ADMIN_CHECK, function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
            $constructr->view->setData('BackendUserRight', 90);

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

            $PLUGINS = scandir('./Plugins');
            $PLUGIN_FILES = array();

            foreach ($PLUGINS as $PLUGIN_FILE) {
                if ($PLUGIN_FILE != '.'  && $PLUGIN_FILE != '..') {
                    $INFO_CONTENT = file_get_contents('./Plugins/'.$PLUGIN_FILE.'/'.$PLUGIN_FILE.'.json');
                    $INFO_CONTENT = utf8_encode($INFO_CONTENT);
                    $INFO_CONTENT = json_decode($INFO_CONTENT, true);

                    $PLUGIN_FILES[$PLUGIN_FILE] = array(
                        'name' => $PLUGIN_FILE,
                        'info' => $INFO_CONTENT,
                    );
                }
            }

            $PLUGIN_FILES = array_unique($PLUGIN_FILES);
            $PLUGINS_COUNTR = count($PLUGIN_FILES);

            $constructr->render('plugins.php',
                array(
                    'USERNAME' => $_SESSION['backend-user-username'],
                    '_CONSTRUCTR_CONF' => $_CONSTRUCTR_CONF,
                    'SUBTITLE' => 'Plugins',
                    'PLUGINS_COUNTR' => $PLUGINS_COUNTR,
                    'PLUGIN_FILES' => $PLUGIN_FILES,
                )
            );
        }
    );