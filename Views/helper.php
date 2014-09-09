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

    function create_guid() {static $guid = '';$uid = uniqid("", true);$data = $_SERVER['REQUEST_TIME'];$data .= $_SERVER['HTTP_USER_AGENT'];$data .= $_SERVER['PHP_SELF'];$data .= $_SERVER['SCRIPT_NAME'];$data .= $_SERVER['REMOTE_ADDR'];$data .= $_SERVER['REMOTE_PORT'];$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));$guid = substr($hash,0,2) . substr($hash,2,2) . substr($hash,4,2) . substr($hash,8,2);return $guid;}
    function mysql_escape_mimic($INPUT){if(!empty($INPUT) && is_string($INPUT)){return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),$INPUT);}return $INPUT;}
    function constructr_sanitization($VAR,$TRIM=true,$STRICT=false){if($TRIM == true){$VAR = trim($VAR);}if($STRICT == true){$VAR = mysql_escape_mimic(strip_tags($VAR));}return $VAR;}
    function cmpUp($a,$b){if ($a == $b){return 0;}return ($a < $b) ? -1 : 1;}
    function cmpDown($a,$b){if ($a == $b){return 0;}return ($a > $b) ? -1 : 1;}
    function getFilesFromDir($dir){$files = array();if ($handle = opendir($dir)){while (false !== ($file = readdir($handle))){if ($file != "." && $file != ".."){if(is_dir($dir.'/'.$file)){$dir2 = $dir.'/'.$file;$files[] = getFilesFromDir($dir2);} else {$files[] = $dir.'/'.$file;}}}closedir($handle);}return flatten_array($files);}
    function flatten_array($array){$flat_array=array();$size=sizeof($array);$keys=array_keys($array);for($x = 0; $x < $size; $x++){$element = $array[$keys[$x]];if(is_array($element)) {$results = flatten_array($element);$sr = sizeof($results);$sk=array_keys($results);for($y = 0; $y < $sr; $y++) {$flat_array[$sk[$y]] = $results[$sk[$y]];}} else {$flat_array[$keys[$x]] = $element;}}return $flat_array;}

    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);

        foreach ($args as $n => $field)
        {
            if (is_string($field))
            {
                $tmp = array();
                foreach ($data as $key => $row)
                   $tmp[$key] = $row[$field];
                   $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    $constructr -> notFound(function () use ($constructr,$_CONSTRUCTR_CONF) 
        {
            $constructr -> getLog() -> error('404 - Not found: ' . $_SERVER['HTTP_REFERER'] . ' :: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL']);
            die();
        }
    );

    $constructr -> error(function (\Exception $e) use ($constructr) 
        {
            $constructr -> getLog() -> error('Exception: ' . $e . ' / ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL']);
            die();
        }
    );

    $ADMIN_CHECK = function() use ($constructr,$DBCON,$_CONSTRUCTR_CONF)
    {
        if(!isset($_SESSION['backend-user-username']) || !isset($_SESSION['backend-user-password']) || $_SESSION['backend-user-username'] == '' || $_SESSION['backend-user-password'] == '')
        {
            if($_CONSTRUCTR_CONF['_LOGGING'] == true)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ' - AdminCheckError');
            }

            $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
            die();
        }
        else
        {
            try
            {
                $ACTIVE = 1;
                $QUERY = 'SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_active = :ACTIVE LIMIT 1;';
                $STMT = $DBCON -> prepare($QUERY);
                $STMT -> bindParam(':USERNAME',$_SESSION['backend-user-username'],PDO::PARAM_STR);
                $STMT -> bindParam(':ACTIVE',$ACTIVE,PDO::PARAM_INT);
                $STMT -> execute();
                $COUNTR = $STMT -> rowCount();

                if($COUNTR != 1)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ' - AdminCheckError: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                    die();
                }
            }
            catch(PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ' - AdminCheckError: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect($_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/login/');
                die();
            }
        }
    };