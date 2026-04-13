@extends('layouts.auth')

@section('title', 'Create Account — ' . config('app.name', 'The Journal'))

@section('content')
<div class="auth-main">

    {{-- ── Left Panel ── --}}
    <div class="auth-panel auth-panel-left">
        <div class="auth-deco-circle auth-deco-circle-1"></div>
        <div class="auth-deco-circle auth-deco-circle-2"></div>
        <div class="auth-deco-line" style="left: 60%;"></div>

        <div class="auth-panel-content">
            <a href="{{ url('/') }}" class="auth-brand">The<span>.</span>Journal</a>

            <h2>Your ideas<br>deserve an<br><span style="color:var(--accent); font-style:italic;">audience.</span></h2>
            <p>
                Join a community of thoughtful writers and readers.
                Free forever — no paywalls, no algorithmic noise.
            </p>

            <ul class="auth-features">
                <li>
                    <div class="auth-feature-icon">✦</div>
                    <span>Publish unlimited articles with a beautiful editor</span>
                </li>
                <li>
                    <div class="auth-feature-icon">◈</div>
                    <span>Build a personal blog and grow your readership</span>
                </li>
                <li>
                    <div class="auth-feature-icon">❋</div>
                    <span>Discover and connect with writers you admire</span>
                </li>
                <li>
                    <div class="auth-feature-icon">◆</div>
                    <span>Your writing, your way — always in your control</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- ── Right Panel: Form ── --}}
    <div class="auth-panel auth-panel-right">
        <div class="auth-form-wrap">

            <h1>Create Account</h1>
            <p class="subtitle">Free to join. Start writing in minutes.</p>

            <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Your name"
                        autocomplete="name"
                        autofocus
                        required
                    >
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

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
                        required
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Min. 8 characters"
                        autocomplete="new-password"
                        required
                    >
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repeat your password"
                        autocomplete="new-password"
                        required
                    >
                </div>

                {{-- Terms --}}
                <div class="form-group">
                    <div class="form-check" style="align-items:flex-start;">
                        <input type="checkbox" id="terms" name="terms" class="form-check-input"
                               style="margin-top:3px;"
                               {{ old('terms') ? 'checked' : '' }} required>
                        <label for="terms" class="form-check-label" style="line-height:1.5;">
                            I agree to the
                            <a href="{{ url('/terms') }}" style="color:var(--accent);">Terms of Service</a>
                            and
                            <a href="{{ url('/privacy') }}" style="color:var(--accent);">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms')
                        <span class="invalid-feedback" style="display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Create My Account
                </button>
            </form>

            <div class="auth-switch">
                Already have an account?
                <a href="{{ route('login') }}">Sign in →</a>
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
