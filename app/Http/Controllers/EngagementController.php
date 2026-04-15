<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogReaction;
use App\Models\Comment;

class EngagementController extends Controller
{
    public function follow(Request $request, User $author)
    {
        $follower_id = $request->user()->id;

        if ($follower_id === $author->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot follow yourself',
                'data' => null
            ], 400);
        }

        $already_followed = Follow::where('follower_id', $follower_id)
            ->where('author_id', $author->id)
            ->exists();

        if ($already_followed) {
            return response()->json([
                'status' => false,
                'message' => 'You are already following this author',
                'data' => null
            ], 200);
        }

        $follow = Follow::create([
            'follower_id' => $follower_id,
            'author_id' => $author->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Followed',
            'data' => $follow
        ], 201);
    }

    public function unfollow(Request $request, User $author)
    {
        $follower_id = $request->user()->id;

        $follower = Follow::where('follower_id', $follower_id)
            ->where('author_id', $author->id)
            ->exists();

        if (!$follower) {
            return response()->json([
                'status' => false,
                'message' => 'You are not following this author',
                'data' => null
            ], 400);
        }

        $unfollow = Follow::where('follower_id', $follower_id)
            ->where('author_id', $author->id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Unfollowed',
            'data' => $unfollow
        ], 200);
    }

    public function followers(User $author)
    {
        $followers = Follow::where('author_id', $author->id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Followers fetched successfully',
            'data' => [
                'followers' => count($followers)
            ]
        ], 200);
    }

    public function following(Request $request)
    {
        $following = Follow::where('follower_id', $request->user()->id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Following list fetched successfully',
            'data' => [
                'following' => count($following)
            ]
        ], 200);
    }

    public function like(Request $request, Blog $blog)
    {
        $reaction = $this->react('like', $blog, $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Blog post liked successfully',
            'data' => $reaction
        ], 201);
    }

    public function removeLike(Request $request, Blog $blog)
    {
        $deleted = BlogReaction::where([
            'user_id' => $request->user()->id,
            'blog_id' => $blog->id,
            'type' => 'like'
        ])->delete();

        return response()->json([
            'status' => true,
            'message' => $deleted ? 'Like removed successfully' : 'Already not liked',
            'data' => null
        ], 200);
    }

    public function listLikes(Request $request, Blog $blog)
    {
        $likes = BlogReaction::where('user_id', $request->user()->id)
            ->where('blog_id', $blog->id)
            ->where('type', 'like')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Likes fetched successfully',
            'data' => [
                'likes' => count($likes)
            ]
        ], 200);
    }

    public function dislike(Request $request, Blog $blog)
    {
        $reaction = $this->react('dislike', $blog, $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Blog post disliked successfully',
            'data' => $reaction
        ], 200);
    }

    private function react($type, Blog $blog, $userId)
    {
        return BlogReaction::updateOrCreate(
            [
                'user_id' => $userId,
                'blog_id' => $blog->id,
            ],
            [
                'type' => $type,
            ]
        );
    }

    public function removeDislike(Request $request, Blog $blog)
    {
        $deleted = BlogReaction::where([
            'user_id' => $request->user()->id,
            'blog_id' => $blog->id,
            'type' => 'dislike'
        ])->delete();

        return response()->json([
            'status' => true,
            'message' => $deleted ? 'Dislike removed successfully' : 'Already not disliked',
            'data' => null
        ], 200);
    }

    public function listDislikes(Request $request, Blog $blog)
    {
        $dislikes = BlogReaction::where('user_id', $request->user()->id)
            ->where('blog_id', $blog->id)
            ->where('type', 'dislike')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Dislikes fetched successfully',
            'data' => [
                'dislikes' => count($dislikes)
            ]
        ], 200);
    }

    public function storeComment(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'blog_id' => $blog->id,
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Commented successfully',
            'data' => $comment
        ], 201);
    }

    public function listComments(Request $request, Blog $blog)
    {
        $comments = Comment::where('user_id', $request->user()->id)
            ->where('blog_id', $blog->id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Comments fetched successfully',
            'data' => $comments
        ], 200);
    }

    public function show(Blog $blog, Comment $comment)
    {
        return response()->json([
            'status' => true,
            'message' => 'Comment fetched successfully',
            'data' => $comment
        ]);
    }

    public function destroy(Request $request, Blog $blog, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully',
            'data' => null
        ], 200);
    }
}
