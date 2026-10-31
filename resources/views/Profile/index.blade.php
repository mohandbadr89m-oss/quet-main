
@extends('Layout.app')

@section('title', $profileUser->name . ' - ATHAR')

@section('content')
<div class="mx-auto max-w-4xl px-5 py-12 sm:px-8">

    <div class="mb-10 rounded-3xl border border-stone-200 bg-white p-8 shadow-sm">
        <a href="{{ route('home') }}" class="text-sm text-stone-500 hover:underline">
            ← العودة للرئيسية
        </a>

        <div class="mt-8 text-center">
            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-stone-100 text-3xl font-bold text-stone-800">
                {{ mb_substr($profileUser->name, 0, 1) }}
            </div>

            <h1 class="text-3xl font-bold text-stone-800">
                {{ $profileUser->name }}
            </h1>

            <p class="mt-3 text-stone-500">
                كاتب في أثر — كلمات تبقى.
            </p>

            <p class="mt-5 text-sm text-stone-500">
                عدد الاقتباسات: {{ $quotes->count() }}
            </p>
        </div>
    </div>

    <h2 class="mb-6 text-2xl font-bold text-stone-800">
        اقتباسات الكاتب
    </h2>

    @forelse ($quotes as $quote)
        <article class="mb-4 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <span class="rounded-full bg-stone-100 px-3 py-1 text-sm text-stone-600">
                    {{ $quote->category ?? 'عام' }}
                </span>

                <span class="text-sm text-stone-400">
                    {{ $quote->created_at->format('Y/m/d') }}
                </span>
            </div>

            <blockquote class="text-lg leading-9 text-stone-800">
                «{{ $quote->content }}»
            </blockquote>
        </article>
    @empty
        <div class="rounded-2xl border border-stone-200 bg-white p-8 text-center">
            <p class="text-stone-600">لا توجد اقتباسات حتى الآن.</p>
        </div>
    @endforelse

</div>
@endsection
