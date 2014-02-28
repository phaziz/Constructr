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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Seitenverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/admin/pages/"><span class="glyphicon glyphicon-th-large"></span> &Uuml;bersicht</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Medienverwaltung <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo _BASE_URL ?>/admin/media/"><span class="glyphicon glyphicon-camera"></span> &Uuml;bersicht</a></li>
                                <li><a href="<?php echo _BASE_URL ?>/admin/media/new/"><span class="glyphicon glyphicon-log-in"></span> Neuer Upload</a></li>
                            </ul>
                        </li>
                        <li class="dropdown active">
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
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/user/edit/<?php echo $BACKENDUSER['beu_id'] ?>/">Benutzer editieren</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                            <h2>Benutzer editieren</h2>
                            <br><br>
                            <?php
                                if($BACKENDUSER)
                                {
                                    ?>
                                        <form role="form" name="new_user_form" id="new_user_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                            <input type="hidden" name="art" id="art" value="intern">
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label">Benutzername:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="username" id="username" placeholder="Benutzername" value="<?php echo $BACKENDUSER['beu_username']; ?>" maxlength="25">
                                                    <small><span class="help-block" id="status-username">Bitte vergeben Sie einen eindeutigen Benutzernamen</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">Passwort:</label>
                                                <div class="col-sm-10 pwd-container">
                                                    <input type="password" class="form-control input-sm" name="password" id="password" placeholder="" maxlength="25">
                                                    <span class="pwstrength_viewport_verdict"></span>
                                                    <small><span class="help-block">Passwort muss neu vergeben werden!</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_retype" class="col-sm-2 control-label">Passwort Wiederholung:</label>
                                                <div class="col-sm-10 pwd-container">
                                                    <input type="password" class="form-control input-sm" name="password_retype" id="password_retype" placeholder="" maxlength="25">
                                                    <span class="pwstrength_viewport_verdict"></span>
                                                    <small><span class="help-block">Neues Passwort bitte erneut eingeben</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">eMail:</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control input-sm" name="email" id="email" placeholder="eMail" value="<?php echo $BACKENDUSER['beu_email']; ?>" maxlength="50">
                                                    <small><span class="help-block">Bitte geben Sie eine g&uuml;ltige eMail-Adresse an.</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                                <div class="col-sm-10">
                                                    <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">Benutzer speichern &#8250;&#8250;</button>
                                                    <a href="<?php echo _BASE_URL . '/admin/user/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                                </div>
                                            </div>
                                        </form>
                                    <?php
                                }
                            ?>
                        </div>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <p><small><a href="<?php echo _BASE_URL ?>/admin/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/admin/user/edit/<?php echo $BACKENDUSER['beu_id'] ?>/">Benutzer editieren</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                        <p><small>Version: <?php echo _VERSION; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div><!-- // EOF CONTAINER -->
            <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
            <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="<?php echo _BASE_URL ?>/Assets/jquery-pwstrength/examples/pwstrength.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        'use strict';
                        $('body').on('mouseover', '.dropdown-toggle', function(e){
                            $(e.currentTarget).trigger('click')
                        })
                        $('#username').focus();
                        $('#username').bind('blur', function()
                            {
                                var U = $('#username').val();
                                if(U != '')
                                {
                                    $.get("./check-single-username/", { username: U })
                                      .done(function( data )
                                        {
                                            if(data != 'jep'){
                                                vex.dialog.alert(
                                                    {
                                                        className: 'vex-theme-flat-attack',
                                                        message: 'Achtung: Bitte w&auml;hlen Sie einen anderen Benutzernamen, der gew&uuml;nschte Benutzername ist bereits vergeben!',
                                                        afterClose: function() {
                                                            $('#username').focus();
                                                            $('#status-username').html('<span style="color:#ff0030">Der Benutzername ist bereits vergeben!</span>');
                                                        }
                                                    }
                                                );
                                                return false;
                                            } else {
                                                $('#status-username').html('<span style="color:green;">Der Benutzername ist verf&uumlgbar!</span>');
                                            }
                                        }
                                    );
                                }
                            }
                        );
                        var options = {};
                        options.ui = {
                            container: ".pwd-container",
                            showStatus: true,
                            showProgressBar: true,
                            showVerdictsInsideProgressBar: true,
                            verdicts : ["Sehr schwaches Passwort!", "Schwaches Passwort!", "Durchschnittliches Passwort!", "Starkes Passwort!", "Sehr starkes Passwort!"],
                            viewports: {
                                verdict: ".pwstrength_viewport_verdict"
                            }
                        };
                        options.rules = {
                            activated: {
                                wordTwoCharacterClasses: true,
                                wordRepetitions: true
                            }
                        };
                        $(':password').pwstrength(options);
                        $( "#new_user_form" ).bind( "submit", function() 
                            {
                                $("#submitter").attr("disabled", "disabled");
                                var U = $('#username').val();
                                var P = $('#password').val();
                                var PRT = $('#password_retype').val();
                                var E = $('#email').val();
                                var A = $('#art').val();
                                var L = $('#password').val().length;
                                if(L < 8){
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Das gew&uuml;nschte Passwort ist zu kurz (Mindestens 8 Zeichen)!',
                                            afterClose: function() {
                                                $('#password').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }
                                var NombreHombre = $('#password').val().replace(/[^0-9]/g,'').length;
                                if(NombreHombre < 2){
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Das Passwort muss Ziffern enthalten (Mindestens 2 Ziffern)!',
                                            afterClose: function() {
                                                $('#password').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }
                                
                                if(A == 'false'){
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                            afterClose: function() {
                                                $('#art').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }
                                
                                if(U == '' || P == '' || PRT == '' || E == '' || A == '0'){
                                    if(U == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function() {
                                                    $('#username').focus();
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
                                                    $('#password').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                    if(PRT == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function() {
                                                    $('#password_retype').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                    if(E == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function() {
                                                    $('#email').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                    if(A == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function() {
                                                    $('#art').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                } else {
                                    if(P != PRT)
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Ihre Eingabe im Feld Passwort stimmt nicht mit der Eingabe im Feld Passwort Wiederholung &uuml;berein!',
                                                afterClose: function() {
                                                    $('#password').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                    return true;
                                }
                            }
                        ); // EOF BIND NEW USER FORM
                    }
                )
            </script>
        </body>
    </html>