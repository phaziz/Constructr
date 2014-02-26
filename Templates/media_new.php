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
            <link href="<?php echo _BASE_URL;?>/Assets/jasny-bootstrap-3.1.0-dist/css/jasny-bootstrap.min.css" rel="stylesheet">
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
                                <li><a href="<?php echo _BASE_URL ?>/admin/media/"><span class="glyphicon glyphicon-camera"></span> &Uuml;bersicht</a></li>
                                <li class="active"><a href="<?php echo _BASE_URL ?>/admin/media/new/"><span class="glyphicon glyphicon-log-in"></span> Neuer Upload</a></li>
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
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/media/">Medienverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/media/new/">Medienverwaltung - Neuer Upload</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                            <h2>Neuer Upload</h2>
                            <br><br>
                            <form role="form" name="new_media_form" id="new_media_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Datei ausw&auml;hlen</span><span class="fileinput-exists">Datei austauschen</span><input type="file" name="fileupload" id="fileupload"></span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Datei entfernen</a>
                                    </div>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">Upload speichern&#8250;&#8250;</button>
                                        <a href="<?php echo _BASE_URL . '/admin/media/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                    </div>
                                </div>
                            </form>
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/media/">Medienverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/media/new/">Medienverwaltung - Neuer Upload</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                        <p><small>Version: <?php echo _VERSION; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div><!-- // EOF CONTAINER -->
            <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
            <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo _BASE_URL;?>/Assets/jasny-bootstrap-3.1.0-dist/js/jasny-bootstrap.min.js"></script>
            <script>
                $(function () {
                    'use strict';
                        $( "#new_media_form" ).bind( "submit", function()
                            {
                                $("#submitter").attr("disabled", "disabled");
                                var F = $('#fileupload').val();
                                if(F == ''){
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Bitte eine Datei ausw&auml;hlen!',
                                            afterClose: function() {
                                                $('#fileupload').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        ); // EOF BIND NEW PAGE FORM

                });
            </script>
        </body>
    </html>