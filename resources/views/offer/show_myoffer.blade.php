@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/offer.css') }}">

    <style>
        .participants {
            margin: 20px auto;
            max-width: 80%;
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 150px;
            flex-direction: column;
        }
        .participants h2 
        {
            color: #fff;
            margin-bottom: 20px;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')



    <div class="row">
        <div class="col-lg-7">
            <section id="info" class="info">
                <div class="box">
                    <i class="fa fa-quote-left fa2"></i>
                    <div class="text">
                        <i class="fa fa-quote-right fa1"></i>
                        <div class="content">
                        <div class="offer-info">
                            <div class="my-col">
                            <h2>الاسم:</h2>
                            <p>{{ $offer->name }}</p>
                            </div>
                            <div class="my-col">
                            <h2>رقم الهاتف:</h2>
                            <p>{{ $offer->phone }}</p>
                            </div>
                            <div class="my-col">
                            <h2>العنوان:</h2>
                            <p>{{ $offer->address }}</p>
                            </div>
            
                        </div>
                        <h2 style="padding-top: 10px;">قوانين المشاركة</h2>
                        <p>{{ $offer->roles }}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-5">
        <section id="square" >

            <div class="square">
                <span></span>
                <span></span>
                <span></span>
                <div class="content">
                    @if ($remaining_offers > 0)
                        <h2>ملاحظة</h2>
                        <p>رابط مشاركة المسابقة الخاصة بك!</p>
                        <a href="https://wa.me/?text={{ url("/offer/show/{$offer->slug}") }}" target="_blank" >مشاركة</a> <br>
                        <a href="{{ url("/offer/show/{$offer->slug}") }}" class="d-none" id="url_share">مشاركة</a>
                        <input type="submit" value="نسخ الرابط" class="btn btn-primary" id="copy">
                    @else    
                        <h2>انتهت الجوائز او وقت المسابقة!</h2>
                    @endif
                    
                </div>
            </div>
        </section>
        </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
  
        <section id="participants" class="participants table-responsive">
            <h2>الفائزون في مسابقتك</h2>
            <table class="table table-light table-hover " style="border: 4px solid #597693 !important;">
                <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col" style="text-align: center">واتساب</th>
                      <th scope="col" style="text-align: center">العرض</th>
                    </tr>
                  </thead>
                  <tbody>
                      @forelse ($participants as $participant)
                            <tr>
                                <th scope="row">1</th>
                                <td style="text-align: center">
                                    <span style="position: relative;top: 30px;">
                                        {{$participant->phone ?? 'لم يدخل رقمه بعد!'}}

                                    </span>
                                </td>
                                <td style="text-align: center">
                                    <img src="{{$participant->valueOffer->image != null ?  asset('valueOffers/'.$participant->valueOffer->image) : asset('valueOffers/'.$participant->valueOffer->value) }}" style="width: 100px;
                                    height: 100px;
                                    border-radius: 100%;">
                                </td>
                            </tr>
                      @empty
                        <tr>
                            <th scope="row">1</th>
                            <td style="text-align: center">لا يوجد اي فائز</td>
                            <td style="text-align: center">لا يوجد اي فائز</td>
                        </tr>
                      @endforelse
                
                  </tbody>
              </table>
        </section>
     
    </div>
  </div>

    

  
   <section class="sectionClock" id="sectionClock">
    <div class="clock">
        <div class="inner" id="clock-inner">
            @isset($offer['offer_end_in'])
                <div id="ampm">تنتهي بعد:</div>

                <h2 id="seconds">00</h2>
                <h2 class="dot">:</h2>
                <h2 id="minute">00</h2>
                <h2 class="dot">:</h2>
                <h2 id="hour">00</h2>
                <h2 class="dot">:</h2>
                <h2 id="days">00</h2>
            @else   
                <h2 style="font-size: 1.7em;color: #dbafaf;">لم يتم تحديد وقت لانتهاء المسابقة!</h2>
            @endisset
          
        </div>
    </div>
   </section> 

@endsection
@section('scripts')




{{-- copy button --}}
    <script>
          $(document).on('click', '#copy', function(e) {
              e.preventDefault();
              var $temp = $("<input>");
              var $url = $('#url_share').attr('href');
              $("body").append($temp);
              $temp.val($url).select();
              document.execCommand("copy");
              $temp.remove();
          })
    </script>



    {{-- clock end --}}
    <script>
        if("{{isset($offer['offer_end_in'])}}") {
            var countDownDate = new Date("{{$offer['offer_end_in']}}").getTime();
            function clock() {
                var now = new Date().getTime();

                var distance = countDownDate - now;

                let days = document.getElementById('days'); 
                let hour = document.getElementById('hour'); 
                let minute = document.getElementById('minute'); 
                let seconds = document.getElementById('seconds'); 

                var d = Math.floor(distance / (1000 * 60 * 60 * 24));
                let h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let s = Math.floor((distance % (1000 * 60)) / 1000);
       
                d = ( d < 10 ) ? '0' + d : d; 
                h = ( h < 10 ) ? '0' + h : h; 
                m = ( m < 10 ) ? '0' + m : m; 
                s = ( s < 10 ) ? '0' + s : s; 

                days.innerHTML = d;
                hour.innerHTML = h;
                minute.innerHTML = m;
                seconds.innerHTML = s;

                if (distance < 0) {
                    const clockInner = document.getElementById("clock-inner");
                    while (clockInner.firstChild) {
                        clockInner.removeChild(clockInner.lastChild);
                    }
                    var tag = document.createElement("h2");
                    var text = document.createTextNode("انتهت المسابقة!");
                    tag.appendChild(text);
                    var element = document.getElementById("clock-inner");
                    element.appendChild(tag);
                    tag.style.fontSize = '1.5s';
                    tag.style.color = '#dbafaf';
                    clearInterval(interval);
                }
            }
            var interval = setInterval(clock, 1000);
        }
    </script>  



@endsection