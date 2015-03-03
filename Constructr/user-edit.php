<?php

/**
 * Constructr CMS TemplateFile edit an User-Account.
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
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
			<nav class="pushy pushy-left">
	            <ul class="sidebar-nav" id="sidebar">
	
	                <?php
	
	                    if ($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != '') {
	
	                ?>
	
	                    <li><a href="<?php echo $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Statische Internetseiten anzeigen">FTP-Seiten</a></li>
	
	                <?php
	
	                    }
	
	                ?>
	
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Vorschau dynamische Internetseiten">Vorschau</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/" title="Dashboard anzeigen">Dashboard</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/" title="Seitenverwaltung anzeigen">Seiten</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Medienverwaltung anzeigen">Medien</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen">M&uuml;lleimer</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/" title="Benutzerverwaltung anzeigen">Benutzer</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/templates/" title="Templates anzeigen">Templates</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/config/" title="Systemkonfiguration anzeigen">System</a></li>
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden">Logout</a></li>
	            </ul>
			</nav>
            <div class="page-content inset">
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    	<br>
                        <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/edit/<?php echo $BACKENDUSER['beu_id'] ?>/">Benutzer editieren</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    	<br>
                    	<div class="pull-right"><div class="menu-btn tt" title="Navigation ein- oder ausblenden" data-placement="bottom">&#9776; ConstructrCMS&#160;&#160;&#160;</div></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron">
                            <h1><?php echo $SUBTITLE; ?></h1>
                            <h2>Benutzer editieren</h2>
                            <br><br>

                            <?php

                                if ($BACKENDUSER) {

                            ?>

                                <form role="form" name="new_user_form" id="new_user_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                    <input type="hidden" name="user_form_guid" value="<?php echo $GUID; ?>">
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
                                            <input type="password" class="form-control input-sm" name="password" id="password" placeholder="" maxlength="50">
                                            <span class="pwstrength_viewport_verdict"></span>
                                            <small><span class="help-block">Passwort muss neu vergeben werden!</span></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_retype" class="col-sm-2 control-label">Passwort Wiederholung:</label>
                                        <div class="col-sm-10 pwd-container">
                                            <input type="password" class="form-control input-sm" name="password_retype" id="password_retype" placeholder="" maxlength="50">
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
                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/user/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                        </div>
                                    </div>
                                </form>

                            <?php

                                }

                            ?>

                        </div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/">Benutzerverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/edit/<?php echo $BACKENDUSER['beu_id'] ?>/">Benutzer editieren</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                        <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-pwstrength/dist/pwstrength-bootstrap-1.2.5.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.min.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();

                        $('#username').focus();

                        $('#username').bind('blur', function()
                            {
                                var U = $('#username').val();

                                if(U != '')
                                {
                                    $.get("./check-single-username/", { username: U })
                                      .done(function( data )
                                        {
                                            if(data != 'jep')
                                            {
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

                                var NombreHombre = $('#password').val().replace(/[^0-9]/g,'').length;

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