# Associate Software Engineer Technical Exam

This repository contains the solution for the Associate Software Engineer technical exam. The application is a unified Laravel monolith that provides server-rendered CRUD for Factories and a dynamic, async-driven Vue 3 SPA interface for Employees, consuming a REST API.

## Development Process

1. **Backend Foundation**: Set up a new Laravel 11 project, configuring SQLite (later switched to MySQL for driver support on the local environment) as the database.
2. **Authentication**: Integrated Laravel Breeze for basic authentication, keeping the login system but stripping out the registration routes and views as requested.
3. **Database Design**: Created Migrations, Models, and Factories for `Factory` and `Employee`. Setup a `DatabaseSeeder` to provision the admin user and test data.
4. **Server-Rendered CRUD**: Built Laravel resource controllers and Blade views for `Factories` management, utilizing FormRequest classes for validation.
5. **Activity Logging**: Implemented a Model Observer (`ModelActivityObserver`) that listens to Eloquent events (`created`, `updated`, `deleted`) on both Factory and Employee models and logs the changes, including old/new values and the user ID, directly to `laravel.log`.
6. **REST API & Dynamic Frontend**: 
   - Created an `Api\EmployeeController` returning paginated JSON responses.
   - Built a dynamic Vue 3 component (`EmployeeList.vue`) to handle the Employees view.
   - The Vue component uses Axios to fetch data, providing a seamless SPA experience with live search (debounced), pagination, and inline CRUD operations without page reloads.

## Tools & Libraries

- **Backend**: Laravel 11, PHP 8.3, MySQL
- **Frontend**: Vue 3 (Composition API & Options API), Tailwind CSS, Vite, Axios
- **AI Tools Used**: Gemini Advanced (Antigravity Agent) was used to assist with rapidly generating boilerplate, configuring the Vite/Vue integration, and planning the application architecture.

## External Resources

- Laravel Documentation (https://laravel.com/docs)
- Vue.js Documentation (https://vuejs.org/guide/introduction.html)
- Tailwind CSS Documentation (https://tailwindcss.com/docs)

## Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL Server

### Installation Steps

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd Backend
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Install Node Dependencies**:
   ```bash
   npm install
   ```

4. **Environment Configuration**:
   Copy `.env.example` to `.env` and generate the app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Ensure your `DB_CONNECTION` in `.env` is set to `mysql` and the database `factory_admin` exists.*

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *This will create the tables and seed the admin user (`admin@admin.com` / `password`).*

6. **Build Frontend Assets**:
   ```bash
   npm run build
   ```
   *For active development, you can use `npm run dev`.*

7. **Start the Local Server**:
   ```bash
   php artisan serve
   ```

### Testing the App
- Go to `http://127.0.0.1:8000` and login with `admin@admin.com` and password `password`.
- Navigate to **Factories** to test the server-rendered CRUD.
- Navigate to **Employees** to test the Vue 3 dynamic list, live search, and inline CRUD.
- Check `storage/logs/laravel.log` to see the model activity logs.
