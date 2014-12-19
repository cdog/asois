<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>{{-- .navbar-toggle collapsed --}}
      <a class="navbar-brand" href="{{ URL::to('/') }}">ASOIS</a>
    </div>{{-- .navbar-header --}}
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li {{ Request::is('/') || Request::is('polls/*') ? 'class="active"' : '' }}>
          <a href="{{ URL::to('/') }}">Polls</a>
        </li>
        @if (Auth::check() && Auth::user()->can('read_events'))
          <li {{ Request::is('events') ? 'class="active"' : '' }}>
            <a href="{{ URL::to('events') }}">Events</a>
          </li>
        @endif
      </ul>{{-- .nav .navbar-nav --}}
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
          <li {{ Request::is('join') ? 'class="active"' : '' }}>
            <a href="{{ URL::to('join') }}">Sign up</a>
          </li>
          <li {{ Request::is('login') ? 'class="active"' : '' }}>
            <a href="{{ URL::to('login') }}">Sign in</a>
          </li>
        @else
          <li><a href="{{ URL::to('logout') }}">Sign out</a></li>
        @endif
      </ul>{{-- .nav .navbar-nav .navbar-right --}}
    </div>{{-- #navbar .collapse .navbar-collapse --}}
  </div>{{-- .container --}}
</nav>{{-- .navbar .navbar-inverse .navbar-static-top --}}
