<?php

namespace App\Http\Controllers;

use App\Model\Weapon;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use PushNotification;

// use Davibennun\LaravelPushNotification\App;
// use Davibennun\LaravelPushNotification\LaravelPushNotification;
// use Davibennun\LaravelPushNotification\PushNotification;
// use Davibennun\LaravelPushNotification\Facades\PushNotification;

class PushNotificationController extends Controller
{
    private $sslPem = 'confirm.pem';

    public function sendNotificationToDevice() {

        $deviceToken = '9f3d805169b891f5fb8c237e101843fe8067ebadf34cc193c060f0e61ffd99f4';
        $message = 'Tine eto na ung push notif!!';

        $dir = base_path('confirm.pem');
        // echo "Full path " . $dir;

        $pushNotif = PushNotification::app(['environment' => 'development',
                                            'certificate' => $dir,
                                            'passPhrase'  => '',
                                            'service'     => 'apns']);

        $pushNotif->to($deviceToken)
                  ->send($message);

    }

}

?>
