import axios from 'axios';

const TOKEN_KEY = 'pulsepress.token';
const USER_KEY = 'pulsepress.user';

const api = axios.create({
    baseURL: window.__APP_CONFIG__?.apiBaseUrl ?? '/api/v1',
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

export function getToken() {
    return localStorage.getItem(TOKEN_KEY);
}

export function getCurrentUser() {
    const raw = localStorage.getItem(USER_KEY);

    if (! raw) {
        return null;
    }

    try {
        return JSON.parse(raw);
    } catch {
        return null;
    }
}

export function setAuthSession(payload) {
    const token = payload?.access_token ?? payload?.token ?? null;

    if (token) {
        localStorage.setItem(TOKEN_KEY, token);
    }

    if (payload) {
        localStorage.setItem(USER_KEY, JSON.stringify({
            id: payload.id,
            name: payload.name,
            email: payload.email,
        }));
    }

    window.dispatchEvent(new CustomEvent('auth:changed', { detail: getCurrentUser() }));
}

export function clearAuthSession() {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
    window.dispatchEvent(new CustomEvent('auth:changed', { detail: null }));
}

api.interceptors.request.use((config) => {
    const token = getToken();

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    window.dispatchEvent(new CustomEvent('loader:start'));
    return config;
});

api.interceptors.response.use(
    (response) => {
        window.dispatchEvent(new CustomEvent('loader:stop'));
        return response;
    },
    (error) => {
        window.dispatchEvent(new CustomEvent('loader:stop'));

        const message =
            error?.response?.data?.message ||
            error?.response?.data?.error ||
            'Something went wrong. Please try again.';

        if (error?.response?.status === 401) {
            clearAuthSession();
            window.dispatchEvent(new CustomEvent('auth:unauthorized'));
        }

        window.dispatchEvent(new CustomEvent('toast', {
            detail: {
                type: 'error',
                message,
            },
        }));

        return Promise.reject(error);
    }
);

const unwrap = async (request) => {
    const response = await request;
    return response.data;
};

export const authApi = {
    register: (payload) => unwrap(api.post('/register', payload)),
    login: (payload) => unwrap(api.post('/login', payload)),
    logout: () => unwrap(api.post('/logout')),
    me: () => unwrap(api.get('/me')),
};

export const blogApi = {
    listMine: () => unwrap(api.get('/blogs')),
    getMine: (id) => unwrap(api.get(`/blogs/${id}`)),
    create: (payload) => unwrap(api.post('/blogs', payload, { headers: { 'Content-Type': 'multipart/form-data' } })),
    update: (id, payload) => unwrap(api.post(`/blogs/${id}?_method=PATCH`, payload, { headers: { 'Content-Type': 'multipart/form-data' } })),
    remove: (id) => unwrap(api.delete(`/blogs/${id}`)),
    publish: (id) => unwrap(api.post(`/blogs/${id}/publish`)),
};

export const publicApi = {
    feed: (params = {}) => unwrap(api.get('/public/blogs', { params })),
    blogDetail: (slug) => unwrap(api.get(`/public/blogs/${slug}`)),
    profile: (id) => unwrap(api.get(`/public/profiles/${id}`)),
    categories: () => unwrap(api.get('/public/categories')),
    tags: () => unwrap(api.get('/public/tags')),
};

export const engagementApi = {
    like: (blogId) => unwrap(api.post(`/blogs/${blogId}/like`)),
    unlike: (blogId) => unwrap(api.delete(`/blogs/${blogId}/like`)),
    comments: (blogId) => unwrap(api.get(`/blogs/${blogId}/comments`)),
    comment: (blogId, payload) => unwrap(api.post(`/blogs/${blogId}/comments`, payload)),
    deleteComment: (blogId, commentId) => unwrap(api.delete(`/blogs/${blogId}/comments/${commentId}`)),
    follow: (authorId) => unwrap(api.post(`/authors/${authorId}/follow`)),
    unfollow: (authorId) => unwrap(api.delete(`/authors/${authorId}/unfollow`)),
    followers: (authorId) => unwrap(api.get(`/authors/${authorId}/followers`)),
    following: () => unwrap(api.get('/me/following')),
};

export default api;
