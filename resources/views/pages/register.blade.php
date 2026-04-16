@extends('layouts.app')

@section('title', 'Register | PulsePress')
@section('page', 'register')

@section('content')
    <section class="auth-shell">
        <div class="auth-panel">
            <div>
                <span class="eyebrow">Create your space</span>
                <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">Launch your writer profile in minutes.</h1>
                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">Start with your account, then head straight into a clean dashboard for writing and publishing.</p>
            </div>

            <form id="register-form" class="mt-8 space-y-5">
                <div>
                    <label for="register-name" class="label">Name</label>
                    <input id="register-name" name="name" type="text" class="input-field" placeholder="Aditya Kumar" required>
                </div>
                <div>
                    <label for="register-email" class="label">Email</label>
                    <input id="register-email" name="email" type="email" class="input-field" placeholder="writer@example.com" required>
                </div>
                <div>
                    <label for="register-password" class="label">Password</label>
                    <input id="register-password" name="password" type="password" class="input-field" placeholder="Minimum 8 characters" required>
                </div>
                <div>
                    <label for="register-password-confirmation" class="label">Confirm password</label>
                    <input id="register-password-confirmation" name="password_confirmation" type="password" class="input-field" placeholder="Repeat password" required>
                </div>
                <button type="submit" class="primary-button w-full justify-center">Create account</button>
            </form>

            <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-cyan-300 dark:hover:text-cyan-200">Sign in</a>
            </p>
        </div>
    </section>
@endsection
