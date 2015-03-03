<?php

/**
 * Constructr CMS TemplateFile Backend User Overview.
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
 * @version 1.04.5 / 02.03.2015
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
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/css/datatables.css" rel="stylesheet">
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
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Medienverwaltung anzeigen">Medien</a></li>
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
                        <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    	<br>
                    	<div class="pull-right"><div class="menu-btn tt" title="Navigation ein- oder ausblenden" data-placement="bottom">&#9776; ConstructrCMS&#160;&#160;&#160;</div></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->

                <?php

                    if (isset($_GET['create']) || isset($_GET['edit']) || isset($_GET['delete'])) {

                ?>
	                <div class="row response">
	                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <?php

                        if (isset($_GET['create']) && $_GET['create'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Neuer Benutzer wurde ohne Fehler erstellt.</div>';
                        } elseif (isset($_GET['create']) && $_GET['create'] == 'error') {
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim anlegen des Benutzers aufgetreten.</div>';
                        }
                        if (isset($_GET['edit']) && $_GET['edit'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Benutzer wurde erfolgreich bearbeitet.</div>';
                        } elseif (isset($_GET['edit']) && $_GET['edit'] == 'error') {
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim Bearbeiten des Benutzers aufgetreten.</div>';
                        }
                        if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Benutzer wurde entfernt.</div>';
                        } elseif (isset($_GET['delete']) && $_GET['delete'] == 'error') {
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Benutzer wurde nicht entfernt - es ist ein Fehler aufgetreten..</div>';
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
                            <h2><?php echo $COUNTR; ?> Angelegte Benutzer <a data-toggle="tooltip" data-placement="top" title="Neuen Benutzer anlegen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/new/'; ?>"><button type="button" class="btn btn-info btn-sm" title="Neuer Benutzer"><span class="glyphicon glyphicon-plus"></span> Neuen Benutzer anlegen</button></a></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Benutzername</th>
                                        <th>eMail</th>
                                        <th class="center">Letzte Anmeldung</th>
                                        <th class="center">Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                        if ($BACKENDUSER) {
                                            foreach ($BACKENDUSER as $USER) {
                                                echo '<tr>';
                                                echo '<td>'.$USER['beu_username'].'</td>';
                                                echo '<td>'.$USER['beu_email'].'</td>';
                                                if ($USER['beu_last_login'] != '0000-00-00 00:00:00') {
                                                    echo '<td class="center">'.date("d.m.Y, H:i", strtotime(substr($USER['beu_last_login'], 0, 18))).' Uhr</td>';
                                                } else {
                                                    echo '<td class="center">./.</td>';
                                                }
                                                echo '<td class="right"><nobr>';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Benutzer bearbeiten" class="tt user-editer" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/edit/'.$USER['beu_id'].'/"><button type="button" class="btn btn-primary btn-xs" title="Editieren"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzerrechte bearbeiten" class="tt user-rights-editer" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/edit-user-rights/'.($USER['beu_id']).'/'.($USER['beu_username']).'/"><button type="button" class="btn btn-info btn-xs" title="Benutzerrechte Editieren"><span class="glyphicon glyphicon-edit"></span></button></a>';
                                                if ($USER['beu_active'] == 1) {
                                                    echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzer deaktivieren" class="tt status-updater" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/set-inactive/'.$USER['beu_id'].'/"><button type="button" class="btn btn-warning btn-xs" title="Deaktivieren"><span class="glyphicon glyphicon-star-empty"></span></button></a>';
                                                } else {
                                                    echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzer aktivieren" class="tt status-updater" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/set-active/'.$USER['beu_id'].'/"><button type="button" class="btn btn-success btn-xs" title="Aktivieren"><span class="glyphicon glyphicon-star"></span></button></a>';
                                                }
                                                echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzer l&ouml;schen" class="user-deleter tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/delete/'.$USER['beu_id'].'/"><button type="button" class="btn btn-danger btn-xs" title="Entfernen"><span class="glyphicon glyphicon-remove-circle"></span></button></a>';
                                                echo '</nobr></td>';
                                                echo '</tr>';
                                            }
                                        }

                                    ?>

                                </tbody>
                            </table>
                            </div><!-- EOF TABLE RESPONSIVE-->
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                        <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.min.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();

                        $('.datatable').dataTable(
                            {
                                "aaSorting": [[ 1,"asc"]],
                                "aoColumns": [
                                    { "sWidth": "30%", "bSortable":true},
                                    { "sWidth": "25%", "bSortable":true},
                                    { "sWidth": "25%", "bSortable":true},
                                    { "sWidth": "20%", "bSortable":false}
                                ],
                                "sPaginationType":"bs_full",
                                "iDisplayLength": 10,
                                "oLanguage": {
                                    "sLengthMenu": '<small>Zeige <select class="form-control input-sm">'+
                                    '<option value="10">10</option>'+
                                    '<option value="20">20</option>'+
                                    '<option value="25">25</option>'+
                                    '<option value="50">50</option>'+
                                    '<option value="100">100</option>'+
                                    '<option value="-1">Alle</option>'+
                                    '</select> Ergebnisse je Seite</small>'
                                }
                            }
                        );

                        $('.datatable').each(function()
                            {
                                var datatable = $(this);
                                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                                search_input.attr('placeholder', 'Suche');
                                search_input.addClass('form-control input-sm');
                                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                                length_sel.addClass('form-control input-sm');
                            }
                        );

                        $('.user-deleter').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'Soll der Benutzer wirklich gel&ouml;scht werden? Achtung: Diese &Auml;nderung wird sofort wirksam und der Benutzer sofort gel&ouml;scht!!!',
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