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
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex.css" rel="stylesheet">
            <link href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/vex/css/vex-theme-flat-attack.css" rel="stylesheet">
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
                        <li><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/" title="Dashboard anzeigen" data-toggle="tooltip" data-placement="right">Dashboard</a></li>
                        <li class="active"><a class="tt" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/" title="Seitenverwaltung anzeigen" data-toggle="tooltip" data-placement="right">Seiten</a></li>
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
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <div class="jumbotron">
                                    <h1><?php echo $SUBTITLE; ?>: <strong><?php echo $PAGE_NAME['pages_name']; ?></strong></h1>
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php 
                            if(isset($_GET['history']) && $_GET['history'] != ''){
                                ?>
                                    <div class="row response">
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                                <?php
                                                    if($_GET['history'] == 'deleted-false')
                                                    {
                                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Fehler!</strong> Fehler bei L&ouml;schvorgang. Bitte diese Seite neu laden!</div>';
                                                    }
                                                    else if($_GET['history'] == 'deleted-true')
                                                    {
                                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Erfolg!</strong> Datensatz wurde erfolgreich vollst&auml;ndig entfernt.</div>';
                                                    }
                                                ?>
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
                                    <h2>Inhalt auf Seite <strong><?php echo $PAGE_NAME['pages_name']; ?></strong> bearbeiten</h2>
                                    <br><br>
                                    <?php
                                    
                                        if($CONTENT)
                                        {

                                            $PAGE_ID = $CONTENT['content_page_id'];

                                    ?>
                                        <form role="form" name="new_page_form" id="new_page_form" action="<?php echo $FORM_ACTION; ?>" method="<?php echo $FORM_METHOD; ?>" enctype="<?php echo $FORM_ENCTYPE; ?>" class="form-horizontal">
                                            <input type="hidden" name="user_form_guid" value="<?php echo $GUID; ?>">
                                            <input type="hidden" name="page_id" value="<?php echo $CONTENT['content_page_id']; ?>">
                                            <div class="form-group">
                                                <label for="page_name" class="col-sm-2 control-label">Inhalt:</label>
                                                <div class="col-sm-10">
                                                    <textarea class="textarea form-control input-sm" name="content" id="content" placeholder="Bitte Inhalt eingeben!" rows="15"><?php echo $CONTENT['content_content']; ?></textarea>
                                                    <small><span class="help-block" id="status-page_name">Bitte geben Sie einen Inhalt an!</span></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="submitter" class="col-sm-2 control-label">&#160;</label>
                                                <div class="col-sm-10">
                                                    <button type="submit" name="submitter" id="submitter" class="btn btn-info btn-sm">Inhalt speichern &#8250;&#8250;</button>
                                                    <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $PAGE_ID . '/'; ?>"><button type="button" class="btn btn-danger btn-sm">Abbrechen</button></a>
                                                </div>
                                            </div>
                                        </form>
                                    <?php
                                        }
                                        else
                                        {
                                            echo 'Es ist ein Fehler aufgetreten...';
                                        }
                                    
                                    ?>
                                </div><!-- // EOF JUMBOTRON -->
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                        <?php
                            if($CONTENT_HISTORY)
                            {
                                ?>
                                <div class="row">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                        <div class="jumbotron">
                                            <h2>Inhalts-Historie:</h2>
                                            <br><br>
                                            <div class="table-responsive">
                                                <table class="datatable table table-bordered table-condensed table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><small>Historien Eintrag</small></th>
                                                            <th><small>Stand</small></th>
                                                            <th class="center"><small>Aktionen</small></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach ($CONTENT_HISTORY as $CONTENT_HISTORY)
                                                            {
                                                                echo '<tr>';
                                                                echo '<td style="max-width:300px;">';
                                                                echo '<pre class="content_history" id="content_' . $CONTENT_HISTORY['content_id'] . '">' . ($CONTENT_HISTORY['content_content']);
                                                                echo '</pre></td>';
                                                                echo '<td><small>';
                                                                echo date("d.m.Y, H:i", strtotime(substr($CONTENT_HISTORY['content_datetime'], 0, 18))) . ' Uhr';
                                                                echo '</small></td>';
                                                                echo '<td class="center"><nobr>';
                                                                echo '<a data-toggle="tooltip" data-placement="top" title="Wiederherstellen" class="recreater tt" href="#" id="' . $CONTENT_HISTORY['content_id'] . '"><button type="button" class="btn btn-success btn-xs" title="Wiederherstellen"><span class="glyphicon glyphicon-import"></span></button></a>';
                                                                echo '&#160;';
                                                                echo '<a data-toggle="tooltip" data-placement="top" title="Diesen Inhalt endg&uuml;ltig l&ouml;schen" class="deleter tt" href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/content/' . $CONTENT_HISTORY['content_page_id'] . '/' . $CONTENT_HISTORY['content_id'] . '/' . $CONTENT_HISTORY['content_content_id'] . '/delete-history-complete/" title="Diese Historie endg&uuml;ltig l&ouml;schen"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></a>';
                                                                echo '</nobr></td>';
                                                                echo '</tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!-- EOF TABLE RESPONSIVE-->
                                            </div><!-- // EOF JUMBOTRON -->
                                        </div><!-- // EOF COL-... -->
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                                    </div><!-- // EOF ROW -->
                                <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                <p><small><a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/">Dashboard</a> <span class="glyphicon glyphicon-chevron-right"></span> <a href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/constructr/pages/">Seitenverwaltung - &Uuml;bersicht</a> <span class="glyphicon glyphicon-chevron-right"></span></small></p>
                                <p><small>Version: <?php echo $_CONSTRUCTR_CONF['_VERSION']; ?> / <?php echo $TIMER; ?> / <?php echo $MEM; ?> / <a href="http://phaziz.com/" onclick="window.open(this.href);return false;">Constructr CMS von phaziz.com</a></small></p>
                            </div><!-- // EOF COL-... -->
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                        </div><!-- // EOF ROW -->
                    </div>
                </div>
            </div>

            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables/media/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'];?>/Assets/datatables-bootstrap3/assets/js/datatables.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/ckeditor/ckeditor.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] ?>/Assets/ckeditor/adapters/jquery.js"></script>
            <script>
                $(function()
                    {
                        $( '#content' ).focus();
                        $( '#content' ).ckeditor(
                            {
                                "customConfig":"",
                                "extraPlugins":"imagebrowser",
                                "imageBrowser_listUrl":"<?php echo $_CONSTRUCTR_CONF['_BASE_URL'] . '/constructr/get-image-list/'; ?>",
                                "allowedContent":true
                            }
                        );

                        $('.recreater').click(function(e)
                            {
                                var C_ID = $(this).attr('id');
                                var CONTENT = $('#content_' + C_ID).html();
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack', 
                                        message: 'M&ouml;chten Sie diesen Historien-Eintrag wiederherstellen?',
                                        callback: function(value)
                                        {
                                            if(value == true)
                                            {
                                                $('textarea#content').val(CONTENT);
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

                        $("#menu-toggle").click(function(e)
                            {
                                e.preventDefault();
                                $("#wrapper").toggleClass("active");
                            }
                        );

                        $('.datatable').dataTable(
                            {
                                "aaSorting": [],
                                "aoColumns": [
                                    { "sWidth": "60%", "bSortable":false},
                                    { "sWidth": "20%", "bSortable":false},
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

                        $('.deleter').click(function(e)
                            {
                                e.preventDefault();
                                var U = $(this).attr('href');
                                vex.dialog.buttons.YES.text = 'Ja';
                                vex.dialog.buttons.NO.text = 'Abbrechen';
                                vex.dialog.confirm(
                                    {
                                        className: 'vex-theme-flat-attack', 
                                        message: 'M&ouml;chten Sie wirklich diesen Historien-Eintrag l&ouml;schen?',
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

                        $( "#new_page_form" ).bind( "submit", function()
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