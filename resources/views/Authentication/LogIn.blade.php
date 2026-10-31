
@extends('Layout.app')

@section('title', 'Log In')

@section('content')
    <div class="flex items-center justify-center p-8">
        <form action="{{ route('login.store') }}" method="POST"
              class="mx-auto mt-5 w-full max-w-xl rounded-lg p-9">
            @csrf

            <h2 class="mb-4 text-center text-2xl font-bold text-white">
                Log In
            </h2>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    class="input w-full"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="label">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="input w-full"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn btn-primary w-full">
                Log In
            </button>

            <p class="mt-4 text-center text-sm text-white">
                Don't have an account?
                <a href="{{ route('signup') }}" class="text-blue-400 hover:underline">
                    Sign Up
                </a>
            </p>
        </form>
    </div>
@endsection
