# Smart Tasks API

## Objective
The goal of this project is to build a **Laravel 12-based API** for managing tasks while ensuring clean code principles, security, and extensibility. The system allows assigning, tracking, and updating tasks efficiently.

---

## Features

### ✅ Task Management:
- **Create Task**: Accepts task details including title, description, status, owner, and assigned user.
- **Update Task**: Modify existing task details.
- **Delete Task**: Remove a task.
- **View Tasks**: Retrieve all tasks or filter by status (`pending`, `in_progress`, `completed`).

### ✅ Activity Logging:
- Tracks changes to **status** and **assigned_to** fields.
- Uses **Spatie Activitylog** package.
- Logs the user who performed the action or defaults to `System`.

### ✅ Business Rules:
- `owner_id` is automatically set to the authenticated user when creating a task.
- Tasks can optionally be assigned to another user (`assigned_to` can be `null`).

### ✅ API Design:
- Follows **RESTful principles**.
- Uses appropriate **HTTP methods & status codes**.
- Provides **pagination** for list endpoints.

### ✅ Authentication & Security:
- Uses **Sanctum authentication**.
- Includes endpoints for **user registration & login**.

### ✅ Validation & Error Handling:
- Ensures **all API inputs are validated**.
- Provides **meaningful error messages**.

### ✅ Testing:
- Unit and Feature tests for:
    - Task creation
    - Task updating
    - Assignment changes
    - Activity logging
    - Authentication

---

## Tech Stack
- **Framework**: Laravel 12
- **Database**: MySQL
- **Authentication**: Sanctum
- **Packages**:
    - `darkaonline/l5-swagger`
    - `spatie/laravel-activitylog`
    - `spatie/laravel-query-builder`
    - `laravel/tinker`

---

## Setup Instructions

### Requirements
- **PHP**: 8.2 or higher
- **MySQL**: 8.0 or higher
- **Composer**: 2.0 or higher

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/anssrabie/smart-tasks-api.git
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

---

## API Documentation (Swagger)

You can access the **Swagger API documentation** for this project using the following link:

[Swagger Documentation](#)

## Activity Logging

Uses **Spatie Activitylog**.

Tracks:

- `status` changes
- `assigned_to` changes

Logs the user performing the action or defaults to **System**.
## API Documentation (Postman)

You can access the **Postman API documentation** for this project using the following link:

[Postman API Documentation](https://documenter.getpostman.com/view/43547209/2sB2cPjkTu)

---


## Adding a New Payment Gateway

This project uses the **Strategy Pattern** for payment gateways, allowing easy integration of new payment methods.

### Steps to Add a New Payment Gateway:
1. **Create a New Payment Gateway Class**:
    - Inside `App\Services\Payments\Gateways`, create a new gateway class implementing `PaymentGatewayInterface`.

2. **Implement the Payment Logic**:
   ```php
   namespace App\Services\Payments\Gateways;

   class StripeGateway implements PaymentGatewayInterface
   {
       public function processPayment(float $amount): array
       {
           return [
            'status' => PaymentStatus::Pending->value,
            'payment_id' => 'stripe_' . uniqid(),
            'message' => 'Payment processed via Stripe',
            'method' => PaymentMethod::CreditCard->value,
           ];
       }
   }
   ```

3. **Register the New Gateway**:
    - Modify `PaymentGatewayFactory` to support the new gateway.
   ```php
   $gateway = match ($method) {
       'credit_card' => new CreditCardGateway(),
       'paypal' => new PayPalGateway(),
       'stripe' => new StripeGateway(), // New gateway
   };
   ```

---

## Testing

To run unit and feature tests, execute:
```bash
php artisan test
```

---

## Conclusion
This API is designed to be **secure, extensible, and easy to maintain**. By leveraging **design patterns**, clean coding practices, and robust authentication, it ensures smooth order and payment management.

