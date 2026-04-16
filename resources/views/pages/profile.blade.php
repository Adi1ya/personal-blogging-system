@extends('layouts.app')

@section('title', 'Profile | PulsePress')
@section('page', 'profile')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8" data-user-id="{{ $userId }}">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="glass-panel p-6 sm:p-8" id="profile-hero"></div>

            <div class="space-y-6">
                <div class="glass-panel p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <span class="eyebrow">Published stories</span>
                            <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Profile feed</h2>
                        </div>
                    </div>
                    <div id="profile-blogs" class="mt-6 grid gap-5"></div>
                    <div id="profile-blogs-empty" class="empty-state hidden mt-6">
                        <h3>No published stories yet</h3>
                        <p>This author has not published any public blogs so far.</p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="glass-panel p-6">
                        <h3 class="text-lg font-semibold text-slate-950 dark:text-white">Followers</h3>
                        <div id="profile-followers" class="mt-4 space-y-3"></div>
                    </div>
                    <div class="glass-panel p-6">
                        <h3 class="text-lg font-semibold text-slate-950 dark:text-white">Following</h3>
                        <div id="profile-following" class="mt-4 space-y-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
