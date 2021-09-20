<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}">امسح و اربح معنا</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="{{route('home')}}">الرئيسية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('offer.create')}}">انشاء عرض</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('myoffers')}}">عروضي</a>
            </li>
          </ul>
          @auth
            <a class="btn btn-outline-success" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
            {{ __('تسجيل الخروج') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          @else     
            <a href="{{route('login')}}" class="btn btn-outline-success">دخول / تسجيل</a>
          @endauth
    
        </div>
      </div>
    </nav>
  </header>