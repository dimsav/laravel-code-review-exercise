# Bookworm - Online Book Marketplace

A Laravel-based marketplace where users can buy and sell second-hand books.

## Tech Stack

- PHP 8.3 / Laravel 12
- MySQL, Redis
- Blade templates, Tailwind CSS

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Models

- **User** — Registered users (buyers and sellers)
- **Book** — Book listings with title, author, ISBN, price
- **Order** — Purchase orders with status tracking
- **OrderItem** — Individual items within an order
