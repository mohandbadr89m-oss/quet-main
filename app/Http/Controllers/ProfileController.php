<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function index(Request $request): View
    {
        return $this->showProfile(
            $request->user(),
            'Profile.profile'
        );
    }

    /**
     * Display a public author's profile.
     */
    public function show(User $user): View
    {
        return $this->showProfile(
            $user,
            'Profile.author'
        );
    }

    /**
     * Upload or replace the user's avatar.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user = $request->user();

        $newAvatarPath = $request->file('avatar')
            ->store('avatars', 'public');

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->update([
            'avatar_path' => $newAvatarPath,
        ]);

        return redirect()
            ->route('profile')
            ->with('success', 'تم تحديث صورتك الشخصية بنجاح.');
    }

    /**
     * Load profile information and quotes.
     */
    private function showProfile(User $user, string $view): View
    {
        $currentUser = auth()->user();

        // Load the user's published quotes.
        $quotesQuery = $user->quotes()
            ->with('user')
            ->withCount('likes')
            ->latest();

        if ($currentUser) {
            $quotesQuery->with([
                'likes' => function ($query) use ($currentUser) {
                    $query->where('user_id', $currentUser->id);
                },
                'favorites' => function ($query) use ($currentUser) {
                    $query->where('user_id', $currentUser->id);
                },
            ]);
        }

        $quotes = $quotesQuery->get();

        // Load saved quotes for the authenticated user's profile.
        $favoriteQuotes = collect();

        if ($view === 'Profile.profile') {
            $favoriteQuotes = $user->favorites()
                ->with([
                    'quote' => function ($query) use ($currentUser) {
                        $query->with('user')
                            ->withCount('likes');

                        if ($currentUser) {
                            $query->with([
                                'likes' => function ($likesQuery) use ($currentUser) {
                                    $likesQuery->where(
                                        'user_id',
                                        $currentUser->id
                                    );
                                },
                                'favorites' => function ($favoritesQuery) use ($currentUser) {
                                    $favoritesQuery->where(
                                        'user_id',
                                        $currentUser->id
                                    );
                                },
                            ]);
                        }
                    },
                ])
                ->latest()
                ->get()
                ->pluck('quote')
                ->filter()
                ->values();
        }

        return view($view, [
            'page' => 'Profile',
            'profileUser' => $user,
            'quotes' => $quotes,
            'favoriteQuotes' => $favoriteQuotes,
            'categories' => config('athar.categories', []),
        ]);
    }
}
