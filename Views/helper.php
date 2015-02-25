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
     * Function to create a CSRF Token.
     *
     * @return int $TOKEN
     */
    function create_guid()
    {
        return mt_rand();
    }

    /**
     * Function to escape MYSQL variables.
     *
     * @param mixed $Input
     *
     * @return mixed cleaned $INPUT
     */
    function mysql_escape_mimic($INPUT)
    {
        if (!empty($INPUT) && is_string($INPUT)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $INPUT);
        }

        return $INPUT;
    }

    /**
     * Function to sanitize Variables.
     *
     * @param mixed $Var    - the variable to clean
     * @param bool  $TRIM   - should the variable be trimmed
     * @param bool  $STRICT - should it be strict or lazy
     *
     * @return mixed cleaned $INPUT
     */
    function constructr_sanitization($VAR, $TRIM = true, $STRICT = false)
    {
        if ($TRIM == true) {
            $VAR = trim($VAR);
        }
        if ($STRICT == true) {
            $VAR = mysql_escape_mimic(strip_tags($VAR));
        }

        return $VAR;
    }

    /**
     * Function to compare Array values.
     *
     * @param mixed $a - variable $a to compare with $b
     * @param mixed $b - variable $b to compare with $a
     *
     * @return bool
     */
    function cmpUp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }

        return ($a < $b) ? -1 : 1;
    }

    /**
     * Function to compare Array values.
     *
     * @param mixed $a - variable $a to compare with $b
     * @param mixed $b - variable $b to compare with $a
     *
     * @return bool
     */
    function cmpDown($a, $b)
    {
        if ($a == $b) {
            return 0;
        }

        return ($a > $b) ? -1 : 1;
    }

    /**
     * Function to retrieve all Files from a start directory.
     *
     * @param string $dir - start directory
     *
     * @return array $FILESTRUCTURE
     */
    function getFilesFromDir($dir)
    {
        $files = array();
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_dir($dir.'/'.$file)) {
                        $dir2 = $dir.'/'.$file;
                        $files[] = getFilesFromDir($dir2);
                    } else {
                        $files[] = $dir.'/'.$file;
                    }
                }
            }
            closedir($handle);
        }

        return flatten_array($files);
    }

    /**
     * Function to flatten a multidimensional array.
     *
     * @param array $array - a multideimensional array
     *
     * @return array $flat_array - the flattened array structure
     */
    function flatten_array($array)
    {
        $flat_array = array();
        $size = sizeof($array);
        $keys = array_keys($array);

        for ($x = 0; $x < $size; $x++) {
            $element = $array[$keys[$x]]; if (is_array($element)) {
    			$results = flatten_array($element);
				$sr = sizeof($results);
    			$sk = array_keys($results);

    			for ($y = 0; $y < $sr; $y++) {
        			$flat_array[$sk[$y]] = $results[$sk[$y]];
    			}

			} else {
    			$flat_array[$keys[$x]] = $element;
			}
        }

        return $flat_array;
    }

    /**
     * Function order an array by (deep) value.
     *
     * @param
     *
     * @return array $array - the reordered array entries
     */
    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);

        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);

        return array_pop($args);
    }

    /**
     * Main not found Route ...
     */
    $constructr->notFound(function () use ($constructr, $_CONSTRUCTR_CONF) {
            $constructr->getLog()->error('404 - Not found: '.$_SERVER['HTTP_REFERER'].' :: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL']);
            die();
        }
    );

    /**
     * Main Error-Route...
     */
    $constructr->error(function (\Exception $e) use ($constructr) {
            $constructr->getLog()->error('Exception: '.$e.' / '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL']);
            die();
        }
    );

    /**
     * Central Admin-Check Funktion...
     * @param object $constructr - $CONSTRUCTR_CMS instance
     * @param object $DBCON - global PDO instance
     * @param array $_CONSTRUCTR_CONF - Constructr CMS global configuration array
     * @return bool true | false
     */
    $ADMIN_CHECK = function () use ($constructr, $DBCON, $_CONSTRUCTR_CONF) {
        if (!isset($_SESSION['backend-user-username']) || !isset($_SESSION['backend-user-password']) || $_SESSION['backend-user-username'] == '' || $_SESSION['backend-user-password'] == '') {
            if ($_CONSTRUCTR_CONF['_LOGGING'] == true) {
                if (!isset($_SESSION['backend-user-username'])) {
                    $_SESSION['backend-user-username'] = 'unknown';
                }
                $constructr->getLog()->error($_SESSION['backend-user-username'].' - AdminCheckError');
            }

            $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/login/');
            die();
        } else {
            try {
                $ACTIVE = 1;
                $QUERY = 'SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_active = :ACTIVE LIMIT 1;';
                $STMT = $DBCON->prepare($QUERY);
                $STMT->bindParam(':USERNAME', $_SESSION['backend-user-username'], PDO::PARAM_STR);
                $STMT->bindParam(':ACTIVE', $ACTIVE, PDO::PARAM_INT);
                $STMT->execute();
                $COUNTR = $STMT->rowCount();

                if ($COUNTR != 1) {
                    if (!isset($_SESSION['backend-user-username'])) {
                        $_SESSION['backend-user-username'] = 'unknown';
                    }
                    $constructr->getLog()->error($_SESSION['backend-user-username'].' - AdminCheckError: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/login/');
                    die();
                }
            } catch (PDOException $e) {
                if (!isset($_SESSION['backend-user-username'])) {
                    $_SESSION['backend-user-username'] = 'unknown';
                }
                $constructr->getLog()->error($_SESSION['backend-user-username'].' - AdminCheckError: '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $constructr->redirect($_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/login/');
                die();
            }
        }
    };