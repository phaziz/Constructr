<?php

/**
 * 	Constructr CMS - a Slim-PHP-Framework based Content Management System
 * 
 * 	Built with:
 * 	Slim-PHP-Framework (http://www.slimframework.com/)
 * 	Bootstrap Frontend Framework (http://getbootstrap.com/)
 * 	PHP PDO (http://php.net/manual/de/book.pdo.php)
 *  jQuery (http://jquery.com/)
 *  ckEditor (http://ckeditor.com/)
 *	Codemirror (http://codemirror.net/)
 * 	...
 * 
 *	LICENCE 
 * 
 *  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *  Version 1, February 2015
 *	Copyright (C) 2015 Christian Becher | phaziz.com <christian@phaziz.com>
 *  Everyone is permitted to copy and distribute verbatim or modified
 *  copies of this license document, and changing it is allowed as long
 *  as the name is changed.
 *
 *  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *  0. YOU JUST DO WHAT THE FUCK YOU WANT TO!
 *
 *  Visit http://constructr-cms.org
 * 	Visit http://blog.phaziz.com/category/constructr-cms/
 *  Visit http://phaziz.com
 * 
 * 
 * @author Christian Becher | phaziz.com <phaziz@gmail.com>
 * @copyright 2015 Christian Becher | phaziz.com
 * @license DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * @version 1.04.3
 * @link http://constructr-cms.org/
 * @package ConstructrCMS
 * 
 */

?>
<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo $_CONSTRUCTR_CONF['_TITLE'] . ' - ' . $SUBTITLE; ?></title>
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/css/constructr.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div id="wrapper" class="active">
                <div id="sidebar-wrapper">
                    <ul id="sidebar_menu" class="sidebar-nav">
                        <li class="sidebar-brand"><a id="menu-toggle" href="#"><div class="pull-right"><span title="&#8249;&#160;Hauptmen&uuml;&#160;&#160;" data-toggle="tooltip" data-placement="right" class="tt glyphicon glyphicon-align-justify"></span>&#160;&#160;</div></a></li>
                    </ul>
                    <ul class="sidebar-nav" id="sidebar">
                        <?php

                            if($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != '')
                            {
                                ?>
                                    <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Statische Internetseiten anzeigen" data-toggle="tooltip" data-placement="right">FTP-Seiten</a></li>
                                <?php
                            }

                        ?>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Vorschau dynamische Internetseiten" data-toggle="tooltip" data-placement="right">Vorschau</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/templates/" title="Templates anzeigen" data-toggle="tooltip" data-placement="right">Templates</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/config/" title="Systemkonfiguration anzeigen" data-toggle="tooltip" data-placement="right">System</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br>
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php
                            if(isset($_GET['transfered-static']) && $_GET['transfered-static'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die statischen Internetseiten wurden &uuml;bertragen!</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($_GET['transfered-static']) && $_GET['transfered-static'] == 'false')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim &uuml;bertragen der statischen Seiten aufgetreten.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($_GET['content-history']) && $_GET['content-history'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die gesamte Content-Historie wurde entfernt.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($_GET['optimized']) && $_GET['optimized'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die einzelnen Datenbanktabellen wurden optimiert.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            else if(isset($_GET['no-rights']) && $_GET['no-rights'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es fehlen die Zugriffsrechte f&uuml;r dieses Modul.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($_GET['cleared-cache']) && $_GET['cleared-cache'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <?php
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die gecachten Dateien wurden entfernt.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($SEARCHR))
                            {
                                ?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="jumbotron">
                                                <h1><?php echo $SUBTITLE; ?></h1>
                                                <h2><?php echo $SEARCHR_COUNTR; ?> Suchergebniss(e) wurden gefunden:</h2>
                                                <br>
                                                <?php
                                                    foreach($SEARCHR AS $SEARCHR_KEY => $SEARCHR_VALUE)
                                                    {
                                                        echo '<a href="' . $SEARCHR_VALUE['result_link'] . '">' . $SEARCHR_VALUE['name'] . '</a><br><br>';
                                                    }
                                                ?>
                                            </div><!-- // EOF JUMBOTRON... -->
                                        </div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?></h1>
                                    <h2>Suche:</h2>
                                    <br>
                                    <form class="form-inline" role="form" name="needle_form" id="needle_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>">
                                        <input type="hidden" id="user_form_guid" name="user_form_guid" value="<?php echo $GUID; ?>">
                                        <div class="col-lg-10">
                                            <input type="text" style="width:100%;" class="form-control input-sm" id="needles" name="needles" placeholder="Suchbegriffe durch Leerstellen getrennt eingeben">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" id="search-submittr" style="width:100%;" class="btn btn-info btn-sm">Suche starten</button>
                                        </div>
                                    </form>
                                    <br><br>
                                    <br><br>
                                    <?php

                                        if($_CONSTRUCTR_CONF['_TRANSFER_STATIC'] == true)
                                        {
                                                echo '<h2>Statische Seiten per FTP &uuml;bertragen</h2><br><ul class="list-group">';

                                            ?>
                                                      <li class="list-group-item">
                                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/transfer-static/<?php echo $GUID ?>/" title="Statische Internetseiten jetzt &uuml;bertragen">Statische Internetseiten jetzt &uuml;bertragen</a>
                                                      </li>
                                                </ul>
                                                <br>
                                            <?php
                                        }
                                    ?>
                                    <h2>Seiten, Uploads &amp; Benutzer:</h2>
                                    <br>
                                    <ul class="list-group">
                                          <li class="list-group-item">
                                                <span class="badge"><?php echo $PAGES_COUNTR; ?></span>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/pages/" title="Seiten anzeigen">Seiten</a>:
                                          </li>
                                          <li class="list-group-item">
                                                <span class="badge"><?php echo $CONTENT_COUNTR; ?></span>
                                                Inhalte:
                                          </li>
                                          <li class="list-group-item">
                                                <span class="badge"><?php echo $UPLOADS_COUNTR; ?></span>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/media/" title="Uploads anzeigen">Uploads</a>:
                                          </li>
                                          <li class="list-group-item">
                                                <span class="badge"><?php echo $BACKEND_USER_COUNTR; ?></span>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/user/" title="Benutzer anzeigen">Benutzer</a>:
                                          </li>
                                          <li class="list-group-item">
                                                <span class="badge"><?php echo $TEMPLATES_COUNTR; ?></span>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/templates/" title="Templates anzeigen">Templates</a>:
                                          </li>
                                    </ul>
                                    <br>
                                    <h2>Wartung:</h2>
                                    <br>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/optimization/<?php echo $GUID ?>/" title="Datenbank optimieren">Datenbank optimieren</a>
                                        </li>
                                        <?php

                                        	if(isset($_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY']) && $_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY'] == true)
                                        	{
                                        		?>
			                                        <li class="list-group-item">
			                                            <span class="badge"><?php echo $CONTENT_HISTORY_COUNTR; ?></span>
			                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/content-history/<?php echo $GUID ?>/" title="Content Historie entfernen">Content Historie entfernen</a>
			                                        </li>
                                        		<?php
                                        	}

                                        ?>
                                        <?php

                                        	if(isset($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE']) && $_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE'] == true)
                                        	{
                                        		?>
			                                        <li class="list-group-item">
			                                            <span class="badge"><?php echo $C_FILE_COUNTR; ?></span>
			                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/clear-cache/<?php echo $GUID ?>/" title="Website Cache entfernen">Website Cache entfernen</a>
			                                        </li>
                                        		<?php
                                        	}

                                        ?>
                                        <?php

                                        	if(isset($_CONSTRUCTR_CONF['_CONSTRUCTR_LOG_ENABLED']) && $_CONSTRUCTR_CONF['_CONSTRUCTR_LOG_ENABLED'] == true)
                                        	{
                                        		?>
			                                        <li class="list-group-item">
			                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Logfiles/<?php echo date('Ymd'); ?>.txt" title="Logfile anzeigen" onclick="window.open(this.href);return false;">Aktuelles Logfile anzeigen</a>
			                                        </li>
                                        		<?php
                                        	}

                                        ?>
                                        <li class="list-group-item">
                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/sitemap.xml" title="Sitemap anzeigen" onclick="window.open(this.href);return false;">Generierte sitemap.xml anzeigen</a>
                                        </li>
                                    </ul>
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script>
                $(function()
                    {
                        $('.tt').tooltip();

                        $('#needle_form').bind('submit',function()
                            {
                                var N = $('#needle').val();
                                if(N == '')
                                {
                                    $('#needle').focus();
                                    return false;
                                }
                            }
                        );

                        if(localStorage && localStorage.removeItem && localStorage.getItem && localStorage.setItem)
                        {
                            MENU_VISIBLE = localStorage.getItem('MENU_VISIBLE');
                            if(MENU_VISIBLE == 'false')
                            {
                                $("#wrapper").removeClass('active');
                            }
                        }

                        $("#menu-toggle").click(function(e)
                            {
                                e.preventDefault();
                                $("#wrapper").toggleClass('active');

                                if(localStorage && localStorage.removeItem && localStorage.getItem && localStorage.setItem)
                                {
                                    MENU_VISIBLE = localStorage.getItem('MENU_VISIBLE');
                                    if(MENU_VISIBLE == 'true')
                                    {
                                        localStorage.setItem('MENU_VISIBLE','false');
                                        $("#wrapper").removeClass('active');
                                    }
                                    else
                                    {
                                        localStorage.setItem('MENU_VISIBLE','true');
                                    }
                                }
                            }
                        );

                        function autoBlinder()
                        {
                            $('.response').fadeOut();
                        }

                        setInterval(autoBlinder,4500);
                    }
                )
            </script>
        </body>
    </html>
