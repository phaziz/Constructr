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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Seitenverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/admin/pages/"><span class="glyphicon glyphicon-th-large"></span> &Uuml;bersicht</a></li>
                            </ul>
                        </li>
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Medienverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a href="<?php echo _BASE_URL ?>/admin/media/"><span class="glyphicon glyphicon-camera"></span> &Uuml;bersicht</a></li>
                                <li><a href="<?php echo _BASE_URL ?>/admin/media/new/"><span class="glyphicon glyphicon-log-in"></span> Neuer Upload</a></li>
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
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/media/">Medienverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                                            if($_GET['res'] == 'create-media-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die Datei wurde ohne Fehler gespeichert.</div>';
                                            } else if($_GET['res'] == 'create-media-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim speichern der Datei aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'del-media-true'){
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Der Upload wurde in den Papierkorb verschoben.</div>';
                                            } else if($_GET['res'] == 'del-media-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim l&ouml;schen des Uploads aufgetreten.</div>';
                                            }
                                            if($_GET['res'] == 'details-media-false'){
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler aufgetreten.</div>';
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
                            <h2><?php echo $MEDIA_COUNTER; ?> Vorhandene Medien <a data-toggle="tooltip" data-placement="top" title="Neuer Uplaod" class="tt" href="<?php echo _BASE_URL . '/admin/media/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neuer Upload"><span class="glyphicon glyphicon-plus"></span></button></a></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="center"><small>Vorschau</small></th>
                                        <th><small>Datei</small></th>
                                        <th><small>Alias</small></th>
                                        <th class="center"><small>Datum</small></th>
                                        <th class="center"><small>Aktionen</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($MEDIA)
                                        {
                                            foreach ($MEDIA as $MEDIA)
                                            {
                                                $FILE_TYPE = strrchr($MEDIA['media_file'],'.');
                                                echo '<tr>';
                                                echo '<td class="center"><img src="' . _BASE_URL . '/' . $MEDIA['media_file'] . '" alt="' . $MEDIA['media_originalname'] . '" height="10%" width=""></td>';
                                                echo '<td><small><strong>' . $MEDIA['media_originalname'] . '</small></td>';
                                                echo '<td><small>' . $MEDIA['media_file'] . '</small></td>';
                                                if($MEDIA['media_datetime'] != '0000-00-00 00:00:00'){
                                                    echo '<td class="center"><small>' . date("d.m.Y, H:i", strtotime(substr($MEDIA['media_datetime'], 0, 18))) . ' Uhr</small></td>';                                                
                                                } else {
                                                    echo '<td class="center"><small>./.</small></td>';
                                                }
                                                echo '<td class="center">';
                                                echo '<a onclick="window.open(this.href);return false;" data-toggle="tooltip" data-placement="top" title="Einfache Vorschau" class="preview tt" href="' . _BASE_URL . '/' . $MEDIA['media_file'] . '"><button type="button" class="btn btn-warning btn-xs" title="Einfache Vorschau"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                echo '&#160;';
                                                if(in_array($FILE_TYPE,$IMAGES)){
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Detail-Vorschau" class="preview tt" href="' . _BASE_URL . '/admin/media/details/' . $MEDIA['media_id'] . '/"><button type="button" class="btn btn-info btn-xs" title="Detail-Vorschau"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Upload l&ouml;schen" class="deleter tt" href="' . _BASE_URL . '/admin/media/delete/' . $MEDIA['media_id'] . '/" title="Upload l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="7">Keine Uploads gefunden!</td></tr>';
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
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/media/">Medienverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                        $('body').on('mouseover', '.dropdown-toggle', function(e){
                            $(e.currentTarget).trigger('click')
                        })
                        function autoBlinder(){$('.response').fadeOut();}
                        // DATATABLES
                        $('.datatable').dataTable({
                            "aaSorting": [],
                            "aoColumns": [
                                { "sWidth": "10%", "bSortable":false},
                                { "sWidth": "30%", "bSortable":true},
                                { "sWidth": "30%", "bSortable":true},
                                { "sWidth": "15%", "bSortable":true},
                                { "sWidth": "15%", "bSortable":false}
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
                        setInterval(autoBlinder,4500);
                        $('.tt').tooltip();
                        $('.deleter').click(function(e){
                            e.preventDefault();
                            var U = $(this).attr('href');
                            vex.dialog.buttons.YES.text = 'Ja';
                            vex.dialog.buttons.NO.text = 'Abbrechen';
                            vex.dialog.confirm(
                                {
                                    className: 'vex-theme-flat-attack', 
                                    message: 'M&ouml;chten Sie diesen Upload wirklich vollst&auml;ndig l&ouml;schen?',
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