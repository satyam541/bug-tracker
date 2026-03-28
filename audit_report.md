# Bug Tracker System — Audit Report

> **Project Name:** Bug Tracker System
> **Type:** College-Level Web Application
> **Framework:** Laravel 13.x (PHP 8.3+)
> **Database:** MySQL 9.1.0 (via WAMP)
> **Frontend:** Bootstrap 5.3.3 + Blade Templating
> **Date:** June 2025

---

## Table of Contents

1. [Technology Stack & Purpose](#1-technology-stack--purpose)
2. [Architecture Overview](#2-architecture-overview)
3. [Database Schema](#3-database-schema)
4. [Role-Based Access Control (RBAC)](#4-role-based-access-control-rbac)
5. [Project Flow](#5-project-flow)
6. [Module-Wise Breakdown](#6-module-wise-breakdown)
7. [Email Notification System](#7-email-notification-system)
8. [Activity Logging](#8-activity-logging)
9. [File & Directory Structure](#9-file--directory-structure)
10. [Default Credentials](#10-default-credentials)
11. [Setup Instructions](#11-setup-instructions)

---

## 1. Technology Stack & Purpose

### Backend Technologies

| Technology | Version | Purpose |
|---|---|---|
| **PHP** | 8.3+ | Server-side programming language used to write all application logic, controllers, models, and services. |
| **Laravel Framework** | 13.x | The core MVC framework providing routing, ORM (Eloquent), middleware, migrations, seeders, mailing, validation, and the overall application structure. |
| **Laravel Breeze** | 2.4 | Lightweight authentication scaffolding that provides ready-made login, registration, password reset, email verification, and profile management features out of the box. |
| **Eloquent ORM** | (built-in) | Laravel's Active Record implementation for interacting with the MySQL database. Each database table has a corresponding Model class. Supports relationships (hasMany, belongsTo, belongsToMany, morphTo), accessors, scopes, and eager loading. |
| **Blade Templating** | (built-in) | Laravel's templating engine for rendering server-side HTML views. Supports template inheritance (`@extends`, `@section`, `@yield`), components, conditionals (`@if`, `@auth`, `@role`), and loops (`@foreach`, `@forelse`). |
| **Composer** | 2.x | PHP dependency manager used to install and manage all backend packages (Laravel, Breeze, Faker, PHPUnit, Pint). |

### Frontend Technologies

| Technology | Version | Purpose |
|---|---|---|
| **Bootstrap** | 5.3.3 | CSS framework loaded via CDN. Provides responsive grid system, pre-styled UI components (cards, tables, badges, buttons, modals, forms, alerts, navbars), and utility classes for rapid frontend development. |
| **Bootstrap Icons** | 1.11.3 | Icon library loaded via CDN. Provides 2,000+ SVG icons used throughout the application for navigation items, action buttons, status indicators, and dashboard widgets. |
| **Chart.js** | 4.4.0 | JavaScript charting library loaded via CDN. Used on the Dashboard page to render four interactive charts: Status Doughnut Chart, Priority Bar Chart, Severity Pie Chart, and Project-wise Horizontal Bar Chart. |
| **HTML5 / CSS3** | — | Standard web technologies for page structure and custom styling beyond Bootstrap defaults. |
| **JavaScript (Vanilla)** | ES6+ | Used for Chart.js initialization, sidebar toggle functionality, form interactions, and dynamic UI behavior without any additional JS framework. |

### Database & Server

| Technology | Version | Purpose |
|---|---|---|
| **MySQL** | 9.1.0 | Relational database management system storing all application data — users, roles, projects, bugs, comments, and activity logs. Chosen for its reliability, ACID compliance, and seamless integration with Laravel's Eloquent ORM. |
| **WAMP Server/Xampp** | — | Windows-based local development stack (Windows + Apache + MySQL + PHP) that runs the application locally. Apache serves HTTP requests to the Laravel application. |

### Development & Testing Tools

| Technology | Purpose |
|---|---|
| **Laravel Pint** | PHP code style fixer that automatically formats code to follow Laravel's coding standards. |
| **PHPUnit** | PHP testing framework for writing and running unit and feature tests. |
| **FakerPHP** | Library for generating realistic fake data used in database seeders (names, emails, paragraphs, dates). |
| **Laravel Tinker** | Interactive REPL (Read-Eval-Print Loop) for testing Eloquent queries and application logic from the command line. |
| **Artisan CLI** | Laravel's built-in command-line interface for running migrations, seeders, cache clearing, route listing, and other administrative tasks. |

---

## 2. Architecture Overview

The application follows the **MVC (Model-View-Controller)** architectural pattern provided by Laravel:

```
┌─────────────┐     ┌───────────────────┐     ┌─────────────────┐
│   Browser    │────▶│   Routes          │────▶│   Middleware     │
│   (User)     │     │   (web.php)       │     │   (auth, role)   │
└─────────────┘     └───────────────────┘     └────────┬────────┘
                                                       │
                                                       ▼
                    ┌───────────────────┐     ┌─────────────────┐
                    │   Form Requests   │◀────│   Controllers    │
                    │   (Validation)    │     │   (Logic)        │
                    └───────────────────┘     └────────┬────────┘
                                                       │
                              ┌─────────────────────────┤
                              │                         │
                              ▼                         ▼
                    ┌─────────────────┐       ┌─────────────────┐
                    │   Models         │       │   Views (Blade)  │
                    │   (Eloquent ORM) │       │   (HTML Output)  │
                    └────────┬────────┘       └─────────────────┘
                             │
                             ▼
                    ┌─────────────────┐
                    │   MySQL Database │
                    └─────────────────┘
```

### Request Lifecycle

1. **HTTP Request** → User submits a request via the browser.
2. **Routing** → `routes/web.php` matches the URL to a controller method.
3. **Middleware** → `auth` middleware checks if the user is logged in. `role` middleware checks if the user has the required role (admin, developer, tester).
4. **Form Request** → For POST/PUT requests, a dedicated Form Request class validates all input fields before the controller receives them.
5. **Controller** → Executes business logic — fetches data, creates/updates records, sends emails, logs activities.
6. **Model (Eloquent)** → Interacts with the MySQL database via the ORM — queries, inserts, updates, deletes.
7. **Service (ActivityLogService)** → Called by controllers to log user actions into the `activity_logs` table.
8. **Mailable** → When certain events occur (bug assigned, status changed, comment added), email notifications are dispatched.
9. **View (Blade)** → Controller passes data to a Blade template which renders the final HTML.
10. **HTTP Response** → Rendered HTML is sent back to the browser.

---

## 3. Database Schema

The application uses **10 migration files** to create the following tables:

### Tables Overview

| Table | Purpose | Key Columns |
|---|---|---|
| `roles` | Stores user roles | `id`, `name` (admin/developer/tester), `timestamps` |
| `users` | Stores all user accounts | `id`, `name`, `email`, `password`, `role_id` (FK → roles), `timestamps` |
| `projects` | Stores project definitions | `id`, `name`, `description`, `status` (active/inactive), `created_by` (FK → users), `timestamps` |
| `project_user` | Pivot table for project team members | `project_id` (FK), `user_id` (FK) |
| `bugs` | Stores all bug reports | `id`, `title`, `description`, `status`, `priority`, `severity`, `project_id` (FK), `reported_by` (FK), `assigned_to` (FK, nullable), `screenshot` (nullable), `timestamps` |
| `comments` | Stores comments on bugs | `id`, `body`, `bug_id` (FK), `user_id` (FK), `timestamps` |
| `activity_logs` | Tracks all user actions | `id`, `user_id` (FK), `action`, `description`, `subject_type` (polymorphic), `subject_id` (polymorphic), `timestamps` |
| `sessions` | Manages user sessions | Laravel default table for database session driver |
| `cache` | Stores application cache | Laravel default table for database cache driver |
| `jobs` | Queue jobs table | Laravel default table for database queue driver |

### Enum Values

| Column | Allowed Values |
|---|---|
| `bugs.status` | `open`, `in_progress`, `fixed`, `closed` |
| `bugs.priority` | `low`, `medium`, `high` |
| `bugs.severity` | `minor`, `major`, `critical` |
| `projects.status` | `active`, `inactive` |

### Relationships Diagram

```
roles ──────┐
            │ 1:N
            ▼
users ──────┬──────────────── projects (created_by)
   │        │                    │
   │   project_user (N:N)        │
   │        │                    │
   │        └────────────────────┘
   │
   ├── bugs (reported_by)
   ├── bugs (assigned_to)
   ├── comments (user_id)
   └── activity_logs (user_id)

projects ──── bugs (project_id) ──── comments (bug_id)

activity_logs ── polymorphic (subject_type + subject_id)
                 Can reference: Bug, Project, User, Comment
```

---

## 4. Role-Based Access Control (RBAC)

The system implements a custom role-based authorization mechanism using a `RoleMiddleware` class.

### Roles & Permissions

| Feature | Admin | Developer | Tester |
|---|:---:|:---:|:---:|
| View Dashboard | ✅ | ✅ | ✅ |
| View Projects | ✅ | ✅ | ✅ |
| Create/Edit/Delete Projects | ✅ | ❌ | ❌ |
| View Bugs | ✅ | ✅ | ✅ |
| Create/Report Bugs | ✅ | ❌ | ✅ |
| Edit/Update Bugs | ✅ | ✅ | ❌ |
| Delete Bugs | ✅ | ❌ | ❌ |
| Add Comments | ✅ | ✅ | ✅ |
| Manage Users | ✅ | ❌ | ❌ |
| Edit Own Profile | ✅ | ✅ | ✅ |

### How It Works

1. **RoleMiddleware** (`app/Http/Middleware/RoleMiddleware.php`) intercepts route requests.
2. It accepts one or more role names as arguments (e.g., `role:admin,tester`).
3. It calls the `User::hasRole()` method which checks if the authenticated user's role name matches any of the provided roles.
4. If the user lacks the required role, a **403 Forbidden** error is returned.
5. The middleware is registered as an alias `'role'` in `bootstrap/app.php`.

### Bug Visibility Scoping

- **Admin**: Sees all bugs from all projects.
- **Developer**: Sees only bugs assigned to them.
- **Tester**: Sees only bugs they have reported.

---

## 5. Project Flow

### 5.1 Authentication Flow

```
User visits / (root URL)
    │
    ▼
Redirected to /login
    │
    ├── Has account? → Enter email + password → POST /login
    │       │
    │       ├── Valid credentials → Redirect to /dashboard
    │       └── Invalid → Show error, stay on login
    │
    └── No account? → Click "Register" → GET /register
            │
            ▼
        Fill name, email, password → POST /register
            │
            ▼
        Account created → Redirect to /dashboard
```

**Purpose:** Ensures only authenticated users can access the system. Laravel Breeze handles all authentication logic including password hashing, session management, CSRF protection, and "remember me" functionality.

### 5.2 Dashboard Flow

```
GET /dashboard
    │
    ▼
DashboardController@index
    │
    ├── Retrieve aggregate statistics (total users, projects, bugs)
    ├── Count bugs by status (open, in-progress, fixed, closed)
    ├── Group bugs by priority and severity
    ├── Fetch project-wise bug counts
    ├── Fetch 5 most recent bugs with relationships
    └── Fetch 10 most recent activity log entries
    │
    ▼
Render dashboard/index.blade.php
    │
    ├── Display stat cards (total counts)
    ├── Render Chart.js charts (4 charts)
    ├── Show recent bugs table
    └── Show recent activity timeline
```

**Purpose:** Provides a centralized overview of the entire system. Admins get full visibility; developers and testers see relevant data. Charts offer visual analytics for quick decision-making.

### 5.3 User Management Flow (Admin Only)

```
GET /users ──────────────────────── List all users with roles
    │
    ├── GET /users/create ──────── Show create user form
    │       │
    │       └── POST /users ────── Validate (StoreUserRequest) → Create user → Log activity
    │
    ├── GET /users/{id}/edit ───── Show edit user form
    │       │
    │       └── PUT /users/{id} ── Validate (UpdateUserRequest) → Update user → Log activity
    │
    └── DELETE /users/{id} ──────── Delete user (prevent self-delete) → Log activity
```

**Purpose:** Admin manages team members — creates accounts for developers and testers, assigns roles, updates credentials, and removes users when needed.

### 5.4 Project Management Flow

```
GET /projects ───────────────────── List all projects (all roles)
    │
    ├── GET /projects/{id} ──────── View project details, members, bugs (all roles)
    │
    ├── GET /projects/create ────── Show create form (admin only)
    │       │
    │       └── POST /projects ──── Validate → Create project → Sync members → Log activity
    │
    ├── GET /projects/{id}/edit ─── Show edit form (admin only)
    │       │
    │       └── PUT /projects/{id} ─ Validate → Update → Sync members → Log activity
    │
    └── DELETE /projects/{id} ────── Delete project + cascade bugs (admin only) → Log activity
```

**Purpose:** Projects serve as containers for bugs. Admin creates projects, assigns team members (developers + testers), and manages the project lifecycle. All authenticated users can view projects and their details.

### 5.5 Bug Tracking Flow (Core Feature)

```
GET /bugs ──────────────────────────── List bugs with filters (role-scoped)
    │                                       │
    │                                  Filters: status, priority, severity,
    │                                           project, assignee, search
    │
    ├── GET /bugs/create ──────────────── Show create form (admin + tester)
    │       │
    │       └── POST /bugs ────────────── Validate (StoreBugRequest)
    │               │                         │
    │               ├── Upload screenshot     ├── Create bug record
    │               ├── Log activity          └── Send BugAssigned email
    │               └── Redirect to bug list
    │
    ├── GET /bugs/{id} ────────────────── View bug details + comments (all roles)
    │       │
    │       └── POST /bugs/{id}/comments ── Add comment → Send email to reporter & assignee
    │
    ├── GET /bugs/{id}/edit ───────────── Show edit form (admin + developer)
    │       │
    │       └── PUT /bugs/{id} ────────── Validate (UpdateBugRequest)
    │               │
    │               ├── Update bug fields
    │               ├── Handle screenshot upload/removal
    │               ├── If status changed → Send BugStatusChanged email
    │               ├── If assignee changed → Send BugAssigned email
    │               └── Log activity
    │
    └── DELETE /bugs/{id} ─────────────── Delete bug + screenshot (admin only) → Log activity
```

**Purpose:** The core module of the system. Testers report bugs with details (title, description, priority, severity, screenshot). Developers update bug status as they work on fixes. Admins have full control. Every status change and assignment triggers email notifications to keep the team informed.

### 5.6 Comment Flow

```
User viewing bug details (GET /bugs/{id})
    │
    ▼
Fill comment text → POST /bugs/{id}/comments
    │
    ├── Validate via StoreCommentRequest
    ├── Create comment record
    ├── Log activity: 'comment_added'
    ├── If commenter ≠ reporter → Send NewCommentAdded email to reporter
    ├── If commenter ≠ assignee → Send NewCommentAdded email to assignee
    └── Redirect back to bug detail page
```

**Purpose:** Enables team collaboration on bugs. Developers can ask clarifying questions, testers can provide additional context, and admins can add instructions. Email notifications ensure stakeholders are alerted.

### 5.7 Profile Management Flow

```
GET /profile ──────────────── Show profile edit form
    │
    ├── PATCH /profile ────── Update name & email (ProfileUpdateRequest)
    ├── PUT /password ─────── Update password (PasswordController)
    └── DELETE /profile ───── Delete own account (with password confirmation)
```

**Purpose:** Allows every user to manage their own account details without admin intervention.

---

## 6. Module-Wise Breakdown

### Controllers (5 Custom + 6 Breeze Auth)

| Controller | Methods | Purpose |
|---|---|---|
| `DashboardController` | `index` | Aggregates statistics and chart data for the dashboard view. |
| `UserController` | `index`, `create`, `store`, `edit`, `update`, `destroy` | Full CRUD operations for user management. Admin-only access. |
| `ProjectController` | `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` | Full CRUD for projects with team member synchronization. |
| `BugController` | `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` | Full CRUD for bugs with filtering, screenshot handling, and email notifications. |
| `CommentController` | `store` | Creates comments on bugs and notifies relevant users. |

### Form Request Classes (8 Custom)

| Form Request | Validates | Key Rules |
|---|---|---|
| `StoreUserRequest` | User creation | `name` required, `email` unique, `password` min:8 confirmed, `role_id` exists in roles |
| `UpdateUserRequest` | User update | Same as store but `email` unique ignoring current user, `password` optional |
| `StoreProjectRequest` | Project creation | `name` required unique, `description` required, `status` in active/inactive, `members` array of user IDs |
| `UpdateProjectRequest` | Project update | Same as store but `name` unique ignoring current project |
| `StoreBugRequest` | Bug creation | `title` required, `project_id` exists, `priority`/`severity`/`status` must be valid enum values, `screenshot` image max:2048KB |
| `UpdateBugRequest` | Bug update | Same as store with optional screenshot |
| `StoreCommentRequest` | Comment creation | `body` required string |
| `UpdateProfileRequest` | Profile update | `name` required, `email` unique ignoring current user |

### Models (6)

| Model | Table | Key Features |
|---|---|---|
| `User` | `users` | belongsTo Role, hasMany Bugs/Comments/ActivityLogs. Helper methods: `isAdmin()`, `isDeveloper()`, `isTester()`, `hasRole(...$roles)` |
| `Role` | `roles` | hasMany Users. Simple model with `name` attribute. |
| `Project` | `projects` | belongsTo creator (User), belongsToMany members (User via pivot), hasMany Bugs. |
| `Bug` | `bugs` | belongsTo Project/Reporter/Assignee (User), hasMany Comments. Accessors: `status_label`, `priority_label`, `severity_label` for display formatting. |
| `Comment` | `comments` | belongsTo Bug, belongsTo User. |
| `ActivityLog` | `activity_logs` | belongsTo User, morphTo subject (polymorphic — can point to Bug, Project, User, or Comment). |

### Views (~20+ Blade Files)

| View Path | Purpose |
|---|---|
| `layouts/app.blade.php` | Main authenticated layout with sidebar navigation, navbar, and content area. |
| `layouts/auth.blade.php` | Minimal centered layout for login/register pages. |
| `layouts/partials/sidebar.blade.php` | Sidebar navigation with role-based menu items. |
| `layouts/partials/navbar.blade.php` | Top navbar with user dropdown (profile, logout). |
| `layouts/partials/alerts.blade.php` | Flash message display (success/error alerts). |
| `auth/login.blade.php` | Login form with email and password fields. |
| `auth/register.blade.php` | Registration form with name, email, password. |
| `dashboard/index.blade.php` | Dashboard with stat cards, Chart.js charts, recent bugs table, activity log. |
| `users/index.blade.php` | Users list table with actions (edit, delete). |
| `users/create.blade.php` | Create user form with role dropdown. |
| `users/edit.blade.php` | Edit user form. |
| `projects/index.blade.php` | Projects list with bug counts and status badges. |
| `projects/create.blade.php` | Create project form with multi-select members. |
| `projects/edit.blade.php` | Edit project form. |
| `projects/show.blade.php` | Project detail view showing members and bugs. |
| `bugs/index.blade.php` | Bugs list with filter sidebar (status, priority, severity, project, search). |
| `bugs/create.blade.php` | Create bug form with screenshot upload. |
| `bugs/edit.blade.php` | Edit bug form with screenshot management. |
| `bugs/show.blade.php` | Bug detail view with comments section and comment form. |
| `profile/edit.blade.php` | Profile editing with password change section. |
| `errors/404.blade.php` | Custom 404 not found page. |
| `emails/bug-assigned.blade.php` | Email template for bug assignment notifications. |
| `emails/bug-status-changed.blade.php` | Email template for status change notifications. |
| `emails/new-comment-added.blade.php` | Email template for new comment notifications. |

---

## 7. Email Notification System

The application uses **3 Mailable classes** to send notifications:

| Mailable | Trigger | Recipient | Content |
|---|---|---|---|
| `BugAssigned` | When a bug is assigned to a developer (on create or reassignment) | The assigned developer | Bug title, project name, priority, severity, reporter name |
| `BugStatusChanged` | When a bug's status is updated (e.g., open → in_progress) | The bug reporter | Bug title, old status, new status, who changed it |
| `NewCommentAdded` | When a comment is posted on a bug | Reporter and assignee (excluding the commenter) | Bug title, commenter name, comment text |

### Mail Configuration

- **Driver:** `log` (development mode — emails are written to `storage/logs/laravel.log` instead of being actually sent)
- **Production-ready:** Can be switched to SMTP, Mailgun, SES, etc. by updating `.env` variables

---

## 8. Activity Logging

The `ActivityLogService` provides centralized audit logging for all significant user actions.

### Logged Actions

| Action | When Logged | What's Recorded |
|---|---|---|
| `user_created` | Admin creates a new user | User details |
| `user_updated` | Admin edits a user | User details |
| `user_deleted` | Admin deletes a user | User details |
| `project_created` | Admin creates a project | Project details |
| `project_updated` | Admin updates a project | Project details |
| `project_deleted` | Admin deletes a project | Project details |
| `bug_created` | Tester/Admin creates a bug | Bug details |
| `bug_assigned` | Bug is assigned to developer | Bug details |
| `bug_updated` | Developer/Admin updates a bug | Bug details |
| `bug_deleted` | Admin deletes a bug | Bug details |
| `comment_added` | Any user adds a comment | Bug details |

### How It Works

```php
ActivityLogService::log('bug_created', "Bug '{$bug->title}' was created.", $bug);
```

- Stores the `user_id` of the authenticated user (who performed the action).
- Stores the `action` name (string identifier).
- Stores a human-readable `description`.
- Uses **polymorphic relationship** (`subject_type` + `subject_id`) to link the log entry to the related model (Bug, Project, User, etc.).
- Displayed on the Dashboard in the "Recent Activity" timeline section.

---

## 9. File & Directory Structure

```
bug-tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Breeze authentication controllers
│   │   │   ├── BugController.php        # Bug CRUD + filtering + emails
│   │   │   ├── CommentController.php    # Comment creation + emails
│   │   │   ├── DashboardController.php  # Dashboard statistics
│   │   │   ├── ProjectController.php    # Project CRUD + member sync
│   │   │   └── UserController.php       # User CRUD (admin only)
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php       # Custom role-based authorization
│   │   └── Requests/
│   │       ├── StoreBugRequest.php
│   │       ├── StoreCommentRequest.php
│   │       ├── StoreProjectRequest.php
│   │       ├── StoreUserRequest.php
│   │       ├── UpdateBugRequest.php
│   │       ├── UpdateProfileRequest.php
│   │       ├── UpdateProjectRequest.php
│   │       └── UpdateUserRequest.php
│   ├── Mail/
│   │   ├── BugAssigned.php              # Email: bug assigned notification
│   │   ├── BugStatusChanged.php         # Email: status changed notification
│   │   └── NewCommentAdded.php          # Email: new comment notification
│   ├── Models/
│   │   ├── ActivityLog.php
│   │   ├── Bug.php
│   │   ├── Comment.php
│   │   ├── Project.php
│   │   ├── Role.php
│   │   └── User.php
│   ├── Providers/
│   │   └── AppServiceProvider.php       # Schema::defaultStringLength(191)
│   └── Services/
│       └── ActivityLogService.php       # Centralized activity logging
├── bootstrap/
│   └── app.php                          # Middleware alias registration
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_01_01_000001_create_roles_table.php
│   │   ├── 2025_01_01_000002_add_role_id_to_users_table.php
│   │   ├── 2025_01_01_000003_create_projects_table.php
│   │   ├── 2025_01_01_000004_create_project_user_table.php
│   │   ├── 2025_01_01_000005_create_bugs_table.php
│   │   ├── 2025_01_01_000006_create_comments_table.php
│   │   └── 2025_01_01_000007_create_activity_logs_table.php
│   └── seeders/
│       ├── ActivityLogSeeder.php
│       ├── BugSeeder.php
│       ├── CommentSeeder.php
│       ├── DatabaseSeeder.php           # Orchestrates all seeders
│       ├── ProjectSeeder.php
│       ├── RoleSeeder.php
│       └── UserSeeder.php
├── resources/views/
│   ├── auth/                            # Login, Register views
│   ├── bugs/                            # Bug CRUD views
│   ├── dashboard/                       # Dashboard view
│   ├── emails/                          # Email templates
│   ├── errors/                          # Custom error pages
│   ├── layouts/                         # Layout templates + partials
│   ├── profile/                         # Profile edit view
│   ├── projects/                        # Project CRUD views
│   └── users/                           # User CRUD views
├── routes/
│   ├── web.php                          # All application routes
│   └── auth.php                         # Breeze authentication routes
├── storage/app/public/screenshots/      # Bug screenshot uploads
├── .env                                 # Environment configuration
├── composer.json                        # PHP dependencies
└── README.md                            # Project setup guide
```

---

## 10. Default Credentials

| Role | Name | Email | Password |
|---|---|---|---|
| **Admin** | Admin User | admin@bugtracker.com | password |
| **Developer** | John Developer | dev1@bugtracker.com | password |
| **Developer** | Jane Developer | dev2@bugtracker.com | password |
| **Tester** | Alice Tester | tester1@bugtracker.com | password |
| **Tester** | Bob Tester | tester2@bugtracker.com | password |

---

## 11. Setup Instructions

```bash
# 1. Clone or navigate to the project directory
cd d:\wamp64\www\projects\ashish\bug-tracker

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and generate application key
cp .env.example .env
php artisan key:generate

# 4. Configure .env (set database credentials)
# DB_DATABASE=bug_tracker
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Create the database in MySQL
# CREATE DATABASE bug_tracker;

# 6. Run migrations and seed sample data
php artisan migrate --seed

# 7. Create storage symbolic link (for screenshot uploads)
php artisan storage:link

# 8. Start the development server
php artisan serve
# Application available at: http://127.0.0.1:8000
```

---

*This audit report documents all technologies, their purpose, and the complete project flow of the Bug Tracker System.*
