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
            <div class="container" style="max-width: 600px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Login Fehler!!!</strong></div>
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jumbotron">
                            <h1>ConstructrCMS</h1>
                            <br><br>
                            <?php

                                if(isset($_SESSION['constructr_login_blocked']) && $_SESSION['constructr_login_blocked'] != '')
                                {
                                    $ACT_TIME = time();
                                    $BLOCKING_TIME = $_SESSION['constructr_login_blocked'];

                                    if($ACT_TIME < ($BLOCKING_TIME + 600))
                                    {
                                        ?>
                                            <div class="alert alert-danger"><strong>Zu viele Anmeldeversuche!</strong> Sie wurden f&uuml;r 10 Minuten gesperrt! Bitte versuchen Sie es danach erneut!</div>
                                        <?php
                                    }
                                    else
                                    {
                                        $_SESSION['constructr_login_blocked'] = '';
                                        $_SESSION['constructr_login_attempt'] = '';

                                        ?>

                                            <form role="form" action="<?php echo $_ACTION ?>" method="<?php echo $_METHOD ?>" enctype="<?php echo $_ENCTYPE ?>">
                                                <input type="hidden" name="_admin_guid" value="<?php if($GUID){echo $GUID;}?>"  id="_admin_guid">
                                                <div class="form-group">
                                                    <label for="_admin_username">Benutzername:</label>
                                                    <input type="text" name="_admin_username" class="form-control" id="_admin_username" placeholder="Benutzername">
                                                </div>
                                                <div class="form-group">
                                                    <label for="_admin_password">Passwort:</label>
                                                    <input type="password" name="_admin_password" class="form-control" id="_admin_password" placeholder="Passwort">
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-default">Anmeldung</button>
                                            </form>

                                        <?php    
                                    }
                                }
                                else
                                {
                                    ?>

                                        <form role="form" action="<?php echo $_ACTION ?>" method="<?php echo $_METHOD ?>" enctype="<?php echo $_ENCTYPE ?>">
                                            <input type="hidden" name="_admin_guid" value="<?php if($GUID){echo $GUID;}?>"  id="_admin_guid">
                                            <div class="form-group">
                                                <label for="_admin_username">Benutzername:</label>
                                                <input type="text" name="_admin_username" class="form-control" id="_admin_username" placeholder="Benutzername">
                                            </div>
                                            <div class="form-group">
                                                <label for="_admin_password">Passwort:</label>
                                                <input type="password" name="_admin_password" class="form-control" id="_admin_password" placeholder="Passwort">
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-default">Anmeldung</button>
                                        </form>

                                    <?php
                                }

                            ?>
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div><!-- // EOF CONTAINER -->
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/Assets/vex/js/vex.combined.min.js"></script>
            <script>
                $(function()
                    {
                        vex.dialog.alert(
                            {
                                className: 'vex-theme-flat-attack',
                                message: 'Achtung: Das Login ist fehlgeschlagen.<br>Bitte &uuml;berpr&uuml;fen Sie Ihre Zugangsdaten!',
                                afterClose: function() 
                                {
                                    $('#_admin_username').focus();
                                }
                            }
                        );
                    }
                )
            </script>
        </body>
    </html>