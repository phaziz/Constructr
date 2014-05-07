<?php

    $filename = './Assets/metadata-toolkit/test.jpg';
    $filenameInt = 'http://constructr.phaziz.com/Assets/metadata-toolkit/test.jpg';

    echo 'ImageTest.php';
    echo '<br><br><br>';
    echo "<img src=\"$filenameInt\">";
    echo '<br><br><br>';

    $jpeg_header_data = get_jpeg_header_data( $filename );
    echo Interpret_EXIF_to_HTML( get_EXIF_JPEG( $filename ), $filename );
    echo Interpret_IRB_to_HTML( get_Photoshop_IRB( get_jpeg_header_data( $filename ) ), $filename );
    echo Generate_JPEG_APP_Segment_HTML( $jpeg_header_data );
    echo Interpret_intrinsic_values_to_HTML( get_jpeg_intrinsic_values( $jpeg_header_data ) );
    echo Interpret_Comment_to_HTML( $jpeg_header_data );
    echo Interpret_JFIF_to_HTML( get_JFIF( $jpeg_header_data ), $filename );
    echo Interpret_JFXX_to_HTML( get_JFXX( $jpeg_header_data ), $filename );
    echo Interpret_App12_Pic_Info_to_HTML( $jpeg_header_data );
    echo Interpret_EXIF_to_HTML( get_EXIF_JPEG( $filename ), $filename );
    echo Interpret_XMP_to_HTML( read_XMP_array_from_text( get_XMP_text( $jpeg_header_data ) ) );
    echo Interpret_IRB_to_HTML( get_Photoshop_IRB( $jpeg_header_data ), $filename );
    echo Interpret_EXIF_to_HTML( get_Meta_JPEG( $filename ), $filename );

?>