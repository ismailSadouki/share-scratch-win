<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\ValueOffer;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ParticipantController extends Controller
{
    public function offerSuccess(Request $request) {
        try {
            $valueOffer = ValueOffer::findOrFail($request->valueOffer_id);
            $valueOffer->will_get -= 1;
            $valueOffer->update(); 
    
            $participant = Participant::findOrFail($request->participant_id);
            $participant->status = 2;
            $participant->value_offer_id = $request->valueOffer_id;
            $participant->update();
        } catch (Error $e) {
            report($e);
            return response()->json([
                'status' => false,
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
        


        
       
    }


    public function savePhone(Request $request, $id) 
    {
        $participant = Participant::findOrFail($id);
        $participant->phone = $request->phone;
        $participant->update();

        return back();
    }

    public function downloadImg($img) 
    {
        $file = public_path(). "/valueOffers/".$img;
        $headers = array(
            'Content-Type: image/*',
          );

        return Response::download($file, $img, $headers);
    }
}
