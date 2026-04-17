import './bootstrap';
import { authApi, blogApi, clearAuthSession, engagementApi, getCurrentUser, getToken, publicApi, setAuthSession } from './api';

const routes = window.__APP_CONFIG__?.routes ?? {};
const body = document.body;
const state = { authUser: getCurrentUser() };
const qs = (s, r = document) => r.querySelector(s);
const qsa = (s, r = document) => Array.from(r.querySelectorAll(s));
const initials = (name = 'PP') => name.split(' ').map((p) => p[0]).join('').slice(0, 2).toUpperCase();
const formatDate = (v) => v ? new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).format(new Date(v)) : 'Just now';
const escapeHtml = (v = '') => v.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c]));
const nl2br = (v = '') => escapeHtml(v).replace(/\n/g, '<br>');
const requireAuth = () => getToken() ? true : (redirectToLogin(), false);
const debounce = (fn, wait) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), wait); }; };

function redirectToLogin() {
    const target = new URL(routes.login, window.location.origin);
    target.searchParams.set('redirect', window.location.pathname);
    window.location.href = target.toString();
}

function showToast(message, type = 'info') {
    const region = qs('#toast-region');
    if (!region) return;
    const item = document.createElement('div');
    item.className = `toast toast-${type}`;
    item.textContent = message;
    region.appendChild(item);
    setTimeout(() => { item.classList.add('opacity-0', 'translate-x-4'); setTimeout(() => item.remove(), 200); }, 3200);
}

function syncAuthUI() {
    const guest = qs('#guest-nav');
    const auth = qs('#auth-nav');
    const name = qs('#nav-user-name');
    if (!guest || !auth || !name) return;
    if (state.authUser) {
        guest.classList.add('hidden');
        auth.classList.remove('hidden');
        name.textContent = state.authUser.name;
    } else {
        guest.classList.remove('hidden');
        auth.classList.add('hidden');
        name.textContent = 'Writer';
    }
}

function setTheme(mode) {
    document.documentElement.classList.toggle('dark', mode === 'dark');
    localStorage.setItem('pulsepress.theme', mode);
    const icon = qs('[data-theme-icon]');
    if (icon) icon.textContent = mode === 'dark' ? '☾' : '☀';
}

function initTheme() {
    const mode = localStorage.getItem('pulsepress.theme') ?? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    setTheme(mode);
    qs('#theme-toggle')?.addEventListener('click', () => setTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark'));
}

function renderSkeletons(container, count = 4) {
    container.innerHTML = Array.from({ length: count }).map(() => `<div class="skeleton"><div class="h-52 rounded-[22px] bg-slate-200/70 dark:bg-slate-800"></div><div class="mt-5 h-4 w-1/3 rounded-full bg-slate-200/70 dark:bg-slate-800"></div><div class="mt-4 h-8 w-4/5 rounded-full bg-slate-200/70 dark:bg-slate-800"></div><div class="mt-3 h-4 w-full rounded-full bg-slate-200/70 dark:bg-slate-800"></div><div class="mt-2 h-4 w-2/3 rounded-full bg-slate-200/70 dark:bg-slate-800"></div></div>`).join('');
}

function createActionButton(label, className, onClick) {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = className;
    button.textContent = label;
    button.addEventListener('click', onClick);
    return button;
}

function createBlogCard(blog, options = {}) {
    const node = qs('#blog-card-template').content.firstElementChild.cloneNode(true);
    qs('.blog-card-link', node).href = `/stories/${blog.slug}`;
    qs('.blog-card-title', node).textContent = blog.title;
    qs('.blog-card-excerpt', node).textContent = blog.excerpt ?? '';
    qs('.blog-card-author', node).textContent = blog.author?.name ?? 'Unknown author';
    qs('.blog-card-author', node).href = blog.author ? `/profiles/${blog.author.id}` : '#';
    qs('.blog-card-date', node).textContent = formatDate(blog.published_at ?? blog.created_at);
    qs('.blog-card-category', node).textContent = blog.category ?? 'General';
    qs('.blog-card-reading', node).textContent = `${blog.reading_time ?? 1} min read`;
    qs('.blog-card-likes', node).textContent = `${blog.likes_count ?? 0} likes`;
    qs('.blog-card-comments', node).textContent = `${blog.comments_count ?? 0} comments`;
    qs('.blog-card-tags', node).innerHTML = (blog.tags ?? []).slice(0, 4).map((tag) => `<button type="button" class="tag-chip" data-tag-filter="${escapeHtml(tag)}">${escapeHtml(tag)}</button>`).join('');
    if (blog.featured_image) {
        qs('.blog-card-image', node).src = blog.featured_image;
        qs('.blog-card-image', node).alt = blog.title;
        qs('.blog-card-image', node).classList.remove('hidden');
        qs('.blog-card-fallback', node).classList.add('hidden');
    }
    if (options.actions?.length) {
        const bar = document.createElement('div');
        bar.className = 'mt-5 flex flex-wrap gap-3';
        options.actions.forEach((a) => bar.appendChild(a));
        node.appendChild(bar);
    }
    return node;
}

function renderUserCard(user) {
    const node = qs('#user-card-template').content.firstElementChild.cloneNode(true);
    qs('.user-avatar', node).textContent = initials(user.name);
    qs('.user-name', node).textContent = user.name;
    qs('.user-name', node).href = `/profiles/${user.id}`;
    qs('.user-meta', node).textContent = user.email ?? 'PulsePress member';
    return node;
}

function renderComment(comment, onDelete) {
    const node = qs('#comment-box-template').content.firstElementChild.cloneNode(true);
    qs('.comment-user', node).textContent = comment.user?.name ?? 'Anonymous';
    qs('.comment-date', node).textContent = formatDate(comment.created_at);
    qs('.comment-body', node).textContent = comment.comment;
    if (comment.is_owner) {
        const button = qs('.comment-delete', node);
        button.classList.remove('hidden');
        button.addEventListener('click', () => onDelete(comment));
    }
    return node;
}

async function initAuthBootstrap() {
    if (!getToken()) return syncAuthUI();
    try {
        const response = await authApi.me();
        state.authUser = response.data;
        localStorage.setItem('pulsepress.user', JSON.stringify(state.authUser));
    } catch {
        clearAuthSession();
    }
    syncAuthUI();
}

async function initAuthForms() {
    if (getToken() && ['login', 'register'].includes(body.dataset.page)) {
        window.location.href = routes.dashboard;
        return;
    }
    qs('#login-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const response = await authApi.login(Object.fromEntries(new FormData(e.currentTarget).entries()));
        setAuthSession(response.data);
        showToast(response.message ?? 'Logged in successfully.', 'success');
        window.location.href = new URLSearchParams(window.location.search).get('redirect') ?? routes.dashboard;
    });
    qs('#register-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const response = await authApi.register(Object.fromEntries(new FormData(e.currentTarget).entries()));
        setAuthSession(response.data);
        showToast(response.message ?? 'Registered successfully.', 'success');
        window.location.href = routes.dashboard;
    });
}

async function initHomePage() {
    if (body.dataset.page !== 'home') return;
    const grid = qs('#feed-grid');
    const empty = qs('#feed-empty');
    const loadMore = qs('#load-more-posts');
    const search = qs('#feed-search');
    const category = qs('#feed-category');
    const pills = qs('#category-pills');
    const feed = { page: 1, hasMore: false, search: '', category: '', tag: '' };
    renderSkeletons(grid);
    const [categoryResponse, tagResponse] = await Promise.all([publicApi.categories(), publicApi.tags()]);
    const categories = categoryResponse.data ?? [];
    const tags = tagResponse.data ?? [];
    category.innerHTML += categories.map((item) => `<option value="${escapeHtml(item)}">${escapeHtml(item)}</option>`).join('');
    pills.innerHTML = [
        '<button type="button" class="tag-chip" data-tag-pill="">All topics</button>',
        ...tags.slice(0, 8).map((item) => `<button type="button" class="tag-chip" data-tag-pill="${escapeHtml(item)}">${escapeHtml(item)}</button>`),
    ].join('');

    const load = async (append = false) => {
        const response = await publicApi.feed({
            page: feed.page,
            category: feed.category || undefined,
            tag: feed.tag || undefined,
            search: feed.search || undefined,
        });
        const items = response.data ?? [];
        if (!append) grid.innerHTML = '';
        items.forEach((blog) => grid.appendChild(createBlogCard(blog)));
        empty.classList.toggle('hidden', append || items.length > 0);
        feed.hasMore = Boolean(response.meta?.has_more);
        loadMore.classList.toggle('hidden', !feed.hasMore);
        qsa('[data-tag-filter]', grid).forEach((button) => button.addEventListener('click', async () => {
            feed.tag = button.dataset.tagFilter ?? '';
            feed.page = 1;
            await load();
            pills.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }));
        qsa('[data-tag-pill]', pills).forEach((button) => {
            button.classList.toggle('bg-slate-950', (button.dataset.tagPill ?? '') === feed.tag);
            button.classList.toggle('text-white', (button.dataset.tagPill ?? '') === feed.tag);
        });
    };

    await load();
    qsa('[data-tag-pill]', pills).forEach((button) => button.addEventListener('click', async () => {
        feed.tag = button.dataset.tagPill ?? '';
        feed.page = 1;
        await load();
    }));
    search?.addEventListener('input', debounce(async () => { feed.search = search.value.trim(); feed.page = 1; await load(); }, 350));
    category?.addEventListener('change', async () => { feed.category = category.value; feed.page = 1; await load(); });
    loadMore?.addEventListener('click', async () => { if (feed.hasMore) { feed.page += 1; await load(true); } });
}

async function initDashboard() {
    if (body.dataset.page !== 'dashboard') return;
    if (!requireAuth()) return;
    const grid = qs('#dashboard-grid');
    const empty = qs('#dashboard-empty');
    const stats = qs('#dashboard-stats');
    const filter = qs('#dashboard-filter');
    let blogs = [];
    renderSkeletons(grid);

    const renderStats = () => {
        const published = blogs.filter((b) => b.is_published).length;
        const likes = blogs.reduce((sum, b) => sum + (b.likes_count ?? 0), 0);
        stats.innerHTML = [['Stories', blogs.length], ['Published', published], ['Total likes', likes]].map(([label, value]) => `<div class="glass-panel p-5"><p class="text-sm text-slate-500 dark:text-slate-400">${label}</p><p class="mt-3 text-3xl font-semibold text-slate-950 dark:text-white">${value}</p></div>`).join('');
    };

    const renderBlogs = () => {
        const visible = filter.value === 'published' ? blogs.filter((b) => b.is_published) : filter.value === 'draft' ? blogs.filter((b) => !b.is_published) : blogs;
        grid.innerHTML = '';
        visible.forEach((blog) => {
            const actions = [
                createActionButton('Edit', 'secondary-button px-4 py-2 text-xs', () => { window.location.href = `/blogs/${blog.id}/edit`; }),
                createActionButton(blog.is_published ? 'Unpublish' : 'Publish', 'secondary-button px-4 py-2 text-xs', async () => {
                    if (blog.is_published) {
                        const payload = new FormData();
                        payload.set('is_published', '0');
                        await blogApi.update(blog.id, payload);
                        showToast('Story moved back to draft.', 'success');
                    } else {
                        await blogApi.publish(blog.id);
                        showToast('Story published successfully.', 'success');
                    }
                    await load();
                }),
                createActionButton('Delete', 'rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-500 transition hover:border-rose-300 hover:bg-rose-50 dark:border-rose-500/30 dark:hover:bg-rose-500/10', async () => {
                    if (!window.confirm('Delete this blog?')) return;
                    await blogApi.remove(blog.id);
                    showToast('Story deleted successfully.', 'success');
                    await load();
                }),
            ];
            grid.appendChild(createBlogCard(blog, { actions }));
        });
        empty.classList.toggle('hidden', visible.length > 0);
    };

    const load = async () => {
        const [me, mine] = await Promise.all([authApi.me(), blogApi.listMine()]);
        state.authUser = me.data;
        syncAuthUI();
        blogs = mine.data ?? [];
        renderStats();
        renderBlogs();
    };

    filter.addEventListener('change', renderBlogs);
    await load();
}

async function initBlogForm() {
    if (!['create-blog', 'edit-blog'].includes(body.dataset.page)) return;
    if (!requireAuth()) return;
    const form = qs('#blog-form');
    const preview = qs('#blog-image-preview');
    const input = qs('#blog-featured-image');
    input?.addEventListener('change', () => {
        const file = input.files?.[0];
        preview.classList.toggle('hidden', !file);
        if (file) qs('img', preview).src = URL.createObjectURL(file);
    });
    if (body.dataset.page === 'edit-blog') {
        const response = await blogApi.getMine(form.dataset.blogId);
        const blog = response.data;
        qs('#blog-title').value = blog.title ?? '';
        qs('#blog-content').value = blog.content ?? '';
        qs('#blog-category').value = blog.category ?? '';
        qs('#blog-tags').value = (blog.tags ?? []).join(', ');
        qs('#blog-is-published').checked = Boolean(blog.is_published);
        if (blog.featured_image) {
            preview.classList.remove('hidden');
            qs('img', preview).src = blog.featured_image;
        }
    }
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = new FormData(form);
        const tags = `${payload.get('tags') ?? ''}`.split(',').map((tag) => tag.trim()).filter(Boolean);
        payload.delete('tags');
        payload.set('is_published', qs('#blog-is-published').checked ? '1' : '0');
        tags.forEach((tag, i) => payload.append(`tags[${i}]`, tag));
        const response = body.dataset.page === 'edit-blog'
            ? await blogApi.update(form.dataset.blogId, payload)
            : await blogApi.create(payload);
        showToast(response.message ?? 'Story saved successfully.', 'success');
        window.location.href = routes.dashboard;
    });
}

async function initProfile() {
    if (body.dataset.page !== 'profile') return;
    const userId = qs('[data-user-id]')?.dataset.userId;
    const hero = qs('#profile-hero');
    const blogsBox = qs('#profile-blogs');
    const empty = qs('#profile-blogs-empty');
    const followers = qs('#profile-followers');
    const following = qs('#profile-following');
    const response = await publicApi.profile(userId);
    const payload = response.data;
    const user = payload.user;
    const own = state.authUser?.id === user.id;

    hero.innerHTML = `<div class="flex flex-col gap-6"><div class="flex items-center gap-4"><div class="flex h-20 w-20 items-center justify-center rounded-[28px] bg-gradient-to-br from-cyan-400 via-indigo-500 to-fuchsia-500 text-2xl font-bold text-white shadow-[var(--shadow-card)]">${initials(user.name)}</div><div><h1 class="text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">${escapeHtml(user.name)}</h1><p class="mt-2 text-sm leading-7 text-slate-500 dark:text-slate-400">${escapeHtml(user.bio ?? 'Publishing thoughtful stories on PulsePress.')}</p></div></div><div class="grid grid-cols-3 gap-4"><div class="rounded-[24px] border border-white/60 bg-white/70 p-4 dark:border-slate-800 dark:bg-slate-900/70"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Followers</p><p class="mt-2 text-2xl font-semibold text-slate-950 dark:text-white">${user.followers_count}</p></div><div class="rounded-[24px] border border-white/60 bg-white/70 p-4 dark:border-slate-800 dark:bg-slate-900/70"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Following</p><p class="mt-2 text-2xl font-semibold text-slate-950 dark:text-white">${user.following_count}</p></div><div class="rounded-[24px] border border-white/60 bg-white/70 p-4 dark:border-slate-800 dark:bg-slate-900/70"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Blogs</p><p class="mt-2 text-2xl font-semibold text-slate-950 dark:text-white">${user.blogs_count}</p></div></div>${!own ? '<button id="profile-follow-button" type="button" class="primary-button w-full justify-center"></button>' : ''}</div>`;
    blogsBox.innerHTML = '';
    (payload.blogs ?? []).forEach((blog) => blogsBox.appendChild(createBlogCard(blog)));
    empty.classList.toggle('hidden', (payload.blogs ?? []).length > 0);
    followers.innerHTML = ''; following.innerHTML = '';
    (payload.followers ?? []).slice(0, 6).forEach((item) => followers.appendChild(renderUserCard(item)));
    (payload.following ?? []).slice(0, 6).forEach((item) => following.appendChild(renderUserCard(item)));

    const followButton = qs('#profile-follow-button');
    if (followButton) {
        const update = () => { followButton.textContent = user.is_following ? 'Unfollow author' : 'Follow author'; };
        update();
        followButton.addEventListener('click', async () => {
            if (!requireAuth()) return;
            if (user.is_following) { await engagementApi.unfollow(user.id); user.is_following = false; }
            else { await engagementApi.follow(user.id); user.is_following = true; }
            showToast(user.is_following ? 'Author followed.' : 'Author unfollowed.', 'success');
            update();
        });
    }
}

async function initBlogDetail() {
    if (body.dataset.page !== 'blog-detail') return;
    const slug = qs('[data-blog-slug]')?.dataset.blogSlug;
    const header = qs('#blog-detail-header');
    const content = qs('#blog-detail-content');
    const image = qs('#blog-detail-image');
    const authorCard = qs('#blog-author-card');
    const authorLink = qs('#blog-author-link');
    const likeButton = qs('#blog-like-button');
    const form = qs('#comment-form');
    const input = qs('#comment-input');
    const list = qs('#comments-list');
    const empty = qs('#comments-empty');
    let payload;

    const render = () => {
        const { blog, author } = payload;
        header.innerHTML = `<span class="eyebrow">${escapeHtml(blog.category ?? 'General')}</span><h1 class="mt-5 text-4xl font-semibold leading-tight tracking-tight text-slate-950 dark:text-white sm:text-5xl">${escapeHtml(blog.title)}</h1><div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400"><a href="/profiles/${author.id}" class="font-semibold text-slate-700 dark:text-slate-100">${escapeHtml(author.name)}</a><span>${formatDate(blog.published_at ?? blog.created_at)}</span><span>${blog.reading_time} min read</span><span>${blog.likes_count} likes</span><span>${blog.comments_count} comments</span></div>`;
        content.innerHTML = `<div class="prose-content">${nl2br(blog.content)}</div>`;
        if (blog.featured_image) { image.classList.remove('hidden'); qs('img', image).src = blog.featured_image; qs('img', image).alt = blog.title; }
        authorLink.href = `/profiles/${author.id}`;
        authorCard.innerHTML = `<div class="flex items-center gap-4"><div class="flex h-16 w-16 items-center justify-center rounded-[24px] bg-gradient-to-br from-cyan-400 via-indigo-500 to-fuchsia-500 text-xl font-bold text-white shadow-[var(--shadow-card)]">${initials(author.name)}</div><div><p class="text-xl font-semibold text-slate-950 dark:text-white">${escapeHtml(author.name)}</p><p class="mt-2 text-sm leading-7 text-slate-500 dark:text-slate-400">${escapeHtml(author.bio ?? 'Thoughtful writer and community member on PulsePress.')}</p></div></div><div class="mt-6 grid grid-cols-3 gap-3"><div class="rounded-[22px] border border-slate-200/80 bg-white/70 p-4 text-center dark:border-slate-800 dark:bg-slate-900/70"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Followers</p><p class="mt-2 text-xl font-semibold text-slate-950 dark:text-white">${author.followers_count}</p></div><div class="rounded-[22px] border border-slate-200/80 bg-white/70 p-4 text-center dark:border-slate-800 dark:bg-slate-900/70"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Following</p><p class="mt-2 text-xl font-semibold text-slate-950 dark:text-white">${author.following_count}</p></div><div class="rounded-[22px] border border-slate-200/80 bg-white/70 p-4 text-center dark:border-slate-800 dark:bg-slate-900/70"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Stories</p><p class="mt-2 text-xl font-semibold text-slate-950 dark:text-white">${author.blogs_count}</p></div></div>${state.authUser && state.authUser.id !== author.id ? '<button id="author-follow-button" type="button" class="primary-button mt-6 w-full justify-center"></button>' : ''}`;
        likeButton.textContent = payload.viewer?.has_liked ? 'Unlike story' : 'Like story';
        const follow = qs('#author-follow-button');
        if (follow) {
            follow.textContent = author.is_following ? 'Unfollow author' : 'Follow author';
            follow.onclick = async () => {
                if (!requireAuth()) return;
                if (author.is_following) { await engagementApi.unfollow(author.id); author.is_following = false; }
                else { await engagementApi.follow(author.id); author.is_following = true; }
                showToast(author.is_following ? 'Author followed.' : 'Author unfollowed.', 'success');
                render();
            };
        }
        list.innerHTML = '';
        (payload.comments ?? []).forEach((comment) => list.appendChild(renderComment(comment, async (item) => {
            if (!window.confirm('Delete this comment?')) return;
            await engagementApi.deleteComment(blog.id, item.id);
            showToast('Comment deleted.', 'success');
            await load();
        })));
        empty.classList.toggle('hidden', (payload.comments ?? []).length > 0);
    };

    const load = async () => { payload = (await publicApi.blogDetail(slug)).data; render(); };

    likeButton.addEventListener('click', async () => {
        if (!requireAuth()) return;
        if (payload.viewer?.has_liked) await engagementApi.unlike(payload.blog.id);
        else await engagementApi.like(payload.blog.id);
        showToast(payload.viewer?.has_liked ? 'Like removed.' : 'Story liked.', 'success');
        await load();
    });
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!requireAuth()) return;
        if (!input.value.trim()) return showToast('Please enter a comment first.', 'info');
        await engagementApi.comment(payload.blog.id, { comment: input.value.trim() });
        input.value = '';
        showToast('Comment posted.', 'success');
        await load();
    });
    await load();
}

function initGlobalEvents() {
    window.addEventListener('toast', (e) => showToast(e.detail.message, e.detail.type));
    window.addEventListener('auth:changed', () => { state.authUser = getCurrentUser(); syncAuthUI(); });
    window.addEventListener('auth:unauthorized', () => { if (body.dataset.requiresAuth === 'true') redirectToLogin(); });
    const loader = qs('#page-loader');
    window.addEventListener('loader:start', () => loader?.classList.remove('hidden'));
    window.addEventListener('loader:stop', () => loader?.classList.add('hidden'));
    qs('#logout-button')?.addEventListener('click', async () => {
        try { await authApi.logout(); } catch { /* toast handled globally */ }
        clearAuthSession();
        showToast('Logged out.', 'success');
        window.location.href = routes.login;
    });
}

async function bootstrap() {
    initTheme();
    initGlobalEvents();
    await initAuthBootstrap();
    if (body.dataset.requiresAuth === 'true' && !requireAuth()) return;
    await initAuthForms();
    await initHomePage();
    await initDashboard();
    await initBlogForm();
    await initProfile();
    await initBlogDetail();
}

bootstrap();
