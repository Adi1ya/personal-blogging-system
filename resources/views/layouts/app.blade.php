<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PulsePress')</title>
    <meta name="description" content="@yield('meta_description', 'A modern social blogging experience built with Laravel and Blade.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="min-h-full bg-[var(--color-page)] text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100"
    data-page="@yield('page')"
    data-requires-auth="@yield('requires-auth', 'false')"
>
    <script>
        window.__APP_CONFIG__ = {
            apiBaseUrl: '{{ url('/api/v1') }}',
            routes: {
                home: '{{ route('home') }}',
                login: '{{ route('login') }}',
                register: '{{ route('register') }}',
                dashboard: '{{ route('dashboard') }}',
                createBlog: '{{ route('blogs.create') }}'
            }
        };
    </script>

    @include('components.toast')
    @include('components.loader')
    @include('components.navbar')

    <main class="relative z-10">
        @yield('content')
    </main>

    @include('components.blog-card')
    @include('components.comment-box')
    @include('components.user-card')
</body>
</html>
