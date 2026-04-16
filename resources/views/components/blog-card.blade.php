<template id="blog-card-template">
    <article class="group overflow-hidden rounded-[28px] border border-white/60 bg-white/90 p-5 shadow-soft transition duration-300 hover:-translate-y-1 hover:shadow-card dark:border-slate-800 dark:bg-slate-900/80">
        <div class="mb-5 overflow-hidden rounded-[22px] bg-gradient-to-br from-cyan-100 via-indigo-100 to-fuchsia-100 dark:from-slate-800 dark:via-slate-900 dark:to-slate-800">
            <img class="blog-card-image hidden h-52 w-full object-cover transition duration-500 group-hover:scale-105" alt="">
            <div class="blog-card-fallback flex h-52 items-end justify-between bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.35),_transparent_45%),radial-gradient(circle_at_bottom_right,_rgba(217,70,239,0.28),_transparent_38%)] p-5">
                <span class="blog-card-category rounded-full bg-white/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700 backdrop-blur dark:bg-slate-950/70 dark:text-slate-200"></span>
                <span class="rounded-full border border-white/60 bg-white/70 px-3 py-1 text-xs font-medium text-slate-600 dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-300">Featured story</span>
            </div>
        </div>

        <div class="flex items-center justify-between gap-3 text-sm text-slate-500 dark:text-slate-400">
            <a class="blog-card-author font-semibold text-slate-700 transition hover:text-indigo-600 dark:text-slate-100 dark:hover:text-cyan-300"></a>
            <span class="blog-card-date"></span>
        </div>

        <a class="blog-card-link mt-4 block">
            <h3 class="blog-card-title text-2xl font-semibold leading-tight tracking-tight text-slate-900 transition group-hover:text-indigo-600 dark:text-white dark:group-hover:text-cyan-300"></h3>
        </a>

        <p class="blog-card-excerpt mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300"></p>

        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
            <span class="blog-card-reading nav-chip"></span>
            <span class="blog-card-likes"></span>
            <span class="blog-card-comments"></span>
        </div>

        <div class="blog-card-tags mt-4 flex flex-wrap gap-2"></div>
    </article>
</template>
