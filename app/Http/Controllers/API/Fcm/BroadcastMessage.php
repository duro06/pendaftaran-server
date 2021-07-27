<?php

namespace App\Http\Controllers\API\Fcm;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Illuminate\Support\Facades\Auth;

use App\Models\Pendaftar;

class BroadcastMessage extends Controller
{
    
    
    public static function sendMessage($sender, $message, $link, $token)
    {   

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('From ' . $sender);
        $notificationBuilder->setBody($message)
                            ->setSound('default')
                            ->setClickAction($link);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['sender' => $sender, 'message'=>$message, 'click_action'=>$link]);

        $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        $notification = null;
        $data = $dataBuilder->build();

        // $tokens = User::all()->pluck('fcm_token')->toArray();

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        return $downstreamResponse->numberSuccess();
    }

    //ini di gunakan ketika user sudah mendaftar dan akan mengupdate kelengkapan dokumen
    public function keteranganPendaftar($user){
        // $user=Auth::user();
        if($user->pendaftar_id!==null){
            $pendaftar=Pendaftar::find($user->pendaftar_id);
            $pendaftar->keterangan=$user->name;
            $pendaftar->save();
        }
    }
}
