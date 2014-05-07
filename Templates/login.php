<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo _TITLE . ' - ' . $SUBTITLE; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo _BASE_URL;?>/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/css/constructr.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <div class="jumbotron">
                            <h1>ConstructrCMS // Anmeldung erforderlich:</h1>
                            <br><br>
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
                        </div><!-- // EOF JUMBOTRON -->
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <p><small>App: <?php echo _VERSION; ?></small></p>
                    </div><!-- // EOF COL-... -->
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div><!-- // EOF COL-... -->
                </div><!-- // EOF ROW -->
            </div><!-- // EOF CONTAINER -->
            <script src="<?php echo _BASE_URL ?>/Assets/jquery-2-1-1.min.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
            <script>
                $(function(){$("#_admin_username").focus()});var _paq=_paq||[];_paq.push(["setDocumentTitle",document.domain+"/"+document.title]);_paq.push(["setCookieDomain","*.constructr.phaziz.com"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);
                (function(){var c=("https:"==document.location.protocol?"https":"http")+"://piwik.phaziz.com/";_paq.push(["setTrackerUrl",c+"piwik.php"]);_paq.push(["setSiteId","3"]);var a=document,b=a.createElement("script"),a=a.getElementsByTagName("script")[0];b.type="text/javascript";b.defer=!0;b.async=!0;b.src=c+"piwik.js";a.parentNode.insertBefore(b,a)})();
			</script>
			<noscript>
				<img src="http://piwik.phaziz.com/piwik.php?idsite=3&amp;rec=1" style="border:0" alt="" />
			</noscript>
        </body>
    </html>