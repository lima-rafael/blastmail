<?php

namespace App\Http\Controllers;

use App\Models\CampaignMail;
use Illuminate\Http\Request;

class TrakingController extends Controller
{
    public function openings(CampaignMail $mail)
    {
        if(! $mail->campaigns->track_open ){
            return;
        }

        $mail->openings++;
        $mail->save();
    }

    public function clicks(CampaignMail $mail)
    {
        if($mail->campaigns->track_click ){
            $mail->clicks++;
            $mail->save();
        }
     

        return redirect()->away(
            request()->get('f')
        );
    }
}
