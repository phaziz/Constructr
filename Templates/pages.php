<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo _TITLE . ' - ' . $SUBTITLE; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/css/app.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/datatables-bootstrap3/assets/css/datatables.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <nav class="navbar navbar-inverse navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo _BASE_URL ?>/admin/">Constructr</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">                        
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Seitenverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a href="<?php echo _BASE_URL ?>/admin/pages/"><span class="glyphicon glyphicon-th-large"></span> &Uuml;bersicht</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Medienverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/admin/media/"><span class="glyphicon glyphicon-camera"></span> &Uuml;bersicht</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzerverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/admin/user/"><span class="glyphicon glyphicon-user"></span> &Uuml;bersicht</a></li>
                                <li><a href="<?php echo _BASE_URL ?>/admin/user/new/"><span class="glyphicon glyphicon-pencil"></span> Neuer Benutzer</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $USERNAME; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/admin/logout/"><span class="glyphicon glyphicon-off"></span> abmelden</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <div class="jumbotron">
                            <h1><?php echo $SUBTITLE; ?></h1>
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
                                            if($_GET['res'] == 'create-page-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die neue Seite wurde ohne Fehler erstellt.</div>';
                                            } else if($_GET['res'] == 'create-page-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim anlegen der Seite aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'activate-page-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite ist nun im Frontend sichtbar/unsichtbar.</div>';
                                            } else if($_GET['res'] == 'create-page-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim aktivieren/deaktivieren der Seite aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'edit-page-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich bearbeitet.</div>';
                                            } else if($_GET['res'] == 'edit-page-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim bearbeiten der Seite aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'del-single-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite wurde erfolgreich entfernt.</div>';
                                            } else if($_GET['res'] == 'del-single-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim l&ouml;schen der Seite aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'del-recursive-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite(n) wurde erfolgreich rekursiv entfernt.</div>';
                                            } else if($_GET['res'] == 'del-recursive-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim rekursiven l&ouml;schen der Seite(n) aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'content-not-empty'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Es existieren noch Inhalte auf dieser Seite!</div>';
                                            }
                                            if($_GET['res'] == 'url-exists'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Gew&uuml;nschte URL existiert bereits!</div>';
                                            }
                                            if($_GET['res'] == 'reorder-error'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten. Bitte diese Seite neu laden!</div>';
                                            }
                                            if($_GET['res'] == 'reorder-success'){
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
                            <h2><?php echo $PAGES_COUNTR; ?> Angelegte Seiten <a data-toggle="tooltip" data-placement="top" title="Neue Seite erstellen" class="tt" href="<?php echo _BASE_URL . '/admin/pages/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neue Seite"><span class="glyphicon glyphicon-plus"></span></button></a></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><small>Name</small></th>
                                        <th><small>Alias (URL)</small></th>
                                        <th class="center"><small>Datum</small></th>
                                        <th class="center"><small>Aktionen</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($PAGES){
                                            foreach ($PAGES as $PAGE)
                                            {
                                                echo '<tr>';
                                                echo '<td><small>';
                                                    if($PAGE['pages_level'] >= 2)
                                                    {
                                                        for($i = 1; $i <= $PAGE['pages_level']; $i++)
                                                        {
                                                            echo '&#160;&#160;&#160;';
                                                        }
                                                    }
                                                echo '<strong><a href="' . _BASE_URL . '/content/' . $PAGE['pages_id'] . '/" title="Inhalte bearbeiten">' . $PAGE['pages_name'] . '</a></strong></small></td>';
                                                echo '<td><small>' . $PAGE['pages_url'] . '</small></td>';
                                                if($PAGE['pages_datetime'] != '0000-00-00 00:00:00'){
                                                    echo '<td class="center"><small>' . date("d.m.Y, H:i", strtotime(substr($PAGE['pages_datetime'], 0, 18))) . ' Uhr</small></td>';                                                
                                                } else {
                                                    echo '<td class="center"><small>./.</small></td>';
                                                }
                                                echo '<td class="right">';
                                                
                                                if($PAGE['pages_lft'] != 1 && $PAGE['pages_upper'] != 0)
                                                {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite nach oben verschieben" class="reorder tt" href="' . _BASE_URL . '/admin/pages/reorder/up/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach oben verschieben"><span class="glyphicon glyphicon-arrow-up"></span></button></a>';
                                                    echo '&#160;';                                                    
                                                }
                                                if($PAGE['pages_lower'] != 0){
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite nach unten verschieben" class="reorder tt" href="' . _BASE_URL . '/admin/pages/reorder/down/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach unten verschieben"><span class="glyphicon glyphicon-arrow-down"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                if($PAGE['pages_active'] == 0){
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite aktivieren" class="activator tt" href="' . _BASE_URL . '/admin/pages/activate/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-danger btn-xs" title="deaktiviert und unsichtbar"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                    echo '&#160;';
                                                } else {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Seite deaktivieren" class="activator tt" href="' . _BASE_URL . '/admin/pages/deactivate/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-success btn-xs" title="aktiviert und sichtbar"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Neue Unterseite erstellen" class="new_sub tt" href="' . _BASE_URL . '/admin/pages/new/sub/' . $PAGE['pages_id'] . '/' . $PAGE['pages_lft'] . '/"><button type="button" class="btn btn-warning btn-xs" title="Neue Unterseite erstellen"><span class="glyphicon glyphicon-plus"></span></button></a>';
                                                echo '&#160;';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Seite bearbeiten" class="editer tt" href="' . _BASE_URL . '/admin/pages/edit/' . $PAGE['pages_id'] . '/"><button type="button" class="btn btn-success btn-xs" title="Seite bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                echo '&#160;';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Diese Seite l&ouml;schen" class="deleter-single tt" href="' . _BASE_URL . '/admin/pages/delete-single/' . $PAGE['pages_id'] . '/' . $PAGE['pages_lft'] . '/' . $PAGE['pages_rgt'] . '/" title="Seite l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                echo '&#160;';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Diese Seite rekursiv l&ouml;schen" class="deleter-recursive tt" href="' . _BASE_URL . '/admin/pages/delete-recursive/' . $PAGE['pages_id'] . '/' . $PAGE['pages_lft'] . '/' . $PAGE['pages_rgt'] . '/" title="Seite rekursiv l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle"></span></button></a>';
                                                echo '</td>';
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
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                        <p><small>Version: <?php echo _VERSION; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div><!-- // EOF CONTAINER -->
            <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
            <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
            <script src="<?php echo _BASE_URL;?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo _BASE_URL;?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        'use strict';
                        $('.tt').tooltip();
                        $('body').on('mouseover', '.dropdown-toggle', function(e){
                            $(e.currentTarget).trigger('click')
                        })
                        function autoBlinder(){$('.response').fadeOut();}
                        setInterval(autoBlinder,4500);
                        // DATATABLES
                        $('.datatable').dataTable({
                            "aaSorting": [],
                            "aoColumns": [
                                { "sWidth": "40%", "bSortable":false},
                                { "sWidth": "25%", "bSortable":false},
                                { "sWidth": "15%", "bSortable":false},
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
                        });
                        $('.datatable').each(function(){
                            var datatable = $(this);
                            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                            search_input.attr('placeholder', 'Suche');
                            search_input.addClass('form-control input-sm');
                            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                            length_sel.addClass('form-control input-sm');
                        });
                       // DATATABELES
                       $('.editer').click(function(e){
                            e.preventDefault();
                            var U = $(this).attr('href');
                            vex.dialog.buttons.YES.text = 'Ja';
                            vex.dialog.buttons.NO.text = 'Abbrechen';
                            vex.dialog.confirm(
                                {
                                    className: 'vex-theme-flat-attack', 
                                    message: 'M&ouml;chten Sie die gew&auml;hlte Seite wirklich bearbeiten?',
                                    callback: function(value)
                                    {
                                        if(value == true){
                                            window.location = (U);
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            );
                       });
                       $('.new_sub').click(function(e){
                            e.preventDefault();
                            var U = $(this).attr('href');
                            vex.dialog.buttons.YES.text = 'Ja';
                            vex.dialog.buttons.NO.text = 'Abbrechen';
                            vex.dialog.confirm(
                                {
                                    className: 'vex-theme-flat-attack', 
                                    message: 'M&ouml;chten Sie wirklich eine neue Unterseite erstellen?',
                                    callback: function(value)
                                    {
                                        if(value == true){
                                            window.location = (U);
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            );
                       });
                       $('.reorder').click(function(e){
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
                                        if(value == true){
                                            window.location = (U);
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            );
                       });
                       $('.deleter-single').click(function(e){
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
                                        if(value == true){
                                            window.location = (U);
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            );
                       });
                       $('.deleter-recursive').click(function(e){
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
                                        if(value == true){
                                            window.location = (U);
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            );
                       });
                       $('.activator').click(function(e){
                            e.preventDefault();
                            var U = $(this).attr('href');
                            vex.dialog.buttons.YES.text = 'Ja';
                            vex.dialog.buttons.NO.text = 'Abbrechen';
                            vex.dialog.confirm(
                                {
                                    className: 'vex-theme-flat-attack', 
                                    message: 'Soll die Sichtbarkeit der Seite wirklich angepasst werden?',
                                    callback: function(value)
                                    {
                                        if(value == true){
                                            window.location = (U);
                                        } else {
                                            return false
                                        }
                                    }
                                }
                            );
                       });
                    }
                );
            </script>
        </body>
    </html>