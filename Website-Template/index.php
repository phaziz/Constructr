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

            ?>
            <meta charset="utf-8">
            <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="generator" content="Slim Framework">
            <meta name="author" content="Christian Becher">
            <meta name="robots" content="index,follow">
            <meta name="revisit-after" content="30 days">
            <meta name="generator" content="ConstructrCMS">
            <meta name="description" content="Senior PHP-Developer and UInterfacedesign-Lover based at Ruhr-Area/Germany. Javascript-Developer. PHP-Framework Enthusiast. Visit Twitter, GitHub, Flickr and my Blog">
            <meta name="keywords" content="Senior PHP-Developer,UInterfacedesign-Lover,Ruhr-Area/Germany, Javascript-Developer,PHP-Framework Enthusiast,Typo3,Wordpress, PHP, MySQL, Idiorm, Paris, Twig, Smarty, Slim-Framework, XML,jQuery">
            <meta name="google-site-verification" content="5gtMoUzg29nbi55aQI7piA7OYbK4vQt8UGlW_MdTqGc">
            <link rel="shortcut icon" href="<?php echo _STATIC_BASE_URL; ?>favicon.ico">
            <link rel="icon" href="<?php echo _STATIC_BASE_URL; ?>favicon.ico">
            <link rel="apple-touch-icon" href="<?php echo _BASE_URL;?>/apple-touch-icon.png">
            <link rel="apple-touch-icon" sizes="57x57" href="<?php echo _BASE_URL;?>/apple-touch-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo _BASE_URL;?>/apple-touch-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo _BASE_URL;?>/apple-touch-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo _BASE_URL;?>/apple-touch-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="<?php echo _BASE_URL;?>/apple-touch-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="<?php echo _BASE_URL;?>/apple-touch-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="<?php echo _BASE_URL;?>/apple-touch-icon-152x152.png">
            <link type="text/plain" rel="author" href="<?php echo _BASE_URL; ?>humans.txt">
            <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
            <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
            <style>
                html,body {height:100%;width:100%;}img{border:0}a:link,a:active,a:visited,a:hover{color:#fff!important;text-decoration: none;}.vert-text {display:table-cell;vertical-align:middle;text-align:center;}.vert-text h1 {padding:0;margin:0;font-size:4.5em;font-weight:200;color:#fff;font-style:italic;}.header {display:table;height:100%;width:100%;position:relative;background:url(http://static_files.phaziz.com/tigerturtle.jpg) no-repeat center center fixed; -webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}.header h1{color:rgb(255,255,255);font-weight:200;}.header h1 em{color:#ff0035;font-weight:100;}.header h3{color:rgb(255,255,255);font-weight:100;}.header h3 em{color:#ff0035;}.intro {padding:50px 0;}.callout {color:#ffffff;display:table;width:100%;background:url(http://static_files.phaziz.com/wolken.jpg) no-repeat center center fixed; -webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}.shining {color:#ffffff;display:table;width:100%;background:url(http://static_files.phaziz.com/sun.jpg) no-repeat center center fixed; -webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}.background {color:#ffffff;display:table;width:100%;background:url(http://static_files.phaziz.com/background.jpg) no-repeat center center fixed; -webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}@media (max-width:768px) { .header {background:url(http://static_files.phaziz.com/tigerturtle.jpg) no-repeat center center scroll; }.callout {background:url(http://static_files.phaziz.com/wolken.jpg) no-repeat center center scroll; }}p.lead{margin:0;font-size:1.5em;color:rgb(0,0,0);font-weight:100;background:rgb(255,255,255);}.container{color:rgb(0,0,0);background:transparent;}footer{background:transparent;font-size:0.80em;}.white{color:rgb(255,255,255);font-weight:100;}h3{font-weight:100;}.scroller{font-size:2.00em;}.scroller:hover{color:#ff0035;font-size:2.00em;}a.more:link,a.more:active,a.more:visited,a.more:hover{color:#ff0035!important;}
                a:link,a:active,a:visited{
                    color: #0000ff !important;
                }
            </style>
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
                                $html .= '<li><a href="' . _BASE_URL . '/">' . $PAGE['pages_name'] . '</a>';    
                            }
                            else
                            {
                                $html .= '<li><a href="' . _BASE_URL . '/' . $PAGE['pages_url'] . '/">' . $PAGE['pages_name'] . '</a>';
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
            <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
            <script>
                $(function(){
                    scroll = function(element){$('html,body').animate({scrollTop:($(element).offset().top)},1500);try{_paq.push(['trackSiteSearch','Scrolled down','',false]);}catch(err){};};
                    resizeDiv=function(cons){if(!cons)cons=false;var vph=$(window).height();$(".higher").css({"height":vph})};
                    resizeDiv();
                    $(window).resize(function(){resizeDiv()});
                });
            </script>
            <script type="text/javascript">
                var _paq=_paq||[];_paq.push(["setDocumentTitle",document.domain+"/"+document.title]);_paq.push(["setCookieDomain","*.constructr.phaziz.com"]);_paq.push(["trackPageView"]);_paq.push(["enableLinkTracking"]);
                (function(){var c=("https:"==document.location.protocol?"https":"http")+"://piwik.phaziz.com/";_paq.push(["setTrackerUrl",c+"piwik.php"]);_paq.push(["setSiteId","3"]);var a=document,b=a.createElement("script"),a=a.getElementsByTagName("script")[0];b.type="text/javascript";b.defer=!0;b.async=!0;b.src=c+"piwik.js";a.parentNode.insertBefore(b,a)})();
            </script>
            <noscript>
                <img src="http://piwik.phaziz.com/piwik.php?idsite=3&amp;rec=1" style="border:0" alt="piwik" />
            </noscript>

        </body>
    </html>
    <!--Website Template/index.php-->