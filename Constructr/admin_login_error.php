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
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
                        <div class="jumbotron" style="background:#000;color:#fff;">
                            <h1>ConstructrCMS</h1>
                            <br><br>
                            <?php

                                if(isset($_SESSION['constructr_login_blocked']) && $_SESSION['constructr_login_blocked'] != '')
                                {
                                    $ACT_TIME = time();
                                    $BLOCKING_TIME = $_SESSION['constructr_login_blocked'];

                                    if($ACT_TIME < ($BLOCKING_TIME + $_CONSTRUCTR_CONF['_LOGIN_BLOCKED_FOR']))
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

                                            <form role="form" name="login_form" id="login_form" action="<?php echo $_ACTION ?>" method="<?php echo $_METHOD ?>" enctype="<?php echo $_ENCTYPE ?>">
                                                <input type="hidden" name="_admin_guid" value="<?php if($GUID){echo $GUID;}?>"  id="_admin_guid">
                                                <div class="form-group">
                                                    <label for="_admin_username">Benutzername:</label>
                                                    <input type="text" value="<?php echo $_SESSION['TMP_LOGIN_NAME']; ?>" name="_admin_username" class="form-control" id="_admin_username" placeholder="Benutzername">
                                                </div>
                                                <div class="form-group">
                                                    <label for="_admin_password">Passwort:</label>
                                                    <input type="password" name="_admin_password" class="form-control" id="_admin_password" placeholder="Passwort">
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-info">Anmeldung</button>
                                            </form>

                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>

                                        <form role="form" name="login_form" id="login_form" action="<?php echo $_ACTION ?>" method="<?php echo $_METHOD ?>" enctype="<?php echo $_ENCTYPE ?>">
                                            <input type="hidden" name="_admin_guid" value="<?php if($GUID){echo $GUID;}?>"  id="_admin_guid">
                                            <div class="form-group">
                                                <label for="_admin_username">Benutzername:</label>
                                                <input type="text" value="<?php echo $_SESSION['TMP_LOGIN_NAME']; ?>" name="_admin_username" class="form-control" id="_admin_username" placeholder="Benutzername">
                                            </div>
                                            <div class="form-group">
                                                <label for="_admin_password">Passwort:</label>
                                                <input type="password" name="_admin_password" class="form-control" id="_admin_password" placeholder="Passwort">
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-info">Anmeldung</button>
                                        </form>

                                    <?php
                                }

                            ?>
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div><!-- // EOF CONTAINER -->
            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script>
                $(function()
                    {
                        if(localStorage && localStorage.removeItem && localStorage.getItem && localStorage.setItem){localStorage.setItem('MENU_VISIBLE','true');}$('#_admin_username').focus();$('#login_form').bind('submit', function(){var A = $('#_admin_username').val();var P = $('#_admin_password').val();if(typeof A === 'undefined' || A == '' || typeof P === 'undefined' ||  P == ''){return false;}});
                    }
                )
            </script>
        </body>
    </html>
