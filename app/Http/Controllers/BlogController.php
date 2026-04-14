<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $blogs = Blog::where('user_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfully',
            'data' => $blogs,
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
            'data' => $blog
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
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        $blog = Blog::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully',
            'data' => $blog
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
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        }

        $blog->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog
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
}
