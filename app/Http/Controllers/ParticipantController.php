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
        $offer = $participant->offer()->first();
        $phone_exists = Participant::where([
                                                'offer_id' => $participant->offer_id,
                                                'phone' => $request->phone
                                                ])->first();
        if ($phone_exists != null) {
            return back()->withErrors(['msg' => 'هذا الرقم مسجل من قبل في هذه المسابقة!']);
        }
        $participant->phone = $request->phone;
        $participant->update();

        // https://api.chat-api.com/instance333384/ and token h1y560qmxws7w3rh
        // send message to winner in whatssapp
        try {

            // the winner################################################

            $data = [
                'phone' => '968'.$request->phone, // Receivers phone
                'body' => "مبروك لقد ربحت في العرض $offer->name \n نرجو تواصل معك \n رقم $offer->phone", // Message
            ];
            $json = json_encode($data); // Encode data to JSON
            // URL for request POST /message
            $token = 'h1y560qmxws7w3rh';
            $instanceId = '333384';
            $url = 'https://api.chat-api.com/instance'.$instanceId.'/message?token='.$token;
            // Make a POST request
            $options = stream_context_create(['http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $json
                ]
            ]);
            // Send a request
            $result = file_get_contents($url, false, $options);





            // the creater of offer #####################################

            $data_2 = [
                'phone' => '968'.$offer->phone, // Receivers phone
                'body' => "صاحب الرقم $request->phone ربح في عرضك \n اذهب الى عروضي لمعرفة الفائزين.", // Message
            ];
            $json_2 = json_encode($data_2); // Encode data to JSON
            // Make a POST request
            $options_2 = stream_context_create(['http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $json_2
                ]
            ]);
            // Send a request
            $result_2 = file_get_contents($url, false, $options_2);
        } catch (Error $e) {
            report($e);
            return back();
        }

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
