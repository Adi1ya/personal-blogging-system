<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $blogs = Blog::where('user_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->withCount([
                'comments',
                'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
            ])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $blogs->map(fn(Blog $blog) => $this->transformBlog($blog)),
        ], 200);
    }

    public function show(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid blog ID',
                'data' => null
            ], 400);
        }

        $blog = Blog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->withCount([
                'comments',
                'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
            ])
            ->first();

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog fetched successfully',
            'data' => $this->transformBlog($blog)
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['category'] = Str::lower($validated['category']);
        $validated['tags'] = $this->normalizeTags($validated['tags'] ?? []);
        $validated['is_published'] = (bool) ($validated['is_published'] ?? false);
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $blog = Blog::create($validated);
        $blog->loadCount([
            'comments',
            'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully',
            'data' => $this->transformBlog($blog)
        ], 201);
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->first();

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
                'data' => null
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'featured_image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category' => 'sometimes|required|string|max:100',
            'tags' => 'sometimes|nullable|array',
            'tags.*' => 'string|max:50',
            'is_published' => 'sometimes|boolean',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        }

        if (array_key_exists('tags', $validated)) {
            $validated['tags'] = $this->normalizeTags($validated['tags'] ?? []);
        }

        if (isset($validated['category'])) {
            $validated['category'] = Str::lower($validated['category']);
        }

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if (array_key_exists('is_published', $validated)) {
            $validated['published_at'] = $validated['is_published'] && ! $blog->published_at
                ? now()
                : ($validated['is_published'] ? $blog->published_at : null);
        }

        $blog->update($validated);
        $blog->refresh()->loadCount([
            'comments',
            'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully',
            'data' => $this->transformBlog($blog)
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $updated = Blog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->update(['is_deleted' => 1]);

        if (!$updated) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully',
            'data' => null
        ], 200);
    }

    public function publish(Request $request, Blog $blog)
    {
        if ($blog->user_id !== $request->user()->id || $blog->is_deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
                'data' => null
            ], 404);
        }

        $blog->update([
            'is_published' => 1,
            'published_at' => now(),
        ]);
        $blog->loadCount([
            'comments',
            'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog published successfully',
            'data' => $this->transformBlog($blog)
        ], 200);
    }

    public function searchByTag($tag)
    {
        validator(['tag' => $tag], [
            'tag' => 'required|string|max:50|alpha_dash'
        ])->validate();

        $tag = strtolower($tag);

        $blogs = Blog::where('is_deleted', 0)
            ->where('is_published', 1)
            ->whereJsonContains('tags', $tag)
            ->with('author:id,name')
            ->withCount([
                'comments',
                'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
            ])
            ->latest('published_at')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $blogs->map(fn(Blog $blog) => $this->transformBlog($blog))
        ], 200);
    }

    public function searchByCategory($category)
    {
        validator(['category' => $category], [
            'category' => 'required|string|max:50|alpha_dash'
        ])->validate();

        $category = strtolower($category);

        $blogs = Blog::where('is_deleted', 0)
            ->where('is_published', 1)
            ->where('category', $category)
            ->with('author:id,name')
            ->withCount([
                'comments',
                'reactions as likes_count' => fn($query) => $query->where('type', 'like'),
            ])
            ->latest('published_at')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $blogs->map(fn(Blog $blog) => $this->transformBlog($blog))
        ], 200);
    }

    private function normalizeTags(array $tags): array
    {
        return array_values(array_filter(array_map(
            fn($tag) => Str::of((string) $tag)->trim()->lower()->value(),
            $tags
        )));
    }

    private function transformBlog(Blog $blog): array
    {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'content' => $blog->content,
            'excerpt' => Str::limit(strip_tags($blog->content), 180),
            'featured_image' => $blog->featured_image_url,
            'category' => $blog->category,
            'tags' => $blog->tags ?? [],
            'is_published' => (bool) $blog->is_published,
            'published_at' => optional($blog->published_at)->toISOString(),
            'created_at' => optional($blog->created_at)->toISOString(),
            'updated_at' => optional($blog->updated_at)->toISOString(),
            'reading_time' => $blog->reading_time,
            'likes_count' => (int) ($blog->likes_count ?? 0),
            'comments_count' => (int) ($blog->comments_count ?? 0),
            'author' => $blog->author
                ? [
                    'id' => $blog->author->id,
                    'name' => $blog->author->name,
                ]
                : null,
        ];
    }
}
