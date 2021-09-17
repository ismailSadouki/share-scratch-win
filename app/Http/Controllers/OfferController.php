<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Participant;
use App\Models\ValueOffer;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use Image;

class OfferController extends Controller
{
    public function index($slug)
    {
        
    }

    public function myOffers()
    {
        $offers = Offer::where('user_id', Auth::id())->get();
        return view('offer.myoffers', compact('offers'));
    }
    public function showMyOffer($id)
    {
        $offer = Offer::findOrFail($id)->first();
        $participants = Participant::where(['offer_id' => $id, 'status' => 2, ['value_offer_id', '!=', null] ])->get();
        // حساب و التحقق من عدد الجوائز المتبقية
        $remaining_offers = $offer->valueOffers()->sum('will_get');
        return view('offer.show_myoffer', compact('offer', 'participants','remaining_offers'));
    }

    public function create()
    {
        return view('offer.create');
    }
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'phone' => 'required',

            'address' => 'required',

            'roles' => 'required',

            'company_name' => 'required_without_all:company_logo',
            'company_logo' => 'required_without_all:company_name',

            'addMoreInputFields.*.value' => 'required_without_all:addMoreInputFields.*.image',
            'addMoreInputFields.*.image' => 'required_without_all:addMoreInputFields.*.value',
            'addMoreInputFields.*.count' => 'required',

        ]);

        $offer = new Offer();
        $offer->user_id = Auth::id();
        $offer->slug = SlugService::createSlug(Offer::class, 'slug', $request->name);
        $offer->name = $request->name;
        $offer->phone = $request->phone;
        $offer->address = $request->address;
        $offer->roles = $request->roles;
        if(isset($request->show_in_home)) {
            $offer->show_in_home = true;
        }
        // save image or name
        if(isset($request->company_logo)) {

            $img_name = time().'.'.$request->company_logo->getClientOriginalExtension();
            $request->company_logo->move(public_path('offers'), $img_name);    
            $offer->company_logo = $img_name;

        }else {
            $image = 'scratch.png';
            $img_name = time().'.'.'png';
     
            $imgFile = Image::make($image);
     
            $imgFile->text( $request->company_name , 700, 450, function($font) { 
                $font->file(base_path('public/Lalezar-Regular.ttf'));
                $font->size(120);  
                $font->color('#dbafaf');  
                $font->align('center');  
                $font->valign('bottom');  
            })->save(public_path('/offers').'/'.$img_name); 

            $offer->company_name = $img_name;

        }
        if(isset($request->date)) {
            if(isset($request->time)) {
                $offer->offer_end_in = $request->date.' '.$request->time;
            } else {
                $offer->offer_end_in = $request->date.' '.'00:00:00';
            }
        }
        $offer->save();

        // Add Offers Value
        foreach ($request->addMoreInputFields as $key => $value) {
            $valueOffer = new ValueOffer();
            $valueOffer->offer_id = $offer->id;

            // save image or value
            if (isset($value['image'])) {

                $valueOffer_img_name = time().$key.'.'.$value['image']->getClientOriginalExtension();
                $value['image']->move(public_path('valueOffers'), $valueOffer_img_name);    
                $valueOffer->image = $valueOffer_img_name;

            } else {
                $image = 'offerDefault.jpg';
                $valueOffer_img_name = time().$key.'.'.'jpg';
         
                $imgFile = Image::make($image);
         
                $imgFile->text( $value['value'] , 700, 450, function($font) { 
                    $font->file(base_path('public/Lalezar-Regular.ttf'));
                    $font->size(120);  
                    $font->color('#dbafaf');  
                    $font->align('center');  
                    $font->valign('bottom');  
                    // $font->angle(90);  
                })->save(public_path('/valueOffers').'/'.$valueOffer_img_name); 

                $valueOffer->value = $valueOffer_img_name;

            }
            $valueOffer->will_get = $value['count'];
            $valueOffer->save();
        }
        $url_share = $offer->slug;
        // return redirect()->back()->with('url_share', $offer->slug);
        return view('offer.create', compact('url_share'));
     
    }
    


    public function show($slug, $reference_code = null)
    {
        $offer = Offer::where('slug', $slug)->first();
    //  اسم الكوكيز
        $cookie_name = 'ip_address'.$offer->id.$offer->created_at;

        // حساب و التحقق من عدد الجوائز المتبقية
        $remaining_offers = $offer->valueOffers()->sum('will_get');
        // 
        $ip = FacadesRequest::ip();


        // get participant if exists
        $participant = Participant::where([
            'ip' => $ip,
            'offer_id' => $offer->id,
        ])->first();
        if(isset($participant)){
            $verification_ip = $participant->ip;
        }else {
            $verification_ip = '1';
        }


        // تحقق اذا دخل الصفحة من قبل عن طريق الايبي و الكوكيز
        if($verification_ip == $ip || Cookie::has($cookie_name)){
            // في حال الايبي لا يساوي الايبي المحفوظ لكن الكوكيز محفوظ
            if(!isset($participant)){
                $participant = Participant::where([
                    'ip' => Cookie::get($cookie_name),
                    'offer_id' => $offer->id,
                ])->first();
            }
            // // في حال الايبي موجود لكن الكوكيز غير موجود
            if (!Cookie::has($cookie_name)) {
                Cookie::queue(Cookie::make($cookie_name, $ip));
            }

            // احضار معلومات المشارك
            switch ($participant->status) {
                case '0':
                    $status = 0;
                    $valueOffer = $offer->valueOffers()->where('will_get', '>', '0')->inRandomOrder()->first();
                    return view('offer.show', compact('offer', 'status', 'remaining_offers','participant', 'valueOffer'));
                    break;
                case '1':
                    if ($remaining_offers >= 1) {
                        $status = 1;
                        $valueOffer = $offer->valueOffers()->where('will_get', '>', '0')->inRandomOrder()->first();
                        return view('offer.show', compact('offer', 'status', 'remaining_offers', 'valueOffer','participant'));
                    } else {
                        $status = 0;
                        return view('offer.show', compact('offer', 'status', 'remaining_offers','participant'));
                    }

                    break;
                case '2':
                    $status = 2;
                    $valueOffer = $participant->valueOffer()->first();
                    return view('offer.show', compact('offer', 'status', 'remaining_offers', 'valueOffer','participant'));
                    break;
                    
                default:
                    return back();
                    break;
            }
        } else {
            if($reference_code != null) {
                // تحديث حالة الشخص الداعي
                $promoter = Participant::where('reference_code', $reference_code)->first();
                if ($promoter){
                    if ($promoter->status == 0) {
                        $promoter->status = 1;
                        $promoter->update();
                    }
                }
                
            }

            // انشاء كوكيز
            Cookie::queue(Cookie::make($cookie_name, $ip));
            // create unique reference_code
            do 
            {
                $reference_code = str::random(9);
                $check_url = Participant::where('reference_code', $reference_code)->first();
            } while(!empty($check_url));
            // تسجيل ان هذا الشخص  دخل هذه الصفحة
            $participant = new Participant();
            $participant->offer_id = $offer->id;
            $participant->status = 0;
            $participant->ip = $ip;
            $participant->reference_code = $reference_code;
            $participant->save();
            
            $status = 0;

            return view('offer.show', compact('offer', 'status', 'remaining_offers', 'participant'));
                    
        }
            
        
    }
}
