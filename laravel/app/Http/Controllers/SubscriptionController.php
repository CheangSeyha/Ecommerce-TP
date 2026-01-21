<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Audience;

class SubscriptionController extends Controller
{
    
      public function subscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'audience_id' => 'required|exists:audiences,id',
            'article_ids' => 'required|array',
            'article_ids.*' => 'exists:articles,id',
        ]);

        $audience = Audience::findOrFail($validated['audience_id']);
        $audience->articles()->attach($validated['article_ids']);

        return response()->json([
            'message' => 'Audience subscribed to articles successfully',
            'audience' => $audience,
        ]);
    }
}
