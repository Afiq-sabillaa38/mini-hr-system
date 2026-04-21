# Mini HR System (Laravel)

## Description
A simple full-stack HR Management System built using Laravel.  
This project demonstrates employee management, payroll calculation, and API integration.

---

## 🚀 Live Demo

👉 https://mini-hr-system-production.up.railway.app

## 🔑 Demo Accounts

Admin

Email: admin@example.com
Password: password123

Employee

Email: employee@example.com
Password: password123

##  🚀 Features

###  Authentication
- Login for Admin and Employee
- Role-based access control

---

###  Employee Management (Admin)
- Create and view employees
- Store:
  - Name
  - Email 
  - Position
  - Basic Salary
  - Join Date

---

###  Payroll System

#### Rules:
- Unpaid Leave Deduction:  
  `basic_salary / 26 × unpaid_leave_days`

- Late Deduction:  
  `RM2 per minute AFTER 30 minutes grace`

- EPF:  
  `11% from (basic_salary - unpaid_leave_deduction)`

- SOCSO & EIS:  
  Based on Malaysia standard rates (hardcoded)

---

###  Dashboard

#### Admin Dashboard:
- Total Employees
- Pending Leaves
- Pending Claims
- Total Basic Salary
- Total Net Salary (monthly)

#### Employee Dashboard:
- Leave Balance
- Latest Payslip Net Salary
- Pending Claims
- Profile Information

---

###  Payslip System
- Store payroll records
- Employee can view:
  - Payslip history
  - Monthly salary breakdown

---

## 🌐 API (Sanctum Authentication)

**Base URL:**  
http://127.0.0.1:8000/api/v1  

### Endpoints:
- POST `/login`
- POST `/logout`
- GET `/employees`
- POST `/leave/apply`
- GET `/payslip/{employee_id}/{month}`

---

##  🔐 API Authentication

Authorization: Bearer {token}


---

## 🧪 Testing
```bash
php artisan test
```

Includes:

Payroll calculation tests (3+ scenarios)
Authentication tests
Profile tests

## ⚙️ Installation
```bash
git clone https://github.com/Afiq-sabillaa38/mini-hr-system.git
cd mini-hr-system

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate --seed

php artisan serve
npm run dev
```

## 🧱 Tech Stack
- Laravel 10+
- MySQL
- Blade (UI)
- Tailwind CSS
- Laravel Sanctum

## 📌 Assumptions
- Salary working days = 26 days/month
- Late penalty applies after 30 minutes/month
- SOCSO & EIS are simplified (hardcoded)
- One payslip per employee per month

## 👨‍💻 Author

Afiq Shahrir