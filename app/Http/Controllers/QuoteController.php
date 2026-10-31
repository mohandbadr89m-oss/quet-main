<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class QuoteController extends Controller
{
    /**
     * Create a new quote.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->validationRules());

        $request->user()->quotes()->create([
            'content' => $validated['content'],
            'category' => $validated['category'],
        ]);

        return redirect()->route('library')
            ->with('success', 'تمت إضافة الاقتباس بنجاح!');
    }

    /**
     * Update an existing quote.
     * Owner can edit any quote.
     * Other users can edit only their own quotes.
     */
    public function update(Request $request, Quote $quote): RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $user->isOwner()
            || (int) $quote->user_id === (int) $user->id,
            403,
            'ليس لديك صلاحية تعديل هذا الاقتباس.'
        );

        $validated = $request->validate($this->validationRules());

        $quote->update([
            'content' => $validated['content'],
            'category' => $validated['category'],
        ]);

        return redirect()->back()
            ->with('success', 'تم تعديل الاقتباس بنجاح!');
    }

    /**
     * Delete an existing quote.
     * Admin and Owner can delete any quote.
     * Users can delete only their own quotes.
     */
    public function destroy(Request $request, Quote $quote): RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $user->isAdmin()
            || (int) $quote->user_id === (int) $user->id,
            403,
            'ليس لديك صلاحية حذف هذا الاقتباس.'
        );

        $quote->delete();

        return redirect()->back()
            ->with('success', 'تم حذف الاقتباس بنجاح!');
    }

    /**
     * Get quote validation rules.
     */
    private function validationRules(): array
    {
        $categories = config('athar.categories', []);

        return [
            'content' => 'required|string|min:3|max:155',
            'category' => 'required|string|in:' . implode(',', $categories),
        ];
    }
}
