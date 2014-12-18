<?php

    /*
    ***************************************************************************

        DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
        Version 1, December 2012
        Copyright (C) 2012 Christian Becher | phaziz.com <christian@phaziz.com>
        Everyone is permitted to copy and distribute verbatim or modified
        copies of this license document, and changing it is allowed as long
        as the name is changed.

        DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
        TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
        0. YOU JUST DO WHAT THE FUCK YOU WANT TO!

        +++ Visit http://phaziz.com +++

    ***************************************************************************
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
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/content/new/predefined/<?php echo $PAGE_ID; ?>/<?php echo $NEW_CONTENT_ORDER; ?>/">Neuer vordefinierter Inhalt</a> </small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?>: <a data-toggle="tooltip" data-placement="top" title="Seite anzeigen" class="tt" onclick="window.open(this.href);return false;" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] .'/'. $PAGE_NAME['pages_url']; ?>"><strong><?php echo $PAGE_NAME['pages_name']; ?></strong></a></h1>
                                    <h2><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/content/<?php echo $PAGE_ID; ?>/<?php echo $NEW_CONTENT_ORDER; ?>/new/">Neuen Inhalt auf Seite <strong><?php echo $PAGE_NAME['pages_name']; ?></strong> erstellen</a> | Neuen vordefinierten Inhalt auf Seite <strong><?php echo $PAGE_NAME['pages_name']; ?></strong> erstellen</h2>
                                    <br><br>
                                    <form role="form" name="new_predefined_form" id="new_predefined_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                        <input type="hidden" name="user_form_guid" value="<?php echo $GUID; ?>">
                                        <input type="hidden" name="page_id" value="<?php echo $PAGE_ID; ?>">
                                        <input type="hidden" name="content_order" value="<?php echo $NEW_CONTENT_ORDER; ?>">
                                        <div class="form-group">
                                            <label for="new_page_order" class="col-sm-2 control-label">Inhaltselement ausw&auml;hlen:</label>
                                            <div class="col-sm-10">
		                                    	<select class="form-control" name="predefined-content-elements" id="predefined-content-elements" autofocus>
		                                    		<option value="">Bitte w&auml;hlen</option>
		                                    		<option value="">- - -</option>
		                                    		<?php 

														foreach($ALL_PREDEFINED_ELEMENTS AS $KEY => $ALL_PREDEFINED_ELEMENT)
														{
															echo '<option value="' . $ALL_PREDEFINED_ELEMENT[0] . '">' . $KEY . '</option>';													
														}

		                                    		?>
		                                    	</select>
                                            </div>
                                        </div>
                                    	<div id="predefined-content-element-form-area">
                                    	</div>
										<div class="form-group">
										    <label for="submitter" class="col-sm-2 control-label">&#160;</label>
										    <div class="col-sm-10">
										        <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
										    </div>
										</div>
                                    </form>
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/content/new/predefined/<?php echo $PAGE_ID; ?>/<?php echo $NEW_CONTENT_ORDER; ?>/">Neuer vordefinierter Inhalt</a> </small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION_DATE']; ?> <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>

                $(function()
                    {
                    	$('#predefined-content-elements').bind('change', function()
                    		{
                    			var PREDEFINED_ELEMENT = $('#predefined-content-elements').val();

								if(PREDEFINED_ELEMENT != '')
								{
	                                $.get(PREDEFINED_ELEMENT, { action: 'INDEX-FORM' })
	                                  .done(function( data )
	                                    {
	                                        if(data != '')
	                                        {
												$('#predefined-content-element-form-area').html(data);
	                                            return false;
	                                        }
	                                    }
	                                );
								}
                    		}
                    	);

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

                        $( "#new_predefined_form" ).bind( "submit", function()
                            {
                                $("#submitter").attr("disabled", "disabled");

                                var C = $('#content').val();

                                if(C == '')
                                {
                                    $('#content').focus();
                                    vex.dialog.alert(
                                        {
                                            className: 'vex-theme-flat-attack',
                                            message: 'Achtung: Bitte Formular komplett ausf&uuml;llen!',
                                            afterClose: function()
                                            {
                                                $('#content').focus();
                                                $("#submitter").removeAttr("disabled");
                                            }
                                        }
                                    );
                                    return false;
                                }
                                return true;
                            }
                        );

                    }
                );

            </script>
        </body>
    </html>