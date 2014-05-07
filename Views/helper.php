<?php

    function get_xmp_array( &$xmp_raw )
    {
        $xmp_arr = array();
        foreach (array(
                'Title' => '<dc:title>\s*<rdf:Alt>\s*(.*?)\s*<\/rdf:Alt>\s*<\/dc:title>',
                'Description' => '<dc:description>\s*<rdf:Alt>\s*(.*?)\s*<\/rdf:Alt>\s*<\/dc:description>',
                'Keywords' => '<dc:subject>\s*<rdf:Bag>\s*(.*?)\s*<\/rdf:Bag>\s*<\/dc:subject>',
                'Hierarchical Keywords' => '<lr:hierarchicalSubject>\s*<rdf:Bag>\s*(.*?)\s*<\/rdf:Bag>\s*<\/lr:hierarchicalSubject>'
        ) as $key => $regex )
        {
            $xmp_arr[$key] = preg_match( "/$regex/is", $xmp_raw, $match ) ? $match[1] : '';
            $xmp_arr[$key] = preg_match_all( "/<rdf:li[^>]*>([^>]*)<\/rdf:li>/is", $xmp_arr[$key], $match ) ? $match[1] : $xmp_arr[$key];
            if(!empty($xmp_arr[$key]) && $key == 'Hierarchical Keywords')
            {
                foreach($xmp_arr[$key] as $li => $val ) $xmp_arr[$key][$li] = explode( '|', $val );
                unset($li,$val);
            }
        }
        return $xmp_arr;
    }

    function getXmpData($filename)
    {
        $buffer = NULL;
        $file_pointer = fopen($filename, 'r');
        $chunk = fread($file_pointer,50000);
        if (($posStart = strpos($chunk, '<x:xmpmeta')) !== FALSE) {
            $buffer = substr($chunk, $posStart);
            $posEnd = strpos($buffer, '</x:xmpmeta>');
            $buffer = substr($buffer, 0, $posEnd + 12);
        }
        fclose($file_pointer);
        return $buffer;
    }

    function retExifData($imagePath)
    {
        if ((isset($imagePath)) and (file_exists($imagePath))) 
        {
          $exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);
          $exif_exif = read_exif_data($imagePath ,'EXIF' ,0);

          $notFound = "./";

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

          if (@array_key_exists('Keywords', $exif_ifd0)) 
          {
            $Keywords2 = $exif_ifd0['Keywords'];
          }
          else
          {
              $Keywords2 = $notFound; 
          }

          if (@array_key_exists('ExposureTime', $exif_ifd0)) 
          {
            $camExposure = $exif_ifd0['ExposureTime'];
          }
          else
          {
              $camExposure = $notFound;
          }
          
          if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) 
          {
            $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
          } 
          else 
          {
              $camAperture = $notFound; 
          }

          if (@array_key_exists('DateTime', $exif_ifd0)) 
          {
            $camDate = $exif_ifd0['DateTime'];
          } 
          else 
          {
              $camDate = $notFound; 
          }
          
          if (@array_key_exists('ISOSpeedRatings',$exif_exif)) 
          {
                $camIso = $exif_exif['ISOSpeedRatings'];
          } 
          else 
          {
               $camIso = $notFound; 
          }

          if (@array_key_exists('Keywords',$exif_exif)) 
          {
                $Keywords1 = $exif_exif['Keywords'];
          } 
          else 
          {
               $Keywords1 = $notFound; 
          }

          $return = array();
          $return['camera'] = $camMake;
          $return['model'] = $camModel;
          $return['exposure'] = $camExposure;
          $return['aperture'] = $camAperture;
          $return['date'] = $camDate;
          $return['iso'] = $camIso;
          $return['keywords1'] = $Keywords1;
          $return['keywords2'] = $Keywords2;
          return $return;
        }
        else
        {
          return false; 
        } 
    }

    function create_guid() {static $guid = '';$uid = uniqid("", true);$data = $_SERVER['REQUEST_TIME'];$data .= $_SERVER['HTTP_USER_AGENT'];$data .= $_SERVER['PHP_SELF'];$data .= $_SERVER['SCRIPT_NAME'];$data .= $_SERVER['REMOTE_ADDR'];$data .= $_SERVER['REMOTE_PORT'];$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));$guid = substr($hash,0,2) . substr($hash,2,2) . substr($hash,4,2) . substr($hash,8,2);return $guid;}

    $constructr -> notFound(function () use ($constructr) 
        {
            $constructr -> getLog() -> error('404 - Not found: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect(_BASE_URL);
        }
    );

    $constructr -> error(function (\Exception $e) use ($constructr) 
        {
            $constructr -> getLog() -> error('Exception: ' . $e . ' / ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $constructr -> redirect(_BASE_URL);
        }
    );

    /*
     * 
     * Zentrale Überprüfungen der Benutzerkonten Start
     * 
     * */
    $ADMIN_CHECK = function() use ($constructr,$DBCON)
    {
        if(!isset($_SESSION['backend-user-username']) || !isset($_SESSION['backend-user-password']) || $_SESSION['backend-user-username'] == '' || $_SESSION['backend-user-password'] == '')
        {
            if(_LOGGING == true)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 0: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }

            $constructr -> redirect(_BASE_URL . '/constructr/login/');
            die();
        }
        else
        {
            try
            {
                $QUERY = $DBCON -> prepare('SELECT * FROM constructr_backenduser WHERE beu_username = :USERNAME AND beu_active = :ACTIVE LIMIT 1;');
                $QUERY -> execute( 
                    array
                    (
                        'USERNAME' => $_SESSION['backend-user-username'],
                        'ACTIVE' => 1
                    ) 
                );
                $COUNTR = $QUERY -> rowCount();
                
                if($COUNTR != 1)
                {
                    $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 1: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $constructr -> redirect(_BASE_URL . '/constructr/login/');
                    die();
                }
            }
            catch (PDOException $e)
            {
                $constructr -> getLog() -> error($_SESSION['backend-user-username'] . ': HelperAdminCheckError 2: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $constructr -> redirect(_BASE_URL . '/constructr/login/');
                die();
            }
        }
    };
    /*
     * 
     * Zentrale Überprüfungen der Benutzerkonten Ende
     * 
     * */