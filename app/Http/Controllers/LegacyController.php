<?php

namespace App\Http\Controllers;

use App\Models\LegacyQuote;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegacyController extends Controller
{
    /**
     * Display the eternal legacy hall.
     */
    public function index(): View
    {
        $quotes = LegacyQuote::with('creator')
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12);

        return view('legacy.index', compact('quotes'));
    }

    /**
     * Store a new legacy quote.
     */
    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->isAdmin(), 403);

        $validated = $request->validate($this->validationRules());

        $request->user()->legacyQuotes()->create([
            'content' => $validated['content'],
            'speaker' => $validated['speaker'],
            'speaker_bio' => $validated['speaker_bio'] ?? null,
            'category' => $validated['category'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('legacy')
            ->with('success', 'تمت إضافة الاقتباس إلى قاعة الأثر الخالدة!');
    }

    /**
     * Update an existing legacy quote.
     */
    public function update(
        Request $request,
        LegacyQuote $legacyQuote
    ): RedirectResponse {
        abort_unless($request->user()->isAdmin(), 403);

        $validated = $request->validate($this->validationRules());

        $legacyQuote->update([
            'content' => $validated['content'],
            'speaker' => $validated['speaker'],
            'speaker_bio' => $validated['speaker_bio'] ?? null,
            'category' => $validated['category'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('legacy')
            ->with('success', 'تم تحديث الاقتباس بنجاح!');
    }

    /**
     * Delete a legacy quote.
     */
    public function destroy(
        Request $request,
        LegacyQuote $legacyQuote
    ): RedirectResponse {
        abort_unless($request->user()->isAdmin(), 403);

        $legacyQuote->delete();

        return redirect()->route('legacy')
            ->with('success', 'تم حذف الاقتباس من قاعة الأثر الخالدة.');
    }

    /**
     * Validation rules.
     */
    private function validationRules(): array
    {
        $categories = config('athar.categories', []);

        return [
            'content' => 'required|string|min:3|max:2000',
            'speaker' => 'required|string|max:150',
            'speaker_bio' => 'nullable|string|max:2000',
            'category' => 'required|string|in:' . implode(',', $categories),
            'is_featured' => 'nullable|boolean',
        ];
    }
}
