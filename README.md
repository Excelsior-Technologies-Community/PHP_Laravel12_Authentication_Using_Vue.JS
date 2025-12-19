# PHP_Laravel12_Authentication_Using_Vue.JS

A modern full‑stack authentication starter project built with **Laravel 12**, **Vue 3**, **Inertia.js**, and **Tailwind CSS**. This repository provides a clean, scalable, and production‑ready foundation for building secure single‑page applications with a complete authentication flow.

---

## Project Overview

This project demonstrates how to build a full authentication system using Laravel as the backend and Vue.js as the frontend while maintaining a seamless SPA‑like experience through Inertia.js.

It is suitable for:

* Laravel + Vue learners
* MCA / BCA / BSc IT projects
* Interview preparation
* Real‑world starter templates

---

## Features

### Authentication System

* User registration and login
* Email verification
* Password reset (forgot password flow)
* Profile management
* Protected routes using middleware

### Modern Tech Stack

* Laravel 12 backend
* Vue 3 with Composition API
* Inertia.js for SPA‑like navigation
* Tailwind CSS for modern UI
* Vite for fast asset bundling

### Security

* Laravel Sanctum authentication
* CSRF protection
* Secure session handling
* Environment‑based configuration

---

## Prerequisites

Make sure the following are installed on your system:

* PHP 8.2 or higher
* Composer (latest version)
* Node.js 18+ with npm or yarn
* MySQL 8.0+ or PostgreSQL
* Git

---

## Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/PHP_Laravel12_Authentication_Using_Vue.JS.git
cd laravel-vue-auth-2025
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with database details:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue_auth
DB_USERNAME=root
DB_PASSWORD=

APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173
```

---

### 4. Database Setup

```bash
php artisan migrate

# Optional
php artisan db:seed
```

---

### 5. Install Frontend Dependencies

```bash
npm install
```

---

### 6. Run Development Servers

Backend server:

```bash
php artisan serve
```

Frontend dev server:

```bash
npm run dev
```

---

### 7. Access the Application

Frontend:

```
http://localhost:5173
```

Backend:

```
http://localhost:8000
```

---

## Project Structure

```
laravel-vue-auth-2025/
├── app/
│   ├── Http/Controllers/Auth/     Authentication controllers
│   ├── Http/Middleware/           Custom middleware
│   └── Models/                    Eloquent models
├── resources/
│   └── js/
│       ├── Components/            Reusable Vue components
│       ├── Layouts/               Application layouts
│       ├── Pages/                 Vue pages (Login, Register, Dashboard)
│       ├── composables/           Vue composables and hooks
│       └── lib/                   Helper utilities
├── routes/
│   ├── web.php                    Web routes (Inertia)
│   └── auth.php                   Authentication routes
├── database/
│   ├── migrations/                Database migrations
│   └── seeders/                   Database seeders
└── tests/                         Feature and unit tests
```

---

## Customization Guide

### Adding New Pages

Create a Vue page inside `resources/js/Pages` and define its route in `routes/web.php`.

```php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
```

---

### Using shadcn‑vue Components

Install reusable UI components:

```bash
npx shadcn-vue@latest add component-name
```

---

### Layout Variants

Switch layouts in `resources/js/Layouts`.

Example:

```js
import AppLayout from '@/Layouts/AppHeaderLayout.vue';
```

Authentication layouts:

```js
import AuthLayout from '@/Layouts/AuthSplitLayout.vue';
```

---

## Testing

Run backend tests:

```bash
php artisan test
```

Run frontend tests:

```bash
npm run test
```

---

## Screenshot

<img width="1765" height="954" alt="image" src="https://github.com/user-attachments/assets/c486e0c6-ab98-443e-8def-38972434e1fc" />

---

## Best Practices

* Keep API logic inside controllers and services
* Use Inertia for seamless page transitions
* Protect routes using middleware
* Validate all form inputs on backend and frontend
* Use environment variables for sensitive data

---
