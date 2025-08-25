# Smart-Tasks API

## Objective
This project is a **Laravel-based RESTful API** for managing tasks in a team environment. It provides a secure, scalable, and well-structured API for task creation, assignment, tracking, and status management while following clean code principles, caching, validation, and authenticated access.

---

## ✅ Features

### 📝 Task Management:
- **Task CRUD**:
    - Create, read, update, and delete tasks.
    - Tasks include `title`, `description`, `status`, `owner_id`,`assigned_to` and `status`.
    - Supports **soft deletes** and **timestamps**.
- **Task Assignment & Status Updates**:
    - Assign tasks to users.
    - Update task status (`pending`, `in_progress`, `completed`, etc.).
    - Tasks can have audit trails for status changes.

### 🔍 Searching, Filtering & Pagination:
- Filter by `status_id`, `assigned_to`, `title`, or `owner_id`.
- Sort tasks by `id`, `title`, `updated_at`, or `created_at`.
- Supports **cursor and offset pagination**.

### 🛡️ Security:
- JWT-based authentication using **Laravel Sanctum**.
- Middleware to protect API endpoints.
- Input validation and sanitization for all requests.
- Secure storage of secrets via `.env` file.

### ⚡ Performance Optimization:
- Uses **eager loading** to prevent N+1 queries.
- Frequently accessed data is cached using Laravel cache.
- Optimized database queries with proper indexing.

### 🧪 Testing:
- **Unit tests** for models and services.
- **Feature tests** for API endpoints.
- Factories and mock data for consistent testing.
- Test coverage report included.

---

## 🗂️ API Endpoints

| Method | Endpoint | Description                                |
|--------|---------|--------------------------------------------|
| POST   | `/api/v1/auth/register` | User registration                     |
| POST   | `/api/v1/auth/login`    | User login                            |
| POST   | `/api/v1/auth/logout`   | User logout                           |
| GET    | `/api/v1/tasks`         | List tasks with filters & pagination |
| GET    | `/api/v1/tasks/{id}`    | Get task details                      |
| POST   | `/api/v1/tasks`         | Create a new task                     |
| PUT    | `/api/v1/tasks/{id}`    | Update a task                         |
| DELETE | `/api/v1/tasks/{id}`    | Soft delete a task                     |
| PATCH  | `/api/v1/tasks/{id}/status` | Update task status                  |
| PATCH  | `/api/v1/tasks/{id}/assign` | Assign task to a user               |

---

## 🗃️ Tech Stack

- **Framework**: Laravel 12 (latest stable)
- **Database**: MySQL 8 / PostgreSQL 15
- **Authentication**: Laravel Sanctum (JWT)
- **Design Pattern**: Repository-Service Pattern
- **Caching**: Laravel Cache (Redis optional)
- **Testing**: PHPUnit with factories & mocks
- **Docker**: Optional setup for containerized development

---

## 🚀 Setup Instructions

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/anssrabie/smart-tasks-api
   ```

2. **Navigate into the project folder**:
   ```bash
   cd smart-tasks-api
   ```

3. **Install dependencies**:
   ```bash
   composer install
   ```

4. **Environment setup**:
   ```bash
   cp .env.example .env
   ```

5. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

6. **Set up the database**:
    - Update your `.env` file with your database credentials.
    - Run the migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Run the application**:
   ```bash
   php artisan serve
   ```
--------------------


### Installation with Docker
1. **Clone the repository**:
   ```bash
   git clone https://github.com/anssrabie/smart-tasks-api

2. **Navigate to the project folder**:
   ```bash
   cd api-workflow

3. **Build the Docker containers: If you don't have Docker installed, download and install it from [here](https://www.docker.com/)**:
   ```bash
   docker-compose up --build

4. **Access the application: The application will now be running at (http://localhost:8000). You can access it through the browser**:

---
## API Documentation

You can access the API documentation using either of the following:

- **Postman**: [Postman API Documentation](https://documenter.getpostman.com/view/47844787/2sB3HetNeQ)
- **Swagger**: The Swagger documentation is generated using **L5-Swagger**.

### To generate and view Swagger docs locally:
1. Run the command to generate Swagger JSON:
```bash
php artisan l5-swagger:generate
 ```
2. Go to:
```bash
http://127.0.0.1:8000/api/documentation
 ```
--------------------

---
## 🧪 Test Results & Coverage

This project includes **unit and feature tests** using PHPUnit.  

### Run tests:
```bash
php artisan test
 ```

### Run tests with coverage report:
```bash
php artisan test --coverage
 ```
