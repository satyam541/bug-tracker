# Bug Tracker System

A comprehensive Bug Tracker System built with Laravel, Blade, and Bootstrap 5 for managing software bugs across projects with role-based access control.

## Features

- **Authentication** - Login, Register, Logout (Laravel Breeze)
- **Role-Based Access Control** - Admin, Developer, Tester with different permissions
- **Dashboard** - Analytics with Chart.js (status, priority, severity, project-wise charts)
- **Project Management** - CRUD with team member assignment
- **Bug Tracking** - Full lifecycle (Open -> In Progress -> Fixed -> Closed)
- **Comments** - Threaded comments on bugs
- **Screenshot Upload** - Attach screenshots to bug reports
- **Activity Logs** - Track all user actions
- **Email Notifications** - Bug assignment, status change, new comments
- **Filters and Search** - Filter bugs by status, priority, severity, project

## Tech Stack

- **Backend:** Laravel 13.x (PHP 8.2+)
- **Frontend:** Blade Templates + Bootstrap 5.3
- **Database:** MySQL
- **Charts:** Chart.js 4.x
- **Icons:** Bootstrap Icons
- **Auth:** Laravel Breeze

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- WAMP/XAMPP/MAMP (or any local server)

### Steps

1. **Install dependencies**
   ```
   composer install
   ```

2. **Environment setup**
   ```
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure database in .env**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bug_tracker
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Create the database**
   ```
   CREATE DATABASE bug_tracker;
   ```

5. **Run migrations and seeders**
   ```
   php artisan migrate --seed
   ```

6. **Create storage link**
   ```
   php artisan storage:link
   ```

7. **Start the server**
   ```
   php artisan serve
   ```

8. **Visit** http://localhost:8000

## Default Login Credentials

| Role      | Email                  | Password  |
|-----------|------------------------|-----------|
| Admin     | admin@bugtracker.com   | password  |
| Developer | dev1@bugtracker.com    | password  |
| Developer | dev2@bugtracker.com    | password  |
| Tester    | tester1@bugtracker.com | password  |
| Tester    | tester2@bugtracker.com | password  |

## User Roles and Permissions

| Feature           | Admin | Developer | Tester |
|-------------------|-------|-----------|--------|
| Dashboard         | Yes   | Yes       | Yes    |
| Manage Users      | Yes   | No        | No     |
| Create Projects   | Yes   | No        | No     |
| Edit Projects     | Yes   | No        | No     |
| Delete Projects   | Yes   | No        | No     |
| View Projects     | Yes   | Yes       | Yes    |
| Report Bugs       | Yes   | No        | Yes    |
| Edit Bugs         | Yes   | Yes       | No     |
| Delete Bugs       | Yes   | No        | No     |
| View Bugs         | Yes   | Yes       | Yes    |
| Add Comments      | Yes   | Yes       | Yes    |

## Database Schema

- **roles** - id, name
- **users** - id, name, email, password, role_id
- **projects** - id, name, description, status, created_by
- **project_user** - project_id, user_id (pivot)
- **bugs** - id, title, description, project_id, reporter_id, assigned_to, status, priority, severity, screenshot
- **comments** - id, bug_id, user_id, body
- **activity_logs** - id, user_id, action, description, subject_type, subject_id

## License

This project is for educational purposes (college project submission).
