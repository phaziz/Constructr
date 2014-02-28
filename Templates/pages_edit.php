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
                    <a class="navbar-brand" href="<?php echo _BASE_URL ?>/admin/">ConstructrCMS</a>
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
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <div class="jumbotron">
                            <h2>Seite bearbeiten</h2>
                            <br><br>
                            <?php
                                if($PAGE)
                                {
                                    ?>
                                        <form role="form" name="new_page_form" id="new_page_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                            <input type="hidden" name="page_id" id="page_id" value="<?php echo $PAGE['pages_id']; ?>" maxlength="100">
                                            <div class="form-group">
                                                <label for="page_name" class="col-sm-2 control-label">Name der Seite:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_name" id="page_name" value="<?php echo $PAGE['pages_name']; ?>" placeholder="Name der neuen Seite" maxlength="100">
                                                    <small><span class="help-block" id="status-page_name">Bitte vergeben Sie einen eindeutigen Seitennamen</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="page_url" class="col-sm-2 control-label">URL der neuen Seite:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_url" id="page_url" value="<?php echo $PAGE['pages_url']; ?>" placeholder="URL der neuen Seite" maxlength="100">
                                                    <small><span class="help-block" id="status-page_url">Bitte vergeben Sie eine eindeutige URL</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="page_title" class="col-sm-2 control-label">Seitentitel:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_title" id="page_title" value="<?php echo $PAGE['pages_title']; ?>" placeholder="Seitentitel in Metadaten">
                                                    <small><span class="help-block" id="status-page_title">Diese Information wird f&uuml;r die Metadaten ben&ouml;tigt</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="page_description" class="col-sm-2 control-label">Beschreibung:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_description" id="page_description" value="<?php echo $PAGE['pages_description']; ?>" placeholder="Beschreibung in Metadaten">
                                                    <small><span class="help-block" id="status-page_description">Diese Information wird f&uuml;r die Metadaten ben&ouml;tigt</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="page_keywords" class="col-sm-2 control-label">Schlagworte:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_keywords" id="page_keywords" value="<?php echo $PAGE['pages_keywords']; ?>" placeholder="Schlagworte in Metadaten">
                                                    <small><span class="help-block" id="status-page_keywords">Diese Information wird f&uuml;r die Metadaten ben&ouml;tigt</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                                <div class="col-sm-10">
                                                    <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">&Auml;nderungen speichern &#8250;&#8250;</button>
                                                    <a href="<?php echo _BASE_URL . '/admin/pages/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                                </div>
                                            </div>
                                        </form>
                                    <?php
                                } else {
                                    echo '<p>Fehler bei der Daten&uuml;bergabe!</p>';
                                }
                            ?>
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
            <script src="<?php echo _BASE_URL ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        'use strict';
                        $('body').on('mouseover', '.dropdown-toggle', function(e){
                            $(e.currentTarget).trigger('click')
                        })
                        $('#page_name').focus();
                        $( "#new_page_form" ).bind( "submit", function()
                            {
                                $("#submitter").attr("disabled", "disabled");
                                var U = $('#page_name').val();
                                var P = $('#page_url').val();
                                if(U == '' || P == ''){
                                    if(U == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function() {
                                                    $('#page_name').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                    if(P == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function() {
                                                    $('#page_url').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                    return true;
                                }
                            }
                        ); // EOF BIND NEW PAGE FORM
                    }
                );
            </script>
        </body>
    </html>