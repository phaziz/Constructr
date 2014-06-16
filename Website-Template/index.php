<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>

            <?php

                if($PAGE_DATA)
                {
                    echo '<title>' . $PAGE_DATA['pages_title'] . '</title>' . "\n";
                    echo '<meta name="description" content="' . $PAGE_DATA['pages_title'] . '">' . "\n";
                    echo '<meta name="keywords" content="' . $PAGE_DATA['pages_title'] . '">' . "\n";
                }

            ?>

            <meta charset="utf-8">
            <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="generator" content="ConstructrCMS">
            <meta name="author" content="Christian Becher">
            <meta name="robots" content="index,follow">
            <meta name="revisit-after" content="30 days">
            <link rel="shortcut icon" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/favicon.ico">
            <link rel="icon" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/favicon.ico">
            <link rel="apple-touch-icon" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon.png">
            <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/apple-touch-icon-152x152.png">
            <link type="text/plain" rel="author" href="<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>/humans.txt">
        </head>
        <body>

            <?php
                // NAVIGATION UL...LI... START
                if($PAGES)
                {
                    $level = -1;
                    $html = '';

                    foreach ($PAGES as $PAGE)
                    {
                        if($PAGE['pages_lft'] == 1)
                        {
                            $PAGE['pages_level'] = ($PAGE['pages_level'] + 1);
                        }

                        if($PAGE['pages_level'] < $level)
                        {
                            $diff = $level - $PAGE['pages_level'];
                            $html .= '</li>';
                            $html .= str_repeat('</ul></li>', $diff);
                        }

                        if($PAGE['pages_level'] > $level)
                        {
                            $html .= '<ul>';
                        }
            
                        if($PAGE['pages_level'] == $level)
                            $html .= '</li>';
                            if($PAGE['pages_lft'] == 1)
                            {
                                $html .= '<li><a href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/">' . $PAGE['pages_name'] . '</a>';    
                            }
                            else
                            {
                                $html .= '<li><a href="' . $_CONSTRUCTR_CONF['_BASE_URL'] . '/' . $PAGE['pages_url'] . '/">' . $PAGE['pages_name'] . '</a>';
                            }
                            $level = $PAGE['pages_level'];
                    }
            
                    if ($level >= 0) $html .= str_repeat('</li></ul>', $level);
            
                    echo $html;
                }
                // NAVIGATION UL...LI... ENDE

                // PAGE CONTENT... START
                if($CONTENT)
                {
                    foreach($CONTENT as $CONTENT)
                    {
                        if($CONTENT['content_deleted'] != 1)
                        {
                            echo $CONTENT['content_content'];   
                        }
                    }
                }
                // PAGE CONTENT... END
            ?>

            <script type="text/javascript">
                var _paq=_paq||[];_paq.push(["setDocumentTitle",document.domain+"/"+document.title]);_paq.push(["setCookieDomain","*.constructr.phaziz.com"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);
                (function(){var c=("https:"==document.location.protocol?"https":"http")+"://piwik.phaziz.com/";_paq.push(["setTrackerUrl",c+"piwik.php"]);_paq.push(["setSiteId","3"]);var a=document,b=a.createElement("script"),a=a.getElementsByTagName("script")[0];b.type="text/javascript";b.defer=!0;b.async=!0;b.src=c+"piwik.js";a.parentNode.insertBefore(b,a)})();
            </script>
            <noscript>
                <img src="http://piwik.phaziz.com/piwik.php?idsite=3&amp;rec=1" style="border:0" alt="piwik" />
            </noscript>

        </body>
    </html>