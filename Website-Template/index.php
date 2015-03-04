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
 * @version 1.04.5 / 04.03.2015
 */

    if($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] && $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != ''){
        $_BASE_ROUTE = $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'];
    } else {
        if($_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] == ''){
            $_BASE_ROUTE = $_CONSTRUCTR_CONF['_BASE_URL'];
        } else {
            $_BASE_ROUTE = $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'];
        }
    }

?>
<!DOCTYPE html>
    <html lang="de">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?php

                if($PAGE_DATA){
                    echo '<title>' . $PAGE_DATA['pages_title'] . '</title>' . "\n";
                    echo '<meta name="description" content="' . $PAGE_DATA['pages_description'] . '">' . "\n";
                    echo '<meta name="keywords" content="' . $PAGE_DATA['pages_keywords'] . '">' . "\n";
					echo $PAGE_DATA['pages_css'];
                }

            ?>
            <meta name="generator" content="ConstructrCMS">
            <meta name="robots" content="index,follow">
            <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
            <?php
 
               	foreach($_CONSTRUCTR_PLUGINS['_CONSTRUCTR_PLUGINS_CSS'] AS $CSS_PLUGIN){
                	echo($CSS_PLUGIN);
               	}
                        
            ?>
            <meta name="generator" content="ConstructrCMS">
            <meta name="author" content="Christian Becher">
            <meta name="robots" content="index,follow">
            <meta name="revisit-after" content="30 days">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            <style>
            	body{padding: 25px 25px 25px 25px;}
            </style>
        </head>
        <body>
            <?php

            	/**
				 * NAVIGATION BEISPIEL UL/LI START
				 */
				if($PAGES){
					$DOM = new domDocument();
					$DOM->validateOnParse = true;
					$DOM->loadHTML('<html>');

					$ROOT = $DOM->createElement('ul');
					$ROOT->setAttribute('class','constructr-menu');

					$DOM->appendChild($ROOT);

					foreach($PAGES as $KEY => $VALUE){
					    $PID = $VALUE['pages_mother'];
					    $PARENT = $DOM->getElementById('constructr-li-'.$PID);

					    if($PARENT != null){
					        $UL = $DOM->getElementById('ul-'.$PID);

					        if($UL == null){
					            $UL = $DOM->createElement('ul');
					            $UL->setAttribute('id','constructr-ul-'.$PID);
					            $PARENT->appendChild($UL);
					        }

					        $TARGET=$UL;
					    }
					    else
					    {
					        $TARGET=$ROOT;
					    }

					    $LI = $DOM->createElement('li','<a href="' . $_BASE_ROUTE . '/' . $VALUE['pages_url'] . '">' . $VALUE['pages_name'] . '</a>');
					    $LI->setAttribute('id','constructr-li-'.$VALUE['pages_id']);

						$TARGET->appendChild($LI);
					}

					$NAVIGATION = $DOM->saveHTML($ROOT);
					$NAVIGATION = str_replace('&lt;','<',$NAVIGATION);
					$NAVIGATION = str_replace('&gt;','>',$NAVIGATION);

					echo $NAVIGATION;
				}
            	/**
				 * NAVIGATION BEISPIEL UL/LI ENDE
				 */

               	foreach($_CONSTRUCTR_PLUGINS['_CONSTRUCTR_PLUGINS_CONTENT'] AS $CONTENT_PLUGIN){
                	echo($CONTENT_PLUGIN);
               	}

                if($CONTENT){
                    foreach($CONTENT as $CONTENT){
                        echo $CONTENT['content_content'];
                    }
                }

            ?>
            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <?php

               	foreach($_CONSTRUCTR_PLUGINS['_CONSTRUCTR_PLUGINS_JS'] AS $JS_PLUGIN){
                	echo($JS_PLUGIN);
               	}

				echo $PAGE_DATA['pages_js'];

            ?>
        </body>
    </html>