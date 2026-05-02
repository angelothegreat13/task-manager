@extends('layouts.master')

@section('content')
<div class="flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-md">

    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
        <p class="mt-2 text-sm text-gray-500">Sign in to your account</p>
    </div>

    <form action="{{ route('login.store') }}" method="POST" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
        @csrf

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
            <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
            </div>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="••••••••"
                autocomplete="current-password"
                class="mt-1 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-teal-500 focus:ring-teal-500' }}"
            >
            @if($errors->has('password'))
                <p class="mt-1 text-xs text-red-500">{{ $errors->first('password') }}</p>
            @endif
        </div>

        {{-- Remember me --}}
        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="w-full rounded-lg bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
        >
            Sign in
        </button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-teal-600 hover:underline">Register</a>
        </p>
    </form>

    </div>
</div>
@endsection
