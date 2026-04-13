<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'The Journal'))</title>
    <meta name="description" content="@yield('meta_description', 'A place for thoughts, ideas, and stories.')">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

    {{-- Styles --}}
    @include('partials.styles')

    {{-- Page-specific head content --}}
    @stack('head')
</head>
<body class="@yield('body-class', '')">

    {{-- Navigation --}}
    @include('partials.nav')

    {{-- Flash Messages --}}
    @include('partials.flash')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Scripts --}}
    @include('partials.scripts')

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
