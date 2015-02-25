<?php

/**
 * Constructr CMS TemplateFile edit a Page Form.
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
 * @version 1.04.5 / 25.02.2015
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
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/codemirror/lib/codemirror.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            <style>
            	.CodeMirror{border:1px solid #666;}
            </style>
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
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?></h1>
                                    <h2>Seite bearbeiten</h2>
                                    <br><br>

                                    <?php

	                                    if ($PAGE) {

                                    ?>

                                    <form role="form" name="new_page_form" id="new_page_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                        <input type="hidden" name="user_form_guid" value="<?php echo $GUID; ?>">
                                        <input type="hidden" name="pages_order" value="<?php echo $PAGE['pages_order']; ?>">
                                        <input type="hidden" name="page_id" id="page_id" value="<?php echo $PAGE['pages_id']; ?>" maxlength="100">
                                        <div class="form-group">
                                            <label for="page_name" class="col-sm-2 control-label">Name der Seite:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="page_name" id="page_name" value="<?php echo $PAGE['pages_name']; ?>" placeholder="Name der neuen Seite" maxlength="100">
                                                <small><span class="help-block" id="status-page_name">Bitte vergeben Sie einen eindeutigen Seitennamen</span></small>
                                            </div>
                                        </div>

                                        <?php

                                            if ($PAGE['pages_order'] == 1) {

                                        ?>
                                            <div class="form-group">
                                                <label for="page_url" class="col-sm-2 control-label">URL der neuen Seite:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_url" id="page_url" value="" placeholder="Startseite ohne URL" maxlength="100" readonly="readonly">
                                                    <small><span class="help-block" id="status-page_url">Bitte vergeben Sie eine eindeutige URL</span></small>
                                                </div>
                                            </div>

                                        <?php

                                            } else {

                                        ?>
                                            <div class="form-group">
                                                <label for="page_url" class="col-sm-2 control-label">URL der neuen Seite:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control input-sm" name="page_url" id="page_url" value="<?php echo $PAGE['pages_url']; ?>" placeholder="URL der neuen Seite" maxlength="100">
                                                    <small><span class="help-block" id="status-page_url">Bitte vergeben Sie eine eindeutige URL</span></small>
                                                </div>
                                            </div>

                                        <?php

                                            }

                                		?>

                                        <div class="form-group">
                                            <label for="page_template" class="col-sm-2 control-label">Template der neuen Seite:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control input-sm" name="page_template" id="page_template">
                                                    <option value="">Bitte w&auml;hlen</option>
                                                    <option value="">- - -</option>

                                                    <?php

                                                        foreach ($TEMPLATES as $TEMPLATE) {
                                                            if ($TEMPLATE != '' && $TEMPLATE != '.' && $TEMPLATE != '..') {
                                                                if ($PAGE['pages_template'] == $TEMPLATE) {
                                                                    echo '<option selected="selected" value="'.$TEMPLATE.'">'.$TEMPLATE.'</option>';
                                                                } else {
                                                                    echo '<option value="'.$TEMPLATE.'">'.$TEMPLATE.'</option>';
                                                                }
                                                            }
                                                        }

		                                            ?>

                                                </select>
                                                <small><span class="help-block" id="status-page_template">Bitte geben Sie dieser Seite ein Template</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_nav_visible" class="col-sm-2 control-label">Sichtbar in Navigation:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control input-sm" name="page_nav_visible" id="page_nav_visible">
                                                    <option value="0">Bitte w&auml;hlen</option>
                                                    <option value="0">- - -</option>

                                                    <?php

                                                        if ($PAGE['pages_nav_visible'] == 1) {
                                                            echo '<option value="1" selected="selected">Sichtbar</option>';
                                                            echo '<option value="0">Unsichtbar</option>';
                                                        } else {
                                                            echo '<option value="1">Sichtbar</option>';
                                                            echo '<option value="0" selected="selected">Unsichtbar</option>';
                                                        }

		                                            ?>

                                                </select>
                                                <small><span class="help-block">Soll die Seite in der Navigation sichtbar sein?</span></small>
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
                                            <label for="page_css" class="col-sm-2 control-label">Seitenspezifisches CSS:</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="50" class="form-control input-sm" name="page_css" id="page_css" placeholder="Seitenspezifisches CSS f&uuml;r diese Seite"><?php echo $PAGE['pages_css']; ?></textarea>
                                                <small><span class="help-block" id="status-page_description">Spezielle CSS-Angaben nur f&uuml;r diese Seite</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_js" class="col-sm-2 control-label">Seitenspezifisches Javascript:</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="50" class="form-control input-sm" name="page_js" id="page_js" placeholder="Seitenspezifisches Javascript f&uuml;r diese Seite"><?php echo $PAGE['pages_js']; ?></textarea>
                                                <small><span class="help-block" id="status-page_description">Spezielle Javascript-Angaben nur f&uuml;r diese Seite</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">&Auml;nderungen speichern &#8250;&#8250;</button>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/pages/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
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
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/codemirror/lib/codemirror.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/codemirror/mode/php/php.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();

                        var editor_css = CodeMirror.fromTextArea(document.getElementById("page_css"),
                            {
                                lineNumbers: true,
                                matchBrackets: true,
                                indentUnit: 4,
                                autofocus: false,
                                mode: 'php'
                            }
                        );

                        var editor_js = CodeMirror.fromTextArea(document.getElementById("page_js"),
                            {
                                lineNumbers: true,
                                matchBrackets: true,
                                indentUnit: 4,
                                autofocus: false,
                                mode: 'php'
                            }
                        );

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

                        $('#page_name').focus();

                        $( "#new_page_form" ).bind( "submit", function()
                            {
                                $("#submitter").attr("disabled", "disabled");

                                var U = $('#page_name').val();
                                var P = $('#page_url').val();
                                var T = $('#page_template').val();

                                <?php
                                    if ($PAGE['pages_order'] == 1) {
                                        ?>
                                            if(U == '' || P == 'constructr' || T == '')
                                            {
                                                if(U == '')
                                                {
                                                    vex.dialog.alert(
                                                        {
                                                            className: 'vex-theme-flat-attack',
                                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                            afterClose: function()
                                                            {
                                                                $('#page_name').focus();
                                                                $("#submitter").removeAttr("disabled");
                                                            }
                                                        }
                                                    );
                                                    return false;
                                                }

                                                if(T == '')
                                                {
                                                    vex.dialog.alert(
                                                        {
                                                            className: 'vex-theme-flat-attack',
                                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                            afterClose: function()
                                                            {
                                                                $('#page_template').focus();
                                                                $("#submitter").removeAttr("disabled");
                                                            }
                                                        }
                                                    );
                                                    return false;
                                                }

                                                if(P == 'constructr')
                                                {
                                                    vex.dialog.alert(
                                                        {
                                                            className: 'vex-theme-flat-attack',
                                                            message: 'Achtung: URL darf nicht "constructr" sein!',
                                                            afterClose: function()
                                                            {
                                                                $('#page_url').focus();
                                                                $("#submitter").removeAttr("disabled");
                                                            }
                                                        }
                                                    );
                                                    return false;
                                                }
                                                return true;
                                            }
                                        <?php

                                    } else {
                                        ?>
                                            if(U == '' || P == '' || P == 'constructr' || T == '')
                                            {
                                                if(U == '')
                                                {
                                                    vex.dialog.alert(
                                                        {
                                                            className: 'vex-theme-flat-attack',
                                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                            afterClose: function()
                                                            {
                                                                $('#page_name').focus();
                                                                $("#submitter").removeAttr("disabled");
                                                            }
                                                        }
                                                    );
                                                    return false;
                                                }

                                                if(T == '')
                                                {
                                                    vex.dialog.alert(
                                                        {
                                                            className: 'vex-theme-flat-attack',
                                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                                            afterClose: function()
                                                            {
                                                                $('#page_template').focus();
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
                                                            message: 'Achtung: URL darf nicht leer sein und nicht "constructr"!',
                                                            afterClose: function()
                                                            {
                                                                $('#page_url').focus();
                                                                $("#submitter").removeAttr("disabled");
                                                            }
                                                        }
                                                    );
                                                    return false;
                                                }
                                                return true;
                                            }
                                        <?php

                                    }
                                ?>

                            }
                        );
                    }
                );

            </script>
        </body>
    </html>