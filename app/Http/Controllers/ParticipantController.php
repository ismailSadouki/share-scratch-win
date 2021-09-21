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
        $phone_exists = Participant::where([
                                                'offer_id' => $participant->offer_id,
                                                'phone' => $request->phone
                                                ])->first();
        if ($phone_exists != null) {
            return back()->withErrors(['msg' => 'هذا الرقم مسجل من قبل في هذه المسابقة!']);
        }
        $participant->phone = $request->phone;
        $participant->update();

        // send message to winner in whatssapp
        // try {

        // } catch (Error $e) {
        //     report($e);
        //     return back();
        // }

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


    public function checkStatus($id) 
    {
        try {
            $participant = Participant::findOrFail($id);
        } catch (Error $e) {
            report($e);
            return response()->json([
                'status' => false,
            ]);
        }

        return response()->json([
            'status' => $participant->status,
        ]);
    }
}
