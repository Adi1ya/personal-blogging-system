<template id="user-card-template">
    <article class="rounded-[24px] border border-slate-200/70 bg-white/85 p-4 shadow-soft dark:border-slate-800 dark:bg-slate-900/80">
        <div class="flex items-center gap-3">
            <div class="user-avatar flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 via-indigo-500 to-fuchsia-500 text-sm font-bold text-white shadow-soft"></div>
            <div class="min-w-0">
                <a class="user-name block truncate text-sm font-semibold text-slate-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-cyan-300"></a>
                <p class="user-meta truncate text-xs text-slate-500 dark:text-slate-400"></p>
            </div>
        </div>
    </article>
</template>
