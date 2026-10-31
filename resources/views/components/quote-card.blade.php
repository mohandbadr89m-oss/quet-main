
@props(['quote', 'categories'])

<blockquote
    id="quote-{{ $quote->id }}"
    class="athar-quote-card relative rounded-2xl border border-[#80683D]/50 bg-[#1C2B21] p-6 text-[#E8DFC9] shadow-lg transition duration-300 hover:border-[#C5A15B]/60">

    {{-- Quote Category --}}
    <div class="relative z-10 mb-4">
        <span class="rounded-full border border-[#C5A15B]/40 bg-[#101B15]/80 px-3 py-1 text-xs font-semibold text-[#D6B66F]">
            {{ $quote->category ?: 'عام' }}
        </span>
    </div>

    {{-- Quote Content --}}
    <p class="athar-quote relative z-10">
        “{{ $quote->content }}”
    </p>

    {{-- Author --}}
    <div class="relative z-10 mt-5 flex items-center gap-3">

        <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-full border border-[#C5A15B]/60 bg-[#C5A15B] font-bold text-[#14251F] shadow-md">

            @if ($quote->user->avatar_path)
                <img
                    src="{{ asset('storage/' . $quote->user->avatar_path) }}"
                    alt="{{ $quote->user->name }}"
                    class="h-full w-full object-cover">
            @else
                {{ mb_substr($quote->user->name, 0, 1) }}
            @endif

        </div>

        <div class="flex flex-wrap items-center gap-2">

            <a
                href="{{ route('authors.show', $quote->user) }}"
                class="text-sm font-semibold text-[#D6B66F] transition hover:text-[#E8DFC9]">

                {{ $quote->user->name }}

            </a>

            <span class="text-xs text-[#A99B7D]">
                · {{ $quote->created_at->format('Y-m-d') }}
            </span>

        </div>

    </div>

    {{-- Like, Favorite and Share --}}
    <div class="relative z-10 mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-[#C5A15B]/25 pt-4">

        @auth
            @php
                $isLiked = $quote->likes->isNotEmpty();
                $isFavorite = $quote->favorites->isNotEmpty();
            @endphp

            <div class="flex flex-wrap items-center gap-3">

                {{-- Like --}}
                <form
                    class="like-form"
                    action="{{ route('quotes.like', $quote) }}"
                    method="POST">

                    @csrf

                    <button
                        type="button"
                        class="like-button flex items-center gap-2 rounded-full border border-[#C5A15B]/40 bg-[#101B15]/80 px-4 py-2 transition duration-300 hover:border-[#D6B66F] hover:bg-[#C5A15B]/10"
                        aria-label="{{ $isLiked ? 'إلغاء الإعجاب' : 'إعجاب بالعبارة' }}"
                        aria-pressed="{{ $isLiked ? 'true' : 'false' }}">

                        <span class="like-icon text-xl">
                            {{ $isLiked ? '❤️' : '🤍' }}
                        </span>

                        <span class="like-count text-sm font-semibold text-[#E8DFC9]">
                            {{ number_format($quote->likes_count) }}
                        </span>

                    </button>
                </form>

                {{-- Favorite --}}
                <form
                    class="favorite-form"
                    action="{{ route('quotes.favorite', $quote) }}"
                    method="POST">

                    @csrf

                    <button
                        type="button"
                        class="favorite-button flex items-center gap-2 rounded-full border border-[#C5A15B]/40 bg-[#101B15]/80 px-4 py-2 transition duration-300 hover:border-[#D6B66F] hover:bg-[#C5A15B]/10 {{ $isFavorite ? 'text-[#D6B66F]' : 'text-[#B6A98D]' }}"
                        aria-label="{{ $isFavorite ? 'إزالة من المفضلة' : 'إضافة للمفضلة' }}"
                        aria-pressed="{{ $isFavorite ? 'true' : 'false' }}">

                        <svg
                            class="favorite-icon h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="{{ $isFavorite ? 'currentColor' : 'none' }}"
                            stroke="currentColor"
                            stroke-width="1.7">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 3.75h12v17l-6-4-6 4v-17Z" />

                        </svg>

                        <span class="favorite-label text-sm font-semibold">
                            {{ $isFavorite ? 'محفوظة' : 'حفظ' }}
                        </span>

                    </button>
                </form>

            </div>

        @else

            {{-- Guest Actions --}}
            <div class="flex flex-wrap items-center gap-3">

                <a
                    href="{{ route('login') }}"
                    class="flex items-center gap-2 rounded-full border border-[#C5A15B]/40 bg-[#101B15]/80 px-4 py-2 text-[#E8DFC9] transition hover:border-[#D6B66F] hover:bg-[#C5A15B]/10">

                    <span class="text-xl">🤍</span>

                    <span class="text-sm font-semibold">
                        {{ number_format($quote->likes_count) }}
                    </span>

                </a>

                <a
                    href="{{ route('login') }}"
                    class="flex items-center gap-2 rounded-full border border-[#C5A15B]/40 bg-[#101B15]/80 px-4 py-2 text-[#B6A98D] transition hover:border-[#D6B66F] hover:text-[#D6B66F]">

                    <span>🔖</span>

                    <span class="text-sm font-semibold">
                        حفظ
                    </span>

                </a>

            </div>

        @endauth

        {{-- Share Button --}}
        <button
            type="button"
            class="share-quote-button inline-flex items-center gap-2 rounded-full border border-[#C5A15B]/50 bg-[#101B15]/80 px-4 py-2 text-[#D6B66F] transition duration-300 hover:border-[#D6B66F] hover:bg-[#C5A15B]/10"
            data-modal-target="share-modal-{{ $quote->id }}"
            aria-label="مشاركة الاقتباس">

            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.7">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 16V4m0 0L7 9m5-5 5 5M5 13v5a2 2 0 0 0 2 2h14v-7" />

            </svg>

            <span class="text-sm font-semibold">
                مشاركة
            </span>

        </button>

    </div>

    {{-- Edit and Delete --}}
    @auth

        @php
            $currentUser = auth()->user();

            $isOwner = $currentUser->isOwner();
            $isAdmin = $currentUser->isAdmin();
            $isAuthor = (int) $quote->user_id === (int) $currentUser->id;
        @endphp

        <div class="relative z-10 mt-5 space-y-4 border-t border-[#C5A15B]/25 pt-4">

            {{-- Edit Quote: Owner or Original Author --}}
            @if ($isOwner || $isAuthor)

                <form
                    action="{{ route('quotes.update', $quote) }}"
                    method="POST"
                    class="flex flex-col gap-3">

                    @csrf
                    @method('PATCH')

                    <textarea
                        name="content"
                        rows="2"
                        required
                        minlength="3"
                        maxlength="155"
                        class="input w-full"
                        aria-label="تعديل العبارة">{{ $quote->content }}</textarea>

                    <label
                        for="edit-category-{{ $quote->id }}"
                        class="label">
                        التصنيف
                    </label>

                    <select
                        id="edit-category-{{ $quote->id }}"
                        name="category"
                        required
                        class="input w-full">

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category }}"
                                @selected($quote->category === $category)>
                                {{ $category }}
                            </option>
                        @endforeach

                    </select>

                    <button
                        type="submit"
                        class="btn btn-secondary">
                        حفظ التعديلات
                    </button>

                </form>

            @endif

            {{-- Delete Quote: Owner, Admin or Original Author --}}
            @if ($isOwner || $isAdmin || $isAuthor)

                <form
                    action="{{ route('quotes.destroy', $quote) }}"
                    method="POST"
                    onsubmit="return confirm('هل أنت متأكد من حذف العبارة؟')">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-secondary">
                        حذف العبارة
                    </button>

                </form>

            @endif

        </div>

    @endauth

</blockquote>


{{-- Share Options Modal --}}
<div
    id="share-modal-{{ $quote->id }}"
    class="share-options-modal fixed inset-0 z-[100] hidden items-center justify-center bg-black/75 p-4 backdrop-blur-sm"
    data-quote="{{ $quote->content }}"
    data-author="{{ $quote->user->name }}"
    data-category="{{ $quote->category ?: 'عام' }}"
    role="dialog"
    aria-modal="true"
    aria-label="خيارات مشاركة الاقتباس">

    {{-- Backdrop --}}
    <button
        type="button"
        class="share-modal-backdrop absolute inset-0 h-full w-full cursor-default"
        aria-label="إغلاق النافذة">
    </button>

    {{-- Modal Content --}}
    <div class="relative z-10 w-full max-w-sm rounded-2xl border border-[#C5A15B]/50 bg-[#14251F] p-6 text-center shadow-2xl">

        <div class="mb-4 text-3xl text-[#D6B66F]">
            ◇
        </div>

        <h3 class="athar-heading text-2xl">
            مشاركة الأثر
        </h3>

        <p class="mt-2 text-sm text-[#B6A98D]">
            اختر كيف تريد مشاركة هذه العبارة
        </p>

        <div class="mt-6 grid grid-cols-2 gap-3">

            {{-- Download Image --}}
            <button
                type="button"
                data-share-action="download"
                class="flex flex-col items-center gap-3 rounded-xl border border-[#C5A15B]/40 bg-[#20382C] p-5 text-[#D6B66F] transition hover:border-[#D6B66F] hover:bg-[#294633]">

                <svg
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v12m0 0 4-4m-4 4-4-4M5 17v3h14v-3" />

                </svg>

                <span class="text-sm font-semibold">
                    تحميل الصورة
                </span>

            </button>

            {{-- Share Image --}}
            <button
                type="button"
                data-share-action="share"
                class="flex flex-col items-center gap-3 rounded-xl border border-[#C5A15B]/40 bg-[#20382C] p-5 text-[#D6B66F] transition hover:border-[#D6B66F] hover:bg-[#294633]">

                <svg
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 16V4m0 0L7 9m5-5 5 5M5 13v5a2 2 0 0 0 2 2h14v-7" />

                </svg>

                <span class="text-sm font-semibold">
                    مشاركة الصورة
                </span>

            </button>

        </div>

        {{-- Cancel --}}
        <button
            type="button"
            class="share-modal-close mt-5 text-sm text-[#A99B7D] transition hover:text-[#E8DFC9]">
            إلغاء
        </button>

        <p class="mt-5 text-xs text-[#8D897B]">
            ATHAR — أثر · كلمات تبقى.
        </p>

    </div>
</div>
