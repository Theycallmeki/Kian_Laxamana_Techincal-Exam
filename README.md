# Associate Software Engineer - Technical Exam

Welcome to my submission for the Associate Software Engineer Technical Exam! 

This repository showcases a full-stack solution featuring a highly secure Laravel 11 Backend API beautifully paired with a lightning-fast Vue 3 Single Page Application (SPA). 

---

## 1. Development Process

**My Approach:**
1. **Backend First:** I began by scaffolding the Laravel application. I installed Laravel Breeze for authentication (surgically disabling the registration route as requested) to ensure the admin panel was completely locked down.
2. **Database & API:** I mapped out the schema using Laravel Migrations, seeded an initial admin user (`admin@admin.com`), and built standard Resource Controllers for `Factories` and `Employees` to handle all CRUD operations securely.
3. **Tracking User Activity:** To meet the tracking requirement, I implemented an Eloquent `ModelActivityObserver`. This elegant solution hooks into Eloquent lifecycle events and logs all creations, updates (including old vs. new values!), and deletions directly to `laravel.log`.
4. **Frontend Architecture:** Instead of using basic Blade files for everything, I built a completely decoupled Vue 3 SPA using Vite. I integrated PrimeVue and Tailwind CSS to craft a stunning, highly responsive dark-mode UI.
5. **Connecting the Two:** I linked the frontend to the backend using Axios and configured Laravel Sanctum to handle secure, cookie-based SPA authentication. 

**Challenges & Solutions:**
- **Cross-Origin Authentication:** Connecting a standalone Vue dev server to a separate Laravel backend often leads to tricky CORS and session cookie errors. I resolved this by carefully configuring `cors.php` and ensuring `SANCTUM_STATEFUL_DOMAINS` mapped perfectly to my Vite development ports.
- **Async State Management:** Managing inline CRUD operations without reloading the page requires careful state management. I solved this by extracting the Create/Edit form into a dedicated `EmployeeFormModal.vue` child component, which cleanly communicates with the parent table to refresh data only when an API call succeeds.

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
*   **PrimeVue v4** (Advanced UI Component Library for DataTables & Modals)
*   **Tailwind CSS v4** (Utility-first styling)
*   **Axios** (Promise-based HTTP client)

### Developer & AI Tools
*   **Laragon:** Used for local server orchestration (Apache & MySQL).
*   **AI Pair-Programming (Gemini/Antigravity):** I utilized an AI assistant as a collaborative pair-programmer throughout the development cycle. The AI helped rapidly scaffold boilerplate Laravel migrations, debug complex cross-origin cookie configurations, and act as a sounding board for refining the PrimeVue UI layout. It significantly accelerated the debugging phase of asynchronous network stress!

---

## 3. External Resources

*   [Laravel 11 Documentation](https://laravel.com/docs) (Specifically referenced for Eloquent Observers and Sanctum routing)
*   [Vue 3 Composition API Guide](https://vuejs.org/guide/introduction.html)
*   [PrimeVue v4 Component Library](https://primevue.org/) (Used heavily for the interactive DataTable, Search inputs, and Dialog modals)
*   [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)

---

## 4. Setup Instructions

Ready to test it out? Follow these simple steps to get the app running on your local machine!

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
   *(Your backend is now securely running at `http://localhost:8000`)*

### Step 2: Boot up the Frontend
1. Open a **brand new terminal window** and navigate to the frontend directory:
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

### Step 3: Test the Application!
1. First, navigate to the backend login page in your browser: `http://localhost:8000/login`
2. Log in using the seeded administrator credentials:
   *   **Email:** `admin@admin.com`
   *   **Password:** `password`
3. Once successfully logged in, open a new tab and navigate to your Vue SPA URL (e.g., `http://localhost:5174`).
4. Enjoy the fully dynamic, async-driven Employee management dashboard!
