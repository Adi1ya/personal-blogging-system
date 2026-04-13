<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'The Journal'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

    {{-- Styles --}}
    @include('partials.styles')

    <style>
        /* Auth-specific overrides: ensure truly full-bleed layout */
        html, body { height: 100%; margin: 0; padding: 0; }
        body.auth-body { display: flex; flex-direction: column; }
        .auth-main { flex: 1; min-height: 100vh; }
    </style>

    @stack('head')
</head>
<body class="auth-body">

    {{-- Flash Messages --}}
    @include('partials.flash')

    {{-- Auth Content — pages render their own .auth-main grid --}}
    @yield('content')

    {{-- Scripts --}}
    @include('partials.scripts')

    @stack('scripts')

</body>
</html>