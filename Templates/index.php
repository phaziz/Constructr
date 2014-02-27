<!DOCTYPE html>
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->
        <head>
            <title><?php echo _TITLE . ' - ' . $SUBTITLE; ?></title>
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
                            echo '<li><a href="' . _BASE_URL . '/' . $PAGE['pages_url'] . '/" title="' . $PAGE['pages_name'] . '">' . $PAGE['pages_name'] . '</a></li>';
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