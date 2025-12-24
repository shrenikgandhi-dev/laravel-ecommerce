# Laravel E-commerce Application

A modern Laravel-based web application built using Laravel Breeze, Tailwind CSS, and MySQL.

## Features
- User authentication (Laravel Breeze)
- User profile management
- Product listing
- SEO-friendly URLs
- Clean Blade components

## Tech Stack
- Laravel 12+
- PHP 8+
- MySQL
- Tailwind CSS
- Laravel Breeze

## Installation

```bash
git clone https://github.com/shrenikgandhi-dev/laravel-ecommerce.git
cd repo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev
php artisan serve