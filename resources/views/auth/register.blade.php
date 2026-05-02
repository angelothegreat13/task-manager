@extends('layouts.master')

@section('content')
<div class="flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-md">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">Create an account</h1>
            <p class="mt-2 text-sm text-gray-500">Sign up to get started</p>
        </div>

        <form action="{{ route('register.store') }}" method="POST" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700" for="name">Full Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    placeholder="John Doe"
                    autocomplete="name"
                    class="mt-1 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-teal-500 focus:ring-teal-500' }}"
                >
                @if($errors->has('name'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    autocomplete="email"
                    class="mt-1 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-teal-500 focus:ring-teal-500' }}"
                >
                @if($errors->has('email'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    class="mt-1 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-teal-500 focus:ring-teal-500' }}"
                >
                @if($errors->has('password'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
            >
                Create account
            </button>

            <p class="text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:underline">Sign in</a>
            </p>
        </form>

    </div>
</div>
@endsection
