<?php

    /*
     * LOGOUT START
     * */
    $constructr -> get('/constructr/logout(/)', function () use ($constructr)
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> debug('Successful logout ' . $_SESSION['backend-user-username'] . ': ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            $_SESSION['backend-user-username'] = '';
            $_SESSION['backend-user-password'] = '';
            $_SESSION = array();

            if (ini_get("session.use_cookies"))
            {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }

            session_destroy();
            $constructr -> redirect(_BASE_URL . '/constructr/login');
            die();
        }
    );
    /*
     * LOGOUT ENDE
     * */