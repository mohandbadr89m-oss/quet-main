
@props(['categories', 'selectedCategory' => null])

<section class="mb-8">

    <h2 class="mb-4 text-xl font-bold text-[#D6B66F]">
        التصنيفات
    </h2>

    <div class="flex flex-wrap gap-2">

        {{-- All categories --}}
        <a
            href="{{ route('home') }}"
            @class([
                'rounded-full border px-4 py-2 text-sm font-semibold transition',
                'border-[#C5A15B] bg-[#C5A15B] text-[#101B15]' => empty($selectedCategory),
                'border-[#80683D]/50 bg-[#1C2B21] text-[#E8DFC9] hover:border-[#C5A15B]' => !empty($selectedCategory),
            ])>

            الكل
        </a>

        {{-- Individual categories --}}
        @foreach ($categories as $category)

            <a
                href="{{ route('home', ['category' => $category]) }}"
                @class([
                    'rounded-full border px-4 py-2 text-sm font-semibold transition',
                    'border-[#C5A15B] bg-[#C5A15B] text-[#101B15]' => $selectedCategory === $category,
                    'border-[#80683D]/50 bg-[#1C2B21] text-[#E8DFC9] hover:border-[#C5A15B]' => $selectedCategory !== $category,
                ])>

                {{ $category }}

            </a>

        @endforeach

    </div>

</section>
