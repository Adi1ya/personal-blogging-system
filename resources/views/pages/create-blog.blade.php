@extends('layouts.app')

@section('title', 'Create Blog | PulsePress')
@section('page', 'create-blog')
@section('requires-auth', 'true')

@section('content')
    <section class="editor-shell">
        <div class="editor-panel">
            <div class="mb-8">
                <span class="eyebrow">New story</span>
                <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">Craft a polished post.</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">Write in a focused editor, add categories and tags, upload an optional feature image, then save as draft or publish instantly.</p>
            </div>

            <form id="blog-form" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="create">
                @include('pages.partials.blog-form-fields')
            </form>
        </div>
    </section>
@endsection
