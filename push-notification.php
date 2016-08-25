<?php

return array(
    'Assassin'     => array(
        'environment' => 'development',
        'certificate' => app_path().'/confirm.pem',
        'passPhrase'  => '',
        'service'     => 'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'yourAPIKey',
        'service'     =>'gcm'
    )

);
