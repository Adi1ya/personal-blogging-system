<header class="sticky top-0 z-40 border-b border-white/10 bg-white/75 backdrop-blur-xl dark:bg-slate-950/75">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 via-indigo-500 to-fuchsia-500 text-lg font-black text-white shadow-lg shadow-cyan-500/30">P</span>
            <div>
                <p class="font-display text-lg font-semibold tracking-tight">PulsePress</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Write with signal, not noise.</p>
            </div>
        </a>

        <div class="hidden items-center gap-2 rounded-full border border-slate-200/70 bg-white/70 px-3 py-2 shadow-soft dark:border-slate-800 dark:bg-slate-900/80 md:flex">
            <a href="{{ route('home') }}" class="nav-link">Explore</a>
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('blogs.create') }}" class="nav-link">Write</a>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" id="theme-toggle" class="icon-button" aria-label="Toggle theme">
                <span data-theme-icon>☀</span>
            </button>

            <div id="guest-nav" class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden rounded-full px-4 py-2 text-sm font-semibold text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white sm:inline-flex">Login</a>
                <a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">Get Started</a>
            </div>

            <div id="auth-nav" class="hidden items-center gap-3">
                <a href="{{ route('dashboard') }}" class="nav-chip">
                    <span id="nav-user-name">Writer</span>
                </a>
                <button type="button" id="logout-button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-rose-300 hover:text-rose-500 dark:border-slate-700 dark:text-slate-200 dark:hover:border-rose-500/40 dark:hover:text-rose-300">
                    Logout
                </button>
            </div>
        </div>
    </div>
</header>
