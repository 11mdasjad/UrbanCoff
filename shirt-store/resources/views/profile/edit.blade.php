@extends('layouts.app')
@section('title', 'My Profile — URBANCOFF')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-2xl lg:text-3xl font-serif font-bold text-[var(--color-dark)] mb-8">My Profile</h1>

    <div class="space-y-8">
        {{-- Profile Info --}}
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
            <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)] mb-4">Personal Information</h2>
            <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm bg-[var(--color-surface-alt)] text-[var(--color-muted)]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-[var(--color-dark)] mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="px-6 py-2.5 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)]">Update Profile</button>
                </div>
            </form>
        </div>

        {{-- Addresses --}}
        <div class="bg-white rounded-xl border border-[var(--color-border)] p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)]">Saved Addresses</h2>
            </div>

            @if($addresses->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                @foreach($addresses as $address)
                <div class="border border-[var(--color-border)] rounded-lg p-4 relative {{ $address->is_default ? 'border-[var(--color-brand-400)]' : '' }}">
                    @if($address->is_default)
                        <span class="absolute top-2 right-2 badge-primary text-[10px] font-bold px-2 py-0.5 rounded-full">Default</span>
                    @endif
                    <p class="text-sm font-medium text-[var(--color-dark)]">{{ $address->name }}</p>
                    <p class="text-xs text-[var(--color-muted)] mt-1">{{ $address->full_address }}</p>
                    <p class="text-xs text-[var(--color-muted)]">{{ $address->phone }}</p>
                    <form action="{{ route('profile.address.destroy', $address) }}" method="POST" class="mt-3">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:underline">Remove</button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Add Address Form --}}
            <details class="group">
                <summary class="text-sm font-medium text-[var(--color-brand-500)] cursor-pointer hover:underline">+ Add New Address</summary>
                <form method="POST" action="{{ route('profile.address.store') }}" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div><label class="block text-sm font-medium mb-1">Phone</label><input type="text" name="phone" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Address Line 1</label><input type="text" name="address_line_1" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div class="sm:col-span-2"><label class="block text-sm font-medium mb-1">Address Line 2</label><input type="text" name="address_line_2" class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div><label class="block text-sm font-medium mb-1">City</label><input type="text" name="city" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div><label class="block text-sm font-medium mb-1">State</label><input type="text" name="state" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div><label class="block text-sm font-medium mb-1">Postal Code</label><input type="text" name="postal_code" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div><label class="block text-sm font-medium mb-1">Country</label><input type="text" name="country" value="India" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
                    <div class="sm:col-span-2 flex items-center gap-4">
                        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_default" value="1"> Set as default</label>
                        <button type="submit" class="px-6 py-2 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)]">Save Address</button>
                    </div>
                </form>
            </details>
        </div>
    </div>
</div>
@endsection
