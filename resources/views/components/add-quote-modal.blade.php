
@props(['categories'])

{{-- Floating Add Button --}}
<button
    type="button"
    popovertarget="quote-popup"
    aria-label="إضافة عبارة"
    class="fixed bottom-8 right-8 z-40 flex h-16 w-16 items-center justify-center rounded-full border border-[#D6B66F] bg-[#C5A15B] text-[#101B15] shadow-[0_8px_30px_rgba(0,0,0,0.4)] transition duration-300 hover:scale-110 hover:bg-[#D8B875] hover:shadow-[0_0_25px_rgba(197,161,91,0.35)] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#C5A15B]/30">

    <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="2.5"
        stroke="currentColor"
        class="h-8 w-8"
        aria-hidden="true">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4.5v15m7.5-7.5h-15" />

    </svg>

</button>


{{-- Add Quote Popup --}}
<div
    id="quote-popup"
    popover
    class="m-auto w-[90%] max-w-lg rounded-3xl border border-[#80683D] bg-[#17251D] p-0 text-[#E8DFC9] shadow-2xl backdrop:bg-black/70 backdrop:backdrop-blur-sm">

    <form
        action="{{ route('quotes.store') }}"
        method="POST"
        class="space-y-4 p-6">

        @csrf

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <h2 class="athar-heading text-2xl">
                أضف أثرًا جديدًا
            </h2>

            <button
                type="button"
                popovertarget="quote-popup"
                popovertargetaction="hide"
                aria-label="إغلاق"
                class="rounded-full p-2 text-[#B6A98D] transition hover:bg-[#C5A15B]/10 hover:text-[#D6B66F]">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-6 w-6"
                    aria-hidden="true">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12" />

                </svg>

            </button>

        </div>


        {{-- Quote Content --}}
        <div>

            <label for="quote-body" class="label">
                العبارة
            </label>

            <textarea
                id="quote-body"
                name="content"
                rows="5"
                required
                minlength="3"
                maxlength="155"
                placeholder="اكتب عبارتك هنا..."
                class="input w-full resize-none">{{ old('content') }}</textarea>

            <p class="mt-1 text-xs text-[#A99B7D]">
                من 3 إلى 155 حرفًا.
            </p>

            @error('content')
                <p class="mt-1 text-sm text-red-300">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Category --}}
        <div>

            <label for="quote-category" class="label">
                التصنيف
            </label>

            <select
                id="quote-category"
                name="category"
                required
                class="input w-full">

                @foreach ($categories as $category)

                    <option
                        value="{{ $category }}"
                        @selected(old('category', 'عام') === $category)>

                        {{ $category }}

                    </option>

                @endforeach

            </select>

            @error('category')
                <p class="mt-1 text-sm text-red-300">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Submit --}}
        <button
            type="submit"
            class="btn-primary w-full">

            نشر العبارة

        </button>

    </form>

</div>
