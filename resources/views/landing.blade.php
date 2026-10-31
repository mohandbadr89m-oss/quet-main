
@extends('Layout.app')

@section('title', 'ATHAR — من ذاكرة الحضارة')

@section('content')

{{-- =========================================
     ATHAR INTRO
========================================= --}}

<div
    id="athar-intro"
    class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden bg-[#080F0B]"
    aria-label="مقدمة ATHAR"
>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(197,161,91,0.12),transparent_55%)]"></div>

    <div class="relative z-10 flex flex-col items-center px-6 text-center">

        {{-- ATHAR geometric logo --}}
        <div id="intro-symbol" class="mb-5 opacity-0">

            <svg
                viewBox="0 0 100 100"
                class="h-24 w-24 md:h-32 md:w-32"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M50 5 L95 50 L50 95 L5 50 Z"
                    stroke="#C5A15B"
                    stroke-width="2"
                />

                <path
                    d="M50 20 L80 50 L50 80 L20 50 Z"
                    stroke="#A47752"
                    stroke-width="2"
                />

                <path
                    d="M50 36 L64 50 L50 64 L36 50 Z"
                    fill="#C5A15B"
                />

                <circle cx="50" cy="50" r="4" fill="#E8DFC9"/>
            </svg>

        </div>

        <h1
            id="intro-title"
            class="text-4xl font-bold tracking-[0.35em] text-[#D6B66F] opacity-0 md:text-6xl"
        >
            ATHAR
        </h1>

        <div
            id="intro-line"
            class="my-6 h-px w-0 bg-gradient-to-r from-transparent via-[#C5A15B] to-transparent"
        ></div>

        <p
            id="intro-tagline"
            class="font-amiri text-xl text-[#E8DFC9] opacity-0 md:text-3xl"
        >
            من ذاكرة الحضارة، إلى خلود الكلمات.
        </p>

        <button
            id="skip-intro"
            type="button"
            class="absolute top-[calc(100%+100px)] whitespace-nowrap rounded-full border border-[#C5A15B]/40 px-5 py-2 text-sm text-[#B6A98D] opacity-0 transition hover:border-[#D6B66F] hover:text-[#D6B66F]"
        >
            تخطي المقدمة
        </button>

    </div>

    <div class="absolute bottom-10 text-xs tracking-[0.3em] text-[#8F8060] opacity-60">
        WORDS THAT LEAVE A TRACE
    </div>
</div>


{{-- =========================================
     LANDING PAGE
========================================= --}}

<div
    id="landing-content"
    class="mx-auto max-w-7xl px-5 pb-20 opacity-0 transition-opacity duration-[1500ms] md:px-8"
>

    {{-- Hero --}}
    <section class="relative flex min-h-[75vh] flex-col items-center justify-center py-24 text-center">

        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(197,161,91,0.09),transparent_65%)]"></div>

        <span class="mb-6 text-xs tracking-[0.45em] text-[#C5A15B]">
            A WORLD OF WORDS
        </span>

        <h2 class="athar-heading max-w-4xl text-4xl leading-relaxed md:text-6xl">
            ليست كل الكلمات تُقال...
            <span class="mt-2 block text-[#D6B66F]">
                بعضها يترك أثرًا.
            </span>
        </h2>

        <p class="mt-8 max-w-2xl text-base leading-loose text-[#B6A98D] md:text-lg">
            في ATHAR، نؤمن أن للكلمات حياة تتجاوز لحظة قولها.
            هنا تجد مساحة تجمع الاقتباسات، وتحفظ المعاني،
            وتمنح الكلمات التي تستحق فرصةً لتبقى.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">

            <a
                href="{{ route('library') }}"
                class="rounded-lg border border-[#D6B66F] bg-[#C5A15B] px-8 py-3 font-semibold text-[#14251F] shadow-[0_0_25px_rgba(197,161,91,0.12)] transition duration-300 hover:-translate-y-1 hover:bg-[#D8B875]"
            >
                اكتشف المكتبة
            </a>

            <a
                href="{{ route('museum') }}"
                class="rounded-lg border border-[#C5A15B]/50 bg-[#14251F]/70 px-8 py-3 font-semibold text-[#E8DFC9] transition duration-300 hover:-translate-y-1 hover:border-[#D6B66F] hover:text-[#D6B66F]"
            >
                ادخل المتحف
            </a>

        </div>

        <div class="absolute bottom-5 flex flex-col items-center gap-2 text-[#8F8060]">
            <span class="text-xs tracking-widest">اكتشف ATHAR</span>
            <span class="animate-bounce text-xl">⌄</span>
        </div>

    </section>


    {{-- Introduction --}}
    <section class="mx-auto mb-24 max-w-4xl text-center">

        <span class="text-xs tracking-[0.35em] text-[#C5A15B]">
            OUR PHILOSOPHY
        </span>

        <h2 class="athar-heading mt-4 text-3xl md:text-4xl">
            لكل كلمة حكاية
        </h2>

        <p class="mt-6 text-base leading-loose text-[#B6A98D] md:text-lg">
            قد تمر الكلمات على مسامعنا، وقد تستقر في ذاكرتنا،
            وقد تغيّر شيئًا في داخلنا.
            أنشأنا ATHAR لتكون مساحةً للكلمات التي لا نريد نسيانها.
        </p>

        <div class="mx-auto mt-8 h-px w-24 bg-gradient-to-r from-transparent via-[#C5A15B] to-transparent"></div>

    </section>


    {{-- Explore ATHAR --}}
    <section class="mb-24">

        <div class="mb-12 text-center">

            <span class="text-xs tracking-[0.35em] text-[#C5A15B]">
                EXPLORE ATHAR
            </span>

            <h2 class="athar-heading mt-4 text-3xl md:text-4xl">
                اكتشف عوالم الأثر
            </h2>

            <p class="mt-4 text-sm text-[#B6A98D]">
                ثلاث مساحات، يجمعها شغف الكلمات.
            </p>

        </div>


        <div class="grid gap-6 md:grid-cols-3">

            {{-- Library --}}
            <a
                href="{{ route('library') }}"
                class="group rounded-2xl border border-[#C5A15B]/20 bg-[#14251F]/80 p-8 text-center backdrop-blur-sm transition duration-500 hover:-translate-y-2 hover:border-[#C5A15B]/70 hover:bg-[#20382C]"
            >

                <div class="mb-6 text-4xl text-[#D6B66F] transition duration-500 group-hover:scale-110">
                    ❖
                </div>

                <h3 class="athar-heading text-2xl">
                    مكتبة الاقتباسات
                </h3>

                <p class="mt-4 text-sm leading-8 text-[#B6A98D]">
                    اكتشف كلمات الآخرين، وشارك كلماتك،
                    واحفظ ما يلامس روحك.
                </p>

                <span class="mt-7 inline-block text-sm text-[#D6B66F]">
                    استكشف المكتبة ←
                </span>

            </a>


            {{-- Museum --}}
            <a
                href="{{ route('museum') }}"
                class="group rounded-2xl border border-[#C5A15B]/20 bg-[#14251F]/80 p-8 text-center backdrop-blur-sm transition duration-500 hover:-translate-y-2 hover:border-[#C5A15B]/70 hover:bg-[#20382C]"
            >

                <div class="mb-6 text-4xl text-[#D6B66F] transition duration-500 group-hover:scale-110">
                    🏛
                </div>

                <h3 class="athar-heading text-2xl">
                    متحف الاقتباسات
                </h3>

                <p class="mt-4 text-sm leading-8 text-[#B6A98D]">
                    قاعة تحتفي بالاقتباسات التي تركت أثرًا
                    وحصلت على تقدير المجتمع.
                </p>

                <span class="mt-7 inline-block text-sm text-[#D6B66F]">
                    ادخل المتحف ←
                </span>

            </a>


            {{-- Eternal Legacy --}}
            <a
                href="{{ route('legacy') }}"
                class="group relative block overflow-hidden rounded-2xl border border-[#C5A15B]/30 bg-[#14251F]/80 p-8 text-center backdrop-blur-sm transition duration-500 hover:-translate-y-2 hover:border-[#D6B66F]/80 hover:bg-[#20382C] hover:shadow-[0_0_35px_rgba(197,161,91,0.15)]"
            >

                <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-[#C5A15B]/10 blur-2xl transition duration-500 group-hover:bg-[#C5A15B]/20"></div>

                <div class="relative mb-6 text-4xl text-[#D6B66F] transition duration-500 group-hover:scale-110">
                    ✧
                </div>

                <h3 class="athar-heading relative text-2xl">
                    قاعة الأثر الخالدة
                </h3>

                <p class="relative mt-4 text-sm leading-8 text-[#B6A98D]">
                    كلمات اختيرت لتتجاوز حدود الزمن،
                    وتبقى جزءًا من ذاكرة ATHAR.
                </p>

                <span class="relative mt-7 inline-block text-sm text-[#D6B66F] transition group-hover:text-[#F0D28A]">
                    اكتشف الأثر الخالد ←
                </span>

            </a>

        </div>

    </section>


    {{-- Closing section --}}
    <section class="relative overflow-hidden rounded-3xl border border-[#C5A15B]/25 bg-gradient-to-br from-[#20382C] to-[#101B15] px-6 py-16 text-center md:px-12">

        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(197,161,91,0.10),transparent_65%)]"></div>

        <div class="relative">

            <span class="text-3xl text-[#D6B66F]">❖</span>

            <h2 class="athar-heading mt-5 text-3xl md:text-4xl">
                اترك أثرًا بكلماتك
            </h2>

            <p class="mx-auto mt-5 max-w-xl leading-8 text-[#B6A98D]">
                ربما تكون كلماتك هي الأثر الذي يبحث عنه شخص آخر.
                شارك ما تؤمن به، ودع كلماتك تجد طريقها.
            </p>

            <a
                href="{{ route('signup') }}"
                class="mt-8 inline-block rounded-lg bg-[#C5A15B] px-8 py-3 font-semibold text-[#14251F] transition duration-300 hover:-translate-y-1 hover:bg-[#D8B875]"
            >
                ابدأ رحلتك مع ATHAR
            </a>

        </div>

    </section>

</div>


{{-- =========================================
     INTRO ANIMATION
========================================= --}}

<style>
    #intro-symbol {
        animation: introSymbol 1.3s ease forwards;
        animation-delay: 0.35s;
    }

    #intro-title {
        animation: introTitle 1.1s ease forwards;
        animation-delay: 1.05s;
    }

    #intro-line {
        animation: introLine 1s ease forwards;
        animation-delay: 1.75s;
    }

    #intro-tagline {
        animation: introTagline 1.2s ease forwards;
        animation-delay: 2.1s;
    }

    #skip-intro {
        animation: skipAppear 0.8s ease forwards;
        animation-delay: 2.8s;
    }

    @keyframes introSymbol {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.75) rotate(-20deg);
            filter: blur(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1) rotate(0);
            filter: blur(0);
        }
    }

    @keyframes introTitle {
        from {
            opacity: 0;
            transform: translateY(15px);
            letter-spacing: 0.7em;
        }

        to {
            opacity: 1;
            transform: translateY(0);
            letter-spacing: 0.35em;
        }
    }

    @keyframes introLine {
        from {
            width: 0;
        }

        to {
            width: 180px;
        }
    }

    @keyframes introTagline {
        from {
            opacity: 0;
            transform: translateY(15px);
            filter: blur(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
    }

    @keyframes skipAppear {
        to {
            opacity: 1;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #intro-symbol,
        #intro-title,
        #intro-line,
        #intro-tagline,
        #skip-intro {
            animation-duration: 0.01ms !important;
            animation-delay: 0ms !important;
        }
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const intro = document.getElementById('athar-intro');
    const landing = document.getElementById('landing-content');
    const skipButton = document.getElementById('skip-intro');

    if (!intro || !landing) return;

    let introFinished = false;

    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    function finishIntro() {

        if (introFinished) return;

        introFinished = true;

        // Hide the intro first.
        intro.style.transition = 'opacity 900ms ease';
        intro.style.opacity = '0';
        intro.style.pointerEvents = 'none';

        // Reveal the landing page after the intro disappears.
        window.setTimeout(function () {

            intro.remove();

            landing.classList.remove('opacity-0');
            landing.classList.add('opacity-100');

        }, 950);
    }

    if (skipButton) {
        skipButton.addEventListener('click', finishIntro);
    }

    if (reducedMotion) {
        finishIntro();
    } else {
        window.setTimeout(finishIntro, 4800);
    }

});
</script>

@endsection
