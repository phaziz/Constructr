<?php

/**
 * Constructr CMS TemplateFile Configuration Table.
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
 * @version 1.04.6 / 05.03.2015
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
	                <li><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/" title="Uploads anzeigen">Uploads</a></li>
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
						<ul class="nav nav-pills">
							<li role="presentation"><a href="http://phaziz.com" target="_blank">ConstructrCMS</a></li>
							<li role="presentation"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a></li>
							<li role="presentation" class="active"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/config/">Systemkonfiguration</a></li>
						</ul>
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
                            <h2>Aktuelle Systemkonfiguration</h2>
                            <br><br>

                            <?php

                                if ($_CONSTRUCTR_CONF) {

                            ?>

							<form role="form" name="config_form" id="config_form" class="form-horizontal">

                            <?php

                                foreach ($_CONSTRUCTR_CONF as $KEY => $VALUE) {
                                    if ($VALUE == '1') {
                                        $VALUE = 'true';
                                    }

                                    if ($VALUE == '0') {
                                        $VALUE = 'false';
                                    }

                                    if ($VALUE == '') {
                                        $VALUE = 'Wert ist leer, oder nicht vorhanden!';
                                    }

							?>

                            <div class="form-group">
                                <label for="<?php echo $KEY; ?>" class="col-sm-3 control-label"><small><?php echo $KEY; ?></small>:</label>
                                <div class="col-sm-9">
                                    <input readonly="readonly" type="text" class="form-control input-sm" name="<?php echo $KEY; ?>" id="<?php echo $KEY; ?>" value="<?php echo $VALUE; ?>" maxlength="100">
                                </div>
                            </div>

                            <?php

                            	}

                            ?>

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
                        <p class="center"><small><a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a>, Version <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> vom <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?></small></p>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.min.js"></script>
            <script>

                $(function()
                    {
                        $('.tt').tooltip();
                    }
                );

            </script>
        </body>
    </html>