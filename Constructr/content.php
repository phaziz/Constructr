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
                            if($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != '')
                            {
                                ?>
                                    <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Statische Internetseiten anzeigen" data-toggle="tooltip" data-placement="right">FTP-Seiten</a></li>
                                <?php
                            }
                        ?>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Vorschau dynamische Internetseiten" data-toggle="tooltip" data-placement="right">Vorschau</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/content/<?php echo $PAGE_ID; ?>/">Seiteninhalte</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php
                            if(isset($_GET['res']) && $_GET['res'] != ''){
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <?php
                                                    if($_GET['res'] == 'create-content-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde ohne Fehler erstellt.</div>';
                                                    }
                                                    else if($_GET['res'] == 'create-content-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim anlegen des Inhalts aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'activate-content-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt ist nun im Frontend sichtbar.</div>';
                                                    }
                                                    else if($_GET['res'] == 'activate-content-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim aktivieren des Inhalts aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'deactivate-content-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite ist nun im Frontend unsichtbar.</div>';
                                                    }
                                                    else if($_GET['res'] == 'deactivate-content-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim deaktivieren des Inhalts aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'edit-content-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich bearbeitet.</div>';
                                                    }
                                                    else if($_GET['res'] == 'edit-content-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim bearbeiten des Inhalts aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'del-content-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich entfernt.</div>';
                                                    }
                                                    else if($_GET['res'] == 'del-content-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim l&ouml;schen des Inhalts aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'reorder-content-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler bei der Sortierung aufgetreten. Bitte diese Seite neu laden!</div>';
                                                    }
                                                    else if($_GET['res'] == 'reorder-content-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich verschoben.</div>';
                                                    }
                                                    if($_GET['res'] == 'recreated-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Fehler bei Wiederherstellung. Bitte diese Seite neu laden!</div>';
                                                    }
                                                    else if($_GET['res'] == 'recreated-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich wiederhergestellt.</div>';
                                                    }
                                                    if($_GET['res'] == 'cleared-page-cache-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Fehler beim entfernen des Caches dieser Seite!</div>';
                                                    }
                                                    else if($_GET['res'] == 'cleared-page-cache-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Cache dieser Seite wurde erfolgreich gel&ouml;scht.</div>';
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
                                    <h1><?php echo $SUBTITLE; ?>: <a data-toggle="tooltip" data-placement="top" title="Seite anzeigen" class="tt" onclick="window.open(this.href);return false;" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] .'/'. $PAGE_NAME['pages_url']; ?>"><strong><?php echo $PAGE_NAME['pages_name']; ?></strong></a>
                                    <?php 

	                                     if($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE'] == true)
	                                     {
	                                     	?> | <a data-toggle="tooltip" data-placement="top" title="Cache dieser Seite l&ouml;schen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] .'/constructr/clear-cache-page/'. $GUID . '/' . $PAGE_NAME['pages_id'] . '/'; ?>"><strong>Cache l&ouml;schen</strong></a> <?php
	                                     }

                                    ?>	
                                    </h1>
                                    <h2><?php echo $CONTENT_COUNTER; ?> Angelegte Inhalte von <strong><?php echo $PAGE_NAME['pages_name']; ?></strong> <a data-toggle="tooltip" data-placement="top" title="Neuen Inhalt erstellen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . ($CONTENT_COUNTER + 1) . '/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neuen Inhalt erstellen"><span class="glyphicon glyphicon-plus"></span></button></a></h2>
                                    <br><br>
                                    <div class="table-responsive">
                                    <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><small>Inhalt</small></th>
                                                <th class="center"><small>Aktionen</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($CONTENT)
                                                {
                                                    foreach ($CONTENT as $CONTENT)
                                                    {
                                                        echo '<tr>';
                                                        echo '<td><small>';
                                                        echo '<a href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/edit/" title="Inhalte bearbeiten">' . htmlspecialchars($CONTENT['content_content']) . '</a></small></td>';
                                                        echo '<td class="right"><nobr>';
                                                        if($CONTENT['content_order'] > 1)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt nach oben verschieben" class="reorder tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/' . $CONTENT['content_order'] . '/up/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach oben verschieben"><span class="glyphicon glyphicon-arrow-up"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        if($CONTENT['content_order'] < $CONTENT_COUNTER)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt nach unten verschieben" class="reorder tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/' . $CONTENT['content_order'] . '/down/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach unten verschieben"><span class="glyphicon glyphicon-arrow-down"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        if($CONTENT['content_active'] == 0)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt aktivieren" class="activator tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/activate/"><button type="button" class="btn btn-danger btn-xs" title="deaktiviert und unsichtbar"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        else
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt deaktivieren" class="activator tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/deactivate/"><button type="button" class="btn btn-success btn-xs" title="aktiviert und sichtbar"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt bearbeiten" class="editer tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/edit/"><button type="button" class="btn btn-success btn-xs" title="Inhalt bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                        echo '&#160;';
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Diesen Inhalt l&ouml;schen" class="deleter tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/' . $CONTENT['content_order'] .  '/delete/" title="Inhalt l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                        echo '</nobr></td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                else
                                                {
                                                    echo '<tr><td colspan="7">Keine Seiteninhalte gefunden!</td></tr>';
                                                };
                                            ?>
                                        </tbody>
                                    </table>
                                    </div><!-- EOF TABLE RESPONSIVE-->
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php

                            if($DELETED_CONTENT_COUNTER != 0)
                            {

                        ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jumbotron">
                                    <h2><?php echo $DELETED_CONTENT_COUNTER; ?> <strong>Gel&ouml;schte</strong> Inhalte von <?php echo $PAGE_NAME['pages_name']; ?></h2>
                                    <br><br>
                                    <div class="table-responsive">
                                    <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><small>Gel&ouml;schter Inhalt</small></th>
                                                <th class="center"><small>Aktionen</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                foreach ($DELETED_CONTENT as $DELETED_CONTENT)
                                                {
                                                    echo '<tr>';
                                                    echo '<td><small>';
                                                    echo '<a href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $DELETED_CONTENT['content_id'] . '/edit/" title="Inhalte bearbeiten">' . htmlspecialchars($DELETED_CONTENT['content_content']) . '</a></small></td>';
                                                    echo '<td class="right"><nobr>';
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Wiederherstellen" class="recreater tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $DELETED_CONTENT['content_id'] . '/' . ($CONTENT_COUNTER+1) . '/re-create/"><button type="button" class="btn btn-success btn-xs" title="Wiederherstellen"><span class="glyphicon glyphicon-import"></span></button></a>';
                                                    echo '&#160;';
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Diesen Inhalt endg&uuml;ltig l&ouml;schen" class="deleter tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/' . $DELETED_CONTENT['content_id'] . '/delete-complete/" title="Inhalt endg&uuml;ltig l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                    echo '</nobr></td>';
                                                    echo '</tr>';
                                                }

                                            ?>
                                        </tbody>
                                    </table>
                                    </div><!-- EOF TABLE RESPONSIVE-->
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/content/<?php echo $PAGE_ID; ?>/">Seiteninhalte</a></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

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

                        function autoBlinder()
                        {
                            $('.response').fadeOut();
                        }

                        setInterval(autoBlinder,4500);

                        $('.datatable').dataTable(
                            {
                                "aaSorting": [],
                                "aoColumns": [
                                    { "sWidth": "80%", "bSortable":false},
                                    { "sWidth": "20%", "bSortable":false}
                                ],
                                "sPaginationType":"bs_full",
                                "iDisplayLength": -1,
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

                        $('.reorder').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'Inhalt wirklich verschieben?',
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

                        $('.recreater').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'M&ouml;chten Sie diesen Inhalt wiederherstellen?',
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

                        $('.deleter').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'M&ouml;chten Sie wirklich diesen Inhalt l&ouml;schen?',
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

                        $('.activator').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'Soll die Sichtbarkeit des Inhalts wirklich angepasst werden?',
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
