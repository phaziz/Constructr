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
 * @version 1.04.5 / 25.02.2015
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

                            if ($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != '') {

                        ?>

                            <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Statische Internetseiten anzeigen" data-toggle="tooltip" data-placement="right">FTP-Seiten</a></li>

                        <?php

                            }

                        ?>

                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Vorschau dynamische Internetseiten" data-toggle="tooltip" data-placement="right">Vorschau</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                </div>
            </div>
            <!-- NEW BE LAYOUT-->

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();

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