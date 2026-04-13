@extends('layouts.auth')

@section('title', 'Sign In — ' . config('app.name', 'The Journal'))

@section('content')
<div class="auth-main">

    {{-- ── Left Panel ── --}}
    <div class="auth-panel auth-panel-left">
        {{-- Decorative --}}
        <div class="auth-deco-circle auth-deco-circle-1"></div>
        <div class="auth-deco-circle auth-deco-circle-2"></div>
        <div class="auth-deco-line" style="left: 30%;"></div>

        <div class="auth-panel-content">
            <a href="{{ url('/') }}" class="auth-brand">The<span>.</span>Journal</a>

            <h2>Good to have<br>you back.</h2>
            <p>
                Your drafts, your readers, and your ideas are waiting.
                Sign in and pick up right where you left off.
            </p>

            <ul class="auth-features">
                <li>
                    <div class="auth-feature-icon">✦</div>
                    <span>Access all your published posts and drafts</span>
                </li>
                <li>
                    <div class="auth-feature-icon">◈</div>
                    <span>See who's reading and engaging with your work</span>
                </li>
                <li>
                    <div class="auth-feature-icon">❋</div>
                    <span>Continue reading your saved articles</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- ── Right Panel: Form ── --}}
    <div class="auth-panel auth-panel-right">
        <div class="auth-form-wrap">

            <h1>Sign In</h1>
            <p class="subtitle">Welcome back. Enter your details below.</p>

            <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autocomplete="email"
                        autofocus
                        required
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <label for="password" class="form-label">Password</label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               style="font-size:0.8125rem; color:var(--accent); font-weight:500;">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="form-check">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="form-check-label">Keep me signed in for 30 days</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Sign In to My Account
                </button>
            </form>

            <div class="auth-switch">
                Don't have an account?
                <a href="{{ route('register') }}">Create one for free →</a>
            </div>

            {{-- Back to site --}}
            <div style="text-align:center; margin-top:2rem;">
                <a href="{{ url('/') }}"
                   style="font-size:0.8125rem; color:var(--ink-muted); transition:color 0.2s;"
                   onmouseover="this.style.color='var(--ink)'"
                   onmouseout="this.style.color='var(--ink-muted)'">
                    ← Back to The Journal
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
