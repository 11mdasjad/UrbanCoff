@extends('layouts.admin')
@section('page_title', 'Customers')
@section('title', 'Customers — Admin')

@section('content')
<div class="bg-white rounded-xl border border-[var(--color-border)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-alt)] text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Customer</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Email</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Phone</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Orders</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Joined</th>
                    <th class="px-4 py-3 font-semibold text-[var(--color-muted)]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($customers as $customer)
                <tr class="hover:bg-[var(--color-surface-alt)]">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[var(--color-brand-100)] flex items-center justify-center text-[var(--color-brand-600)] text-xs font-bold">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                            <span class="font-medium text-[var(--color-dark)]">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-[var(--color-muted)]">{{ $customer->email }}</td>
                    <td class="px-4 py-3 text-[var(--color-muted)]">{{ $customer->phone ?? '—' }}</td>
                    <td class="px-4 py-3 font-medium">{{ $customer->orders_count }}</td>
                    <td class="px-4 py-3 text-[var(--color-muted)]">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3"><a href="{{ route('admin.customers.show', $customer) }}" class="text-[var(--color-brand-500)] text-xs font-medium hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-[var(--color-muted)]">No customers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $customers->links() }}</div>
@endsection
