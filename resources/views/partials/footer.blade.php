<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            {{-- Brand Column --}}
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="logo">The<span>.</span>Journal</a>
                <p>A home for thoughtful writing. Share your ideas, stories, and insights with a community that values depth over noise.</p>
            </div>

            {{-- Explore --}}
            <div class="footer-col">
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ url('/blog') }}">All Articles</a></li>
                    <li><a href="{{ url('/topics') }}">Topics</a></li>
                    <li><a href="{{ url('/writers') }}">Writers</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                </ul>
            </div>

            {{-- Account --}}
            <div class="footer-col">
                <h4>Account</h4>
                <ul>
                    @auth
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/new-post') }}">New Post</a></li>
                        <li><a href="{{ url('/profile') }}">Profile</a></li>
                        <li><a href="{{ url('/settings') }}">Settings</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('register') }}">Create Account</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Legal --}}
            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ url('/terms') }}">Terms of Service</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="{{ url('/rss') }}">RSS Feed</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'The Journal') }}. All rights reserved.</span>
            <span>Built with care &amp; <a href="https://laravel.com" target="_blank" rel="noopener">Laravel</a>.</span>
        </div>
    </div>
</footer>
