<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $blogs = Blog::where('user_id', $request->user()->id)->get();

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
            'featured_image' => 'nullable|url',
            'content' => 'required|string',
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
            'featured_image' => 'nullable|url',
            'content' => 'sometimes|required|string',
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

        $blog = Blog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
                'data' => null
            ], 404);
        }

        $blog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully',
            'data' => null
        ], 200);
    }
}
