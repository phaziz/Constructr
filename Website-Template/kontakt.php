<?php

    if(isset($_POST['key']) && $_POST['key'] == $_CONSTRUCTR_CONF['_MAGIC_GENERATION_KEY'])
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
            <link rel="shortcut icon" href="<?php echo $_BASE_ROUTE; ?>favicon.ico">
            <link rel="icon" href="<?php echo $_BASE_ROUTE; ?>favicon.ico">
            <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

            <style>
              html, body, #map-canvas
              {
                height: 500px;
                margin: 0 auto;
              }
              .vorname
              {
                  display:none;
                  visibility: hidden;
              }
            </style>
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
            <script>
                function initialize() {
                  var myLatlng = new google.maps.LatLng(51.454528,6.664714);
                  var mapOptions = {
                    zoom: 17,
                    center: myLatlng
                  }
                  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                  var marker = new google.maps.Marker({
                      position: myLatlng,
                      map: map,
                      title: 'Hello World!'
                  });
                }

                google.maps.event.addDomListener(window, 'load', initialize);
            </script>
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
                <div class="row mb50px">
                    <div class="col-md-1"></div>
                    <div class="col-md-7">
                        <?php
                            // NAVIGATION UL...LI... START
                            if($PAGES)
                            {
                                echo '<nav class="links">';
                                    foreach ($PAGES as $PAGE)
                                    {
                                        if($PAGE['pages_lft'] != 1 && $PAGE['pages_id'] != 104 && $PAGE['pages_id'] != 106 && $PAGE['pages_nav_visible'] == 1)
                                            echo '<a href="' . $_BASE_ROUTE . $PAGE['pages_url'] . '/">' . $PAGE['pages_name'] . '</a>&#160;';
                                    }
                                echo '</nav>';
                            }
                            // NAVIGATION UL...LI... ENDE
                        ?>
                    </div>
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-1"></div>
                </div>

            <div id="map-canvas"></div>

            <?php
                // PAGE CONTENT... START
                if($CONTENT)
                {
                    foreach($CONTENT as $CONTENT)
                    {
                        ?>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 content">
                                <?php echo $CONTENT['content_content']; ?>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        <?php
                    }
                }
                // PAGE CONTENT... END

            ?>

            <div class="row" id="senderrr" style="display:none;">
                <div class="col-md-1"></div>
                <div class="col-md-10 content">
                    <p style="color:green;font-weight:900;">Vielen Dank!<br>Wir haben Ihre eMail bekommen!</p>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 content">
                    <form class="form-horizontal" name="constructr_mailform" id="constructr_mailform" role="form" action="" method="post" enctype="application/x-www-form-urlencoded">
                        <input type="hidden" name="constructr_postmaster" id="constructr_postmaster" value="try">
                        <input type="hidden" name="postmaster_guid" id="postmaster_guid" value="<?php echo $POSTMASTER_GUID; ?>">
                        <input type="hidden" name="referrer" id="referrer" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="postmaster_datetime" id="postmaster_datetime" value="<?php echo time(); ?>">
                        <div class="form-group vorname">
                            <label for="vorname" class="col-sm-2 control-label">Vorname:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="vorname" id="vorname" placeholder="Vorname">
                            </div>
                        </div>
                        <div class="form-group name">
                            <label for="name" class="col-sm-2 control-label">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group email">
                            <label for="email" class="col-sm-2 control-label">eMail:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" id="email" placeholder="eMail">
                            </div>
                        </div>
                        <div class="form-group text">
                            <label for="text" class="col-sm-2 control-label">Text:</label>
                            <div class="col-sm-10">
                                <textarea rows="10" cols="50" class="form-control" name="text" id="text" placeholder="Text"></textarea>
                            </div>
                        </div>
                        <div class="form-group submit">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Absenden</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-1"></div>
            </div>

            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script>

                ;$(function()
                    {
                        $('#constructr_mailform').bind('submit',function(e)
                            {
                                e.preventDefault();
                                var C = $('#constructr_postmaster').val();
                                var G = $('#postmaster_guid').val();
                                var DT = $('#postmaster_datetime').val();
                                var R = $('#referrer').val();
                                var V = $('#vorname').val();
                                var N = $('#name').val();
                                var E = $('#email').val();
                                var T = $('#text').val();

                                if(V != '')
                                {
                                    return false;
                                }

                                if(N != '' && E != '' && T != '')
                                {
                                    $.ajax(
                                        {
                                            type:"POST",
                                            url:"<?php echo $_CONSTRUCTR_CONF['_BASE_URL']; ?>",
                                            data:{constructr_postmaster:C,postmaster_guid:G,postmaster_datetime:DT,referrer:R,name:N,email:E,text:T}
                                        }
                                    ).done(function()
                                        {
                                            $('#senderrr').fadeIn()
                                            $('#name').val('');
                                            $('#email').val('');
                                            $('#text').val('');
                                        }
                                    );
                                }
                                else
                                {
                                    alert(unescape("Fehler%3A Bitte alle Formularfelder bef%FCllen%21"));
                                    $('#name').focus();
                                    return false;
                                }
                            }
                        );
                    }
                );
            </script>

            <!-- // CONSTRUCTR_ANALYTICS // -->
            <script src="http://constructr.phaziz.com/Analytics/constructr_analytics.js"></script>
            <script>
                constructr_analytics('http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>','<?php echo time(); ?>');
            </script>
            <!-- // CONSTRUCTR_ANALYTICS // -->

        </body>
    </html>
    <!--TEMPLATE: startseite.php-->
