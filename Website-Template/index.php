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

    if(isset($_GET['key']) && $_GET['key'] == $_CONSTRUCTR_CONF['_MAGIC_GENERATION_KEY'])
    {
        $_BASE_ROUTE = $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'];
    }
    else
    {
        if($_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] == '')
        {
            $_BASE_ROUTE = $_CONSTRUCTR_CONF['_BASE_URL'];
        }
        else
        {
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

                if($PAGE_DATA)
                {
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
 
               	foreach($_CONSTRUCTR_PLUGINS['_CONSTRUCTR_PLUGINS_CSS'] AS $CSS_PLUGIN)
               	{
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
				 * NAVIGATION BEISPIELE START
				 */
				if($PAGES)
				{
					/**
					 * NAVIGATION BEISPIEL: Alle Seiten als ungeordnete (<UL></UL>) Liste ausgeben. START
					 */
					echo '<p>Alle sichtbaren Seiten nach der angelegten Sortierung:</p>';
					echo '<ul>';

					foreach($PAGES AS $PAGE)
					{
						if($PAGE['pages_nav_visible'] == 1)
						{
							echo '<li><a href="' . $_BASE_ROUTE . '/' .  $PAGE['pages_url'] . '">' . $PAGE['pages_name'] . '</a></li>';
						}
					}

					echo '</ul>';
					/**
					 * NAVIGATION BEISPIEL: Alle Seiten als ungeordnete (<UL></UL>) Liste ausgeben. ENDE
					 */

					/**
					 * NAVIGATION BEISPIEL: Alle Seiten als ungeordnete (<UL></UL>) Liste mit entsprechender Hierarchie ausgeben. START
					 */
		            try
		            {
						echo '<p>Alle sichtbaren Seiten nach der angelegten Sortierung mit entsprechender Hierarchie:</p>';
						echo '<ul>';

						$PAGES = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_mother = 0 ORDER BY pages_order ASC;');
						$PARENT_PAGES = $PAGES -> fetchAll();

						foreach($PARENT_PAGES as $PAGE)
						{
							echo '<li><a href="' . $_BASE_ROUTE . '/' . $PAGE['pages_url'] . '">' . $PAGE['pages_name'] . '</a>';

							$CHILDS = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_mother = ' . $PAGE['pages_id'] . ' ORDER BY pages_order ASC;');
							$CHILD_PAGES = $CHILDS -> fetchAll();

							if(count($CHILD_PAGES)>0)
							{
								echo '<ul>';
							}

							foreach($CHILD_PAGES as $CHILD)
							{
								echo '<li><a href="' . $_BASE_ROUTE . '/' . $CHILD['pages_url'] . '">' . $CHILD['pages_name'] . '</a>';

								$CHILDS2 = $DBCON -> query('SELECT * FROM constructr_pages WHERE pages_mother = ' . $CHILD['pages_id'] . ' ORDER BY pages_order ASC;');
								$CHILD_PAGES2 = $CHILDS2 -> fetchAll();

								if(count($CHILD_PAGES2)>0)
								{
									echo '<ul>';
								}
	
								foreach($CHILD_PAGES2 as $CHILD2)
								{
									echo '<li><a href="' . $_BASE_ROUTE . '/' . $CHILD2['pages_url'] . '">' . $CHILD2['pages_name'] . '</a>';
								}
	
								if(count($CHILD_PAGES2)>0)
								{
									echo '</ul>';
								}
	
								echo '</li>';
							}

							if(count($CHILD_PAGES)>0)
							{
								echo '</ul>';
							}

							echo '</li>';
						}
		            }
		            catch(PDOException $e)
		            {
		                die();
		            }

					echo '</ul>';
					/**
					 * NAVIGATION BEISPIEL: Alle Seiten als ungeordnete Liste (<UL></UL>) mit entsprechender Hierarchie ausgeben. ENDE
					 */					 
				}
            	/**
				 * NAVIGATION BEISPIELE ENDE
				 */

               	foreach($_CONSTRUCTR_PLUGINS['_CONSTRUCTR_PLUGINS_CONTENT'] AS $CONTENT_PLUGIN)
               	{
                	echo($CONTENT_PLUGIN);
               	}

                if($CONTENT)
                { 
                    foreach($CONTENT as $CONTENT)
                    {
                        echo $CONTENT['content_content'];
                    }
                }

            ?>
            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <?php

               	foreach($_CONSTRUCTR_PLUGINS['_CONSTRUCTR_PLUGINS_JS'] AS $JS_PLUGIN)
               	{
                	echo($JS_PLUGIN);
               	}

            ?>
            <script type="text/javascript">
                var _paq=_paq||[];_paq.push(["setDocumentTitle",document.domain+"/"+document.title]);_paq.push(["setCookieDomain","*.constructr.phaziz.com"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);
                (function(){var c=("https:"==document.location.protocol?"https":"http")+"://piwik.phaziz.com/";_paq.push(["setTrackerUrl",c+"piwik.php"]);_paq.push(["setSiteId","3"]);var a=document,b=a.createElement("script"),a=a.getElementsByTagName("script")[0];b.type="text/javascript";b.defer=!0;b.async=!0;b.src=c+"piwik.js";a.parentNode.insertBefore(b,a)})();
            </script>
            <?php

				echo $PAGE_DATA['pages_js'];

            ?>
            <noscript>
                <img src="http://piwik.phaziz.com/piwik.php?idsite=3&rec=1" style="border:0" alt="piwik" />
            </noscript>
        </body>
    </html>
