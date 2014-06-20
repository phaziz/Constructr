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
            <meta name="robots" content="index,follow">
            <meta name="revisit-after" content="30 days">
        </head>
        <body>

            <?php

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
                if($CONTENT)
                {
                    foreach($CONTENT as $CONTENT)
                    {
                        echo $CONTENT['content_content'];   
                    }
                }
            ?>

        </body>
    </html>