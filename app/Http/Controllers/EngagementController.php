<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\User;

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

        $followers = count($followers);

        return response()->json([
            'status' => true,
            'message' => 'Followers fetched successfully',
            'data' => [
                'followers' => $followers
            ]
        ], 200);
    }

    public function following(Request $request)
    {
        $following = Follow::where('follower_id', $request->user()->id)
            ->get();

        $following = count($following);

        return response()->json([
            'status' => true,
            'message' => 'Following list fetched successfully',
            'data' => [
                'following' => $following
            ]
        ], 200);
    }
}
