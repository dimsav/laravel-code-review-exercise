<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Book> */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(2, 5)),
            'author' => fake()->name(),
            'isbn' => fake()->unique()->isbn13(),
            'price' => fake()->randomFloat(2, 2, 45),
            'description' => fake()->optional()->paragraph(),
        ];
    }
}
