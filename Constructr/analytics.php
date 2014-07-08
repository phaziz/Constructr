<!DOCTYPE html>
    <html lang="de">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo $_CONSTRUCTR_CONF['_TITLE'] . ' - ' . $SUBTITLE; ?></title>
            <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/css/constructr.css" rel="stylesheet">
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
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/" title="Medienverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Medien</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/media/trash/" title="M&uuml;lleimer anzeigen" data-toggle="tooltip" data-placement="right">M&uuml;lleimer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/user/" title="Benutzerverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Benutzer</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/templates/" title="Templates anzeigen" data-toggle="tooltip" data-placement="right">Templates</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/config/" title="Systemkonfiguration anzeigen" data-toggle="tooltip" data-placement="right">System</a></li>
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/logout/" title="<?php echo $_SESSION['backend-user-username']; ?> abmelden" data-toggle="tooltip" data-placement="right">abmelden</a></li>
                    </ul>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br>
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span></small> <small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/dashboard/analytics/">Analytics</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?></h1>

                                    <!-- // ANALYTICS // -->
                                    <?php

                                        $LOGS_DIR = $_CONSTRUCTR_CONF['_CONSTRUCTR_LOGFILES_PATH'];
                                        $ALL_LOGS = getFilesFromDir($LOGS_DIR);
                                        $ANALYTICS_ARRAY = array();

                                        if($ALL_LOGS)
                                        {
                                            foreach($ALL_LOGS as $ALL_LOGS_KEY => $ALL_LOGS_VALUE)
                                            {
                                                $LOGS_CONTENT = file_get_contents($ALL_LOGS_VALUE);
                                                $LOGS_LINES_ARRAY = explode("\n",$LOGS_CONTENT);

                                                foreach($LOGS_LINES_ARRAY as $KEY => $VALUE)
                                                {
                                                    $pos = strpos($VALUE,'###CONSTRUCTR_ANALYTICS###');

                                                    if ($pos !== false)
                                                    {
                                                        $VALUE = explode('###CONSTRUCTR_ANALYTICS###',$VALUE);                                                        
                                                        $DATA = explode(':::',$VALUE[1]);

                                                        $URI = $DATA[0];
                                                        $TIMESTAMP = $DATA[0];
                                                        $UUID = $DATA[0];
                                                        $BROWSER = $DATA[0];
                                                        $BROWSER_NICKNAME = $DATA[0];
                                                        $BROWSER_VERSION = $DATA[0];
                                                        $BROWSER_HTTP_STRING = $DATA[0];
                                                        $BROWSER_PLATTFORM = $DATA[0];
                                                        $BROWSER_LANGUAGE = $DATA[0];
                                                        $SCREEN_PIXELDEPTH = $DATA[0];
                                                        $SCREEN_COLORDEPTH = $DATA[0];
                                                        $SCREEN_AVAIL_HEIGHT = $DATA[0];
                                                        $SCREEN_AVAIL_WIDTH = $DATA[0];
                                                        $SCREEN_HEIGHT = $DATA[0];
                                                        $SCREEN_WIDTH = $DATA[0];

                                                        $ANALYTICS_ARRAY[$KEY] = array
                                                        (
                                                            'uri' => $DATA[0],
                                                            'referrer' => $DATA[15],
                                                            'timestamp' => $DATA[1],
                                                            'date_day' => $datum = date("d",$DATA[1]),
                                                            'date_month' => $datum = date("m",$DATA[1]),
                                                            'date_year' => $datum = date("Y",$DATA[1]),
                                                            'date_hour' => $datum = date("H",$DATA[1]),
                                                            'date_minutes' => $datum = date("m",$DATA[1]),
                                                            'date_seconds' => $datum = date("s",$DATA[1]),
                                                            'uuid' => $DATA[2],
                                                            'browser' => $DATA[3],
                                                            'browser_nickname' => $DATA[4],
                                                            'browser_version' => $DATA[5],
                                                            'browser_http_string' => $DATA[6],
                                                            'plattform' => $DATA[7],
                                                            'language' => $DATA[8],
                                                            'pixeldepth' => $DATA[9],
                                                            'colordepth' => $DATA[10],
                                                            'avail_height' => $DATA[11],
                                                            'avail_width' => $DATA[12],
                                                            'screen_height' => $DATA[13],
                                                            'screen_width' => $DATA[14]
                                                        );
                                                    }
                                                }

                                                if($ANALYTICS_ARRAY)
                                                {
                                                    echo '<pre>';
                                                    var_dump($ANALYTICS_ARRAY);
                                                    echo '</pre>';
                                                }
                                            }
                                        }

                                    ?>
                                    <!-- // ANALYTICS // -->

                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span></small> <small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/dashboard/analytics/">Analytics</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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