
@extends('Layout.app')

@section('title', 'ملفي الشخصي — ATHAR')

@section('content')

<div class="mx-auto max-w-4xl px-5 py-12 sm:px-8">

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl border border-[#C5A15B]/30 bg-[#20382C] p-4 text-[#E8DFC9]">
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile Header --}}
    <section class="mb-10 overflow-hidden rounded-3xl border border-[#80683D]/50 bg-[#1C2B21] shadow-xl">

        <div class="h-32 bg-gradient-to-l from-[#14251F] via-[#304735] to-[#956D45]"></div>

        <div class="relative px-6 pb-8 text-center">

            {{-- Avatar --}}
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

            {{-- Change Avatar --}}
            <form
                action="{{ route('profile.avatar') }}"
                method="POST"
                enctype="multipart/form-data"
                class="mx-auto mt-4 max-w-xs">

                @csrf

                <label
                    for="avatar"
                    class="inline-flex cursor-pointer items-center justify-center rounded-full border border-[#C5A15B]/40 bg-[#101B15] px-5 py-2 text-sm font-semibold text-[#D6B66F] transition hover:bg-[#C5A15B]/10">

                    تغيير الصورة الشخصية
                </label>

                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                    accept="image/jpeg,image/png,image/webp"
                    class="hidden"
                    onchange="this.form.submit()">

                @error('avatar')
                    <p class="mt-2 text-sm text-red-300">
                        {{ $message }}
                    </p>
                @enderror

            </form>

            {{-- User Information --}}
            <h1 class="athar-heading mt-5 text-3xl">
                {{ $profileUser->name }}
            </h1>

            @if ($profileUser->username)
                <p class="mt-2 text-sm text-[#D6B66F]" dir="ltr">
                    @ {{ $profileUser->username }}
                </p>
            @endif

            <p class="mx-auto mt-4 max-w-xl leading-8 text-[#B6A98D]">
                {{ $profileUser->bio ?: 'كل إنسان يترك أثرًا، وهذه مساحتي لأشارك كلماتي.' }}
            </p>

            <p class="mt-3 text-xs text-[#A99B7D]">
                كاتب في أثر — كلمات تبقى.
            </p>

        </div>

    </section>

    {{-- Statistics --}}
    <section class="mb-10 grid grid-cols-2 gap-4">

        <div class="rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-5 text-center">
            <p class="text-3xl font-bold text-[#D6B66F]">
                {{ $quotes->count() }}
            </p>
            <p class="mt-2 text-sm text-[#B6A98D]">
                اقتباساتي
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

    {{-- Profile Tabs --}}
    <section class="space-y-6">

        <div class="flex flex-wrap gap-3 border-b border-[#C5A15B]/20 pb-4">

            <button
                type="button"
                data-profile-tab="quotes"
                aria-pressed="true"
                class="profile-tab rounded-full border border-[#C5A15B] bg-[#C5A15B] px-6 py-2 text-sm font-semibold text-[#101B15] transition">

                اقتباساتي ({{ $quotes->count() }})
            </button>

            <button
                type="button"
                data-profile-tab="favorites"
                aria-pressed="false"
                class="profile-tab rounded-full border border-[#80683D]/50 bg-[#1C2B21] px-6 py-2 text-sm font-semibold text-[#E8DFC9] transition hover:border-[#C5A15B]">

                المفضلة ({{ $favoriteQuotes->count() }})
            </button>

        </div>

        {{-- My Quotes --}}
        <div id="profile-quotes" class="space-y-5">

            <div class="flex items-center justify-between">
                <h2 class="athar-heading text-2xl">
                    اقتباساتي
                </h2>

                <a
                    href="{{ route('home') }}"
                    class="text-sm text-[#D6B66F] transition hover:text-[#E8DFC9]">

                    العودة للرئيسية ←
                </a>
            </div>

            @forelse ($quotes as $quote)

                <x-quote-card
                    :quote="$quote"
                    :categories="$categories"
                />

            @empty

                <div class="rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-10 text-center">

                    <p class="mb-3 text-4xl">✦</p>

                    <h3 class="athar-heading text-xl">
                        لم تكتب أثرك الأول بعد
                    </h3>

                    <p class="mt-3 text-sm text-[#B6A98D]">
                        ابدأ بمشاركة كلماتك، فقد تصبح أثرًا يبقى.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="btn-primary mt-6 inline-block">

                        أضف اقتباسًا
                    </a>

                </div>

            @endforelse

        </div>

        {{-- Favorite Quotes --}}
        <div id="profile-favorites" class="hidden space-y-5">

            <h2 class="athar-heading text-2xl">
                العبارات المحفوظة
            </h2>

            @forelse ($favoriteQuotes as $quote)

                <x-quote-card
                    :quote="$quote"
                    :categories="$categories"
                />

            @empty

                <div class="rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-10 text-center">

                    <p class="mb-3 text-4xl">🔖</p>

                    <h3 class="athar-heading text-xl">
                        لم تحفظ أي عبارة بعد
                    </h3>

                    <p class="mt-3 text-sm text-[#B6A98D]">
                        احفظ العبارات التي تعجبك لتجدها هنا لاحقًا.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="btn-primary mt-6 inline-block">

                        اكتشف العبارات
                    </a>

                </div>

            @endforelse

        </div>

    </section>

</div>

{{-- Profile Tabs Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const tabs = document.querySelectorAll('.profile-tab');

    const quotesPanel = document.getElementById('profile-quotes');
    const favoritesPanel = document.getElementById('profile-favorites');

    tabs.forEach((tab) => {

        tab.addEventListener('click', () => {

            const selectedTab = tab.dataset.profileTab;
            const showQuotes = selectedTab === 'quotes';

            quotesPanel.classList.toggle('hidden', !showQuotes);
            favoritesPanel.classList.toggle('hidden', showQuotes);

            tabs.forEach((item) => {

                const isActive = item === tab;

                item.setAttribute('aria-pressed', String(isActive));

                item.classList.toggle('bg-[#C5A15B]', isActive);
                item.classList.toggle('text-[#101B15]', isActive);
                item.classList.toggle('border-[#C5A15B]', isActive);

                item.classList.toggle('bg-[#1C2B21]', !isActive);
                item.classList.toggle('text-[#E8DFC9]', !isActive);
                item.classList.toggle('border-[#80683D]/50', !isActive);

            });

        });

    });

});
</script>

@endsection
