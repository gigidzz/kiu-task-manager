# KIU Student Task Manager

A web-based task management application built with Laravel for the KIU Web Programming with laravel midterm project. Students can create, track, and manage their academic tasks with priority levels, deadlines, and status tracking.

---

## Features

- **Full CRUD** — create, view, edit, and delete tasks
- **Dashboard** — overview of total, completed, pending, and overdue tasks with a progress bar and upcoming deadlines
- **Status toggle (AJAX)** — mark tasks done or pending instantly without a page reload
- **Filters** — filter by status, priority, and deadline (overdue / due today / due this week); dropdowns apply instantly without pressing a button
- **Search** — live search by task title or subject with debounce
- **Overdue highlighting** — tasks past their deadline are highlighted in red automatically
- **Pagination** — 10 tasks per page
- **Bootstrap 5 UI** — clean, responsive interface

---

## Tech Stack

| Layer      | Technology            |
|------------|-----------------------|
| Framework  | Laravel 13            |
| Language   | PHP 8.4               |
| Database   | MySQL                 |
| Frontend   | Blade + Bootstrap 5   |
| Icons      | Bootstrap Icons       |

---

## Setup & Installation

### Requirements

- PHP >= 8.2 (older versions may work too)
- Composer
- MySQL
- Laravel CLI

### Steps

**1. Clone the repository**

```bash
git clone <repository-url>
cd kiu-task-manager
```

**2. Install dependencies**

```bash
composer install
```

**3. Create the environment file**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure the database**

Open `.env` and update your MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kiu_task_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then create the database in MySQL:

```sql
CREATE DATABASE kiu_task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**4. Run migrations and seed sample data**

```bash
php artisan migrate --seed
```

**5. Link the storage folder** (required for file-upload attachments to display)

```bash
php artisan storage:link
```

**6. Start the development server**

```bash
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Demo login

A seeded demo account is available:

| Email              | Password   |
|--------------------|------------|
| `demo@kiu.edu.ge`  | `password` |

Or register a new account from the sign-up page.

> **Note:** the compiled front-end assets are included in `public/build`, so you do **not** need Node/npm to run the project. If you change any CSS/JS, rebuild with `npm install && npm run build`.

---

## Database Schema

**Table: `tasks`**

| Column        | Type                          | Notes                    |
|---------------|-------------------------------|--------------------------|
| `id`          | bigint (PK, auto-increment)   |                          |
| `title`       | varchar(255)                  | Required                 |
| `description` | text                          | Optional                 |
| `subject`     | varchar(255)                  | e.g. Web Programming     |
| `status`      | tinyint — `0` pending, `1` done            | Default: `0`  |
| `priority`    | tinyint — `0` low, `1` medium, `2` high    | Default: `1`  |
| `deadline`    | date                          | Optional                 |
| `created_at`  | timestamp                     |                          |
| `updated_at`  | timestamp                     |                          |

---

## Project Structure

```
app/
  Http/Controllers/
    TaskController.php     # All CRUD + dashboard + AJAX toggle
  Models/
    Task.php               # Eloquent model

database/
  migrations/
    ..._create_tasks_table.php
  seeders/
    TaskSeeder.php         # 8 sample academic tasks
    DatabaseSeeder.php

resources/views/
  layouts/
    app.blade.php          # Main layout (navbar, flash messages)
  dashboard.blade.php      # Stats dashboard
  tasks/
    index.blade.php        # Task list with filters & AJAX toggle
    show.blade.php         # Task detail page
    create.blade.php       # Create form
    edit.blade.php         # Edit form
    _form.blade.php        # Shared form partial

routes/
  web.php                  
```

---


## Sample Data

The seeder loads 8 pre-built tasks across different subjects (Web Programming, Database Systems, Computer Networks, etc.) with a mix of statuses, priorities, and deadlines — including some overdue tasks for demonstration.

To re-seed at any time:

```bash
php artisan migrate:fresh --seed
```

---

## Author
Giorgi Dzimistarishvili

