@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">My Order History</h1>

    <form method="GET" action="{{ route('orders.index') }}" class="mb-6 flex gap-4">
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All Statuses</option>
            <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ $currentStatus == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="shipped" {{ $currentStatus == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ $currentStatus == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ $currentStatus == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <input type="text" name="search" value="{{ $search }}" placeholder="Search by book title..."
               class="border rounded px-3 py-2 flex-1">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    </form>

    @if($search)
        <p class="mb-4 text-gray-600">Showing results for: <strong>{!! $search !!}</strong></p>
    @endif

    <div class="mb-4 text-gray-600">
        <p>Total orders: {{ count($orders) }}</p>
        <p>Total spent: &euro;{{ number_format($totalSpent, 2) }}</p>
    </div>

    @if(count($orders) > 0)
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Order #</th>
                    <th class="border px-4 py-2 text-left">Date</th>
                    <th class="border px-4 py-2 text-left">Items</th>
                    <th class="border px-4 py-2 text-left">Total</th>
                    <th class="border px-4 py-2 text-left">Status</th>
                    <th class="border px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="border px-4 py-2">#{{ $order->id }}</td>
                    <td class="border px-4 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="border px-4 py-2">
                        @foreach($order->items as $item)
                            <div>{{ $item->book->title }} (x{{ $item->quantity }})</div>
                        @endforeach
                    </td>
                    <td class="border px-4 py-2">&euro;{{ number_format($order->total_amount, 2) }}</td>
                    <td class="border px-4 py-2">
                        <span class="px-2 py-1 rounded text-sm
                            @if($order->status == 'delivered') bg-green-100 text-green-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-500 hover:underline">
                            View Details
                        </a>
                        @if($order->status != 'cancelled')
                            <a href="{{ route('orders.cancel', $order->id) }}"
                               class="text-red-500 hover:underline ml-2">
                                Cancel
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500">No orders found.</p>
    @endif
</div>
@endsection
