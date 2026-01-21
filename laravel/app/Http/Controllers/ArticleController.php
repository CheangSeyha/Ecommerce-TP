<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Article;


class ArticleController extends Controller
{
    
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id',
        ]);

        $article = Article::create($validated);

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article->load('author'),
        ], 201);
    }

    /**
     * Get all audiences subscribed to a specific article
     */
    public function getAudiences($articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);
        $audiences = $article->audiences()->get();

        return response()->json([
            'article' => $article,
            'audiences' => $audiences,
        ]);
    }

    /**
     * Get all comments on a specific article
     */
    public function getComments($articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);
        $comments = $article->comments()->with('user')->get();

        return response()->json([
            'article' => $article,
            'comments' => $comments,
        ]);
    }
}
