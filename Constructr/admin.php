<?php

/**
 * Constructr CMS TemplateFile Administration Dashboard.
 */

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
 * @version 1.04.6 / 05.03.2015
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
            <title><?php echo $_CONSTRUCTR_CONF['_TITLE'].' - '.$SUBTITLE; ?></title>
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/css/constructr.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>

			<nav class="pushy pushy-left">
	            <ul class="sidebar-nav" id="sidebar">
	
	                <?php
	
	                    if ($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != '') {
	
	                ?>
	
	                    <li><a href="<?php echo $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Statische Internetseiten anzeigen">FTP-Seiten</a></li>
	
	                <?php
	
	                    }
	
	                ?>
	
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Vorschau dynamische Internetseiten">Vorschau</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/" title="Dashboard anzeigen">Dashboard</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/" title="Seitenverwaltung anzeigen">Seiten</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Uploads anzeigen">Uploads</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen">M&uuml;lleimer</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/" title="Benutzerverwaltung anzeigen">Benutzer</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/templates/" title="Templates anzeigen">Templates</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/config/" title="Systemkonfiguration anzeigen">System</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden">Logout</a></li>
	            </ul>
			</nav>
            <div class="page-content inset">
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    	<br>
						<ul class="nav nav-pills">
							<li role="presentation"><a href="http://phaziz.com" target="_blank">ConstructrCMS</a></li>
							<li role="presentation"><a href="http://phaziz.com" target="_blank">ConstructrCMS</a></li>
							<li role="presentation" class="active"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a></li>
						</ul>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    	<br>
                    	<div class="pull-right"><div class="menu-btn tt" title="Navigation ein- oder ausblenden" data-placement="bottom">&#9776; ConstructrCMS&#160;&#160;&#160;</div></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->

                <?php

                    if (isset($_GET['backup-config']) && $_GET['backup-config'] == 'true') {
                        ?>
                            <div class="row response">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <?php
                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Konfiguration wurde auf dem Server gesichert!</div>';
                    				?>
                                </div><!-- // EOF COL-... -->
                            </div><!-- // EOF ROW -->
                    	<?php

                    }
                    if (isset($_GET['backup-config']) && $_GET['backup-config'] == 'false') {
                        ?>
                            <div class="row response">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <?php
                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim sichern der Konfiguration aufgetreten!</div>';
                        			?>
                                </div><!-- // EOF COL-... -->
                            </div><!-- // EOF ROW -->
                        <?php

                    }
                    if (isset($_GET['transfered-static']) && $_GET['transfered-static'] == 'true') {
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
                    if (isset($_GET['transfered-static']) && $_GET['transfered-static'] == 'false') {
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
                    if (isset($_GET['content-history']) && $_GET['content-history'] == 'true') {
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
                    if (isset($_GET['optimized']) && $_GET['optimized'] == 'true') {
                        ?>
                            <div class="row response">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <?php
                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die einzelnen Datenbanktabellen wurden optimiert.</div>';
                        			?>
                                </div><!-- // EOF COL-... -->
                            </div><!-- // EOF ROW -->
                        <?php

                    } elseif (isset($_GET['no-rights']) && $_GET['no-rights'] == 'true') {
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
                    if (isset($_GET['cleared-cache']) && $_GET['cleared-cache'] == 'true') {
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
                    if (isset($SEARCHR)) {
                        ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="jumbotron">
                                        <h1><?php echo $SUBTITLE; ?></h1>
                                        <h2><?php echo $SEARCHR_COUNTR; ?> Suchergebniss(e) wurden gefunden:</h2>
                                        <br>
                                        <?php
                                            foreach ($SEARCHR as $SEARCHR_KEY => $SEARCHR_VALUE) {
                                                echo '<a href="'.$SEARCHR_VALUE['result_link'].'">'.$SEARCHR_VALUE['name'].'</a><br><br>';
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
                                    <input type="text" pattern=".{3,100}" style="width:100%;" maxlength="100" minlength="3" class="form-control input-sm" id="needles" name="needles" placeholder="Mindesteingabe 3 Zeichen - Suchbegriffe durch Leerstellen getrennt eingeben" autofocus required="required" autocomplete="off">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" id="search-submittr" style="width:100%;" class="btn btn-info btn-sm">Suche starten <span class="glyphicon glyphicon-chevron-right"></span></button>
                                </div>
                            </form>
                            <br><br>
                            <?php

                                if ($_CONSTRUCTR_CONF['_TRANSFER_STATIC'] == true) {
                                    echo '<h2>Statische Seiten per FTP &uuml;bertragen</h2><br><ul class="list-group">';

                    		?>

									<li class="list-group-item">
										<a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/transfer-static/<?php echo $GUID ?>/" title="Statische Internetseiten jetzt &uuml;bertragen">Statische Internetseiten jetzt &uuml;bertragen</a>
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
                                        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/pages/" title="Seiten anzeigen" class="tt">Seiten</a>:
                                  </li>
                                  <li class="list-group-item">
                                        <span class="badge"><?php echo $CONTENT_COUNTR; ?></span>
                                        Inhalte:
                                  </li>
                                  <li class="list-group-item">
                                        <span class="badge"><?php echo $UPLOADS_COUNTR; ?></span>
                                        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/media/" title="Uploads anzeigen" class="tt">Uploads</a>:
                                  </li>
                                  <li class="list-group-item">
                                        <span class="badge"><?php echo $BACKEND_USER_COUNTR; ?></span>
                                        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/user/" title="Benutzer anzeigen" class="tt">Benutzer</a>:
                                  </li>
                                  <li class="list-group-item">
                                        <span class="badge"><?php echo $TEMPLATES_COUNTR; ?></span>
                                        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/templates/" title="Templates anzeigen" class="tt">Templates</a>:
                                  </li>
                            </ul>
                            <br>
                            <h2>Wartung:</h2>
                            <br>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/optimization/<?php echo $GUID ?>/" title="Datenbank optimieren" class="tt">Datenbank optimieren</a>
                                </li>
                                <?php

                                    if (isset($_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY']) && $_CONSTRUCTR_CONF['_ENABLE_CONTENT_HISTORY'] == true) {
                                ?>

                                    <li class="list-group-item">
                                        <span class="badge"><?php echo $CONTENT_HISTORY_COUNTR; ?></span>
                                        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/content-history/<?php echo $GUID ?>/" title="Content Historie entfernen" class="tt">Content Historie entfernen</a>
                                    </li>

                        		<?php

                                    }

                                ?>
                                <?php

                                    if (isset($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE']) && $_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE'] == true) {

                                ?>

                                    <li class="list-group-item"><span class="badge"><?php echo $C_FILE_COUNTR; ?></span>
                                        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/clear-cache/<?php echo $GUID ?>/" title="Website Cache entfernen" class="tt">Website Cache entfernen</a>
                                    </li>

                        		<?php

                                    }

                                ?>
                                <?php

                                    if (isset($_CONSTRUCTR_CONF['_CONSTRUCTR_LOG_ENABLED']) && $_CONSTRUCTR_CONF['_CONSTRUCTR_LOG_ENABLED'] == true) {

                                ?>
                                    <li class="list-group-item">
                                    	<a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Logfiles/<?php echo date('Ymd'); ?>.txt" class="tt" title="Logfile anzeigen" onclick="window.open(this.href);return false;">Aktuelles Logfile anzeigen</a>
                                	</li>

                        		<?php

                                    }

                                ?>
                                <li class="list-group-item">
                                    <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/sitemap.xml" title="Sitemap anzeigen" class="tt" onclick="window.open(this.href);return false;">Sitemap (sitemap.xml) anzeigen</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/config-backup/" class="tt" title="Konfiguration sichern">Konfiguration auf Server sichern</a>
                                </li>
                            </ul>
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="center"><small><a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a>, Version <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> vom <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?></small></p>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.min.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();
						$('#needles').focus();

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

                        function autoBlinder()
                        {
                            $('.response').fadeOut();
                        }

                        setInterval(autoBlinder,4500);
                    }
               );

            </script>
        </body>
    </html>