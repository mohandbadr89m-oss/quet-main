
@extends('Layout.app')

@section('title', 'قاعة الأثر الخالدة — ATHAR')

@section('content')

<div class="relative min-h-screen overflow-hidden bg-[#080E0B] text-[#E8DFC9]">

    {{-- Background --}}
    <div class="pointer-events-none absolute inset-0">
        <div
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('/images/museum-hall.png');"
        ></div>
        <div class="absolute inset-0 bg-[#08130F]/75"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#08130F]/70 via-[#08130F]/50 to-[#08130F]"></div>
    </div>

    <div class="relative z-10 mx-auto max-w-[1450px] px-5 py-16">

        {{-- Header --}}
        <header class="mb-16 text-center">

            <span class="text-xs tracking-[0.4em] text-[#D6B66F]">
                ATHAR · THE ETERNAL LEGACY
            </span>

            <h1 class="athar-heading mt-6 text-4xl text-[#E8C77F] drop-shadow-[0_0_25px_rgba(214,182,111,0.3)] md:text-6xl">
                قاعة الأثر الخالدة
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-sm leading-loose text-[#E8DFC9]/80 md:text-base">
                ليست كل الكلمات عابرة؛ بعضها يتجاوز زمن قائله،
                ليبقى شاهدًا على فكر الإنسان وذاكرة الحضارة.
            </p>

            <div class="mx-auto mt-8 h-px w-40 bg-gradient-to-r from-transparent via-[#D6B66F] to-transparent"></div>

            <div class="mt-5 text-2xl text-[#D6B66F]">❖</div>

        </header>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="mx-auto mb-8 max-w-3xl rounded-xl border border-[#D6B66F]/40 bg-[#14251F]/90 px-6 py-4 text-center text-[#E8C77F]">
                {{ session('success') }}
            </div>
        @endif


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mx-auto mb-8 max-w-3xl rounded-xl border border-red-400/30 bg-red-950/40 px-6 py-4 text-sm text-red-200">
                <p class="mb-2 font-semibold">يرجى مراجعة البيانات التالية:</p>
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Admin Management --}}
        @auth
            @if (auth()->user()->isAdmin())

                <section class="mx-auto mb-16 max-w-4xl rounded-2xl border border-[#D6B66F]/40 bg-gradient-to-b from-[#20382C]/95 to-[#101D18]/95 p-6 shadow-[0_0_40px_rgba(214,182,111,0.08)] md:p-9">

                    <div class="mb-8 text-center">
                        <span class="text-2xl text-[#D6B66F]">✦</span>

                        <h2 class="mt-3 text-2xl text-[#E8C77F]">
                            إدارة الموروث الأدبي
                        </h2>

                        <p class="mt-2 text-sm text-[#B6A98D]">
                            أضف الكلمات التي تستحق أن تبقى.
                        </p>
                    </div>

                    <form action="{{ route('legacy.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm text-[#D6B66F]">
                                نص الاقتباس
                            </label>

                            <textarea
                                name="content"
                                rows="4"
                                required
                                maxlength="2000"
                                placeholder="اكتب الاقتباس هنا..."
                                class="w-full rounded-xl border border-[#D6B66F]/30 bg-[#08130F]/80 px-4 py-3 text-[#F0E7D5] outline-none transition focus:border-[#D6B66F]"
                            >{{ old('content') }}</textarea>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">

                            <div>
                                <label class="mb-2 block text-sm text-[#D6B66F]">
                                    صاحب الاقتباس
                                </label>

                                <input
                                    type="text"
                                    name="speaker"
                                    value="{{ old('speaker') }}"
                                    required
                                    maxlength="150"
                                    placeholder="اسم المفكر أو الكاتب"
                                    class="w-full rounded-xl border border-[#D6B66F]/30 bg-[#08130F]/80 px-4 py-3 text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm text-[#D6B66F]">
                                    التصنيف
                                </label>

                                <select
                                    name="category"
                                    required
                                    class="w-full rounded-xl border border-[#D6B66F]/30 bg-[#08130F] px-4 py-3 text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                                >
                                    <option value="">اختر التصنيف</option>

                                    @foreach (config('athar.categories', []) as $category)
                                        <option
                                            value="{{ $category }}"
                                            @selected(old('category') === $category)
                                        >
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div>
                            <label class="mb-2 block text-sm text-[#D6B66F]">
                                نبذة عن صاحب الاقتباس
                            </label>

                            <textarea
                                name="speaker_bio"
                                rows="3"
                                maxlength="2000"
                                placeholder="نبذة مختصرة عن حياته أو أعماله (اختياري)"
                                class="w-full rounded-xl border border-[#D6B66F]/30 bg-[#08130F]/80 px-4 py-3 text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                            >{{ old('speaker_bio') }}</textarea>
                        </div>

                        <label class="flex cursor-pointer items-center gap-3 text-sm text-[#E8DFC9]">
                            <input
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                @checked(old('is_featured'))
                                class="h-4 w-4 accent-[#D6B66F]"
                            >
                            تمييز هذا الاقتباس في القاعة
                        </label>

                        <button
                            type="submit"
                            class="w-full rounded-xl border border-[#D6B66F]/60 bg-gradient-to-r from-[#8B6A36] to-[#C5A15B] px-6 py-4 font-semibold text-[#101810] shadow-lg transition hover:-translate-y-1 hover:brightness-110"
                        >
                            ✦ إضافة إلى الأثر الخالد
                        </button>

                    </form>

                </section>

            @endif
        @endauth


        {{-- Gallery Heading --}}
        <div class="mb-10 text-center">
            <span class="text-xs tracking-[0.3em] text-[#B6A98D]">
                THE COLLECTION
            </span>

            <h2 class="mt-3 text-2xl text-[#E8C77F] md:text-3xl">
                مجموعة الكلمات الخالدة
            </h2>
        </div>


        {{-- Legacy Gallery --}}
        @if ($quotes->isNotEmpty())

            <section class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($quotes as $quote)

                    <article
                        class="group relative flex flex-col overflow-hidden rounded-t-[150px] border border-[#D6B66F]/40 bg-gradient-to-b from-[#294333]/95 via-[#14251F]/95 to-[#09130F]/95 p-3 pt-5 shadow-[0_15px_45px_rgba(0,0,0,0.5)] transition duration-700 hover:-translate-y-2 hover:border-[#E8C77F] hover:shadow-[0_0_35px_rgba(214,182,111,0.15)]"
                    >

                        {{-- Featured Label --}}
                        @if ($quote->is_featured)
                            <div class="absolute right-5 top-5 z-10 rounded-full border border-[#D6B66F]/60 bg-[#8B6A36] px-3 py-1 text-xs text-[#FFF1CC] shadow-lg">
                                ✦ قطعة مميزة
                            </div>
                        @endif


                        {{-- Exhibit --}}
                        <div class="flex flex-1 flex-col items-center rounded-t-[135px] border border-[#D6B66F]/20 bg-[#08130F]/85 px-6 pb-8 pt-16 text-center transition group-hover:border-[#D6B66F]/60">

                            <span class="mb-7 text-3xl text-[#D6B66F]">
                                ❖
                            </span>

                            <blockquote class="athar-quote text-lg leading-loose text-[#F0E7D5]">
                                « {{ $quote->content }} »
                            </blockquote>

                            <div class="my-7 h-px w-16 bg-[#D6B66F]/60"></div>

                            <h3 class="text-lg font-semibold text-[#E8C77F]">
                                {{ $quote->speaker }}
                            </h3>

                            @if ($quote->speaker_bio)
                                <p class="mt-4 text-sm leading-loose text-[#B6A98D]">
                                    {{ $quote->speaker_bio }}
                                </p>
                            @endif

                            <span class="mt-6 rounded-full border border-[#D6B66F]/30 px-4 py-1.5 text-xs text-[#D6B66F]">
                                {{ $quote->category }}
                            </span>

                        </div>


                        {{-- Pedestal --}}
                        <div class="mx-auto h-3 w-[108%] border border-[#D6B66F]/50 bg-gradient-to-b from-[#B18A4D] via-[#443521] to-[#15150F]"></div>

                        <div class="mx-auto w-[96%] border-x border-b border-[#A88A56]/60 bg-gradient-to-r from-[#101510] via-[#293027] to-[#101510] px-4 py-4 text-center shadow-xl">

                            <p class="text-xs text-[#B6A98D]">
                                محفوظ في ذاكرة أثر
                            </p>

                            <p class="mt-2 text-xs text-[#8F8A75]">
                                أضيف إلى القاعة
                                {{ $quote->created_at->format('Y/m/d') }}
                            </p>

                        </div>

                        <div class="mx-auto h-3 w-[108%] rounded-b-sm border border-[#80683D]/70 bg-gradient-to-b from-[#51432D] to-[#171A15]"></div>


                        {{-- Admin Controls --}}
                        @auth
                            @if (auth()->user()->isAdmin())

                                <div class="mt-5 flex flex-wrap justify-center gap-3">

                                    <button
                                        type="button"
                                        onclick="document.getElementById('edit-legacy-{{ $quote->id }}').classList.toggle('hidden')"
                                        class="rounded-full border border-[#D6B66F]/50 px-5 py-2 text-xs text-[#E8C77F] transition hover:bg-[#D6B66F]/10"
                                    >
                                        تعديل القطعة
                                    </button>

                                    <form
                                        action="{{ route('legacy.destroy', $quote) }}"
                                        method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الاقتباس؟');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-full border border-red-400/40 px-5 py-2 text-xs text-red-300 transition hover:bg-red-500/10"
                                        >
                                            حذف القطعة
                                        </button>
                                    </form>

                                </div>

                                {{-- Edit Form --}}
                                <div id="edit-legacy-{{ $quote->id }}" class="mt-5 hidden rounded-xl border border-[#D6B66F]/30 bg-[#08130F]/90 p-5 text-right">

                                    <h4 class="mb-5 text-center text-[#E8C77F]">
                                        تعديل بيانات القطعة
                                    </h4>

                                    <form
                                        action="{{ route('legacy.update', $quote) }}"
                                        method="POST"
                                        class="space-y-4"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <textarea
                                            name="content"
                                            rows="4"
                                            required
                                            maxlength="2000"
                                            class="w-full rounded-lg border border-[#D6B66F]/30 bg-[#14251F] p-3 text-sm text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                                        >{{ $quote->content }}</textarea>

                                        <input
                                            type="text"
                                            name="speaker"
                                            value="{{ $quote->speaker }}"
                                            required
                                            maxlength="150"
                                            placeholder="صاحب الاقتباس"
                                            class="w-full rounded-lg border border-[#D6B66F]/30 bg-[#14251F] p-3 text-sm text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                                        >

                                        <textarea
                                            name="speaker_bio"
                                            rows="3"
                                            maxlength="2000"
                                            placeholder="نبذة عن صاحب الاقتباس"
                                            class="w-full rounded-lg border border-[#D6B66F]/30 bg-[#14251F] p-3 text-sm text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                                        >{{ $quote->speaker_bio }}</textarea>

                                        <select
                                            name="category"
                                            required
                                            class="w-full rounded-lg border border-[#D6B66F]/30 bg-[#14251F] p-3 text-sm text-[#F0E7D5] outline-none focus:border-[#D6B66F]"
                                        >
                                            @foreach (config('athar.categories', []) as $category)
                                                <option
                                                    value="{{ $category }}"
                                                    @selected($quote->category === $category)
                                                >
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <label class="flex items-center gap-3 text-sm text-[#E8DFC9]">
                                            <input
                                                type="checkbox"
                                                name="is_featured"
                                                value="1"
                                                @checked($quote->is_featured)
                                                class="h-4 w-4 accent-[#D6B66F]"
                                            >
                                            قطعة مميزة
                                        </label>

                                        <div class="flex gap-3">

                                            <button
                                                type="submit"
                                                class="flex-1 rounded-lg bg-[#B18A4D] px-4 py-3 text-sm font-semibold text-[#101810] transition hover:brightness-110"
                                            >
                                                حفظ التعديلات
                                            </button>

                                            <button
                                                type="button"
                                                onclick="document.getElementById('edit-legacy-{{ $quote->id }}').classList.add('hidden')"
                                                class="rounded-lg border border-[#D6B66F]/30 px-4 py-3 text-sm text-[#D6B66F]"
                                            >
                                                إلغاء
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            @endif
                        @endauth

                    </article>

                @endforeach

            </section>


            {{-- Pagination --}}
            <div class="mt-14">
                {{ $quotes->links() }}
            </div>

        @else

            <div class="mx-auto max-w-2xl rounded-2xl border border-[#D6B66F]/30 bg-[#101D18]/90 p-12 text-center backdrop-blur-md">

                <span class="text-4xl text-[#D6B66F]">❖</span>

                <h3 class="mt-6 text-xl text-[#E8C77F]">
                    القاعة تنتظر كلماتها الأولى
                </h3>

                <p class="mt-4 text-sm leading-loose text-[#B6A98D]">
                    لم تُضف أي اقتباسات إلى الأثر الخالد حتى الآن.
                    ستبدأ هذه القاعة رحلتها مع أول كلمة تستحق البقاء.
                </p>

            </div>

        @endif


        {{-- Footer Navigation --}}
        <footer class="mt-24 pb-10 text-center">

            <div class="mb-6 text-2xl text-[#D6B66F]">❖</div>

            <div class="flex flex-wrap justify-center gap-4">

                <a
                    href="{{ route('library') }}"
                    class="rounded-full border border-[#D6B66F]/50 bg-[#101D18]/80 px-7 py-3 text-sm text-[#E8C77F] transition hover:-translate-y-1 hover:bg-[#20382C]"
                >
                    العودة إلى المكتبة
                </a>

                <a
                    href="{{ route('museum') }}"
                    class="rounded-full border border-[#D6B66F]/30 bg-[#101D18]/60 px-7 py-3 text-sm text-[#B6A98D] transition hover:-translate-y-1 hover:border-[#D6B66F] hover:text-[#E8C77F]"
                >
                    متحف الاقتباسات
                </a>

                <a
                    href="{{ route('home') }}"
                    class="rounded-full border border-[#D6B66F]/30 bg-[#101D18]/60 px-7 py-3 text-sm text-[#B6A98D] transition hover:-translate-y-1 hover:border-[#D6B66F] hover:text-[#E8C77F]"
                >
                    الرئيسية
                </a>

            </div>

            <p class="mt-8 text-xs tracking-widest text-[#8F8A75]">
                ATHAR · كلمات تبقى.
            </p>

        </footer>

    </div>
</div>

@endsection
