
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'ATHAR — أثر')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="relative flex min-h-screen flex-col overflow-x-hidden text-[#E8DFC9]"
    style="
        background-color: #101B15;
        background-image:
            linear-gradient(
                180deg,
                rgba(8, 17, 12, 0.48) 0%,
                rgba(12, 25, 18, 0.68) 45%,
                rgba(8, 17, 12, 0.82) 100%
            ),
            url('/images/athar-museum.png');
        background-position: center top;
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    ">

    {{-- Navigation --}}
    <div class="relative z-50">
        <x-navbar :page="$page ?? ''" />
    </div>

    {{-- Main Content --}}
    <main class="relative z-10 flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="relative z-10 border-t border-[#C5A15B]/20 bg-[#0B130F]/90 px-4 py-8 text-center backdrop-blur-md">

        <p class="text-xl font-bold tracking-[0.25em] text-[#C5A15B]">
            ATHAR
        </p>

        <p class="mt-1 font-amiri text-xl text-[#E8DFC9]">
            أثر
        </p>

        <p class="mt-2 text-sm tracking-wide text-[#A99B7D]">
            كلمات تبقى.
        </p>

        <div class="mx-auto mt-5 h-px w-20 bg-gradient-to-r from-transparent via-[#C5A15B] to-transparent"></div>

        <p class="mt-4 text-xs text-[#8D897B]">
            © {{ date('Y') }} ATHAR — جميع الحقوق محفوظة
        </p>

    </footer>

</body>

</html>
