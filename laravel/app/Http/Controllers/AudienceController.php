<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Audience;

class AudienceController extends Controller
{

     public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|unique:users,name|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        
        $user = User::create([
            'name' => $validated['user_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        
        $audience = Audience::create([
            'name' => $validated['name'],
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Audience created successfully',
            'audience' => $audience->load('user'),
        ], 201);
    }

    /**
     * Get all comments from a specific audience
     */
    public function getComments($audienceId): JsonResponse
    {
        $audience = Audience::findOrFail($audienceId);
        $comments = $audience->comments()->with('user')->get();

        return response()->json([
            'audience' => $audience,
            'comments' => $comments,
        ]);
    }
}
