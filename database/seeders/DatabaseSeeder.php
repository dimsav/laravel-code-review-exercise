<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();
        $books = Book::factory(50)->create();

        foreach ($users as $user) {
            $orders = Order::factory(rand(3, 15))->create([
                'user_id' => $user->id,
            ]);

            foreach ($orders as $order) {
                $itemCount = rand(1, 4);
                $total = 0;

                for ($i = 0; $i < $itemCount; $i++) {
                    $book = $books->random();
                    $item = OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'book_id' => $book->id,
                        'price_at_time_of_order' => $book->price,
                    ]);
                    $total += $item->price_at_time_of_order * $item->quantity;
                }

                $order->update(['total_amount' => $total]);
            }
        }
    }
}
