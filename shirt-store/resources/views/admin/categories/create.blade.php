@extends('layouts.admin')
@section('page_title', 'Add Category')
@section('title', 'Add Category — Admin')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm text-[var(--color-muted)] hover:text-[var(--color-dark)] mb-6">← Back</a>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-xl border border-[var(--color-border)] p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium mb-1">Name *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]">{{ old('description') }}</textarea></div>
        <div><label class="block text-sm font-medium mb-1">Image URL</label><input type="text" name="image" value="{{ old('image') }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm focus:outline-none focus:border-[var(--color-brand-400)]"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2.5 border border-[var(--color-border)] rounded-lg text-sm"></div>
            <div class="flex items-end pb-1"><label class="flex items-center gap-2 text-sm"><input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded"> Active</label></div>
        </div>
        <button type="submit" class="px-8 py-3 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)]">Create Category</button>
    </form>
</div>
@endsection
