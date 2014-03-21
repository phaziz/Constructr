<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>            
            <?php

                if($PAGE_DATA)
                {
                    echo '<title>' . $PAGE_DATA['pages_title'] . '</title>';
                    echo '<meta name="description" content="' . $PAGE_DATA['pages_title'] . '">';
                    echo '<meta name="keywords" content="' . $PAGE_DATA['pages_title'] . '">';
                }
                else
                {
                    echo '<title>ConstructrCMS // http://phaziz.com</title>';
                    echo '<meta name="description" content="ConstructrCMS based on Slim-PHP5-Microframework by phaziz.com">';
                    echo '<meta name="keywords" content="ConstructrCMS,CMS,phaziz.com">';
                }

            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="<?php echo _BASE_URL;?>/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/css/constructr.css" rel="stylesheet">
        </head>
        <body style="padding-top: 100px;">

            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="http://constructr.phaziz.com/">ConstructrCMS</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php
            
                                if($PAGES)
                                {
                                    foreach($PAGES as $PAGE)
                                    {
                                        echo '<li><a href="' . _BASE_URL . '/' . $PAGE['pages_url'] . '" title="' . $PAGE['pages_name'] . '">' . $PAGE['pages_name'] . '</a></li>';
                                    }
                                }
        
                            ?>
                      </ul>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
        
                            if($CONTENT)
                            {
                                foreach($CONTENT as $CONTENT)
                                {
                                    echo $CONTENT['content_content'];
                                }
                            }
        
                        ?>
                    </div>
                </div>
            </div>

            <script src="<?php echo _BASE_URL ?>/Assets/jquery-2-1-0.min.js"></script>
            <script src="<?php echo _BASE_URL ?>/Assets/bootstrap/js/bootstrap.min.js"></script>
			<script type="text/javascript">
                var _paq=_paq||[];_paq.push(["setDocumentTitle",document.domain+"/"+document.title]);_paq.push(["setCookieDomain","*.constructr.phaziz.com"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);
                (function(){var c=("https:"==document.location.protocol?"https":"http")+"://piwik.phaziz.com/";_paq.push(["setTrackerUrl",c+"piwik.php"]);_paq.push(["setSiteId","3"]);var a=document,b=a.createElement("script"),a=a.getElementsByTagName("script")[0];b.type="text/javascript";b.defer=!0;b.async=!0;b.src=c+"piwik.js";a.parentNode.insertBefore(b,a)})();
			</script>
			<noscript>
				<img src="http://piwik.phaziz.com/piwik.php?idsite=3&amp;rec=1" style="border:0" alt="piwik" />
			</noscript>

        </body>
    </html>