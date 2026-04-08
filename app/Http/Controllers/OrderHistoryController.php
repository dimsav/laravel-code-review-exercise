<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $query = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('items', function ($q) use ($search) {
                $q->join('books', 'order_items.book_id', '=', 'books.id')
                    ->whereRaw("books.title LIKE '%" . $search . "%'");
            });
        }

        $orders = $query->get();

        $totalSpent = 0;
        foreach ($orders as $order) {
            $totalSpent = $totalSpent + $order->total_amount;
        }

        return view('orders.history', [
            'orders' => $orders,
            'totalSpent' => $totalSpent,
            'currentStatus' => $status,
            'search' => $search,
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        $items = $order->items;

        return view('orders.show', [
            'order' => $order,
            'items' => $items,
        ]);
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')->with('success', 'Order cancelled.');
    }
}
