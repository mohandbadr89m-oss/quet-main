
@extends('Layout.app')

@section('title', 'لوحة الإدارة — ATHAR')

@section('content')
<div class="mx-auto max-w-7xl space-y-8 p-6 md:p-10">

    <header class="border-b border-[#C5A15B]/30 pb-6">
        <span class="text-xs tracking-[0.3em] text-[#C5A15B]">
            ATHAR CONTROL CENTER
        </span>

        <h1 class="athar-heading mt-3 text-3xl md:text-4xl">
            لوحة الإدارة
        </h1>

        <p class="mt-2 text-[#B6A98D]">
            إدارة المستخدمين والصلاحيات في منصة أثر.
        </p>
    </header>

    @if (session('success'))
        <div class="rounded-xl border border-green-500/30 bg-green-950/30 p-4 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-500/30 bg-red-950/30 p-4 text-red-200">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Statistics --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-[#C5A15B]/30 bg-[#1C2B21] p-6">
            <p class="text-sm text-[#B6A98D]">المستخدمون</p>
            <p class="mt-3 text-3xl font-bold text-[#E8DFC9]">
                {{ $totalUsers }}
            </p>
        </div>

        <div class="rounded-2xl border border-[#C5A15B]/30 bg-[#1C2B21] p-6">
            <p class="text-sm text-[#B6A98D]">المدراء</p>
            <p class="mt-3 text-3xl font-bold text-[#D6B66F]">
                {{ $totalAdmins }}
            </p>
        </div>

        <div class="rounded-2xl border border-[#C5A15B]/30 bg-[#1C2B21] p-6">
            <p class="text-sm text-[#B6A98D]">الملاك</p>
            <p class="mt-3 text-3xl font-bold text-[#D6B66F]">
                {{ $totalOwners }}
            </p>
        </div>

    </section>

    {{-- Create Admin: Owner only --}}
    @if (auth()->user()->isOwner())

        <section class="rounded-2xl border border-[#C5A15B]/30 bg-[#1C2B21] p-6">

            <h2 class="text-xl font-bold text-[#D6B66F]">
                إنشاء حساب مدير جديد
            </h2>

            <p class="mt-2 text-sm text-[#B6A98D]">
                هذه الصلاحية متاحة لمالك المنصة فقط.
            </p>

            <form action="{{ route('admin.admins.store') }}"
                  method="POST"
                  class="mt-6 space-y-4">

                @csrf

                <div>
                    <label class="mb-2 block text-sm text-[#E8DFC9]">
                        الاسم
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           class="w-full rounded-lg border border-[#C5A15B]/30 bg-[#101B15] p-3 text-[#E8DFC9]">
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#E8DFC9]">
                        البريد الإلكتروني
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           class="w-full rounded-lg border border-[#C5A15B]/30 bg-[#101B15] p-3 text-[#E8DFC9]">
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#E8DFC9]">
                        كلمة المرور
                    </label>

                    <input type="password"
                           name="password"
                           required
                           minlength="8"
                           class="w-full rounded-lg border border-[#C5A15B]/30 bg-[#101B15] p-3 text-[#E8DFC9]">
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#E8DFC9]">
                        تأكيد كلمة المرور
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           required
                           minlength="8"
                           class="w-full rounded-lg border border-[#C5A15B]/30 bg-[#101B15] p-3 text-[#E8DFC9]">
                </div>

                <button type="submit"
                        class="rounded-lg bg-[#C5A15B] px-6 py-3 font-bold text-[#172017] transition hover:bg-[#D8B875]">
                    إنشاء حساب المدير
                </button>

            </form>
        </section>

    @endif

    {{-- Users Table --}}
    <section class="overflow-hidden rounded-2xl border border-[#C5A15B]/30 bg-[#1C2B21]">

        <div class="border-b border-[#C5A15B]/20 p-6">
            <h2 class="text-xl font-bold text-[#D6B66F]">
                حسابات المنصة
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-right text-sm">

                <thead class="bg-[#101B15] text-[#D6B66F]">
                    <tr>
                        <th class="p-4">المستخدم</th>
                        <th class="p-4">البريد الإلكتروني</th>
                        <th class="p-4">الصلاحية</th>

                        @if (auth()->user()->isOwner())
                            <th class="p-4">الإجراءات</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#C5A15B]/10">

                    @foreach ($users as $user)

                        <tr>
                            <td class="p-4 text-[#E8DFC9]">
                                {{ $user->name }}
                            </td>

                            <td class="p-4 text-[#B6A98D]" dir="ltr">
                                {{ $user->email }}
                            </td>

                            <td class="p-4">
                                @if ($user->isOwner())
                                    <span class="text-[#D6B66F]">Owner</span>
                                @elseif ($user->isAdmin())
                                    <span class="text-blue-300">Admin</span>
                                @else
                                    <span class="text-[#B6A98D]">User</span>
                                @endif
                            </td>

                            @if (auth()->user()->isOwner())
                                <td class="p-4">

                                    @if ($user->isAdmin())

                                        <form action="{{ route('admin.admins.revoke', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('هل أنت متأكد من سحب صلاحيات هذا المدير؟')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="rounded-lg border border-red-400/40 px-3 py-2 text-red-300 transition hover:bg-red-950/40">
                                                سحب الصلاحية
                                            </button>

                                        </form>

                                    @elseif ($user->isOwner())

                                        <span class="text-xs text-[#D6B66F]">
                                            مالك المنصة
                                        </span>

                                    @else

                                        <span class="text-xs text-[#8D897B]">
                                            —
                                        </span>

                                    @endif

                                </td>
                            @endif

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </section>

    <div class="text-center">
        <a href="{{ route('home') }}"
           class="text-sm text-[#D6B66F] transition hover:text-[#E8DFC9]">
            العودة إلى الصفحة الرئيسية
        </a>
    </div>

</div>
@endsection
