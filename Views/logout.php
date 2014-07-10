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