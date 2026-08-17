<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $order->order_number }} — URBANCOFF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .invoice-card {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            @page {
                margin: 1.5cm;
                size: A4;
            }
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        {{-- Action Bar (Hidden in Print) --}}
        <div class="no-print mb-6 flex flex-wrap items-center justify-between gap-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                @if(isset($isAdmin) && $isAdmin)
                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Admin Order
                    </a>
                @else
                    <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Order Details
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-black text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print / Save PDF
                </button>
            </div>
        </div>

        {{-- Printable Invoice Document --}}
        <div class="invoice-card bg-white rounded-2xl border border-gray-200 shadow-sm p-8 sm:p-12">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-8 border-b border-gray-100 gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/urbancoff-logo.png') }}" alt="URBANCOFF" class="h-14 w-14 object-contain rounded-xl shadow-sm">
                    <div>
                        <h1 class="font-sans text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900">URBANCOFF</h1>
                        <p class="text-xs uppercase tracking-[0.2em] text-[#b8944e] font-semibold mt-0.5">Premium Menswear</p>
                        <p class="text-xs text-gray-500 mt-1">www.urbancoff.com · support@urbancoff.com</p>
                    </div>
                </div>
                <div class="sm:text-right">
                    <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full {{ match($order->status) {
                        'delivered' => 'bg-green-100 text-green-800',
                        'shipped' => 'bg-blue-100 text-blue-800',
                        'confirmed' => 'bg-indigo-100 text-indigo-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        default => 'bg-amber-100 text-amber-800'
                    } }}">
                        {{ ucfirst($order->status) }}
                    </span>
                    <h2 class="text-xl font-bold text-gray-900 mt-2">INVOICE</h2>
                    <p class="text-sm font-semibold text-gray-700">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Date: {{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            {{-- Addresses & Order Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-8 border-b border-gray-100 text-sm">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Billed & Shipped To</p>
                    <p class="font-bold text-gray-900 text-base">{{ $order->name }}</p>
                    <p class="text-gray-600 mt-1">{{ $order->address_line_1 }}</p>
                    @if($order->address_line_2)
                        <p class="text-gray-600">{{ $order->address_line_2 }}</p>
                    @endif
                    <p class="text-gray-600">{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                    <p class="text-gray-600">{{ $order->country }}</p>
                    <p class="text-gray-600 mt-2"><span class="font-medium text-gray-700">Email:</span> {{ $order->email }}</p>
                    <p class="text-gray-600"><span class="font-medium text-gray-700">Phone:</span> {{ $order->phone }}</p>
                </div>
                <div class="sm:text-right space-y-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Payment Details</p>
                    <p class="text-gray-700"><span class="font-medium">Method:</span> {{ ucfirst($order->payment_method) === 'Cod' ? 'Cash on Delivery (COD)' : ucfirst($order->payment_method) }}</p>
                    <p class="text-gray-700"><span class="font-medium">Payment Status:</span> <span class="capitalize font-semibold">{{ $order->payment_status ?? 'Pending' }}</span></p>
                    <p class="text-gray-700"><span class="font-medium">Order Placed:</span> {{ $order->created_at->format('h:i A, F d, Y') }}</p>
                </div>
            </div>

            {{-- Line Items Table --}}
            <div class="py-8 border-b border-gray-100">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-bold uppercase tracking-wider text-gray-500">
                            <th class="pb-3">Item Description</th>
                            <th class="pb-3 text-center">Variant</th>
                            <th class="pb-3 text-center">Qty</th>
                            <th class="pb-3 text-right">Unit Price</th>
                            <th class="pb-3 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-4">
                                    <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                    @if($item->product && $item->product->sku)
                                        <p class="text-xs text-gray-400 mt-0.5">SKU: {{ $item->product->sku }}</p>
                                    @endif
                                </td>
                                <td class="py-4 text-center text-xs text-gray-600">
                                    <span class="inline-block bg-gray-100 px-2 py-1 rounded font-medium">{{ $item->size }} / {{ $item->color }}</span>
                                </td>
                                <td class="py-4 text-center font-medium text-gray-900">{{ $item->quantity }}</td>
                                <td class="py-4 text-right text-gray-600">₹{{ number_format($item->price, 2) }}</td>
                                <td class="py-4 text-right font-bold text-gray-900">₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary & Totals --}}
            <div class="pt-8 flex flex-col sm:flex-row sm:justify-between gap-8">
                <div class="max-w-xs text-xs text-gray-500 space-y-1">
                    <p class="font-bold text-gray-700 uppercase tracking-wider">Terms & Instructions</p>
                    <p>All prices are inclusive of applicable GST.</p>
                    <p>For any return or exchange assistance within 30 days, please visit <span class="font-medium text-gray-700">urbancoff.com</span> with your Order Number.</p>
                </div>
                <div class="sm:w-64 space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-900">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span class="font-medium text-gray-900">{{ $order->shipping_cost > 0 ? '₹' . number_format($order->shipping_cost, 2) : 'FREE' }}</span>
                    </div>
                    <div class="border-t-2 border-gray-900 pt-3 flex justify-between font-bold text-base text-gray-900">
                        <span>Total Due</span>
                        <span class="text-xl">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Footer note --}}
            <div class="mt-12 pt-6 border-t border-gray-100 text-center text-xs text-gray-400">
                <p>Thank you for choosing <span class="font-bold text-gray-700">URBANCOFF</span>. Premium Quality · Fast Delivery · Easy Returns</p>
            </div>
        </div>
    </div>
</body>
</html>
