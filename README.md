# Associate Software Engineer - Technical Exam

This repository contains the completion of the Associate Software Engineer technical exam. It consists of a decoupled Laravel Backend API and a modern Vue 3 Single Page Application (SPA) Frontend.

## 1. Development Process

**Approach:**
1. **Backend Infrastructure:** I started by scaffolding a Laravel 11 application. I installed Laravel Breeze for authentication and surgically removed the registration capabilities as requested. I then created migrations, factories, and seeders for the `Factories` and `Employees` tables.
2. **REST API & Observers:** I built resource controllers to handle CRUD operations and implemented a `ModelActivityObserver` to hook into Eloquent events (created, updated, deleted) and log all tracking data (including old and new values) directly into `laravel.log`.
3. **Frontend SPA:** I created a separate Vue 3 application using Vite. I integrated PrimeVue components and Tailwind CSS for a highly polished, responsive dark-mode UI.
4. **Asynchronous Integration:** I connected the frontend to the backend via Axios, configuring Laravel Sanctum for secure CSRF cookie-based authentication. I implemented a dynamic data table with live debounce searching, loading states, and inline Create/Edit/Delete modals to ensure the user never has to reload the page.

**Challenges & Solutions:**
- **Cross-Origin Authentication:** Connecting a standalone Vue dev server to a Laravel backend often leads to CORS and Sanctum cookie issues. I addressed this by carefully configuring Laravel's `cors.php`, ensuring `SANCTUM_STATEFUL_DOMAINS` mapped to the Vite development ports, and configuring Axios to always include credentials.
- **UI Styling Conflicts:** Integrating PrimeVue alongside Tailwind CSS v4 initially caused some CSS reset clashes that misaligned icons and disrupted the dark theme. I resolved this by manually auditing the CSS and adjusting Tailwind utility classes to perfectly compliment PrimeVue's component structures.

## 2. Tools & Libraries

**Backend:**
- Laravel 11 (PHP Framework)
- Laravel Breeze (Authentication starter kit)
- Laravel Sanctum (API Authentication)
- MySQL (Database)

**Frontend:**
- Vue 3 (Composition API)
- Vite (Build tool & dev server)
- PrimeVue v4 (Component library for DataTable, Dialogs, Forms)
- Tailwind CSS v4 (Utility-first CSS styling)
- Axios (HTTP client)

**Developer & AI Tools:**
- **Laragon:** Used for local development (Apache & MySQL).
- **AI Assistant:** Used an AI pair-programming assistant to rapidly scaffold Laravel migrations, configure complex CORS/Sanctum setups, debug frontend alignment issues, and generate boilerplate API controllers. The AI significantly accelerated the debugging phase of cross-origin requests.

## 3. External Resources

- [Laravel 11 Documentation](https://laravel.com/docs) - Specifically Eloquent Observers and Sanctum routing.
- [Vue 3 Composition API Docs](https://vuejs.org/guide/introduction.html)
- [PrimeVue v4 Component Library](https://primevue.org/) - Referenced for DataTable styling, Dialogs, and IconField implementations.
- [Tailwind CSS v4 Docs](https://tailwindcss.com/docs)

## 4. Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (Laragon, XAMPP, or Docker)

### Backend Setup
1. Open a terminal and navigate to the backend folder:
   ```bash
   cd Backend
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Setup your environment variables:
   - Copy `.env.example` to `.env`
   - Open `.env` and configure your database credentials (e.g., `DB_DATABASE=laxamana_exam`, `DB_USERNAME=root`, `DB_PASSWORD=`).
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seed the database (this will create the admin user):
   ```bash
   php artisan migrate --seed
   ```
6. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
   *The backend will now be running at `http://localhost:8000`*

### Frontend Setup
1. Open a **new** terminal and navigate to the frontend folder:
   ```bash
   cd Frontend
   ```
2. Install JavaScript dependencies:
   ```bash
   npm install
   ```
3. Start the Vite development server:
   ```bash
   npm run dev
   ```
   *The frontend will now be running (usually at `http://localhost:5173` or `5174`). Check your terminal for the exact URL.*

### Testing the Application
1. Open `http://localhost:8000/login` in your browser.
2. Log in using the seeded administrator credentials:
   - **Email:** `admin@admin.com`
   - **Password:** `password`
3. Open your Vue SPA URL (e.g., `http://localhost:5173`) in the same browser to interact with the fully dynamic Employee management panel!
