<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
      <a class="navbar-brand" href="#">3zoz</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{route('home')}}">{{__('Home')}}</a>
              </li>
              @auth
              <li class="nav-item">
                  <a class="nav-link" href="{{route('logout')}}" >{{__('Logout')}}</a>
              </li>
              @else
              <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">{{__('Login')}}</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{route('registration')}}">{{__('Register')}}</a>
              </li>
              @endauth
          </ul>
          <div id="languageToggle" class="navbar-text ms-auto d-flex">
            <button onclick="toggleLanguage()">{{__('Toggle Language')}}</button>
          </div>
          <span class="navbar-text ms-auto d-flex">
              @auth
              Hi, {{auth()->user()->user_name}}
              @endauth
          </span>
      </div>
  </div>
</nav>
<script>
    function toggleLanguage() {
        var currentLang = document.documentElement.lang;
        var newLang = currentLang === 'en' ? 'ar' : 'en';
        window.location.href = "{{ url('lang/') }}" + newLang;
    }
</script>