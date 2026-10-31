
@extends('Layout.app')

@section('title', 'مكتبة ATHAR — أثر')

@section('content')

<div class="mx-auto max-w-6xl p-6 md:p-8">

    {{-- Success message --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg border border-[#C5A15B]/30 bg-[#20382C] p-3 text-[#E8DFC9]">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-400/30 bg-red-950/40 p-3 text-red-200">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Favorite AJAX status message --}}
    <div
        id="favorite-message"
        role="status"
        aria-live="polite"
        class="mb-4 hidden rounded-lg border border-[#C5A15B]/30 bg-[#20382C] p-3 text-sm text-[#E8DFC9]">
    </div>

    {{-- Library heading --}}
    <section class="mb-10 text-center">

        <span class="mb-3 block text-xs tracking-[0.35em] text-[#C5A15B]">
            ATHAR LIBRARY
        </span>

        <h1 class="athar-heading text-3xl md:text-4xl">
            مكتبة الاقتباسات
        </h1>

        <p class="mt-3 text-sm text-[#B6A98D]">
            مساحة للكلمات التي تستحق أن تُقرأ وتُحفظ.
        </p>

        <div class="mx-auto mt-5 h-px w-24 bg-gradient-to-r from-transparent via-[#C5A15B] to-transparent"></div>

    </section>

    {{-- Category filters --}}
    <x-category-filters
        :categories="$categories"
        :selected-category="$selectedCategory"
    />

    {{-- Quotes panel --}}
    <section class="mt-8 space-y-5">

        <h2 class="athar-heading text-3xl">
            {{ $selectedCategory ?? 'أحدث العبارات' }}
        </h2>

        @forelse ($quotes as $quote)

            <x-quote-card
                :quote="$quote"
                :categories="$categories"
            />

        @empty

            <div class="rounded-xl border border-[#80683D]/40 bg-[#1C2B21] p-8 text-center">

                <span class="text-3xl text-[#D6B66F]">❖</span>

                <p class="mt-4 text-[#E8DFC9]">
                    المكتبة تنتظر كلماتك الأولى.
                </p>

                <p class="mt-2 text-sm text-[#B6A98D]">
                    لا توجد اقتباسات هنا حاليًا، كن أول من يترك أثرًا.
                </p>

            </div>

        @endforelse

    </section>

</div>


{{-- Add Quote Component --}}
@auth
    <x-add-quote-modal :categories="$categories" />
@endauth

@endsection
