<div class="grid gap-6 lg:grid-cols-[1.25fr_0.75fr]">
    <div class="space-y-6">
        <div>
            <label for="blog-title" class="label">Title</label>
            <input id="blog-title" name="title" type="text" class="input-field" placeholder="The story headline readers will remember" required>
        </div>

        <div>
            <label for="blog-content" class="label">Content</label>
            <textarea id="blog-content" name="content" rows="16" class="input-field min-h-[24rem]" placeholder="Write your article here..." required></textarea>
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <label for="blog-category" class="label">Category</label>
            <input id="blog-category" name="category" type="text" class="input-field" placeholder="technology" required>
        </div>

        <div>
            <label for="blog-tags" class="label">Tags</label>
            <input id="blog-tags" name="tags" type="text" class="input-field" placeholder="laravel, blade, design">
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Separate tags with commas.</p>
        </div>

        <div>
            <label for="blog-featured-image" class="label">Feature image</label>
            <input id="blog-featured-image" name="featured_image" type="file" accept="image/*" class="input-field file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white dark:file:bg-white dark:file:text-slate-900">
            <div id="blog-image-preview" class="mt-4 hidden overflow-hidden rounded-[24px] border border-slate-200 dark:border-slate-800">
                <img src="" alt="Feature image preview" class="h-56 w-full object-cover">
            </div>
        </div>

        <label class="flex items-center justify-between rounded-[24px] border border-slate-200/80 bg-white/70 px-4 py-4 dark:border-slate-800 dark:bg-slate-900/80">
            <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Publish immediately</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Leave this off to save as a draft.</p>
            </div>
            <input id="blog-is-published" name="is_published" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
        </label>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="primary-button">Save post</button>
            <a href="{{ route('dashboard') }}" class="secondary-button">Cancel</a>
        </div>
    </div>
</div>
