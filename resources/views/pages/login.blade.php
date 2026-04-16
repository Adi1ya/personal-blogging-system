@extends('layouts.app')

@section('title', 'Login | PulsePress')
@section('page', 'login')

@section('content')
    <section class="auth-shell">
        <div class="auth-panel">
            <div>
                <span class="eyebrow">Welcome back</span>
                <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">Sign in to keep publishing.</h1>
                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">Your access token is stored locally and attached automatically to protected API requests.</p>
            </div>

            <form id="login-form" class="mt-8 space-y-5">
                <div>
                    <label for="login-email" class="label">Email</label>
                    <input id="login-email" name="email" type="email" class="input-field" placeholder="writer@example.com" required>
                </div>
                <div>
                    <label for="login-password" class="label">Password</label>
                    <input id="login-password" name="password" type="password" class="input-field" placeholder="••••••••" required>
                </div>
                <button type="submit" class="primary-button w-full justify-center">Login</button>
            </form>

            <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
                New here?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-cyan-300 dark:hover:text-cyan-200">Create an account</a>
            </p>
        </div>
    </section>
@endsection
