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
	 * Constructr CMS Backend Logout. 
	 */
    $constructr -> get('/constructr/logout/', function () use ($constructr,$_CONSTRUCTR_CONF)
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> debug('Successful logout ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            $_SESSION['constructr_login_attempt'] = '';
            $_SESSION['constructr_login_blocked'] = '';
            $_SESSION['backend-user-username'] = '';
            $_SESSION['backend-user-password'] = '';
            $_SESSION['backend-user-id'] = '';
            $_SESSION = array();

            if (ini_get("session.use_cookies"))
            {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }

            session_destroy();
            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login');
            die();
        }
    );