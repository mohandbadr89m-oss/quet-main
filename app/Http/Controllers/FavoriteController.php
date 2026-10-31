<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**
     * Toggle a quote in the user's favorites.
     */
    public function toggle(Request $request, Quote $quote): JsonResponse
    {
        $user = $request->user();

        $favorite = $quote->favorites()
            ->where('user_id', $user->id);

        if ($favorite->exists()) {
            $favorite->delete();

            return response()->json([
                'success' => true,
                'is_favorite' => false,
                'message' => 'تمت إزالة العبارة من المفضلة',
            ]);
        }

        $quote->favorites()->create([
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'is_favorite' => true,
            'message' => 'تمت إضافة العبارة إلى المفضلة',
        ]);
    }
}
