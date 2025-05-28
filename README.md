# 🗓️ Content Scheduler – Laravel 11

A modern content scheduling platform built with Laravel 11 that allows users to create, manage, and schedule posts across multiple platforms like Twitter, Instagram, LinkedIn, and more.

---

## 🚀 Features

### ✅ Core Functionality

- 🔐 User authentication (Laravel Sanctum)
- 📝 Create, update, and delete posts with:
  - Title, content, image upload
  - Platform selection (multi-select)
  - Scheduled publishing
  - Status: `draft`, `scheduled`, `published`
- 📆 Schedule posts for future publishing
- 🔁 Laravel queue job to process due posts
- 🧪 Per-platform content validation (e.g., character limits)
- 🔄 Rate limiting: max 10 scheduled posts per user/day
- 📝 Activity log (via `spatie/laravel-activitylog`)

---

## ⚙️ Tech Stack

- Laravel 11.x
- Sanctum for API authentication
- Spatie Activity Log
- Redis (via Predis)
- Laravel Queues & Scheduler
- SQLite / MySQL (via XAMPP)
- Postman (for API testing)

---

## 🖥️ Setup Instructions

### 1️⃣ Requirements

- PHP ^8.2
- Composer
- Node.js & npm
- Redis Server
- XAMPP (or any MySQL server)
- Laravel CLI
- Postman (for API testing)

---

### 2️⃣ Installation Steps

```bash
# Clone the repository
git clone https://github.com/mahmoudroz/task-PGetPayIn.git
cd task-PGetPayIn

# Install backend dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Migration and Seeders
php artisan migrate --seed

# import postman collection from root project

# run
php artisan serve 

Explanation of Approach and Trade-offs
Approach
Built the API using Laravel 11 with Sanctum for simple and secure user authentication.

Used a pivot table to link posts with multiple platforms, allowing flexible multi-platform scheduling.

Scheduled post publishing using Laravel Jobs dispatched by the Scheduler to ensure timely, asynchronous processing without blocking user requests.

Integrated spatie/laravel-activitylog to track user activities and maintain an audit log.

Trade-offs
Did not implement real API integration with social platforms (Twitter, Instagram, etc.); publishing is mocked to simplify development and testing.

Frontend UI and dashboard features were skipped due to time constraints, focusing mainly on backend functionality.


Chose a simple MVC architecture over more complex patterns like Domain-Driven Design to speed up development and keep the codebase easy to understand and maintain.

Implemented software design patterns such as the Repository Pattern to separate data access logic, making it easier to modify the data source (e.g., switching databases) without affecting other parts of the application.

Used the Service Layer Pattern to organize business logic outside of controllers, improving maintainability and testability.

Applied Dependency Injection to enhance scalability and facilitate unit testing.

These design patterns helped create clean, reusable, and easy-to-understand code that can be maintained and extended by the development team efficiently.
