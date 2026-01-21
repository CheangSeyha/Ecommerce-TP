<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Author;

class AuthorController extends Controller
{
    //
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:authors,user_name',
            'email' => 'required|string|email|max:255|unique:authors,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $author = Author::create([
            'user_id' => $user->id,
            'user_name' => $validated['user_name'],
        ]);

        return response()->json([
            'message' => 'Author created successfully',
            'author' => $author->load('user'),
        ], 201);
    }

    public function getArticles($authorId): JsonResponse
    {
        $author = Author::findOrFail($authorId);
        $articles = $author->articles()->get();

        return response()->json([
            'author' => $author->name,
            'articles' => $articles,
        ]);
    }

    public function getAudiences($authorId): JsonResponse
    {
        $author = Author::findOrFail($authorId);
        $audiences = $author->audiences()->get();

        return response()->json([
            'author' => $author->name,
            'audiences' => $audiences,
        ]);
    }
}


