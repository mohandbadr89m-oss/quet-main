
@extends('Layout.app')

@section('title', $profileUser->name . ' — ATHAR')

@section('content')

<div class="mx-auto max-w-4xl px-5 py-12 sm:px-8">

    {{-- Back to Home --}}
    <div class="mb-6">
        <a
            href="{{ route('home') }}"
            class="text-sm text-[#D6B66F] transition hover:text-[#E8DFC9]">
            ← العودة للرئيسية
        </a>
    </div>

    {{-- Author Header --}}
    <section class="mb-10 overflow-hidden rounded-3xl border border-[#80683D]/50 bg-[#1C2B21] shadow-xl">

        <div class="h-32 bg-gradient-to-l from-[#14251F] via-[#304735] to-[#956D45]"></div>

        <div class="relative px-6 pb-8 text-center">

            {{-- Author Avatar --}}
            <div class="mx-auto -mt-14 mb-4 flex h-28 w-28 items-center justify-center overflow-hidden rounded-full border-4 border-[#1C2B21] bg-[#C5A15B] text-4xl font-bold text-[#14251F] shadow-xl">

                @if ($profileUser->avatar_path)
                    <img
                        src="{{ asset('storage/' . $profileUser->avatar_path) }}"
                        alt="{{ $profileUser->name }}"
                        class="h-full w-full object-cover">
                @else
                    {{ mb_substr($profileUser->name, 0, 1) }}
                @endif

            </div>

            {{-- Author Information --}}
            <h1 class="athar-heading text-3xl">
                {{ $profileUser->name }}
            </h1>

            @if ($profileUser->username)
                <p class="mt-2 text-sm text-[#D6B66F]" dir="ltr">
                    @ {{ $profileUser->username }}
                </p>
            @endif

            <p class="mx-auto mt-4 max-w-xl leading-8 text-[#B6A98D]">
                {{ $profileUser->bio ?: 'كاتب في أثر — كلمات تبقى.' }}
            </p>

            <p class="mt-3 text-xs text-[#A99B7D]">
                يترك كلماته هنا لتبقى.
            </p>

        </div>

    </section>

    {{-- Author Statistics --}}
    <section class="mb-10 grid grid-cols-2 gap-4">

        <div class="rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-5 text-center">

            <p class="text-3xl font-bold text-[#D6B66F]">
                {{ $quotes->count() }}
            </p>

            <p class="mt-2 text-sm text-[#B6A98D]">
                الاقتباسات
            </p>

        </div>

        <div class="rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-5 text-center">

            <p class="text-3xl font-bold text-[#D6B66F]">
                {{ $quotes->sum('likes_count') }}
            </p>

            <p class="mt-2 text-sm text-[#B6A98D]">
                إجمالي الإعجابات
            </p>

        </div>

    </section>

    {{-- Author Quotes --}}
    <section class="space-y-5">

        <h2 class="athar-heading text-2xl">
            اقتباسات الكاتب
        </h2>

        @forelse ($quotes as $quote)

            <x-quote-card
                :quote="$quote"
                :categories="$categories"
            />

        @empty

            <div class="rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-10 text-center">

                <p class="mb-3 text-4xl">✦</p>

                <h3 class="athar-heading text-xl">
                    لا توجد اقتباسات حتى الآن
                </h3>

                <p class="mt-3 text-sm text-[#B6A98D]">
                    لم يشارك هذا الكاتب أي عبارات بعد.
                </p>

            </div>

        @endforelse

    </section>

</div>

@endsection
