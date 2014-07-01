<?php

    if(isset($_GET['key']) && $_GET['key'] == $_CONSTRUCTR_CONF['_MAGIC_GENERATION_KEY'])
    {
        $_BASE_ROUTE = $_CONSTRUCTR_CONF['_CREATE_STATIC_DOMAIN'];
    }
    else
    {
        if($_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'] == '')
        {
            $_BASE_ROUTE = $_CONSTRUCTR_CONF['_BASE_URL'];    
        }
        else
        {
            $_BASE_ROUTE = $_CONSTRUCTR_CONF['_CREATE_DYNAMIC_DOMAIN'];
        }
    }

?>
<!DOCTYPE html>
    <html lang="de">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?php
                if($PAGE_DATA)
                {
                    echo '<title>' . $PAGE_DATA['pages_title'] . '</title>' . "\n";
                    echo '<meta name="description" content="' . $PAGE_DATA['pages_description'] . '">' . "\n";
                    echo '<meta name="keywords" content="' . $PAGE_DATA['pages_keywords'] . '">' . "\n";
                }
            ?>
            <meta name="generator" content="ConstructrCMS">
            <meta name="robots" content="index,follow">
            <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
            <meta name="generator" content="ConstructrCMS">
            <meta name="author" content="Christian Becher">
            <meta name="robots" content="index,follow">
            <meta name="revisit-after" content="30 days">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
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
                                $html .= '<li><a href="' . $_BASE_ROUTE . '">' . $PAGE['pages_name'] . '</a>';    
                            }
                            else
                            {
                                $html .= '<li><a href="' . $_BASE_ROUTE . $PAGE['pages_url'] . '/">' . $PAGE['pages_name'] . '</a>';
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
                        echo $CONTENT['content_content'];   
                    }
                }
                // PAGE CONTENT... END
            ?>

            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script type="text/javascript">
                var _paq=_paq||[];_paq.push(["setDocumentTitle",document.domain+"/"+document.title]);_paq.push(["setCookieDomain","*.constructr.phaziz.com"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);
                (function(){var c=("https:"==document.location.protocol?"https":"http")+"://piwik.phaziz.com/";_paq.push(["setTrackerUrl",c+"piwik.php"]);_paq.push(["setSiteId","3"]);var a=document,b=a.createElement("script"),a=a.getElementsByTagName("script")[0];b.type="text/javascript";b.defer=!0;b.async=!0;b.src=c+"piwik.js";a.parentNode.insertBefore(b,a)})();
            </script>
            <noscript>
                <img src="http://piwik.phaziz.com/piwik.php?idsite=3&amp;rec=1" style="border:0" alt="piwik" />
            </noscript>
        </body>
    </html>