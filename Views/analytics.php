<?php

    $constructr -> post('/constructr/analytics/', function () use ($constructr)
        {
            $RES = constructr_sanitization($constructr -> request() -> post('result'),true,true);
            $constructr -> getLog() -> info($RES);
        }
    );