
@extends('Layout.app')

@section('title', 'متحف الاقتباسات — ATHAR')

@section('content')

<div
    id="museum-page"
    class="relative min-h-screen overflow-hidden bg-[#080E0B] text-[#E8DFC9]"
>

    {{-- Cinematic intro --}}
    <div
        id="museum-intro"
        class="fixed inset-0 z-[200] flex flex-col items-center justify-center bg-[#08130F] transition-opacity duration-1000"
    >
        <div id="museum-intro-content" class="text-center">

            <div class="museum-logo mb-6 text-4xl text-[#D6B66F]">
                ❖
            </div>

            <h1 class="athar-heading text-5xl tracking-widest">
                ATHAR
            </h1>

            <p class="mt-3 text-lg text-[#D6B66F]">
                متحف الاقتباسات
            </p>

            <p class="mt-8 text-xs tracking-[0.3em] text-[#8F8A75]">
                كلمات تبقى...
            </p>

        </div>

        <button
            id="skip-museum-intro"
            type="button"
            class="absolute bottom-10 rounded-full border border-[#C5A15B]/40 px-5 py-2 text-sm text-[#C5A15B] transition hover:bg-[#C5A15B]/10"
        >
            تخطي المقدمة
        </button>
    </div>


    {{-- Museum Background --}}
    <div class="pointer-events-none absolute inset-0">

        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('/images/museum-hall.png');"
        ></div>

        <div class="absolute inset-0 bg-[#08130F]/35"></div>

        <div class="absolute inset-0 bg-gradient-to-b from-[#08130F]/65 via-transparent to-[#08130F]/85"></div>

        <div class="absolute inset-0 bg-gradient-to-r from-[#08130F]/40 via-transparent to-[#08130F]/40"></div>

    </div>


    {{-- Museum Content --}}
    <div
        id="museum-content"
        class="relative z-10 mx-auto max-w-[1500px] px-5 py-16 opacity-0 transition-opacity duration-1000"
    >

        {{-- Header --}}
        <header class="mb-16 text-center">

            <span class="text-xs tracking-[0.4em] text-[#D6B66F]">
                ATHAR · THE MUSEUM
            </span>

            <h1 class="athar-heading mt-5 text-4xl text-[#E8C77F] drop-shadow-[0_0_20px_rgba(214,182,111,0.35)] md:text-6xl">
                متحف الاقتباسات
            </h1>

            <p class="mt-5 text-sm text-[#E8DFC9] drop-shadow-lg">
                هنا تعيش الكلمات التي تركت أثرًا.
            </p>

            <div class="mx-auto mt-8 h-px w-32 bg-gradient-to-r from-transparent via-[#D6B66F] to-transparent"></div>

            <div class="mt-4 text-xl text-[#D6B66F]">
                ❖
            </div>

        </header>


        {{-- Museum Gallery --}}
        <section class="relative">

            @if ($museumQuotes->isNotEmpty())

                <div class="museum-gallery flex items-end gap-8 overflow-x-auto px-6 pb-14 pt-14 snap-x snap-mandatory">

                    @foreach ($museumQuotes as $index => $quote)

                        @php
                            $rank = $index + 1;

                            $rankStyle = match ($rank) {
                                1 => 'border-[#D6B66F] shadow-[0_0_40px_rgba(214,182,111,0.35)]',
                                2 => 'border-[#C8C8C8] shadow-[0_0_30px_rgba(183,183,183,0.25)]',
                                3 => 'border-[#B98250] shadow-[0_0_30px_rgba(185,130,80,0.25)]',
                                default => 'border-[#80683D]/60',
                            };

                            $rankColor = match ($rank) {
                                1 => 'text-[#F0D28A]',
                                2 => 'text-[#D5D5D5]',
                                3 => 'text-[#D49A65]',
                                default => 'text-[#D6B66F]',
                            };
                        @endphp


                        {{-- Museum Exhibit --}}
                        <button
                            type="button"
                            class="museum-piece group relative flex w-[260px] min-w-[260px] snap-center flex-col items-center text-center transition-all duration-700 hover:-translate-y-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#D6B66F]"
                            data-museum-quote
                            data-quote="{{ $quote->content }}"
                            data-author="{{ $quote->user->name ?? 'كاتب مجهول' }}"
                            data-likes="{{ $quote->likes_count }}"
                            data-rank="{{ $rank }}"
                        >

                            {{-- Golden Spotlight --}}
                            <div class="pointer-events-none absolute -inset-8 -top-12 rounded-full bg-[#D6B66F]/10 opacity-0 blur-3xl transition duration-700 group-hover:opacity-100"></div>


                            {{-- Rank Badge --}}
                            <span class="relative z-20 mb-[-22px] flex h-11 w-11 items-center justify-center rounded-full border border-[#D6B66F]/70 bg-[#101D18] text-base font-semibold {{ $rankColor }} shadow-[0_0_20px_rgba(197,161,91,0.25)]">
                                {{ $rank }}
                            </span>


                            {{-- Display Arch --}}
                            <div class="relative w-full overflow-hidden rounded-t-[130px] border {{ $rankStyle }} bg-gradient-to-b from-[#294333]/95 via-[#14251F]/95 to-[#09130F]/95 px-5 pb-7 pt-14 shadow-2xl backdrop-blur-sm transition-all duration-700 group-hover:border-[#F0D28A] group-hover:shadow-[0_0_45px_rgba(214,182,111,0.35)]">

                                {{-- Inner Frame --}}
                                <div class="flex min-h-[285px] flex-col items-center justify-center rounded-t-[105px] border border-[#D6B66F]/25 bg-[#08130F]/85 px-5 py-8 transition-all duration-700 group-hover:border-[#D6B66F]/70 group-hover:bg-[#10231A]/95">

                                    <span class="mb-7 text-3xl {{ $rankColor }} transition-transform duration-700 group-hover:scale-125">
                                        ❖
                                    </span>

                                    <p class="athar-quote text-lg leading-loose text-[#F0E7D5]">
                                        {{ $quote->content }}
                                    </p>

                                    <div class="my-6 h-px w-12 bg-[#D6B66F]/60"></div>

                                    <p class="text-sm text-[#E3BD70]">
                                        {{ $quote->user->name ?? 'كاتب مجهول' }}
                                    </p>

                                </div>

                                {{-- Golden Light --}}
                                <div class="pointer-events-none absolute bottom-0 left-1/2 h-1 w-2/3 -translate-x-1/2 bg-[#D6B66F]/50 opacity-40 blur-md transition duration-700 group-hover:opacity-100"></div>

                            </div>


                            {{-- Marble Pedestal Top --}}
                            <div class="relative z-10 h-4 w-[108%] border border-[#D6B66F]/50 bg-gradient-to-b from-[#B18A4D] via-[#443521] to-[#15150F] shadow-[0_8px_18px_rgba(0,0,0,0.6)]"></div>


                            {{-- Stone Pedestal --}}
                            <div class="relative -mt-px w-[96%] border-x border-b border-[#A88A56]/60 bg-gradient-to-r from-[#101510] via-[#293027] to-[#101510] px-4 py-5 shadow-[0_15px_25px_rgba(0,0,0,0.65)]">

                                <p class="text-xs {{ $rankColor }}">
                                    @switch($rank)
                                        @case(1)
                                            الأثر الأول
                                            @break

                                        @case(2)
                                            الأثر الثاني
                                            @break

                                        @case(3)
                                            الأثر الثالث
                                            @break

                                        @default
                                            المركز {{ $rank }}
                                    @endswitch
                                </p>

                                <p class="mt-2 text-sm text-[#E3BD70]">
                                    ♥ {{ $quote->likes_count }} إعجاب
                                </p>

                            </div>


                            {{-- Pedestal Base --}}
                            <div class="h-3 w-[108%] rounded-b-sm border border-[#80683D]/70 bg-gradient-to-b from-[#51432D] to-[#171A15] shadow-[0_12px_20px_rgba(0,0,0,0.65)]"></div>


                            {{-- Floor Shadow --}}
                            <div class="mt-2 h-5 w-[85%] rounded-full bg-black/60 blur-xl transition-all duration-700 group-hover:w-full group-hover:bg-[#D6B66F]/20"></div>

                        </button>

                    @endforeach

                </div>


                <p class="mt-3 text-center text-xs tracking-wider text-[#E8DFC9]/80 drop-shadow-lg">
                    اختر إحدى القطع لاكتشاف تفاصيلها
                </p>

                <div class="mt-5 text-center text-xl text-[#D6B66F]">
                    ❖
                </div>


            @else

                <div class="rounded-xl border border-[#D6B66F]/40 bg-[#101D18]/90 p-10 text-center backdrop-blur-md">

                    <span class="text-3xl text-[#D6B66F]">❖</span>

                    <p class="mt-5 text-[#E8DFC9]">
                        لم تُعرض أي اقتباسات في المتحف حتى الآن.
                    </p>

                </div>

            @endif

        </section>


        {{-- Quote Details Modal --}}
        <div
            id="museum-details"
            class="fixed inset-0 z-[150] hidden items-center justify-center bg-[#030805]/90 p-5 backdrop-blur-lg"
        >

            <div class="relative w-full max-w-xl rounded-2xl border border-[#D6B66F]/60 bg-gradient-to-b from-[#20382C] to-[#09140F] p-8 text-center shadow-[0_0_60px_rgba(214,182,111,0.15)]">

                <button
                    id="close-museum-details"
                    type="button"
                    aria-label="إغلاق"
                    class="absolute left-5 top-4 text-3xl text-[#B6A98D] transition hover:rotate-90 hover:text-[#D6B66F]"
                >
                    ×
                </button>

                <span class="text-3xl text-[#D6B66F]">
                    ❖
                </span>

                <p
                    id="museum-detail-rank"
                    class="mt-5 text-sm text-[#D6B66F]"
                ></p>

                <blockquote
                    id="museum-detail-quote"
                    class="athar-quote my-8 text-2xl leading-loose text-[#F0E7D5]"
                ></blockquote>

                <div class="mx-auto mb-6 h-px w-16 bg-[#D6B66F]/60"></div>

                <p
                    id="museum-detail-author"
                    class="text-[#E3BD70]"
                ></p>

                <p
                    id="museum-detail-likes"
                    class="mt-4 text-sm text-[#B6A98D]"
                ></p>

            </div>

        </div>


        {{-- Navigation Back Links --}}
        <div class="mt-20 pb-10 text-center">

            <div class="mb-6 text-xl text-[#D6B66F]">
                ❖
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4">

                <a
                    href="{{ route('library') }}"
                    class="inline-flex items-center gap-3 rounded-full border border-[#D6B66F]/60 bg-[#101D18]/80 px-8 py-3 text-sm text-[#E3BD70] shadow-lg backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:border-[#F0D28A] hover:bg-[#20382C]"
                >
                    <span>←</span>
                    العودة إلى المكتبة
                </a>

                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-3 rounded-full border border-[#C5A15B]/30 bg-[#101D18]/60 px-8 py-3 text-sm text-[#B6A98D] shadow-lg backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:border-[#D6B66F] hover:text-[#D6B66F]"
                >
                    الصفحة الرئيسية
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
