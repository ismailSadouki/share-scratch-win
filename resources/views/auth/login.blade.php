@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css')}} ">
@endsection

@section('content')



<div class="hero">
    <div class="form-box">
        <div class="button-box">
            <div id="btn"></div>
            <button type="button" class="toggle-btn" onclick="loginBtn()">{{ __('دخول') }}</button>
            <button type="button" class="toggle-btn" onclick="registerBtn()">{{ __('تسجيل') }}</button>
        </div>
        {{-- login --}}
        <form id="login" method="POST" action="{{ route('login') }}" class="input-group">
            @csrf
            <input type="email" name="email" id="email" class="input-field @error('email') is-invalid @enderror" placeholder="{{ __('البريد الالكتروني') }}" required autocomplete="email" style="text-align:right">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="password" name="password" id="password" class="input-field @error('password') is-invalid @enderror" placeholder="{{ __('كلمة السر') }}" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

   
                
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('تذكرني') }}
                        </label>
                    </div>
                    {{-- @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('نسيت كلمة السر') }}
                        </a>
                    @endif --}}
         

            <button type="submit" class="submit-btn" style="margin-top: 40px !important;"> {{ __('دخول') }}</button>
        </form>


        {{-- register --}}

        <form id="register" method="POST" action="{{ route('register') }}" class="input-group">
            @csrf

            <input type="text"  id="name" class="input-field @error('name') is-invalid @enderror" placeholder="{{ __('الاسم') }}" name="name" value="{{ old('name') }}" required autocomplete="name">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input type="email" id="email" class="input-field @error('email') is-invalid @enderror" placeholder="{{ __('البريد الالكتروني') }}" name="email" value="{{ old('email') }}" required autocomplete="email" style="text-align: right">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <input type="password" id="password" class="input-field @error('password') is-invalid @enderror" placeholder="{{ __('كلمة السر') }}" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <input type="password" id="password-confirm" class="input-field" placeholder="{{ __('تأكيد كلمة السر') }}" name="password_confirmation" required autocomplete="new-password">



            <button type="submit" class="submit-btn">{{ __('تسجيل') }}</button>
        </form>


    </div>
</div>

@endsection
@section('scripts')
<script>
    var login = document.getElementById("login"); 
    var register = document.getElementById("register"); 
    var btn = document.getElementById("btn"); 

    function registerBtn() {
        login.style.right = "-400px";
        register.style.right = "50px";
        btn.style.right = "110px";
    }
    function loginBtn() {
        login.style.right = "50px";
        register.style.right = "450px";
        btn.style.right = "0";
    }

</script>
@endsection