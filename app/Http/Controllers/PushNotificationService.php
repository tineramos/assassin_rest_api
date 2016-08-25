<?php

$PushNotificationService = PushNotification::app(['environment' => 'development',
                                    'certificate' => base_path('confirm.pem'),
                                    'passPhrase'  => '',
                                    'service'     => 'apns']);
return $PushNotificationService;

?>
