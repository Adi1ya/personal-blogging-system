# PulsePress

PulsePress is a modern personal blogging platform built with Laravel, Blade, and Vite. It combines a polished reading experience with lightweight social features so writers can publish quickly and readers can discover, like, comment on, and follow the people they enjoy.

## Highlights

- Public home feed with search, category filters, and tag-based browsing
- Authentication with Laravel Sanctum
- Writer dashboard for creating, editing, publishing, and deleting stories
- Draft and published blog workflow
- Blog categories and multi-tag support
- Public author profiles with follower and following counts
- Likes, dislikes, and comments on blog posts
- Responsive Blade UI with a custom frontend powered by Vite

## Tech Stack

- Backend: Laravel 12, PHP 8.2+
- Frontend: Blade templates, vanilla JavaScript, Tailwind CSS, Vite
- Auth: Laravel Sanctum
- Database: SQLite by default, with MySQL-compatible Laravel configuration available

## Screens and Features

### Public Experience

- Landing page with curated hero section and live story feed
- Story detail pages with reading metadata, author card, likes, and comments
- Author profile pages showing published stories and social graph data
- Tag pills that filter the feed by selected topic

### Writer Experience

- Register and log in with token-based authentication
- Create stories with title, content, optional featured image, category, and tags
- Save stories as draft or publish immediately
- Edit existing stories from the dashboard
- Unpublish or soft-delete stories

## Project Structure

```text
app/Http/Controllers     Application controllers for auth, blogs, public content, and engagement
app/Models               Eloquent models for blogs, users, comments, follows, and reactions
resources/views          Blade pages and reusable UI components
resources/js             Frontend logic for feed loading, auth flows, blog actions, and interactivity
routes/web.php           Browser routes
routes/api.php           JSON API routes
database/migrations      Schema for users, blogs, follows, reactions, comments, and tags/categories
```

## Getting Started

### Prerequisites

- PHP 8.2 or newer
- Composer
- Node.js and npm
- A database supported by Laravel

### Quick Setup

```bash
composer setup
```

The `composer setup` script installs PHP dependencies, creates `.env` if needed, generates the app key, runs migrations, installs frontend dependencies, and builds assets.

### Manual Setup

1. Install dependencies:

```bash
composer install
npm install
```

2. Create your environment file:

```bash
copy .env.example .env
```

3. Generate the application key:

```bash
php artisan key:generate
```

4. Configure your database in `.env`.

The default `.env.example` is set up for SQLite. If you want the fastest local setup, create the database file and keep `DB_CONNECTION=sqlite`.

5. Run migrations:

```bash
php artisan migrate
```

6. Start the app:

```bash
composer dev
```

This starts the Laravel server, queue listener, log viewer, and Vite dev server together.

### Production Build

```bash
npm run build
```

## Default URLs

- App: `http://127.0.0.1:8000`
- API base: `http://127.0.0.1:8000/api/v1`

## API Overview

### Public Endpoints

- `POST /api/v1/register`
- `POST /api/v1/login`
- `GET /api/v1/public/blogs`
- `GET /api/v1/public/blogs/{slug}`
- `GET /api/v1/public/profiles/{user}`
- `GET /api/v1/public/categories`
- `GET /api/v1/public/tags`

### Protected Endpoints

- Blog CRUD and publishing
- Follow and unfollow authors
- Like and dislike stories
- Create, list, view, and delete comments
- Fetch authenticated user details

Protected routes require a Sanctum bearer token.

## Filtering and Discovery

The public feed supports:

- Search by blog title and content
- Filter by category
- Filter by tag
- Pagination for loading more stories

## Data Model Summary

The application includes:

- `users`
- `blogs`
- `follows`
- `blog_reactions`
- `comments`
- personal access tokens for API authentication

Blogs support:

- `title`
- `slug`
- `content`
- `featured_image`
- `category`
- `tags`
- `is_published`
- `is_deleted`
- `published_at`

## Development Notes

- Frontend behavior lives mostly in [`resources/js/app.js`](resources/js/app.js)
- Public and protected API helpers live in [`resources/js/api.js`](resources/js/api.js)
- Blade pages are rendered through [`app/Http/Controllers/FrontendController.php`](app/Http/Controllers/FrontendController.php)
- The app uses soft-delete style behavior through an `is_deleted` flag on blogs

## Testing

Run the test suite with:

```bash
composer test
```

## License

This project is open-sourced under the MIT license.
