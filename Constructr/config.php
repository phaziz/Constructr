<!DOCTYPE html>
    <html lang="de">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo $_CONSTRUCTR_CONF['_TITLE'] . ' - ' . $SUBTITLE; ?></title>
            <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
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

                            if($_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] != '')
                            {
                                ?>
                                    <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Statische Internetseiten anzeigen" data-toggle="tooltip" data-placement="right">FTP-Seiten</a></li>        
                                <?php   
                            }

                        ?>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] ?>" onclick="window.open(this.href);return false;" title="Vorschau dynamische Internetseiten" data-toggle="tooltip" data-placement="right">Vorschau</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/config/" title="Systemkonfiguration anzeigen" data-toggle="tooltip" data-placement="right">System</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <br>
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/config/">Systemkonfiguration</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?></h1>
                                    <h2>Aktuelle Systemkonfiguration</h2>
                                    <br><br>
                                    <?php
                                        if($_CONSTRUCTR_CONF)
                                        {
                                            ?>
                                                <form role="form" name="config_form" id="config_form" action="" method="" enctype="" class="form-horizontal">
                                                    <?php
                                                        foreach($_CONSTRUCTR_CONF as $KEY => $VALUE)
                                                        {
                                                            if($VALUE == '1')
                                                            {
                                                                $VALUE = 'true';
                                                            }

                                                            if($VALUE == '0')
                                                            {
                                                                $VALUE = 'false';
                                                            }

                                                            if($VALUE == '')
                                                            {
                                                                $VALUE = 'Wert ist leer, oder nicht vorhanden!';
                                                            }

                                                            ?>
                                                                <div class="form-group">
                                                                    <label for="<?php echo $KEY; ?>" class="col-sm-3 control-label"><?php echo $KEY; ?>:</label>
                                                                    <div class="col-sm-9">
                                                                        <input readonly="readonly" type="text" class="form-control input-sm" name="<?php echo $KEY; ?>" id="<?php echo $KEY; ?>" value="<?php echo $VALUE; ?>" maxlength="100">
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </form>
                                            <?php
                                        }
                                        else
                                        {
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/config/">Systemkonfiguration</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        $("#menu-toggle").click(function(e)
                            {
                                e.preventDefault();
                                $("#wrapper").toggleClass("active");
                            }
                        );
                    }
                );
            </script>
        </body>
    </html>