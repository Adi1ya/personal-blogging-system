<template id="comment-box-template">
    <article class="rounded-[24px] border border-slate-200/80 bg-white/80 p-5 shadow-soft dark:border-slate-800 dark:bg-slate-900/80">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="comment-user text-sm font-semibold text-slate-900 dark:text-white"></p>
                <p class="comment-date mt-1 text-xs uppercase tracking-[0.2em] text-slate-400"></p>
            </div>
            <button type="button" class="comment-delete hidden text-sm font-semibold text-rose-500 transition hover:text-rose-600">Delete</button>
        </div>
        <p class="comment-body mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300"></p>
    </article>
</template>
