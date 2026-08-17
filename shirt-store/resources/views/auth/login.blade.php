@extends('layouts.app')
@section('title', 'Login — URBANCOFF')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('images/urbancoff-logo.png') }}" alt="URBANCOFF" class="h-10 w-10 object-contain rounded-lg">
                <span class="font-sans text-2xl font-extrabold tracking-tight text-[var(--color-dark)]">URBANCOFF</span>
            </a>
            <h1 class="font-serif text-2xl font-bold text-[var(--color-dark)] mt-6">Welcome Back</h1>
            <p class="text-sm text-[var(--color-muted)] mt-2">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="bg-white rounded-xl border border-[var(--color-border)] p-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-[var(--color-muted)]">
                    <input type="checkbox" name="remember" class="rounded border-[var(--color-border)] text-[var(--color-brand-500)] focus:ring-[var(--color-brand-400)]">
                    Remember me
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors">
                Sign In
            </button>
        </form>

        <p class="text-center text-sm text-[var(--color-muted)] mt-6">
            Don't have an account? <a href="{{ route('register') }}" class="text-[var(--color-brand-500)] font-medium hover:underline">Create one</a>
        </p>
    </div>
</div>
@endsection
