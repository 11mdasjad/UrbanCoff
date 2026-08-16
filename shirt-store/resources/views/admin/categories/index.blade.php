@extends('layouts.admin')
@section('page_title', 'Categories')
@section('title', 'Categories — Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="font-sans text-lg font-semibold text-[var(--color-dark)]">All Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-5 py-2.5 bg-[var(--color-dark)] text-white text-sm font-semibold rounded-lg hover:bg-[var(--color-dark-light)]">+ Add Category</a>
    </div>
    <div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-alt)] text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Name</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Slug</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Products</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Status</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($categories as $category)
                <tr class="hover:bg-[var(--color-surface-alt)]">
                    <td class="px-4 py-3 font-medium text-[var(--color-dark)]">{{ $category->name }}</td>
                    <td class="px-4 py-3 text-[var(--color-muted)]">{{ $category->slug }}</td>
                    <td class="px-4 py-3">{{ $category->products_count }}</td>
                    <td class="px-4 py-3"><span class="badge-{{ $category->status ? 'success' : 'secondary' }} text-xs font-semibold px-2.5 py-1 rounded-full">{{ $category->status ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-[var(--color-brand-500)] hover:text-[var(--color-brand-700)] text-xs font-medium">Edit</a>
                            @if($category->products_count === 0)
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="text-red-500 text-xs font-medium">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-[var(--color-muted)]">No categories.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $categories->links() }}</div>
</div>
@endsection
