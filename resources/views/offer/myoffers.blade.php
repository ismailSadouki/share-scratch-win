@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')

     <!-- section-card------------------------------------------------- -->
     <section id="movies" class="movies">
        <div class="container">
  
            @forelse ($offers as $offer)
            <div class="card">
                <div class="imgBx">
                    @if ($offer->company_logo != null)
                        <img src="{{asset('offers/'.$offer->company_logo)}}" alt="img movie">
                    @else
                        <img src="{{asset('offers/'.$offer->company_name)}}" alt="img movie">
                    @endif
                </div>
                <div class="content">
                <p>{{$offer->name}}</p>
                <div class="card-btns">
                    <a href="{{route('show.myoffers', $offer->id)}}" class="play-btn">عرض<i class="fas fa-play"></i></a>
                </div>
                </div>
            </div>
                
            @empty
                <h2 style="color:#fff">لم تنشئ اي عروض!</h2>
            @endforelse
          
  
         
          
  
        </div>
      </section>
@endsection
