<?php

/**
 * Constructr CMS TemplateFile Media Upload Details View.
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
                        <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/">Medienverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/details/<?php echo $MEDIA_ID; ?>/">Detailansicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    	<br>
                    	<div class="pull-right"><div class="menu-btn tt" title="Navigation ein- oder ausblenden" data-placement="bottom">&#9776; ConstructrCMS&#160;&#160;&#160;</div></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->

                <?php

                    if (isset($_GET['details']) && $_GET['details'] == 'updated') {

                ?>

                    <div class="row response">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <?php

                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Die Detailinformationen wurden aktualisiert.</div>';

	                        ?>

                    	</div><!-- // EOF COL-... -->
                    </div><!-- // EOF ROW -->

                <?php

                    }

                ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron">
                            <h1><?php echo $SUBTITLE; ?></h1>
                            <h2>Detailansicht <?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/'.$DETAILS['media_file']; ?> | <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/' ?>" class="tt" data-toggle="tooltip" data-placement="top" title="Zur&uuml;ck zur &Uuml;bersicht">zur&uuml;ck</a></h2>
                            <br><br>

                                <?php

                                    if ($DETAILS) {
                                        echo '<center><img src="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/'.$DETAILS['media_file'].'" style="max-height:500px;max-width:100%"></center>';

                                ?>

                                    <br><br>
                                    <form role="form" name="media_details_form" id="media_details_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="title" class="col-sm-2 control-label">Titel:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="title" id="title" value="<?php echo $DETAILS['media_title']; ?>" placeholder="Titel" maxlength="200">
                                                <small><span class="help-block">Bitte vergeben Sie einen Titel</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="copyright" class="col-sm-2 control-label">Copyright:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="copyright" id="copyright" value="<?php echo $DETAILS['media_copyright']; ?>" placeholder="Copyright" maxlength="255">
                                                <small><span class="help-block">Bitte geben Sie den Rechteinhaber an</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="col-sm-2 control-label">Beschreibung:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="description" id="description" value="<?php echo $DETAILS['media_description']; ?>" placeholder="Beschreibung">
                                                <small><span class="help-block">Bitte geben Sie eine Beschreibung ein</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="keywords" class="col-sm-2 control-label">Keywords:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" name="keywords" id="keywords" value="<?php echo $DETAILS['media_keywords']; ?>" placeholder="Keywords, kommagetrennte Eingabe">
                                                <small><span class="help-block">Bitte geben Sie durch Komma getrennte Keywords an</span></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">&Auml;nderungen speichern &#8250;&#8250;</button>
                                                <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/media/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                            </div>
                                        </div>
                                    </form>

                                <?php

                                    }

                                ?>
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/">Medienverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/media/details/<?php echo $MEDIA_ID; ?>/">Detailansicht</a> <span class="glyphicon glyphicon-chevron-right"></span></p>
                        <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
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