@extends('layouts.app')

@section('title', 'Edit Blog | PulsePress')
@section('page', 'edit-blog')
@section('requires-auth', 'true')

@section('content')
    <section class="editor-shell">
        <div class="editor-panel">
            <div class="mb-8">
                <span class="eyebrow">Edit story</span>
                <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">Refine your draft before it goes live.</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-300">Update metadata, refresh the feature image, and toggle publishing status without leaving the page.</p>
            </div>

            <form id="blog-form" class="space-y-6" enctype="multipart/form-data" data-blog-id="{{ $blogId }}">
                <input type="hidden" name="mode" value="edit">
                @include('pages.partials.blog-form-fields')
            </form>
        </div>
    </section>
@endsection
