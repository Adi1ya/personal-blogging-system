<nav class="site-nav" id="site-nav">
    <div class="container">
        <div class="nav-inner">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="nav-logo">
                The<span>.</span>Journal
            </a>

            {{-- Desktop Navigation Links --}}
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/blog') }}">Articles</a></li>
                <li><a href="{{ url('/topics') }}">Topics</a></li>
                <li><a href="{{ url('/about') }}">About</a></li>
            </ul>

            {{-- Auth Actions --}}
            <div class="nav-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-ghost">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Sign Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Start Writing</a>
                @endauth

                {{-- Mobile Toggle --}}
                <button class="nav-toggle" id="nav-toggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="nav-mobile" id="nav-mobile">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/blog') }}">Articles</a>
        <a href="{{ url('/topics') }}">Topics</a>
        <a href="{{ url('/about') }}">About</a>
        @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Sign In</a>
            <a href="{{ route('register') }}">Start Writing — it's free</a>
        @endauth
    </div>
</nav>
