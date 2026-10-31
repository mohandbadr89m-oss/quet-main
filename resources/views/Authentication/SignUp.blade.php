
@extends('Layout.app')

@section('title', 'Sign Up')

@section('content')
<div class="flex items-center justify-center p-8">
    <form action="{{ url('/signup') }}" method="POST"
          class="mx-auto mt-5 w-full max-w-xl rounded-lg p-9">
        @csrf

        <h2 class="mb-4 text-center text-2xl font-bold text-white">
            Sign Up
        </h2>

        <div class="mb-4">
            <label for="name" class="label">Name</label>
            <input id="name" name="name" type="text"
                   class="input" required minlength="2" maxlength="50"
                   pattern="[A-Za-z\u0600-\u06FF ]+">
        </div>

        <div class="mb-4">
            <label for="email" class="label">Email</label>
            <input id="email" name="email" type="email"
                   class="input" required>
        </div>

        <div class="mb-4">
            <label for="password" class="label">Password</label>
            <input id="password" name="password" type="password"
                   class="input" required minlength="8">
        </div>

        <p class="mb-4 text-sm text-white">
            You already have an account?
            <a href="/login" class="text-blue-500 hover:underline">Log In</a>
        </p>

        <button type="submit" class="btn-primary w-full">
            Sign Up
        </button>
    </form>
</div>
@endsection
