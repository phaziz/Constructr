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
                    <a class="navbar-brand" href="<?php echo _BASE_URL ?>/constructr/">ConstructrCMS</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Seitenverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>" onclick="window.open(this.href);return false;"><span class="glyphicon glyphicon-eye-open"></span> Internetseite anzeigen</a></li>
                                <li><a href="<?php echo _BASE_URL ?>/constructr/pages/"><span class="glyphicon glyphicon-th-large"></span> &Uuml;bersicht</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Medienverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/constructr/media/"><span class="glyphicon glyphicon-camera"></span> &Uuml;bersicht</a></li>
                                <li><a href="<?php echo _BASE_URL ?>/constructr/media/new/"><span class="glyphicon glyphicon-log-in"></span> Neuer Upload</a></li>
                            </ul>
                        </li>
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzerverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="active"><a href="<?php echo _BASE_URL ?>/constructr/user/"><span class="glyphicon glyphicon-user"></span> &Uuml;bersicht</a></li>
                                <li><a href="<?php echo _BASE_URL ?>/constructr/user/new/"><span class="glyphicon glyphicon-pencil"></span> Neuer Benutzer</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $USERNAME; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/constructr/logout/"><span class="glyphicon glyphicon-off"></span> abmelden</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <p><small><a href="<?php echo _BASE_URL ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <div class="jumbotron">
                            <h2><?php echo $COUNTR; ?> Angelegte Benutzer <a data-toggle="tooltip" data-placement="top" title="Neuen Benutzer anlegen" class="tt" href="<?php echo _BASE_URL . '/constructr/user/new/'; ?>"><button type="button" class="btn btn-info btn-sm" title="Neuer Benutzer"><span class="glyphicon glyphicon-plus"></span></button></a></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="center">Kennung</th>
                                        <th>Benutzername</th>
                                        <th>Art</th>
                                        <th>eMail</th>
                                        <th class="center">Letzte Anmeldung</th>
                                        <th class="center">Aktionen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($BACKENDUSER)
                                        {
                                            foreach ($BACKENDUSER as $USER)
                                            {
                                                echo '<tr>';
                                                echo '<td class="center">' . $USER['beu_id'] . '</td>';
                                                echo '<td>' . $USER['beu_username'] . '</td>';
                                                if($USER['beu_art'] != 1)
                                                {
                                                    echo '<td class="center">intern</td>';                                                
                                                }
                                                else
                                                {
                                                    echo '<td class="center">extern</td>';
                                                }
                                                echo '<td>' . $USER['beu_email'] . '</td>';
                                                if($USER['beu_last_login'] != '0000-00-00 00:00:00')
                                                {
                                                    echo '<td class="center">' . date("d.m.Y, H:i", strtotime(substr($USER['beu_last_login'], 0, 18))) . ' Uhr</td>';                                                
                                                }
                                                else
                                                {
                                                    echo '<td class="center">./.</td>';
                                                }
                                                echo '<td class="center">';                                            
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Benutzer bearbeiten" class="tt user-editer" href="' . _BASE_URL . '/constructr/user/edit/' . $USER['beu_id'] . '/"><button type="button" class="btn btn-primary btn-xs" title="Editieren"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                if($USER['beu_active'] == 1)
                                                {
                                                    echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzer deaktivieren" class="tt status-updater" href="' . _BASE_URL . '/constructr/user/set-inactive/' . $USER['beu_id'] . '/"><button type="button" class="btn btn-warning btn-xs" title="Deaktivieren"><span class="glyphicon glyphicon-star-empty"></span></button></a>';
                                                }
                                                else
                                                {
                                                    echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzer aktivieren" class="tt status-updater" href="' . _BASE_URL . '/constructr/user/set-active/' . $USER['beu_id'] . '/"><button type="button" class="btn btn-success btn-xs" title="Aktivieren"><span class="glyphicon glyphicon-star"></span></button></a>';
                                                }
                                                echo '&#160;&#160;<a data-toggle="tooltip" data-placement="top" title="Benutzer l&ouml;schen" class="user-deleter tt" href="' . _BASE_URL . '/constructr/user/delete/' . $USER['beu_id'] . '/"><button type="button" class="btn btn-danger btn-xs" title="Entfernen"><span class="glyphicon glyphicon-remove-circle"></span></button></a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
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
                        <p><small><a href="<?php echo _BASE_URL ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                        $('body').on('mouseover', '.dropdown-toggle', function(e)
                            {
                                $(e.currentTarget).trigger('click')
                            }
                        )
                        $('.datatable').dataTable(
                            {
                                "aaSorting": [[ 1,"asc"]],
                                "aoColumns": [
                                    { "sWidth": "8%", "bSortable":true},
                                    { "sWidth": "39%", "bSortable":true},
                                    { "sWidth": "8%", "bSortable":true},
                                    { "sWidth": "20%", "bSortable":true},
                                    { "sWidth": "15%", "bSortable":true},
                                    { "sWidth": "15%", "bSortable":false}
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
                       $('.status-updater').click(function(e)
                           {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    { 
                                        className: 'vex-theme-flat-attack', 
                                        message: 'Soll der Benutzerstatus wirklich ge&auml;ndert werden? Achtung: Diese &Auml;nderung wird sofort wirksam!',
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
                       $('.user-editer').click(function(e)
                       {
                            e.preventDefault();
                            var U = $(this).attr('href');
                            vex.dialog.buttons.YES.text = 'Ja';
                            vex.dialog.buttons.NO.text = 'Abbrechen';
                            vex.dialog.confirm(
                                {
                                    className: 'vex-theme-flat-attack', 
                                    message: 'Soll der Benutzer wirklich ge&auml;ndert werden?',
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
                )
            </script>
        </body>
    </html>