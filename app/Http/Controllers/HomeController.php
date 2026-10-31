<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the new ATHAR landing page.
     */
    public function landing(): View
    {
        return view('landing', [
            'page' => 'Landing',
        ]);
    }

    /**
     * Display the quotes library and its latest quotes.
     */
    public function index(Request $request): View
    {
        $categories = config('athar.categories', []);

        $selectedCategory = $request->query('category');

        $user = $request->user();

        $quotesQuery = Quote::with('user')
            ->withCount('likes')
            ->latest();

        // Load the current user's likes and favorites only.
        if ($user) {
            $quotesQuery->with([
                'likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },

                'favorites' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ]);
        }

        // Apply category filter.
        if (in_array($selectedCategory, $categories, true)) {
            $quotesQuery->where('category', $selectedCategory);
        } else {
            $selectedCategory = null;
        }

        $quotes = $quotesQuery->get();

        return view('welcome', [
            'page' => 'Home',
            'quotes' => $quotes,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * Display the Museum of Quotes.
     */
    public function museum(): View
    {
        $museumQuotes = Quote::with('user')
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->orderBy('created_at')
            ->limit(10)
            ->get();

        return view('museum', [
            'page' => 'Museum',
            'museumQuotes' => $museumQuotes,
        ]);
    }
}
