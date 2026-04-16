@extends('layouts.app')

@section('title', 'Story | PulsePress')
@section('page', 'blog-detail')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8" data-blog-slug="{{ $slug }}">
        <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <article class="glass-panel p-6 sm:p-8">
                <div id="blog-detail-header"></div>
                <div id="blog-detail-image" class="mt-8 hidden overflow-hidden rounded-[28px] border border-white/60 dark:border-slate-800">
                    <img src="" alt="" class="h-[22rem] w-full object-cover">
                </div>
                <div id="blog-detail-content" class="prose prose-slate mt-8 max-w-none dark:prose-invert"></div>
                <div class="mt-10 flex flex-wrap gap-3">
                    <button id="blog-like-button" type="button" class="primary-button">Like story</button>
                    <a id="blog-author-link" href="#" class="secondary-button">View author</a>
                </div>
            </article>

            <aside class="space-y-6">
                <div class="glass-panel p-6" id="blog-author-card"></div>

                <div class="glass-panel p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <span class="eyebrow">Discussion</span>
                            <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Comments</h2>
                        </div>
                    </div>

                    <form id="comment-form" class="mt-6 space-y-4">
                        <textarea id="comment-input" class="input-field min-h-32" placeholder="Join the conversation..." required></textarea>
                        <button type="submit" class="primary-button w-full justify-center">Post comment</button>
                    </form>

                    <div id="comments-list" class="mt-6 space-y-4"></div>
                    <div id="comments-empty" class="empty-state hidden mt-6">
                        <h3>No comments yet</h3>
                        <p>Be the first reader to respond to this story.</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
