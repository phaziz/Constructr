<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo $_CONSTRUCTR_CONF['_TITLE'] . ' - ' . $SUBTITLE; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/css/constructr.css" rel="stylesheet">
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
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>" onclick="window.open(this.href);return false;" title="Internetseite anzeigen" data-toggle="tooltip" data-placement="right">Internetseite</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/config/" title="Systemkonfiguration anzeigen" data-toggle="tooltip" data-placement="right">System</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <br>
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php
                            if(isset($_GET['created-static']) && $_GET['created-static'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <?php
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die statischen Internetseiten wurden generiert!</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($_GET['created-static']) && $_GET['created-static'] == 'false')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <?php
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim generieren der statischen Seiten aufgetreten.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if(isset($_GET['optimized']) && $_GET['optimized'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <?php
                                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die einzelnen Datenbanktabellen wurden optimiert.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            else if(isset($_GET['no-rights']) && $_GET['no-rights'] == 'true')
                            {
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <?php
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es fehlen die Zugriffsrechte f&uuml;r dieses Modul.</div>';
                                            ?>
                                        </div><!-- // EOF COL-... -->
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                            if($SEARCHR)
                            {
                                ?>
                                    <div class="row">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <div class="jumbotron">
                                                <h1><?php echo $SUBTITLE; ?></h1>
                                                <h2><?php echo $SEARCHR_COUNTR; ?> Suchergebniss(e) wurden gefunden:</h2>
                                                <br>
                                                <?php
                                                    foreach($SEARCHR AS $SEARCHR_KEY => $SEARCHR_VALUE)
                                                    {
                                                        echo '<a href="' . $SEARCHR_VALUE['result_link'] . '">' . $SEARCHR_VALUE['name'] . '</a><br><br>';
                                                    }
                                                ?>
                                            </div><!-- // EOF JUMBOTRON... -->
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
                                    <h1><?php echo $SUBTITLE; ?></h1>
                                    <h2>Suche:</h2>
                                    <br>
                                    <form class="form-inline" role="form" name="needle_form" id="needle_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>">
                                        <input type="hidden" id="user_form_guid" name="user_form_guid" value="<?php echo $GUID; ?>">
                                        <div class="col-lg-10">
                                            <input type="text" style="width:100%;" class="form-control input-sm" id="needles" name="needles" placeholder="Suchbegriffe durch Leerstellen getrennt eingeben">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" id="search-submittr" style="width:100%;" class="btn btn-info btn-sm">Suche starten</button>
                                        </div>
                                    </form>
                                    <br><br>
                                    <?php
                                        if($_SERVE_STATIC == true)
                                        {
                                            ?>
                                                <br>
                                                <h2>Generierung statischer Internetseiten:</h2>
                                                <br>
                                                <ul class="list-group">
                                                      <li class="list-group-item">
                                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/generate-static/<?php echo $GUID ?>/" title="Statische Internetseiten jetzt generieren">Statische Internetseiten jetzt generieren</a>
                                                      </li>
                                                </ul>
                                                <br>
                                            <?php
                                        }
                                    ?>
                                    <h2>Seiten, Uploads &amp; Benutzer:</h2>
                                    <?php
                                        if($PAGES_COUNTR || $BACKEND_USER_COUNTR || $UPLOADS_COUNTR)
                                        {
                                            ?>
                                                <br>
                                                <ul class="list-group">
                                                      <li class="list-group-item">
                                                            <span class="badge"><?php echo $PAGES_COUNTR; ?></span>
                                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/pages/" title="Seiten anzeigen">Seiten</a>:
                                                      </li>
                                                      <li class="list-group-item">
                                                            <span class="badge"><?php echo $UPLOADS_COUNTR; ?></span>
                                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/media/" title="Uploads anzeigen">Uploads</a>:
                                                      </li>
                                                      <li class="list-group-item">
                                                            <span class="badge"><?php echo $BACKEND_USER_COUNTR; ?></span>
                                                            <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/user/" title="Benutzer anzeigen">Benutzer</a>:
                                                      </li>
                                                </ul>
                                            <?php
                                        }
                                    ?>
                                    <br>
                                    <h2>Wartung:</h2>
                                    <br>
                                    <ul class="list-group">
                                          <li class="list-group-item">
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/constructr/optimization/<?php echo $GUID ?>/" title="Datenbank optimieren">Datenbank optimieren</a>
                                          </li>
                                          <li class="list-group-item">
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Logfiles/<?php echo date('Ymd'); ?>.txt" title="Logfile anzeigen" onclick="window.open(this.href);return false;">Aktuelles Logfile anzeigen</a>
                                          </li>
                                    </ul>
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script>
                $(function()
                    {
                        $('.tt').tooltip();

                        $('#needle_form').bind('submit',function()
                            {
                                var N = $('#needle').val();
                                if(N == '')
                                {
                                    $('#needle').focus();
                                    return false;
                                }
                            }
                        );

                        $("#menu-toggle").click(function(e)
                            {
                                e.preventDefault();
                                $("#wrapper").toggleClass("active");
                            }
                        );

                        function autoBlinder()
                        {
                            $('.response').fadeOut();
                        }

                        setInterval(autoBlinder,4500);
                    }
                )
            </script>
        </body>
    </html>