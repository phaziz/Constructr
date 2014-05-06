<?php

    /*
     * 
     * This is the main config-file - just edit for your needs
     * 
     * Hopefully, you know what to do :)
     * 
     * */

    // BASE URL DER INSTALLATION
    define('_BASE_URL','http://' . $_SERVER['HTTP_HOST'] . '');

    // VERSIONSNUMMER CONSTRUCTR CMS
    define('_VERSION','20140408');

    // VERSCHLÜSSELUNGS SALZ
    define('_SALT','$2y$07$R.gJb2U2N.FmZ4hPp1y2CN$');

    // LOGFILES ERSTELLEN?
    define('_LOGGING',true);

    // DEBUGGING AUSGABE DEFINIEREN (FRONTEND)
    define('_DEBUGGING',false);

    // CONSTRUCTR BASE TITEL DEFINIEREN
    define('_TITLE','CONSTRUCTR');

    // FRONTEND BEFINDET SICH WO???
    define('_EXT_WWW',''); // for example: define('_EXT_WWW','./Web/index.php');

    // HTML_SEITE STATISCH AUSGEBEN
    define('_SERVE_STATIC',false);

    // STATISCHE HTML SEITE GENERIEREN
    define('_CREATE_STATIC',true);

    // VERZEICHNIS FÜR STATISCHE HTML SEITEN
    define('_STATIC_DIR','./Static/');