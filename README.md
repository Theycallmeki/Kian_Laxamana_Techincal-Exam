# Technical Exam - Associate Software Engineer

This repository contains the full stack application required for the Associate Software Engineer technical exam. The project is split into two main layers: a Laravel REST API Backend, and a Vue.js Decoupled SPA Frontend.

## Development Process

1. **Backend Setup & API:** I started by creating a new Laravel application and configuring a SQLite database. I used Laravel Breeze to scaffold out the required authentication boilerplate (logging in as an admin) and immediately disabled the registration routes to secure the admin panel.
2. **Database & Seeding:** I created migrations for both `Factories` and `Employees`, ensuring the correct foreign key relationships (`factory_id`). Then, I set up model factories and seeders to populate the database with dummy data, including the `admin@admin.com` user required by the prompt.
3. **Controllers & Validation:** I generated Laravel Resource Controllers. I implemented Form Request classes (`StoreEmployeeRequest` and `UpdateEmployeeRequest`) to ensure all incoming data to the REST API was strictly validated before hitting the database.
4. **Observer Logging:** To track user activity automatically, I created a `ModelActivityObserver`. It hooks into the `saved` and `deleted` eloquent events to log the model name, record ID, and exact attribute changes directly into `laravel.log`.
5. **Frontend SPA:** I created a totally decoupled Vue 3 frontend using Vite. I utilized Axios to consume the Laravel REST API asynchronously.
6. **CORS & Sanctum:** I configured Laravel Sanctum's stateful API settings (`config/cors.php` and `bootstrap/app.php`) to allow the Vite server to securely share session cookies and bypass CORS restrictions.
7. **Async UX & Debouncing:** I built the `EmployeeList` component, adding loading states, error handling, and a Vue `watch` function to debounce the search input by 500ms, effectively handling overlapping requests.
8. **Inline CRUD:** I added a modal to handle Creating and Editing records, and a direct Delete button, all without ever refreshing the page.

## Tools & Libraries

* **Backend:** Laravel 11, PHP 8.2+, SQLite, Laravel Sanctum, Laravel Breeze.
* **Frontend:** Vue 3 (Composition API), Vite, Axios, Tailwind CSS v4.
* **AI Assistance:** I paired with an AI assistant (Google Gemini) within my IDE to accelerate boilerplate generation (like migrations, Form Requests, and repetitive Vue templates) and to help streamline the CORS configuration between Vite and Laravel Sanctum. The AI acted as a pair programmer, while I drove the architectural decisions and verified the logic.

## Setup Instructions

### 1. Backend Setup

Navigate to the `Backend` directory and run the following commands:

```bash
cd Backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

*Note: The database is pre-seeded with the administrator account: `admin@admin.com` / `password`.*

### 2. Frontend Setup

Open a **new terminal window**, navigate to the `Frontend` directory, and start the Vite development server:

```bash
cd Frontend
npm install
npm run dev
```

### 3. Usage

1. Make sure both `php artisan serve` (port 8000) and `npm run dev` (port 5174) are running simultaneously.
2. Open your browser and go to the Laravel Backend: `http://localhost:8000/login`
3. Log in with `admin@admin.com` and `password`.
4. Open a new tab and go to the Vue Frontend: `http://localhost:5174`
5. You can now use the fully decoupled SPA to view, search, create, edit, and delete employees dynamically
