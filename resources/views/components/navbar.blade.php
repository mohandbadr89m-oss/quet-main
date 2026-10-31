
@props(['page' => ''])

<nav class="sticky top-0 z-50 border-b border-[#C5A15B]/25 bg-[#101B15]/95 shadow-[0_4px_25px_rgba(0,0,0,0.35)] backdrop-blur-xl">

    <div class="mx-auto flex min-h-20 max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-3">

        {{-- ATHAR Brand --}}
        <a href="{{ route('home') }}"
           class="order-1 flex shrink-0 items-center gap-3 no-underline"
           aria-label="ATHAR - الصفحة الرئيسية">

            <svg viewBox="0 0 64 64"
                 class="h-10 w-10"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg"
                 aria-hidden="true">

                <path d="M32 4 57 32 32 60 7 32Z"
                      stroke="#C5A15B"
                      stroke-width="2"/>

                <path d="M32 15 47 32 32 49 17 32Z"
                      stroke="#A47752"
                      stroke-width="1.8"/>

                <path d="M32 24 39 32 32 40 25 32Z"
                      fill="#C5A15B"/>

                <circle cx="32" cy="32" r="2.5" fill="#E8DFC9"/>

            </svg>

            <span class="flex flex-col">
                <span class="text-lg font-bold tracking-[0.2em] text-[#D6B66F]">
                    ATHAR
                </span>

                <span class="text-xs tracking-wide text-[#B6A98D]">
                    أثر · كلمات تبقى.
                </span>
            </span>

        </a>


        {{-- Main Navigation --}}
        <div class="order-3 flex w-full items-center justify-center gap-1 sm:order-2 sm:w-auto sm:gap-2">

            {{-- Library --}}
            <a
                href="{{ route('library') }}"
                @if (request()->routeIs('library')) aria-current="page" @endif
                class="rounded-full border px-3 py-2 text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                {{ request()->routeIs('library')
                    ? 'border-[#D6B66F]/70 bg-[#C5A15B]/15 text-[#F0D28A] shadow-[0_0_15px_rgba(197,161,91,0.12)]'
                    : 'border-transparent text-[#B6A98D] hover:border-[#C5A15B]/40 hover:bg-[#C5A15B]/10 hover:text-[#D6B66F]' }}"
            >
                المكتبة
            </a>


            {{-- Museum --}}
            <a
                href="{{ route('museum') }}"
                @if (request()->routeIs('museum')) aria-current="page" @endif
                class="rounded-full border px-3 py-2 text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                {{ request()->routeIs('museum')
                    ? 'border-[#D6B66F]/70 bg-[#C5A15B]/15 text-[#F0D28A] shadow-[0_0_15px_rgba(197,161,91,0.12)]'
                    : 'border-transparent text-[#B6A98D] hover:border-[#C5A15B]/40 hover:bg-[#C5A15B]/10 hover:text-[#D6B66F]' }}"
            >
                ❖ متحف الاقتباسات
            </a>


            {{-- Eternal Legacy --}}
            <a
                href="{{ route('legacy') }}"
                @if (request()->routeIs('legacy', 'legacy.*')) aria-current="page" @endif
                class="rounded-full border px-3 py-2 text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                {{ request()->routeIs('legacy', 'legacy.*')
                    ? 'border-[#D6B66F]/70 bg-[#C5A15B]/15 text-[#F0D28A] shadow-[0_0_18px_rgba(197,161,91,0.2)]'
                    : 'border-transparent text-[#B6A98D] hover:border-[#C5A15B]/40 hover:bg-[#C5A15B]/10 hover:text-[#D6B66F]' }}"
            >
                ✦ الأثر الخالد
            </a>

        </div>


        {{-- User Actions --}}
        <div class="order-2 flex shrink-0 items-center gap-2 sm:order-3 sm:gap-3">

            @auth

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="rounded-lg border border-[#C5A15B]/40 bg-[#C5A15B] px-3 py-2 text-xs font-semibold text-[#172017] transition duration-300 hover:bg-[#D8B875] sm:px-4 sm:text-sm">
                        تسجيل الخروج
                    </button>
                </form>

                <a href="{{ route('profile') }}"
                   class="flex items-center gap-2 rounded-full border border-transparent p-1 transition hover:border-[#C5A15B]/40"
                   aria-label="الملف الشخصي">

                    @if (auth()->user()->avatar_path)

                        <img
                            src="{{ asset('storage/' . auth()->user()->avatar_path) }}"
                            alt="الصورة الشخصية"
                            class="h-9 w-9 rounded-full border border-[#C5A15B] object-cover">

                    @else

                        <div class="flex h-9 w-9 items-center justify-center rounded-full border border-[#C5A15B]/70 bg-[#26382B] font-bold text-[#D6B66F]">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        </div>

                    @endif

                    <span class="hidden text-sm font-medium text-[#E8DFC9] lg:block">
                        {{ auth()->user()->username ? '@' . auth()->user()->username : auth()->user()->name }}
                    </span>

                </a>

            @else

                <a href="{{ route('login') }}"
                   class="rounded-lg border border-[#C5A15B]/60 px-3 py-2 text-xs font-semibold text-[#E8DFC9] transition hover:bg-[#C5A15B]/10 hover:text-[#D6B66F] sm:px-4 sm:text-sm">
                    تسجيل الدخول
                </a>

                <a href="{{ route('signup') }}"
                   class="rounded-lg bg-[#C5A15B] px-3 py-2 text-xs font-semibold text-[#172017] transition hover:bg-[#D8B875] sm:px-4 sm:text-sm">
                    إنشاء حساب
                </a>

            @endauth

        </div>

    </div>

</nav>
