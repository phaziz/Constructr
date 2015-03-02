<?php

/**
 * Constructr CMS TemplateFile create a new Backend-User-Account.
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
 * @version 1.04.5 / 02.03.2015
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
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/new" title="Neuer Benutzer" data-toggle="tooltip" data-placement="right"><small>Neuer Benutzer</small></a></li>
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/new/">Neuer Benutzer</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?></h1>
                                    <h2>Einen neuen Benutzer anlegen</h2>
                                    <br><br>
                                    <form role="form" name="new_user_form" id="new_user_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                        <input type="hidden" name="user_form_guid" value="<?php echo $GUID; ?>">
                                        <input type="hidden" name="art" id="art" value="intern">
                                        <div class="form-group">
                                            <label for="username" class="col-sm-2 control-label">Benutzername:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="username" id="username" placeholder="Benutzername" maxlength="25">
                                                <small><span class="help-block" id="status-username">Bitte vergeben Sie einen eindeutigen Benutzernamen</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label">Passwort:</label>
                                            <div class="col-sm-10 pwd-container">
                                                <input type="password" class="form-control input-sm" name="password" id="password" placeholder="" maxlength="50">
                                                <span class="pwstrength_viewport_verdict"></span>
                                                <small><span class="help-block">Passwort eingeben</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password_retype" class="col-sm-2 control-label">Passwort Wiederholung:</label>
                                            <div class="col-sm-10 pwd-container">
                                                <input type="password" class="form-control input-sm" name="password_retype" id="password_retype" placeholder="" maxlength="50">
                                                <span class="pwstrength_viewport_verdict"></span>
                                                <small><span class="help-block">Passwort bitte erneut eingeben</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">eMail:</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control input-sm" name="email" id="email" placeholder="eMail" maxlength="50">
                                                <small><span class="help-block">Bitte geben Sie eine g&uuml;ltige eMail-Adresse an.</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">Benutzer anlegen &#8250;&#8250;</button>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/new/">Neuer Benutzer</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-pwstrength/dist/pwstrength-bootstrap-1.2.5.min.js"></script>
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

                        $('#username').focus();

                        $('#username').bind('blur', function()
                            {
                                var U = $('#username').val();
                                if(U != '')
                                {
                                    $.get("./check-username/", { username: U })
                                      .done(function( data )
                                        {
                                            if(data != 'jep'){
                                                vex.dialog.alert(
                                                    {
                                                        className: 'vex-theme-flat-attack',
                                                        message: 'Achtung: Bitte w&auml;hlen Sie einen anderen Benutzernamen, der gew&uuml;nschte Benutzername ist bereits vergeben!',
                                                        afterClose: function()
                                                        {
                                                            $('#username').focus();
                                                            $('#status-username').html('<span style="color:#ff0030">Der Benutzername ist bereits vergeben!</span>');
                                                        }
                                                    }
                                                );
                                                return false;
                                            }
                                            else
                                            {
                                                $('#status-username').html('<span style="color:green;">Der Benutzername ist verf&uumlgbar!</span>');
                                            }
                                        }
                                    );
                                }
                            }
                        );

                        $('#rg-address').hide();

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
                                var NombreHombre = $('#password').val().replace(/[^0-9]/g,'').length;

                                if(L < 8)
                                {
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Das gew&uuml;nschte Passwort ist zu kurz (Mindestens 8 Zeichen)!',
                                            afterClose: function()
                                            {
                                                $('#password').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }

                                if(NombreHombre < 2)
                                {
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Das Passwort muss Ziffern enthalten (Mindestens 2 Ziffern)!',
                                            afterClose: function()
                                            {
                                                $('#password').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }

                                if(A == 'false')
                                {
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                            afterClose: function()
                                            {
                                                $('#art').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }

                                if(U == '' || P == '' || PRT == '' || E == '' || A == '0')
                                {
                                    if(U == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                afterClose: function()
                                                {
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
                                                afterClose: function()
                                                {
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
                                                afterClose: function()
                                                {
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
                                                afterClose: function()
                                                {
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
                                                afterClose: function()
                                                {
                                                    $('#art').focus();
                                                    $("#submitter").removeAttr("disabled");
                                                }
                                            }
                                        );
                                        return false;
                                    }
                                }
                                else
                                {
                                    if(P != PRT)
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Ihre Eingabe im Feld Passwort stimmt nicht mit der Eingabe im Feld Passwort Wiederholung &uuml;berein!',
                                                afterClose: function()
                                                {
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
                        );
                    }
               );

            </script>
        </body>
    </html>