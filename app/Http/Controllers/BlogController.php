<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function createBlog(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'featured_image' => 'nullable|string',
            'content' => 'required|string',
        ]);


        $blog = Blog::create($validated);

        return response()->json([
            'message' => 'Blog created successfully',
            'data' => $blog
        ], 201);
    }
}
