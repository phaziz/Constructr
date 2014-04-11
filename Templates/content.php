<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo _TITLE . ' - ' . $SUBTITLE; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo _BASE_URL;?>/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/css/constructr.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/datatables-bootstrap3/assets/css/datatables.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div id="wrapper" class="active">
                <div id="sidebar-wrapper">
                    <ul id="sidebar_menu" class="sidebar-nav">
                        <li class="sidebar-brand"><a id="menu-toggle" href="#"><div class="pull-right"><span title="&#8249;&#160;Hauptmen&uuml;&#160;&#160;" data-toggle="tooltip" data-placement="right" class="tt glyphicon glyphicon-align-justify"></span>&#160;&#160;</div></a></li>
                    </ul>
                    <ul class="sidebar-nav" id="sidebar">     
                        <li><a class="tt" href="<?php echo _BASE_URL ?>" onclick="window.open(this.href);return false;" title="Internetseite anzeigen" data-toggle="tooltip" data-placement="right">Internetseite</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                    <p><small class="trademark">&#160;&#160;&#160;Constructr CMS</small></p>
                    <p><small class="trademark">&#160;&#160;&#160;Version: <?php echo _VERSION; ?><br>&#160;&#160;&#160;<?php echo $TIMER; ?><br>&#160;&#160;&#160;<?php echo $MEM; ?><br>&#160;&#160;&#160;<a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <br>
                                <p><small><a href="<?php echo _BASE_URL ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/content/<?php echo $PAGE_ID; ?>/">Inhalte - &Uuml;bersicht</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?>: <strong><?php echo $PAGE_NAME['pages_name']; ?></strong></h1>
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php 
                            if(isset($_GET['res']) && $_GET['res'] != ''){
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
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
                                                ?>
                                        </div><!-- // EOF COL-... -->
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <div class="jumbotron">
                                    <h2><?php echo $CONTENT_COUNTER; ?> Angelegte Inhalte von <strong><?php echo $PAGE_NAME['pages_name']; ?></strong> <a data-toggle="tooltip" data-placement="top" title="Neuen Inhalt erstellen" class="tt" href="<?php echo _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . ($CONTENT_COUNTER + 1) . '/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neuen Inhalt erstellen"><span class="glyphicon glyphicon-plus"></span></button></a></h2>
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
                                                        echo '<a href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/edit/" title="Inhalte bearbeiten">' . htmlentities($CONTENT['content_content']) . '</a></small></td>';
                                                        echo '<td class="right"><nobr>';
                                                        if($CONTENT['content_order'] > 1)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt nach oben verschieben" class="reorder tt" href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/' . $CONTENT['content_order'] . '/up/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach oben verschieben"><span class="glyphicon glyphicon-arrow-up"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        if($CONTENT['content_order'] < $CONTENT_COUNTER)
                                                        {                                                    
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt nach unten verschieben" class="reorder tt" href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/' . $CONTENT['content_order'] . '/down/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach unten verschieben"><span class="glyphicon glyphicon-arrow-down"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        if($CONTENT['content_active'] == 0)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt aktivieren" class="activator tt" href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/activate/"><button type="button" class="btn btn-danger btn-xs" title="deaktiviert und unsichtbar"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        else
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt deaktivieren" class="activator tt" href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/deactivate/"><button type="button" class="btn btn-success btn-xs" title="aktiviert und sichtbar"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt bearbeiten" class="editer tt" href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/edit/"><button type="button" class="btn btn-success btn-xs" title="Inhalt bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                        echo '&#160;';
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Diesen Inhalt l&ouml;schen" class="deleter tt" href="' . _BASE_URL . '/constructr/content/' . $PAGE_ID . '/' . $CONTENT['content_id'] . '/' . $CONTENT['content_order'] .  '/delete/" title="Inhalt l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
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
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <p><small><a href="<?php echo _BASE_URL ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/content/<?php echo $PAGE_ID; ?>/">Inhalte - &Uuml;bersicht</a></small></p>
                                <p><small>Version: <?php echo _VERSION; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo _BASE_URL ?>/Assets/jquery-2-1-0.min.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="<?php echo _BASE_URL;?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo _BASE_URL;?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        $('.tt').tooltip();

                        $("#menu-toggle").click(function(e)
                            {
                                e.preventDefault();
                                $("#wrapper").toggleClass("active");
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