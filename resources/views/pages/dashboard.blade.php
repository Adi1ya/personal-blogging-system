@extends('layouts.app')

@section('title', 'Dashboard | PulsePress')
@section('page', 'dashboard')
@section('requires-auth', 'true')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <span class="eyebrow">Writer dashboard</span>
                <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">Manage your stories with clarity.</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">Create drafts, publish when ready, and track how each story is performing across likes and comments.</p>
            </div>
            <a href="{{ route('blogs.create') }}" class="primary-button">Create new post</a>
        </div>

        <div id="dashboard-stats" class="mt-10 grid gap-4 md:grid-cols-3"></div>

        <div class="mt-10 flex flex-col gap-4 rounded-[28px] border border-white/60 bg-white/80 p-5 shadow-soft dark:border-slate-800 dark:bg-slate-900/80 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-950 dark:text-white">Your blogs</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Use quick actions to edit, publish, or archive content.</p>
            </div>
            <select id="dashboard-filter" class="input-field w-full sm:w-56">
                <option value="all">All posts</option>
                <option value="published">Published</option>
                <option value="draft">Drafts</option>
            </select>
        </div>

        <div id="dashboard-grid" class="mt-6 grid gap-6 lg:grid-cols-2"></div>
        <div id="dashboard-empty" class="empty-state hidden mt-10">
            <h3>No blogs in this view</h3>
            <p>Create your first post or switch filters to see more stories.</p>
        </div>
    </section>
@endsection
