<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Create a comment on an article or audience (polymorphic)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'commentable_type' => 'required|in:App\Models\Article,App\Models\Audience,App\Models\Author',
            'commentable_id' => 'required|integer',
        ]);

        $comment = Comment::create($validated);

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment->load('user', 'commentable'),
        ], 201);
    }

    /**
     * Get all comments from a specific audience
     */
    public function getByAudience($audienceId): JsonResponse
    {
        $audience = Audience::findOrFail($audienceId);
        $comments = $audience->comments()->with('user')->get();

        return response()->json([
            'audience' => $audience,
            'comments' => $comments,
        ]);
    }

    /**
     * Get all comments with a specific topic/content filter
     */
    public function getByTopic(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'topic' => 'required|string',
        ]);

        $comments = Comment::where('content', 'like', '%' . $validated['topic'] . '%')
            ->with('user', 'commentable')
            ->get();

        return response()->json([
            'topic' => $validated['topic'],
            'comments' => $comments,
        ]);
    }
}