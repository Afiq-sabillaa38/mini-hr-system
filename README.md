# Mini HR System (Laravel)

## Description
A full-stack HR Management System built using Laravel.  
This project demonstrates employee management, payroll calculation, file handling, and REST API integration with authentication.

---

## 🚀 Live Demo

👉 https://mini-hr-system-production.up.railway.app

---

## 🔑 Demo Accounts

### Admin
- Email: admin@example.com  
- Password: password123  

### Employee
- Email: employee@example.com  
- Password: password123  

---

## 🚀 Features

### 🔐 Authentication
- Login for Admin and Employee
- Role-based access control using middleware

---

### 👨‍💼 Employee Management (Admin)
- Create, view employees
- Fields:
  - Name
  - Email
  - Position
  - Basic Salary
  - Join Date

---

### 💰 Payroll System

#### Salary Deduction Logic
- Unpaid Leave:
basic_salary / 26 × unpaid_leave_days
- Late Deduction:
RM2 per minute AFTER 30 minutes grace
- EPF:
11% from (basic_salary - unpaid_leave_deduction)
- SOCSO & EIS:
- Based on Malaysia standard rates (hardcoded)

#### Output
- Stores payroll record
- Returns breakdown:
- EPF
- SOCSO
- EIS
- Total deductions
- Net salary

---

### 📅 Leave Management
- Apply leave with:
- leave_type
- start_date
- end_date
- reason
- attachment (optional)
- Auto-calculates total days (exclude weekends)
- Annual leave balance: 14 days
- Status flow:
Pending → Approved → Rejected

---

### 🧾 Claims Module
- Submit claim:
- title
- amount
- category
- receipt upload (JPG/PNG/PDF)
- Admin can approve/reject with remarks

---

### 📊 Dashboard

#### Admin:
- Total employees
- Pending leaves
- Pending claims
- Total salary payout (monthly)

#### Employee:
- Leave balance
- Latest payslip
- Pending claims

---

### 📄 Payslip System
- Employee can view:
- Payslip history
- Detailed salary breakdown (EPF, SOCSO, etc.)

---

## 🌐 API (Sanctum Authentication)

**Base URL:**  
👉 https://mini-hr-system-production.up.railway.app/api/v1  

---

### Endpoints

#### 🔐 Auth
- `POST /login`
- `POST /logout`

#### 📌 Core APIs
- `GET /employees`
- `POST /leave/apply`
- `GET /payslip/{employee_id}/{month}`

---

## 🔑 API Authentication

All protected endpoints require:
Authorization: Bearer {token}

---

## 🧪 API Testing (Postman)

### 1. Login
```http
POST /api/v1/login
```

Body:
{
  "email": "admin@example.com",
  "password": "password123"
}

2. Get Employees
GET /api/v1/employees
Header:

Authorization: Bearer {token}

3. Apply Leave
POST /api/v1/leave/apply

Body:

{
  "leave_type": "Annual Leave",
  "start_date": "2026-05-10",
  "end_date": "2026-05-11",
  "reason": "Family matter"
}

4. Get Payslip
GET /api/v1/payslip/{employee_id}/{month}

Example:

GET /api/v1/payslip/3/2026-04

🧪 Testing
php artisan test

Includes:

Payroll calculation tests (3+ scenarios)
Authentication tests
Profile tests

⚙️ Installation
git clone https://github.com/Afiq-sabillaa38/mini-hr-system.git
cd mini-hr-system

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate --seed

php artisan serve
npm run dev

🧱 Tech Stack
Laravel 10+
MySQL (Railway)
Blade (UI)
Tailwind CSS
Laravel Sanctum
📌 Assumptions
26 working days per month
Late penalty after 30 minutes/month
SOCSO & EIS simplified (hardcoded)
One payslip per employee per month
👨‍💻 Author

Afiq Shahrir