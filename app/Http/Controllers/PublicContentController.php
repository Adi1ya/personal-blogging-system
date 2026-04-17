<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogReaction;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicContentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(12, max(1, (int) $request->integer('per_page', 6)));
        $query = Blog::query()
            ->where('is_deleted', false)
            ->where('is_published', true)
            ->with('author:id,name')
            ->withCount([
                'comments',
                'reactions as likes_count' => fn ($builder) => $builder->where('type', 'like'),
            ])
            ->latest('published_at');

        if ($request->filled('category')) {
            $query->where('category', Str::lower($request->string('category')->value()));
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', Str::lower($request->string('tag')->value()));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->value();
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $blogs = $query->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Public blogs fetched successfully',
            'data' => collect($blogs->items())->map(fn (Blog $blog) => $this->transformBlog($blog)),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
                'has_more' => $blogs->hasMorePages(),
            ],
        ]);
    }

    public function show(Request $request, Blog $blog)
    {
        abort_if(! $blog->is_published || $blog->is_deleted, 404);

        $blog->load('author:id,name,email')
            ->loadCount([
                'comments',
                'reactions as likes_count' => fn ($builder) => $builder->where('type', 'like'),
            ]);

        $comments = Comment::where('blog_id', $blog->id)
            ->with('user:id,name,email')
            ->latest()
            ->get();

        $author = $blog->author;
        $viewer = $request->user('sanctum');

        return response()->json([
            'status' => true,
            'message' => 'Blog detail fetched successfully',
            'data' => [
                'blog' => $this->transformBlog($blog),
                'comments' => $comments->map(fn (Comment $comment) => [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'created_at' => optional($comment->created_at)->toISOString(),
                    'user' => [
                        'id' => $comment->user?->id,
                        'name' => $comment->user?->name,
                        'email' => $comment->user?->email,
                    ],
                    'is_owner' => $viewer?->id === $comment->user_id,
                ]),
                'author' => [
                    'id' => $author->id,
                    'name' => $author->name,
                    'email' => $author->email,
                    'bio' => null,
                    'avatar' => null,
                    'followers_count' => Follow::where('author_id', $author->id)->count(),
                    'following_count' => Follow::where('follower_id', $author->id)->count(),
                    'blogs_count' => Blog::where('user_id', $author->id)
                        ->where('is_deleted', false)
                        ->where('is_published', true)
                        ->count(),
                    'is_following' => $viewer
                        ? Follow::where('follower_id', $viewer->id)->where('author_id', $author->id)->exists()
                        : false,
                ],
                'viewer' => $viewer ? [
                    'id' => $viewer->id,
                    'has_liked' => BlogReaction::where('blog_id', $blog->id)
                        ->where('user_id', $viewer->id)
                        ->where('type', 'like')
                        ->exists(),
                ] : null,
            ],
        ]);
    }

    public function profile(Request $request, User $user)
    {
        $blogs = Blog::query()
            ->where('user_id', $user->id)
            ->where('is_deleted', false)
            ->where('is_published', true)
            ->with('author:id,name')
            ->withCount([
                'comments',
                'reactions as likes_count' => fn ($builder) => $builder->where('type', 'like'),
            ])
            ->latest('published_at')
            ->get();

        $followers = Follow::where('author_id', $user->id)
            ->with('follower:id,name,email')
            ->get();

        $following = Follow::where('follower_id', $user->id)
            ->with('author:id,name,email')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Profile fetched successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'bio' => null,
                    'avatar' => null,
                    'followers_count' => $followers->count(),
                    'following_count' => $following->count(),
                    'blogs_count' => $blogs->count(),
                    'is_following' => $request->user('sanctum')
                        ? Follow::where('follower_id', $request->user('sanctum')->id)->where('author_id', $user->id)->exists()
                        : false,
                ],
                'blogs' => $blogs->map(fn (Blog $blog) => $this->transformBlog($blog)),
                'followers' => $followers->map(fn (Follow $follow) => [
                    'id' => $follow->follower?->id,
                    'name' => $follow->follower?->name,
                    'email' => $follow->follower?->email,
                ]),
                'following' => $following->map(fn (Follow $follow) => [
                    'id' => $follow->author?->id,
                    'name' => $follow->author?->name,
                    'email' => $follow->author?->email,
                ]),
            ],
        ]);
    }

    public function categories()
    {
        $categories = Blog::query()
            ->where('is_deleted', false)
            ->where('is_published', true)
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Categories fetched successfully',
            'data' => $categories,
        ]);
    }

    public function tags()
    {
        $tags = Blog::query()
            ->where('is_deleted', false)
            ->where('is_published', true)
            ->pluck('tags')
            ->flatten(1)
            ->filter(fn ($tag) => filled($tag))
            ->map(fn ($tag) => Str::lower((string) $tag))
            ->unique()
            ->sort()
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Tags fetched successfully',
            'data' => $tags,
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'message' => 'Authenticated user fetched successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    private function transformBlog(Blog $blog): array
    {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'content' => $blog->content,
            'excerpt' => Str::limit(strip_tags($blog->content), 220),
            'featured_image' => $blog->featured_image_url,
            'category' => $blog->category,
            'tags' => $blog->tags ?? [],
            'published_at' => optional($blog->published_at)->toISOString(),
            'created_at' => optional($blog->created_at)->toISOString(),
            'reading_time' => $blog->reading_time,
            'likes_count' => (int) ($blog->likes_count ?? 0),
            'comments_count' => (int) ($blog->comments_count ?? 0),
            'author' => [
                'id' => $blog->author?->id,
                'name' => $blog->author?->name,
            ],
        ];
    }
}
