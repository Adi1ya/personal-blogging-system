@extends('layouts.app')

@section('title', 'PulsePress | Discover sharp writing')
@section('page', 'home')

@section('content')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.22),_transparent_30%),radial-gradient(circle_at_top_right,_rgba(99,102,241,0.18),_transparent_30%),radial-gradient(circle_at_bottom,_rgba(236,72,153,0.18),_transparent_30%)]"></div>
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.15fr_0.85fr] lg:px-8 lg:py-24">
            <div class="relative">
                <span class="eyebrow">Social blogging, reimagined</span>
                <h1 class="mt-6 max-w-3xl text-5xl font-semibold leading-[1.05] tracking-tight text-slate-950 dark:text-white sm:text-6xl">
                    Publish with a calm, premium rhythm and discover people worth following.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">
                    PulsePress blends a clean reading experience with lightweight social features so every post feels elegant, alive, and easy to share.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="primary-button">Start writing</a>
                    <a href="{{ route('dashboard') }}" class="secondary-button">Open dashboard</a>
                </div>

                <div class="mt-10 flex flex-wrap gap-3" id="category-pills">
                    <span class="tag-chip">Loading topics...</span>
                </div>
            </div>

            <div class="glass-panel relative overflow-hidden p-6 sm:p-8">
                <div class="absolute inset-x-0 top-0 h-28 bg-gradient-to-r from-cyan-400/20 via-indigo-500/20 to-fuchsia-500/20"></div>
                <div class="relative">
                    <p class="eyebrow">Live feed highlights</p>
                    <div class="mt-6 space-y-4">
                        <div class="rounded-[24px] border border-white/60 bg-white/70 p-5 shadow-soft dark:border-slate-800 dark:bg-slate-900/70">
                            <p class="text-sm font-semibold text-indigo-600 dark:text-cyan-300">Fast publishing</p>
                            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Create, draft, publish, and update posts from a writer dashboard tuned for focus.</p>
                        </div>
                        <div class="rounded-[24px] border border-white/60 bg-white/70 p-5 shadow-soft dark:border-slate-800 dark:bg-slate-900/70">
                            <p class="text-sm font-semibold text-indigo-600 dark:text-cyan-300">Built-in community</p>
                            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Readers can like, comment, and follow authors without the interface feeling noisy or crowded.</p>
                        </div>
                        <div class="rounded-[24px] border border-white/60 bg-white/70 p-5 shadow-soft dark:border-slate-800 dark:bg-slate-900/70">
                            <p class="text-sm font-semibold text-indigo-600 dark:text-cyan-300">Responsive everywhere</p>
                            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Every page is designed mobile-first, then expanded into an editorial desktop layout.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8 lg:pb-24">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="eyebrow">Public feed</span>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">Fresh stories from the network</h2>
            </div>

            <form id="feed-filter-form" class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">
                <input id="feed-search" type="search" placeholder="Search stories..." class="input-field min-w-[15rem]">
                <select id="feed-category" class="input-field min-w-[12rem]">
                    <option value="">All categories</option>
                </select>
            </form>
        </div>

        <div id="feed-grid" class="grid gap-6 lg:grid-cols-2"></div>
        <div id="feed-empty" class="empty-state hidden mt-10">
            <h3>No published blogs yet</h3>
            <p>The public feed will appear here as soon as writers start publishing.</p>
        </div>

        <div class="mt-8 flex justify-center">
            <button id="load-more-posts" type="button" class="secondary-button hidden">Load more stories</button>
        </div>
    </section>
@endsection
