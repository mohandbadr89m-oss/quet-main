<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    /**
     * Toggle a like on a quote.
     */
    public function toggle(Request $request, Quote $quote): JsonResponse
    {
        $user = $request->user();

        $like = $quote->likes()
            ->where('user_id', $user->id);

        if ($like->exists()) {
            $like->delete();

            $isLiked = false;
            $message = 'تم إلغاء الإعجاب';
        } else {
            $quote->likes()->create([
                'user_id' => $user->id,
            ]);

            $isLiked = true;
            $message = 'تم تسجيل الإعجاب';
        }

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $quote->likes()->count(),
            'message' => $message,
        ]);
    }
}
