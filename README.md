# Associate Software Engineer - Technical Exam

Welcome to my submission for the Associate Software Engineer Technical Exam. 

This repository features a full-stack solution using a Laravel 11 Backend API paired with a Vue 3 Single Page Application (SPA). 

---

## 1. Development Process

**My Approach:**
1. **Backend First:** I began by scaffolding the Laravel application. I installed Laravel Breeze for authentication (disabling the registration route as requested) to ensure the admin panel was locked down.
2. **Database & API:** I mapped out the schema using Laravel Migrations, seeded an initial admin user (`admin@admin.com`), and built standard Resource Controllers for `Factories` and `Employees` to handle CRUD operations.
3. **Tracking User Activity:** To meet the tracking requirement, I implemented an Eloquent `ModelActivityObserver`. This solution hooks into Eloquent lifecycle events and logs all creations, updates (including old vs. new values), and deletions directly to `laravel.log`.
4. **Frontend Architecture:** Instead of using Blade files for everything, I built a decoupled Vue 3 SPA using Vite. I integrated PrimeVue and Tailwind CSS to build a responsive UI.
5. **Connecting the Two:** I linked the frontend to the backend using Axios and configured Laravel Sanctum to handle cookie-based SPA authentication. 

**Challenges & Solutions:**
- **Cross-Origin Authentication:** Connecting a standalone Vue dev server to a separate Laravel backend often leads to CORS and session cookie errors. I resolved this by configuring `cors.php` and ensuring `SANCTUM_STATEFUL_DOMAINS` mapped correctly to my Vite development ports.
- **Async State Management:** Managing inline CRUD operations without reloading the page requires careful state management. I solved this by extracting the Create/Edit form into a dedicated `EmployeeFormModal.vue` child component, which communicates with the parent table to refresh data only when an API call succeeds.

---

## 2. Tools & Libraries

### Backend Stack
*   **Laravel 11** (Core PHP Framework)
*   **Laravel Breeze** (Authentication scaffolding)
*   **Laravel Sanctum** (Secure SPA Cookie Authentication)
*   **MySQL** (Relational Database)

### Frontend Stack
*   **Vue 3 (Composition API)** (Reactive UI Framework)
*   **Vite** (Next-generation frontend tooling)
*   **PrimeVue v4** (UI Component Library for DataTables & Modals)
*   **Tailwind CSS v4** (Utility-first styling)
*   **Axios** (Promise-based HTTP client)

### Developer & AI Tools
*   **Laragon:** Used for local server orchestration (Apache & MySQL).
*   **AI Pair-Programming (Gemini/Antigravity & Claude):** I utilized AI assistants as collaborative pair-programmers throughout the development cycle. They helped scaffold boilerplate Laravel migrations, debug cross-origin cookie configurations, and act as a sounding board for refining the PrimeVue UI layout. They accelerated the debugging phase of asynchronous network operations.

---

## 3. External Resources

*   [Laravel 11 Documentation](https://laravel.com/docs) (Specifically referenced for Eloquent Observers and Sanctum routing)
*   [Vue 3 Composition API Guide](https://vuejs.org/guide/introduction.html)
*   [PrimeVue v4 Component Library](https://primevue.org/) (Used for the DataTable, Search inputs, and Dialog modals)
*   [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)

---

## 4. Setup Instructions

Ready to test it out? Follow these steps to get the app running on your local machine.

### Prerequisites
Make sure you have the following installed:
*   PHP 8.2+
*   Composer
*   Node.js & npm
*   MySQL (Laragon, XAMPP, or Docker)

### Step 1: Boot up the Backend
1. Open a terminal and navigate to the backend directory:
   ```bash
   cd Backend
   ```
2. Install the PHP dependencies:
   ```bash
   composer install
   ```
3. Set up your environment variables:
   - Duplicate the `.env.example` file and rename it to `.env`.
   - Open `.env` and enter your database credentials (e.g., `DB_DATABASE=laxamana_exam`, `DB_USERNAME=root`).
4. Generate the application encryption key:
   ```bash
   php artisan key:generate
   ```
5. Run the migrations and seed the initial admin user:
   ```bash
   php artisan migrate --seed
   ```
6. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
   *(Your backend is now running at `http://localhost:8000`)*

### Step 2: Boot up the Frontend
1. Open a **new terminal window** and navigate to the frontend directory:
   ```bash
   cd Frontend
   ```
2. Install the JavaScript dependencies:
   ```bash
   npm install
   ```
3. Start the Vite development server:
   ```bash
   npm run dev
   ```
   *(Your frontend SPA is now running. Check your terminal for the exact URL, usually `http://localhost:5173` or `5174`)*

### Step 3: Test the Application
1. First, navigate to the backend login page in your browser: `http://localhost:8000/login`
2. Log in using the seeded administrator credentials:
   *   **Email:** `admin@admin.com`
   *   **Password:** `password`
3. Once successfully logged in, open a new tab and navigate to your Vue SPA URL (e.g., `http://localhost:5174`).
4. You can now use the async-driven Employee management dashboard.
