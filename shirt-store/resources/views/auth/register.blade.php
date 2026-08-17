@extends('layouts.app')
@section('title', 'Register — URBANCOFF')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('images/urbancoff-logo.png') }}" alt="URBANCOFF" class="h-10 w-10 object-contain rounded-lg">
                <span class="font-sans text-2xl font-extrabold tracking-tight text-[var(--color-dark)]">URBANCOFF</span>
            </a>
            <h1 class="font-serif text-2xl font-bold text-[var(--color-dark)] mt-6">Create Account</h1>
            <p class="text-sm text-[var(--color-muted)] mt-2">Join us for the best shirt shopping experience</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="bg-white rounded-xl border border-[var(--color-border)] p-8 space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors @error('name') border-red-400 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Phone <span class="text-[var(--color-muted)] font-normal">(optional)</span></label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors @error('password') border-red-400 @enderror">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)] transition-colors">
            </div>

            <button type="submit" class="w-full py-3 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)] transition-colors">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm text-[var(--color-muted)] mt-6">
            Already have an account? <a href="{{ route('login') }}" class="text-[var(--color-brand-500)] font-medium hover:underline">Sign in</a>
        </p>
    </div>
</div>
@endsection
