<?php

/**
 * Constructr CMS TemplateFile Pages Overview.
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
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/css/constructr.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.css" rel="stylesheet">
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
							<li role="presentation"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a></li>
							<li role="presentation" class="active"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a></li>
						</ul>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    	<br>
                    	<div class="pull-right"><div class="menu-btn tt" title="Navigation ein- oder ausblenden" data-placement="bottom">&#9776; ConstructrCMS&#160;&#160;&#160;</div></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->

                <?php

                    if (isset($_GET['res']) && $_GET['res'] != '') {

                ?>
	                <div class="row response">
	                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	                        <?php

	                            if ($_GET['res'] == 'create-page-true') {
	                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die neue Seite wurde ohne Fehler erstellt.</div>';
	                            } elseif ($_GET['res'] == 'create-page-false') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim anlegen der Seite aufgetreten.</div>';
	                            }
	                            if ($_GET['res'] == 'activate-page-true') {
	                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite ist nun im Frontend sichtbar/unsichtbar.</div>';
	                            } elseif ($_GET['res'] == 'activate-page-false') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim aktivieren/deaktivieren der Seite aufgetreten.</div>';
	                            }
	                            if ($_GET['res'] == 'edit-page-true') {
	                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich bearbeitet.</div>';
	                            } elseif ($_GET['res'] == 'edit-page-false') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim bearbeiten der Seite aufgetreten.</div>';
	                            }
	                            if ($_GET['res'] == 'del-single-true') {
	                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich entfernt.</div>';
	                            } elseif ($_GET['res'] == 'del-single-false') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim l&ouml;schen der Seite aufgetreten.</div>';
	                            }
	                            if ($_GET['res'] == 'subpages-not-empty') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Es existieren noch Unterseiten zu dieser Seite!</div>';
	                            }
	                            if ($_GET['res'] == 'url-exists') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Gew&uuml;nschte URL existiert bereits!</div>';
	                            }
	                            if ($_GET['res'] == 'reorder-error') {
	                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler bei der Sortierung aufgetreten. Bitte diese Seite neu laden!</div>';
	                            }
	                            if ($_GET['res'] == 'reorder-success') {
	                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich verschoben.</div>';
	                            }

                            ?>

                        </div><!-- // EOF COL-... -->
                    </div><!-- // EOF ROW -->

                <?php

                    }

                ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron">
                            <h1><?php echo $SUBTITLE; ?></h1>
                            <h2><?php echo $PAGES_COUNTR; ?> Angelegte Seiten <a data-toggle="tooltip" data-placement="top" title="Neue Seite erstellen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neue Seite"><span class="glyphicon glyphicon-plus"></span> Neue Seite erstellen</button></a></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><small>Name</small></th>
                                        <th><small>Alias (URL)</small></th>
                                        <th><small>Template</small></th>
                                        <th class="center"><small>Aktionen</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	
                                    <?php

                                        if ($PAGES) {
                                            foreach ($PAGES as $PAGE) {
                                                echo '<tr>';
                                                echo '<td>';
                                                if ($PAGE['pages_level'] > 1) {
                                                    for ($i = 1; $i <= $PAGE['pages_level']; $i++) {
                                                        echo '&#160;&#160;&#160;';
                                                    }
                                                }
                                                if ($PAGE['pages_nav_visible'] == 0) {
                                                    echo '<a style="color: #ff0066!important;" class="tt" data-toggle="tooltip" data-placement="top" title="Inhalte von Seite '.$PAGE['pages_name'].' bearbeiten" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE['pages_id'].'/" title="Inhalte von Seite '.$PAGE['pages_name'].' bearbeiten"><small>'.$PAGE['pages_name'].'</small></a></td>';
                                                } else {
                                                    echo '<a class="tt" data-toggle="tooltip" data-placement="top" title="Inhalte von Seite '.$PAGE['pages_name'].' bearbeiten" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE['pages_id'].'/" title="Inhalte von Seite '.$PAGE['pages_name'].' bearbeiten"><small>'.$PAGE['pages_name'].'</small></a></td>';
                                                }

                                                if ($PAGE['pages_url'] == '') {
	                                                if ($PAGE['pages_nav_visible'] == 0) {
	                                                	echo '<td><small><a style="color: #ff0066!important;" class="tt" data-toggle="tooltip" data-placement="top" title="Seite im Browser anzeigen" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'" onclick="window.open(this.href);return false;">'.$_CONSTRUCTR_CONF['_BASE_URL'].'</a></small></td>';    
	                                                } else {
	                                                    echo '<td><small><a class="tt" data-toggle="tooltip" data-placement="top" title="Seite im Browser anzeigen" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'" onclick="window.open(this.href);return false;">'.$_CONSTRUCTR_CONF['_BASE_URL'].'</a></small></td>';
	                                                }
                                                } else {
	                                                if ($PAGE['pages_nav_visible'] == 0) {
	                                                	echo '<td><small><a style="color: #ff0066!important;" class="tt" data-toggle="tooltip" data-placement="top" title="Seite im Browser anzeigen" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$PAGE['pages_url'].'" onclick="window.open(this.href);return false;">'.$PAGE['pages_url'].'</a></small></td>';    
	                                                } else {
	                                                    echo '<td><small><a class="tt" data-toggle="tooltip" data-placement="top" title="Seite im Browser anzeigen" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$PAGE['pages_url'].'" onclick="window.open(this.href);return false;">'.$PAGE['pages_url'].'</a></small></td>';
	                                                }
                                                }
                                                
                                                echo '<td><small>'.$PAGE['pages_template'].'</small></td>';
                                                echo '<td class="right"><nobr>';

                                                if ($PAGE['pages_order'] > 1) {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite nach oben verschieben" class="reorder tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/reorder/up/'.$PAGE['pages_id'].'/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach oben verschieben"><span class="glyphicon glyphicon-arrow-up"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                if ($PAGE['pages_order'] < $PAGES_COUNTR) {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite nach unten verschieben" class="reorder tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/reorder/down/'.$PAGE['pages_id'].'/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach unten verschieben"><span class="glyphicon glyphicon-arrow-down"></span></button></a>';
                                                    echo '&#160;';
                                                }

                                                if ($PAGE['pages_active'] == 0) {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite aktivieren" class="activator tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/activate/'.$PAGE['pages_id'].'/"><button type="button" class="btn btn-danger btn-xs" title="deaktiviert und unsichtbar"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                    echo '&#160;';
                                                } else {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite deaktivieren" class="activator tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/deactivate/'.$PAGE['pages_id'].'/"><button type="button" class="btn btn-success btn-xs" title="aktiviert und sichtbar"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                    echo '&#160;';
                                                }

                                                echo '<a data-toggle="tooltip" data-placement="top" title="Inhalte von Seite '.$PAGE['pages_name'].' bearbeiten" class="editercontent tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE['pages_id'].'/"><button type="button" class="btn btn-info btn-xs" title="Inhalte von Seite '.$PAGE['pages_name'].' bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                echo '&#160;';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Seite '.$PAGE['pages_name'].' bearbeiten" class="editer tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/edit/'.$PAGE['pages_id'].'/"><button type="button" class="btn btn-success btn-xs" title="Seite '.$PAGE['pages_name'].' bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                echo '&#160;';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Diese Seite l&ouml;schen" class="deleter-single tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/delete-single/'.$PAGE['pages_id'].'/'.$PAGE['pages_order'].'/" title="Seite l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                echo '</nobr></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="7">Keine Seiten gefunden!</td></tr>';
                                        };

                                    ?>

                                </tbody>
                            </table>
                            </div><!-- EOF TABLE RESPONSIVE-->
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
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.min.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();

                        function autoBlinder()
                        {
                            $('.response').fadeOut();
                        }

                        setInterval(autoBlinder,4500);

                        $( ".reorder" ).dblclick(function(e)
                            {
                              e.preventDefault();
                              return false;
                            }
                        );

                        $('.deleter-single').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'M&ouml;chten Sie wirklich diese Seite l&ouml;schen?<br><small>Vorhandene Inhalte werden ebenfalls gel&ouml;scht!</small>',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                window.location = (U);
                                            }
                                            else
                                            {
                                                return false
                                            }
                                        }
                                    }
                                );
                           }
                        );

                        $('.deleter-recursive').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'M&ouml;chten Sie wirklich diese Seite inklusive der Unterseiten l&ouml;schen?',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                window.location = (U);
                                            }
                                            else
                                            {
                                                return false
                                            }
                                        }
                                    }
                                );
                            }
                        );
                    }
                );

            </script>
        </body>
    </html>