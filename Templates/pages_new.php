<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo _TITLE . ' - ' . $SUBTITLE; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo _BASE_URL;?>/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/css/constructr.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
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
                        <li><a class="tt" href="<?php echo _BASE_URL ?>" onclick="window.open(this.href);return false;" title="Internetseite anzeigen" data-toggle="tooltip" data-placement="right">Internetseite</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li><a class="tt" href="<?php echo _BASE_URL ?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                    <p><small class="trademark">&#160;&#160;&#160;Constructr CMS</small></p>
                    <p><small class="trademark">&#160;&#160;&#160;Version: <?php echo _VERSION; ?><br>&#160;&#160;&#160;<?php echo $TIMER; ?><br>&#160;&#160;&#160;<?php echo $MEM; ?><br>&#160;&#160;&#160;<a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <br>
                                <p><small><a href="<?php echo _BASE_URL ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
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
                                    <h2>Eine neue Seite erstellen</h2>
                                    <br><br>
                                    <form role="form" name="new_page_form" id="new_page_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="page_name" class="col-sm-2 control-label">Name der Seite:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="page_name" id="page_name" placeholder="Name der neuen Seite" maxlength="100">
                                                <small><span class="help-block" id="status-page_name">Bitte vergeben Sie einen eindeutigen Seitennamen</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_url" class="col-sm-2 control-label">URL der neuen Seite:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="page_url" id="page_url" placeholder="URL der neuen Seite" maxlength="100">
                                                <small><span class="help-block" id="status-page_url">Bitte vergeben Sie eine eindeutige URL</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_title" class="col-sm-2 control-label">Seitentitel:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="page_title" id="page_title" placeholder="Seitentitel in Metadaten">
                                                <small><span class="help-block" id="status-page_title">Diese Information wird f&uuml;r die Metadaten ben&ouml;tigt</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_description" class="col-sm-2 control-label">Beschreibung:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="page_description" id="page_description" placeholder="Beschreibung in Metadaten">
                                                <small><span class="help-block" id="status-page_description">Diese Information wird f&uuml;r die Metadaten ben&ouml;tigt</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_keywords" class="col-sm-2 control-label">Schlagworte:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="page_keywords" id="page_keywords" placeholder="Schlagworte in Metadaten">
                                                <small><span class="help-block" id="status-page_keywords">Diese Information wird f&uuml;r die Metadaten ben&ouml;tigt</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">Neue Seite anlegen &#8250;&#8250;</button>
                                                <a href="<?php echo _BASE_URL . '/constructr/pages/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
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
                                <p><small><a href="<?php echo _BASE_URL ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo _BASE_URL ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo _VERSION; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo _BASE_URL ?>/Assets/jquery-2-1-0.min.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        $("#menu-toggle").click(function(e)
                            {
                                e.preventDefault();
                                $("#wrapper").toggleClass("active");
                            }
                        );

                        $('#page_name').focus();

                        $( "#new_page_form" ).bind( "submit", function()
                            {
                                $("#submitter").attr("disabled", "disabled");

                                var U = $('#page_name').val();
                                var P = $('#page_url').val();

                                if(U == '' || P == '' || P == 'admin')
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

                                    if(P == '')
                                    {
                                        vex.dialog.alert(
                                            {
                                                className: 'vex-theme-flat-attack',
                                                message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
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
                            }
                        );
                    }
                );
            </script>
        </body>
    </html>