@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/offer.css') }}">

    @if ($new == true)
        <script>
            if(localStorage["{{$offer->id}}"]) {
                var participantId = localStorage["{{$offer->id}}"];
                var offerId = "{{$offer->id}}";
                let url = "{{url('/of/show/:offerId/:participantId')}}";
                url = url.replace(':offerId', offerId);
                url = url.replace(':participantId', participantId);
                window.location.href = url;
            } 
            console.log(localStorage["{{$offer->id}}"]);
        </script> 
    @endif

  

@endsection

@section('content')

<canvas id="my-canvas" style="position: absolute;"></canvas>

<div class="row">
    <h2 style="color: #fff;text-align: center;z-index: 9;margin-top: 90px;">{{$offer->address}}</h2>
    @if ($status != 2 && $remaining_offers > 0)
        @if (Carbon\Carbon::now()->toDateTimeString() < $offer->offer_end_in || $offer->offer_end_in == null )

                <div class="col-lg-12 d-none " id="giftInStatus1"> 
                    <section  id="gift" >
                        <div class="gift"> 
                                <span id="giftBackground">
                                {{-- script --}}
                                </span>
                        </div>
                    </section>
                </div>
            
        @endif
    @endif    
    @if ($status == 2)
        <div class="col-lg-12">
            <section  id="gift" >
                <div class="gift">
                    @if($valueOffer->value != null)
                        <span id="giftBackground">
                            <img src="{{ asset('valueOffers/'.$valueOffer->value) }}">
                        </span>
                    @else     
                        <span id="giftBackground">
                            <img src="{{ asset('valueOffers/'.$valueOffer->image) }}">
                        </span>
                    @endif
                </div>
            </section>
        </div>
    @endif

            <div class="col-lg-12 {{ $status != 2 ? 'd-none' : '' }}" id="successElement" style="transition: .5s ease">
                <section  id="form" class="form">
                    <div class="loader">
                    <div class="dot" style="--i:0"></div>
                    <div class="dot" style="--i:1"></div>
                    <div class="dot" style="--i:2"></div>
                    <div class="dot" style="--i:3"></div>
                    <div class="dot" style="--i:4"></div>
                    <div class="dot" style="--i:5"></div>
                    <div class="dot" style="--i:6"></div>
                    <div class="dot" style="--i:7"></div>
                    <div class="dot" style="--i:8"></div>
                    <div class="dot" style="--i:9"></div>
                    </div>
                    @if ($participant->phone == null)
                        <h2>مبروك!ادخل رقمك</h2>   
                        <form action="{{ route('save.phone',$participant->id) }}" method="POST">
                            @csrf
                            <div class="input">
                                <div class="inputBox">
                                    <label for="phone">الواتساب الخاص بك</label>
                                    @if($errors->any())
                                        <label style="color:red; background-color: red;color: #fff;">{{$errors->first()}}</label>
                                    @endif
                                    <input type="text" name="phone" placeholder="+2130984xxxx">
                                </div>
                            </div>     
                           
                    @else 
                        <h2>مبروك!تم تسجيلك كفائز</h2>     
                    @endif
                   
                    <div class="buttons">
                        @if ($participant->phone == null)
                                <div class="buttonBox">
                                    <input type="submit" value="ارسال رقمك" id="">
                                </div>
                            </form>  
                        @endif    

                        <div class="buttonBox">
                            @if ($status == 2 || $remaining_offers > 0)                 
                                @if($valueOffer->value != null)
                                    <a href="{{ route('download.img', $valueOffer->value) }}">احفظ الصورة</a>
                                @else     
                                    <a href="{{ route('download.img', $valueOffer->image) }}">احفظ الصورة</a>
                                @endif
                            @endif
                          
                        </div>
                    </div>
                    <div class="loader">
                    <div class="dot" style="--i:0"></div>
                    <div class="dot" style="--i:1"></div>
                    <div class="dot" style="--i:2"></div>
                    <div class="dot" style="--i:3"></div>
                    <div class="dot" style="--i:4"></div>
                    <div class="dot" style="--i:5"></div>
                    <div class="dot" style="--i:6"></div>
                    <div class="dot" style="--i:7"></div>
                    <div class="dot" style="--i:8"></div>
                    <div class="dot" style="--i:9"></div>
                    </div>
                </section>

</div>

<div class="row">
    @if ($status != 2)
        
    <div class="col-lg-5">
        <section id="square" class="">
  
          <div class="square">
              <span></span>
              <span></span>
              <span></span>
              <div class="content">
                  @if ($remaining_offers > 0 || $status == 2)
                      <h2>ملاحظة</h2>
                      <p>عليك اولا مشاركة العرض مع شخص واحد على الأقل و يدخل الرابط الخاص بك لتتمكن من مسح الصورة و رؤية هديتك!</p>
                      <a href="https://wa.me/?text=%0aمرحبا...%0aساعدني في مسابقة امسح و اربح معي هدية و يطلب مني حتى احصل عليها ان تشاركني فيها%0a{{ "sadouki-scratch-win.herokuapp.com/offer/show/{$offer->slug}/$participant->reference_code" }}%0aيمكنك ان تربح انت ايضا!" target="_blank">مشاركة</a> <br>
                      <a href="{{ url("/offer/show/{$offer->slug}/$participant->reference_code") }}" class="d-none" id="url_share">مشاركة</a>
                      <input type="submit" value="نسخ الرابط" class="btn btn-primary" id="copy">
                  @else    
                      <h2>انتهت الجوائز او وقت المسابقة!</h2>
                  @endif
                  
              </div>
          </div>
        </section>
    </div>
    @endif

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
                <h2 class="end-clock">لم يتم تحديد وقت لانتهاء المسابقة!</h2>
            @endisset
          
        </div>
    </div>
   </section> 

@endsection
@section('scripts')

    {{-- Confetti Effect --}}
    <script type="text/javascript" src="{{asset('js/confetti.min.js')}}"></script>
    <script>
                        console.log('localstorage' + localStorage["{{$offer->id}}"]);
        console.log('status' +"{{$status}}");
        
        var confettiSettings = { target: 'my-canvas',height: '2000',max: '200' };
        var confetti = new ConfettiGenerator(confettiSettings);
    </script>



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
            //  error countDownDate "is NaN" in some browser
            if (!countDownDate) {
                var dateStr= "{{$offer['offer_end_in']}}"; //returned from mysql timestamp/datetime field
                var a=dateStr.split(" ");
                var d=a[0].split("-");
                var t=a[1].split(":");
                var countDownDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
            }

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

@if ($status == 0 && $remaining_offers > 0)
    {{-- scratch to win --}}
    <script type="text/javascript" src="{{asset('js/wScratchPad.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

    {{-- Fatch Status with ajax if status 1 --}}
    <script>
        function fetchdata(){
            $.ajaxSetup({
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            });
            jQuery.ajax({
                url:"/check/status/"+"{{ $participant->id }}",
                type: 'GET',
                success: function( data ){
                    if (data.status == 1) {
                        // delete share section 
                        
                        var squaresquare = document.getElementById("square");
                        squaresquare.classList.add('d-none');
                        squaresquare.style.display = "none";

                        // show success page
                        var giftInStatus1 = document.getElementById("giftInStatus1");
                        giftInStatus1.classList.remove('d-none');
                        // scratch to win
                        var executed = false;  
                        var e = $('#giftBackground').wScratchPad({
                            size        : 50,          // The size of the brush/scratch.
                            bg          : "{{ isset($valueOffer->image) ? asset('valueOffers/'.$valueOffer->image) : asset('valueOffers/'.$valueOffer->value) }}",  // Background (image path or hex color).
                            fg          : "{{ asset('scratch3.jpg') }}",  // Foreground (image path or hex color).
                            realtime    : true,       // Calculates percentage in realitime.
                            scratchMove: function(e, percent) {
                                if (!executed) {
                                    if(percent >= 25) {
                                        executed = true;
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        let participant_id = "{{ $participant->id }}";
                                        let valueOffer_id = "{{$valueOffer->id}}";
                                        $.ajax({
                                            type: 'post',
                                            url: "{{ route('offer.success') }}",
                                            data: {
                                                'participant_id': participant_id,
                                                'valueOffer_id': valueOffer_id,
                                            },
                                            success: function (data) {
                                            
                                                if(data.status == true) {
                                                    var squaresquare = document.getElementById("square");
                                                    squaresquare.classList.add('d-none');
                                                    squaresquare.style.display = "none";
                                                    var successElement = document.getElementById("successElement");
                                                    successElement.classList.remove('d-none');
                                                    confetti.render();
                                                } else {
                                                
                                                }
                                                
                                            }, error: function(reject) {
                                                console.log('error , reject');
                                                
                                            }
                                        });
                                    }
                                }
                            },
                            cursor      : 'progress', // Set cursor.
                            
                            });

  
                        console.log(data.status);
                    } else {
                        setTimeout(fetchdata,3000);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        $(document).ready(function(){
            setTimeout(fetchdata,1000);
        });
    </script>
@endif    
@if ($status == 1 && $remaining_offers > 0)
    {{-- scratch to win --}}
    <script type="text/javascript" src="{{asset('js/wScratchPad.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    
    {{-- Fatch Status with ajax if status 1 --}}
    <script>

    var giftInStatus1 = document.getElementById("giftInStatus1");
    giftInStatus1.classList.remove('d-none');
    // scratch to win
    var executed = false;  
    var e = $('#giftBackground').wScratchPad({
        size        : 50,          // The size of the brush/scratch.
        bg          : "{{ isset($valueOffer->image) ? asset('valueOffers/'.$valueOffer->image) : asset('valueOffers/'.$valueOffer->value) }}",  // Background (image path or hex color).
        fg          : "{{ asset('scratch3.jpg') }}",  // Foreground (image path or hex color).
        realtime    : true,       // Calculates percentage in realitime.
        scratchMove: function(e, percent) {
            if (!executed) {
                if(percent >= 25) {
                    executed = true;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    let participant_id = "{{ $participant->id }}";
                    let valueOffer_id = "{{$valueOffer->id}}";
                    $.ajax({
                        type: 'post',
                        url: "{{ route('offer.success') }}",
                        data: {
                            'participant_id': participant_id,
                            'valueOffer_id': valueOffer_id,
                        },
                        success: function (data) {
                        
                            if(data.status == true) {
                                var squaresquare = document.getElementById("square");
                                squaresquare.classList.add('d-none');
                                squaresquare.style.display = "none";
                                var successElement = document.getElementById("successElement");
                                successElement.classList.remove('d-none');
                                confetti.render();
                                // console.log('success , true');
                            } else {
                            
                                // console.log('success , false');
                            }
                            
                        }, error: function(reject) {
                            console.log('error , reject');
                            
                        }
                    });
                }
            }
            
            // if (percent >= 63) {
            //     $('canvas').css("display", "none");
            // }
        },
        cursor      : 'progress', // Set cursor.
        
        });

     
    </script>
@endif   

@if($status == 2)
    <script>
        confetti.render();
    </script>    
@endif



{{-- if new partecipant --}}
@if ($new == true)
    <script>
        if(!localStorage["{{$offer->id}}"]) {
            localStorage["{{$offer->id}}"] = "{{$participant->id}}";
            // add cookie and session
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let cookie_name = "{{ $cookie_name }}";
            let ip = "{{$ip}}";
            $.ajax({
                type: 'post',
                url: "{{ route('session.cookie') }}",
                data: {
                    'cookie_name': cookie_name,
                    'ip': ip,
                },
                success: function (data) {

                    console.log(data.status);
                
                }, error: function(reject) {
                    console.log('error , reject'); 
                }
            });
        }
    </script> 
@endif

@endsection