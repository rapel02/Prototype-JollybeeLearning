<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="/">Jollybee Learning</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/materials">Material</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/problems">Problem</a>
      </li>
      @if(!Auth::guest() && Auth::user()->authentication >= 1)
        <li class="nav-item">
          <a class="nav-link" href="/topics">Topic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/users">User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/files">File</a>
        </li>
      @endif
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @else
            <li class="nav-item">
                <div class="nav-link">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
  </div>
</nav>