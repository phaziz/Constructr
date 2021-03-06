<?php

/**
 * Constructr CMS TemplateFile Page Content Overview.
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
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/css/datatables.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/codemirror/lib/codemirror.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            <style>
            	.CodeMirror{border:1px solid #666;}
            </style>
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
							<li role="presentation"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a></li>
							<li role="presentation" class="active"><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/constructr/content/<?php echo $PAGE_ID; ?>/">Seiteninhalte</a></li>
						</ul>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    	<br>
                    	<div class="pull-right"><div class="menu-btn tt" title="Navigation ein- oder ausblenden" data-placement="bottom">&#9776; ConstructrCMS&#160;&#160;&#160;</div></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->

                <?php

                    if (isset($_GET['res']) && $_GET['res'] != '') {

                        ?>

                            <div class="row response">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                    <?php

                                        if ($_GET['res'] == 'update-page-data-true') {
                                            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seiten CSS und Javascript wurde erfolgreich aktualisiert.</div>';
                                        }
		                                if ($_GET['res'] == 'create-content-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde ohne Fehler erstellt.</div>';
		                                } elseif ($_GET['res'] == 'create-content-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim anlegen des Inhalts aufgetreten.</div>';
		                                }
		                                if ($_GET['res'] == 'activate-content-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt ist nun im Frontend sichtbar.</div>';
		                                } elseif ($_GET['res'] == 'activate-content-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim aktivieren des Inhalts aufgetreten.</div>';
		                                }
		                                if ($_GET['res'] == 'deactivate-content-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Seite ist nun im Frontend unsichtbar.</div>';
		                                } elseif ($_GET['res'] == 'deactivate-content-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim deaktivieren des Inhalts aufgetreten.</div>';
		                                }
		                                if ($_GET['res'] == 'edit-content-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich bearbeitet.</div>';
		                                } elseif ($_GET['res'] == 'edit-content-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim bearbeiten des Inhalts aufgetreten.</div>';
		                                }
		                                if ($_GET['res'] == 'del-content-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich entfernt.</div>';
		                                } elseif ($_GET['res'] == 'del-content-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler beim l&ouml;schen des Inhalts aufgetreten.</div>';
		                                }
		                                if ($_GET['res'] == 'reorder-content-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Es ist ein Fehler bei der Sortierung aufgetreten. Bitte diese Seite neu laden!</div>';
		                                } elseif ($_GET['res'] == 'reorder-content-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich verschoben.</div>';
		                                }
		                                if ($_GET['res'] == 'recreated-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Fehler bei Wiederherstellung. Bitte diese Seite neu laden!</div>';
		                                } elseif ($_GET['res'] == 'recreated-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Inhalt wurde erfolgreich wiederhergestellt.</div>';
		                                }
		                                if ($_GET['res'] == 'cleared-page-cache-false') {
		                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Fehler beim entfernen des Caches dieser Seite!</div>';
		                                } elseif ($_GET['res'] == 'cleared-page-cache-true') {
		                                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Cache dieser Seite wurde erfolgreich gel&ouml;scht.</div>';
		                                }

	                                ?>

                                </div><!-- // EOF COL-... -->

                            </div><!-- // EOF ROW -->

                        <?php

                    }
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron">
                            <h1><?php echo $SUBTITLE; ?>: <a data-toggle="tooltip" data-placement="top" title="Seite anzeigen" class="tt" onclick="window.open(this.href);return false;" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/'.$PAGE_NAME['pages_url']; ?>"><strong><?php echo $PAGE_NAME['pages_name']; ?></strong></a>

                            <?php

                                 if ($_CONSTRUCTR_CONF['_CONSTRUCTR_WEBSITE_CACHE'] == true) {
                                     ?> | <a data-toggle="tooltip" data-placement="top" title="Cache dieser Seite l&ouml;schen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/clear-cache-page/'.$GUID.'/'.$PAGE_NAME['pages_id'].'/';
                                     ?>"><strong>Cache l&ouml;schen</strong></a>

                             <?php

                                 }

                            ?>

                            </h1>
                            <h2><?php echo $CONTENT_COUNTER; ?> Angelegte Inhalte auf Seite <strong><?php echo $PAGE_NAME['pages_name']; ?></strong> <a data-toggle="tooltip" data-placement="top" title="Neuen Inhalt erstellen" class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.($CONTENT_COUNTER + 1).'/new/' ?>"><button type="button" class="btn btn-info btn-sm" title="Neuen Inhalt erstellen"><span class="glyphicon glyphicon-plus"></span> Neuen Inhalt erstellen</button></a></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><small>Inhalt</small></th>
                                        <th class="center"><small>Aktionen</small></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                        if ($CONTENT) {
                                            foreach ($CONTENT as $CONTENT) {
                                                echo '<tr>';
                                                echo '<td><small>';
                                                echo '<a href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/edit/" title="Inhalte bearbeiten">'.htmlspecialchars($CONTENT['content_content']).'</a></small></td>';
                                                echo '<td class="right"><nobr>';
                                                if ($CONTENT['content_order'] > 1) {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt nach oben verschieben" class="reorder tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/'.$CONTENT['content_order'].'/up/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach oben verschieben"><span class="glyphicon glyphicon-arrow-up"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                if ($CONTENT['content_order'] < $CONTENT_COUNTER) {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt nach unten verschieben" class="reorder tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/'.$CONTENT['content_order'].'/down/"><button type="button" class="btn btn-primary btn-xs" title="Seite nach unten verschieben"><span class="glyphicon glyphicon-arrow-down"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                if ($CONTENT['content_active'] == 0) {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt aktivieren" class="activator tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/activate/"><button type="button" class="btn btn-danger btn-xs" title="deaktiviert und unsichtbar"><span class="glyphicon glyphicon-eye-close"></span></button></a>';
                                                    echo '&#160;';
                                                } else {
                                                    echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt deaktivieren" class="activator tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/deactivate/"><button type="button" class="btn btn-success btn-xs" title="aktiviert und sichtbar"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                                                    echo '&#160;';
                                                }
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Inhalt bearbeiten" class="editer tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/edit/"><button type="button" class="btn btn-success btn-xs" title="Inhalt bearbeiten"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                                                echo '&#160;';
                                                echo '<a data-toggle="tooltip" data-placement="top" title="Diesen Inhalt l&ouml;schen" class="deleter tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$CONTENT['content_id'].'/'.$CONTENT['content_order'].'/delete/" title="Inhalt l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                echo '</nobr></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="7">Keine Seiteninhalte gefunden!</td></tr>';
                                        };

                                    ?>

                                </tbody>
                            </table>
                            </div><!-- EOF TABLE RESPONSIVE-->

							<?php

                                if ($PAGE_NAME) {

                            ?>

								<h1><a href="#" id="toogle-extra-parts"><span id="extra-parts-icon" class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a> Seitenspezifische CSS- und Javascript-Eigenschaften:</h1>
								
								<div id="area-extra-parts">
								
									<form role="form" name="new_page_form" id="new_page_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                        <input type="hidden" name="user_form_guid" value="<?php echo $GUID; ?>">
                                        <input type="hidden" name="page_id" id="page_id" value="<?php echo $PAGE_NAME['pages_id']; ?>" maxlength="100">
                                        <div class="form-group">
                                            <label for="page_css" class="col-sm-2 control-label">Seitenspezifisches CSS:</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="50" class="form-control input-sm" name="page_css" id="page_css" placeholder="Seitenspezifisches CSS f&uuml;r diese Seite"><?php echo $PAGE_NAME['pages_css']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_js" class="col-sm-2 control-label">Seitenspezifisches Javascript:</label>
                                            <div class="col-sm-10">
                                                <textarea rows="5" cols="50" class="form-control input-sm" name="page_js" id="page_js" placeholder="Seitenspezifisches Javascript f&uuml;r diese Seite"><?php echo $PAGE_NAME['pages_js']; ?></textarea>
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

								</div>

							<?php

                                }

                            ?>

                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <?php

                    if ($DELETED_CONTENT_COUNTER != 0) {

                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron">
                            <h2><?php echo $DELETED_CONTENT_COUNTER;?> <strong>Gel&ouml;schte</strong> Inhalte von <?php echo $PAGE_NAME['pages_name']; ?></h2>
                            <br><br>
                            <div class="table-responsive">
                            <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><small>Gel&ouml;schter Inhalt</small></th>
                                        <th class="center"><small>Aktionen</small></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                        foreach ($DELETED_CONTENT as $DELETED_CONTENT) {
                                            echo '<tr>';
                                            echo '<td><small>';
                                            echo '<a href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$DELETED_CONTENT['content_id'].'/edit/" title="Inhalte bearbeiten">'.htmlspecialchars($DELETED_CONTENT['content_content']).'</a></small></td>';
                                            echo '<td class="right"><nobr>';
                                            echo '<a data-toggle="tooltip" data-placement="top" title="Wiederherstellen" class="recreater tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$DELETED_CONTENT['content_id'].'/'.($CONTENT_COUNTER+1).'/re-create/"><button type="button" class="btn btn-success btn-xs" title="Wiederherstellen"><span class="glyphicon glyphicon-import"></span></button></a>';
                                            echo '&#160;';
                                            echo '<a data-toggle="tooltip" data-placement="top" title="Diesen Inhalt endg&uuml;ltig l&ouml;schen" class="deleter tt" href="'.$_CONSTRUCTR_CONF['_BASE_URL'].'/constructr/content/'.$PAGE_ID.'/'.$DELETED_CONTENT['content_id'].'/delete-complete/" title="Inhalt endg&uuml;ltig l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                            echo '</nobr></td>';
                                            echo '</tr>';
                                        }

	                                ?>

                                </tbody>
                            </table>
                            </div><!-- EOF TABLE RESPONSIVE-->
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->

                <?php

                    }

                ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="center"><small><a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a>, Version <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> vom <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?></small></p>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div>


            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/jquery-1.11.2.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/codemirror/lib/codemirror.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/codemirror/mode/php/php.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/pushy/pushy.min.js"></script>
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

                        $("#toogle-extra-parts").click(function(e){
                            e.preventDefault();
						    $('#area-extra-parts').toggle();

							if($("#area-extra-parts").is(":visible")){
							    $('#toogle-extra-parts').html('<span id="extra-parts-icon" title="CSS + JS ausblenden" class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>');
							} else { 
							     $('#toogle-extra-parts').html('<span id="extra-parts-icon" title="CSS + JS einblenden" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>');
							}
                        });

                        function autoBlinder()
                        {
                            $('.response').fadeOut();
                        }

                        setInterval(autoBlinder,4500);

                        $('.datatable').dataTable(
                            {
                                "aaSorting": [],
                                "aoColumns": [
                                    { "sWidth": "80%", "bSortable":false},
                                    { "sWidth": "20%", "bSortable":false}
                                ],
                                "sPaginationType":"bs_full",
                                "iDisplayLength": -1,
                                "oLanguage": {
                                    "sLengthMenu": '<small>Zeige <select class="form-control input-sm">'+
                                    '<option value="10">10</option>'+
                                    '<option value="20">20</option>'+
                                    '<option value="25">25</option>'+
                                    '<option value="50">50</option>'+
                                    '<option value="100">100</option>'+
                                    '<option value="-1">Alle</option>'+
                                    '</select> Ergebnisse je Seite</small>'
                                }
                            }
                        );

                        $('.datatable').each(function()
                            {
                                var datatable = $(this);
                                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                                search_input.attr('placeholder', 'Suche');
                                search_input.addClass('form-control input-sm');
                                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                                length_sel.addClass('form-control input-sm');
                            }
                        );

                        $('.reorder').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'Inhalt wirklich verschieben?',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                window.location = (U);
                                            }
                                            else
                                            {
                                                return false
                                            }
                                        }
                                    }
                                );
                            }
                        );

                        $('.recreater').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'M&ouml;chten Sie diesen Inhalt wiederherstellen?',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                window.location = (U);
                                            }
                                            else
                                            {
                                                return false
                                            }
                                        }
                                    }
                                );
                            }
                        );

                        $('.deleter').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'M&ouml;chten Sie wirklich diesen Inhalt l&ouml;schen?',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                window.location = (U);
                                            }
                                            else
                                            {
                                                return false
                                            }
                                        }
                                    }
                                );
                            }
                        );

                        $('.activator').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack',
                                        message: 'Soll die Sichtbarkeit des Inhalts wirklich angepasst werden?',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                window.location = (U);
                                            }
                                            else
                                            {
                                                return false
                                            }
                                        }
                                    }
                                );
                            }
                        );
                    }
                );

            </script>
        </body>
    </html>