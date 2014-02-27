<?php

    function retExifData($imagePath)
    {
        if ((isset($imagePath)) and (file_exists($imagePath))) 
        {
          $exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);       
          $exif_exif = read_exif_data($imagePath ,'EXIF' ,0);
          $notFound = "Unavailable";
          if (@array_key_exists('Make', $exif_ifd0)) 
          {
            $camMake = $exif_ifd0['Make'];
          } 
          else 
          { $camMake = $notFound; }
          
          if (@array_key_exists('Model', $exif_ifd0)) 
          {
            $camModel = $exif_ifd0['Model'];
          }
          else
          {
              $camModel = $notFound; 
          }
          
          if (@array_key_exists('ExposureTime', $exif_ifd0)) {
            $camExposure = $exif_ifd0['ExposureTime'];
          } else { $camExposure = $notFound; }
          
          if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
            $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
          } else { $camAperture = $notFound; }
          
          if (@array_key_exists('DateTime', $exif_ifd0)) {
            $camDate = $exif_ifd0['DateTime'];
          } else { $camDate = $notFound; }
          
          if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
            $camIso = $exif_exif['ISOSpeedRatings'];
          } else { $camIso = $notFound; }
          
          $return = array();
          $return['camera'] = $camMake;
          $return['model'] = $camModel;
          $return['exposure'] = $camExposure;
          $return['aperture'] = $camAperture;
          $return['date'] = $camDate;
          $return['iso'] = $camIso;
          return $return;
        } else {
          return false; 
        } 
    }

    function create_guid() {static $guid = '';$uid = uniqid("", true);$data = $_SERVER['REQUEST_TIME'];$data .= $_SERVER['HTTP_USER_AGENT'];$data .= $_SERVER['PHP_SELF'];$data .= $_SERVER['SCRIPT_NAME'];$data .= $_SERVER['REMOTE_ADDR'];$data .= $_SERVER['REMOTE_PORT'];$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));$guid = substr($hash,0,2) . substr($hash,2,2) . substr($hash,4,2) . substr($hash,8,2);return $guid;}

    $app -> notFound(function () use ($app) 
        {
            $app -> getLog() -> error('404 - Not found: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $app -> redirect(_BASE_URL);
        }
    );

    $app -> error(function (\Exception $e) use ($app) 
        {
            $app -> getLog() -> error('Exception: ' . $e . ' / ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $app -> redirect(_BASE_URL);
        }
    );

    /*
     * 
     * Zentrale Überprüfungen der Benutzerkonten Start
     * 
     * */
    $ADMIN_CHECK = function() use ($app,$DBCON)
    {
        if(!isset($_SESSION['backend-user-username']) || !isset($_SESSION['backend-user-password']) || $_SESSION['backend-user-username'] == '' || $_SESSION['backend-user-password'] == '')
        {
            if(_LOGGING == true)
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 0: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }
            $app -> redirect(_BASE_URL . '/admin/login/');
            die();
        }
        else
        {
            try
            {
                $QUERY = $DBCON -> prepare('SELECT * FROM backenduser WHERE beu_username = :USERNAME AND beu_active = :ACTIVE LIMIT 1;');
                $QUERY -> execute( 
                    array(
                        'USERNAME' => $_SESSION['backend-user-username'],
                        'ACTIVE' => 1,
                        ) 
                );
                $COUNTR = $QUERY -> rowCount();
                if($COUNTR != 1)
                {
                    $app -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 1: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $app -> redirect(_BASE_URL . '/admin/login/');
                    die();
                }
            }
            catch (PDOException $e)
            {
                $app -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 2: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $app -> redirect(_BASE_URL . '/admin/login/');
                die();
            }
        }
    };
    /*
     * 
     * Zentrale Überprüfungen der Benutzerkonten Ende
     * 
     * */