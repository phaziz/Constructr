<?php

    require_once './Assets/metadata-toolkit/JPEG.php';
    require_once './Assets/metadata-toolkit/EXIF.php';
    require_once './Assets/metadata-toolkit/JFIF.php';
    require_once './Assets/metadata-toolkit/Photoshop_IRB.php';
    require_once './Assets/metadata-toolkit/PictureInfo.php';
    require_once './Assets/metadata-toolkit/XMP.php';

    $constructr -> get('/constructr/image-test/', $ADMIN_CHECK, function () use ($constructr,$DBCON)
        {
            $constructr -> render('image-test.php',
                array
                (

                )
            );
        }
    );