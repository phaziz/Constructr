<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo $_CONSTRUCTR_CONF['_TITLE'] . ' - ' . $SUBTITLE; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/css/constructr.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/css/datatables.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
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
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>" onclick="window.open(this.href);return false;" title="Internetseite anzeigen" data-toggle="tooltip" data-placement="right">Internetseite</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/config/" title="Systemkonfiguration anzeigen" data-toggle="tooltip" data-placement="right">System</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <br>
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                                                    if($_GET['res'] == 'create-page-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die neue Seite wurde ohne Fehler erstellt.</div>';
                                                    }
                                                    else if($_GET['res'] == 'create-page-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim anlegen der Seite aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'activate-page-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite ist nun im Frontend sichtbar/unsichtbar.</div>';
                                                    }
                                                    else if($_GET['res'] == 'create-page-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim aktivieren/deaktivieren der Seite aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'edit-page-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich bearbeitet.</div>';
                                                    }
                                                    else if($_GET['res'] == 'edit-page-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim bearbeiten der Seite aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'del-single-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich entfernt.</div>';
                                                    }
                                                    else if($_GET['res'] == 'del-single-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim l&ouml;schen der Seite aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'del-recursive-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite(n) wurde erfolgreich rekursiv entfernt.</div>';
                                                    }
                                                    else if($_GET['res'] == 'del-recursive-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim rekursiven l&ouml;schen der Seite(n) aufgetreten.</div>';
                                                    }
                                                    if($_GET['res'] == 'content-not-empty')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Es existieren noch Inhalte auf dieser Seite!</div>';
                                                    }
                                                    if($_GET['res'] == 'url-exists')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Gew&uuml;nschte URL existiert bereits!</div>';
                                                    }
                                                    if($_GET['res'] == 'reorder-error')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler bei der Sortierung aufgetreten. Bitte diese Seite neu laden!</div>';
                                                    }
                                                    if($_GET['res'] == 'reorder-success')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich verschoben.</div>';
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
                                    <h1><?php echo $SUBTITLE; ?></h1>
                                    <h2><?php echo $PAGES_COUNTR; ?> Angelegte Seiten <a data-toggle="tooltip" data-placement="top" title="Neue Seite erstellen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neue Seite"><span class="glyphicon glyphicon-plus"></span></button></a></h2>
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
                                                if($PAGES){
                                                    foreach ($PAGES as $PAGE)
                                                    {
                                                        echo '<tr>';
                                                        echo '<td>';
                                                        if($PAGE['pages_level'] >= 2)
                                                        {
                                                            for($i = 1; $i <= $PAGE['pages_level']; $i++)
                                                            {
                                                                echo '&#160;&#160;';
                                                            }
                                                        }
                                                        echo '<a class="tt" data-toggle="tooltip" data-placement="top" title="Inhalte von Seite ' . $PAGE['pages_name'] . ' bearbeiten" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE['pages_id'] . '/" title="Inhalte von Seite ' . $PAGE['pages_name'] . ' bearbeiten">' . $PAGE['pages_name'] . '</a></td>';
                                                        echo '<td><small><a class="tt" data-toggle="tooltip" data-placement="top" title="Seite im Browser anzeigen" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/' . $PAGE['pages_url'] . '" onclick="window.open(this.href);return false;">' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/' . $PAGE['pages_url'] . '</a></small></td>';
                                                        echo '<td><small>' . $PAGE['pages_template'] . '</small></td>';
                                                        echo '<td class="right"><nobr>';
                                                        if($PAGE['pages_lft'] != 1 && $PAGE['pages_upper'] != 0)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Seite nach oben verschieben" class="reorder tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/reorder/up/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach oben verschieben"><span class="glyphicon glyphicon-arrow-up"></span></button></a>';
                                                            echo '&#160;';                                                    
                                                        }
                                                        if($PAGE['pages_lower'] != 0)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Seite nach unten verschieben" class="reorder tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/reorder/down/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach unten verschieben"><span class="glyphicon glyphicon-arrow-down"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        if($PAGE['pages_active'] == 0)
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Seite aktivieren" class="activator tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/activate/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-danger btn-xs" title="deaktiviert und unsichtbar"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        else
                                                        {
                                                            echo '<a data-toggle="tooltip" data-placement="top" title="Seite deaktivieren" class="activator tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/deactivate/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-success btn-xs" title="aktiviert und sichtbar"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                            echo '&#160;';
                                                        }
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Neue Unterseite erstellen" class="new_sub tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/new/sub/' . $PAGE['pages_id'] . '/' . $PAGE['pages_lft'] . '/"><button type="button" class="btn btn-warning btn-xs" title="Neue Unterseite erstellen"><span class="glyphicon glyphicon-plus"></span></button></a>';
                                                        echo '&#160;';
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Inhalte von Seite ' . $PAGE['pages_name'] . ' bearbeiten" class="editercontent tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-info btn-xs" title="Inhalte von Seite ' . $PAGE['pages_name'] . ' bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                        echo '&#160;';
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Seite ' . $PAGE['pages_name'] . ' bearbeiten" class="editer tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/edit/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-success btn-xs" title="Seite ' . $PAGE['pages_name'] . ' bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                        echo '&#160;';
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Diese Seite l&ouml;schen" class="deleter-single tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/delete-single/' . $PAGE['pages_id'] . '/' . $PAGE['pages_lft'] . '/' . $PAGE['pages_rgt'] . '/" title="Seite l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                        echo '&#160;';
                                                        echo '<a data-toggle="tooltip" data-placement="top" title="Diese Seite rekursiv l&ouml;schen" class="deleter-recursive tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/pages/delete-recursive/' . $PAGE['pages_id'] . '/' . $PAGE['pages_lft'] . '/' . $PAGE['pages_rgt'] . '/" title="Seite rekursiv l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle"></span></button></a>';
                                                        echo '</nobr></td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                else
                                                {
                                                    echo '<tr><td colspan="7">Keine Seiten gefunden!</td></tr>';
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/vex/js/vex.combined.min.js"></script>
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
                                    { "sWidth": "30%", "bSortable":false},
                                    { "sWidth": "30%", "bSortable":false},
                                    { "sWidth": "20%", "bSortable":false},
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
                                        message: 'Seite wirklich verschieben?',
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

                        $('.deleter-single').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack', 
                                        message: 'M&ouml;chten Sie wirklich diese Seite l&ouml;schen?',
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