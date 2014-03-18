<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <link rel="shortcut icon" href="<?php echo _BASE_URL;?>/favicon.ico" type="image/x-icon">
            <link rel="apple-touch-icon" href="<?php echo _BASE_URL;?>/apple-touch-icon.png">
            <link rel="apple-touch-icon" sizes="57x57" href="<?php echo _BASE_URL;?>/apple-touch-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo _BASE_URL;?>/apple-touch-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo _BASE_URL;?>/apple-touch-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo _BASE_URL;?>/apple-touch-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="<?php echo _BASE_URL;?>/apple-touch-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="<?php echo _BASE_URL;?>/apple-touch-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="<?php echo _BASE_URL;?>/apple-touch-icon-152x152.png">
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
            <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo _BASE_URL;?>/Assets/css/app.css" rel="stylesheet">
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div class="container">
                <?php

                    if($PAGES)
                    {
                        echo '<nav><ul>';
                        foreach($PAGES as $PAGE)
                        {
                            echo '<li><a href="' . _BASE_URL . '/' . $PAGE['pages_url'] . '" title="' . $PAGE['pages_name'] . '">' . $PAGE['pages_name'] . '</a></li>';
                        }
                        echo '</ul></nav>';
                    }
                    echo '<br><br>';
                    if($CONTENT)
                    {
                        foreach($CONTENT as $CONTENT)
                        {
                            echo $CONTENT['content_content'];
                        }
                    }

                ?>
            </div>
        </body>
    </html>