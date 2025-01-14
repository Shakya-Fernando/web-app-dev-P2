
Project for University Course Web Application Development
=======
# 2703ICT - Assignment 2: Peer Review Web Application

## Overview
This project is a web application developed as part of the **2703ICT** coursework to facilitate a streamlined peer review process for students. It allows students to register, submit peer reviews, and access their received reviews, while also enabling teachers to manage courses, assessments, and the peer review process effectively.

### Key Features

#### User Authentication
- Students can register with their name, email, and S-number.
- Teachers are pre-seeded into the database for testing purposes.
- Users log in with their S-number and password.
- A logged-in user's name and role (teacher or student) are displayed at the top of every page.

#### User Roles
- **Students:**
  - View courses they are enrolled in.
  - Submit and view peer reviews.
- **Teachers:**
  - Manage courses and assessments.
  - Enrol students in courses.
  - Assign scores to students based on peer reviews.

#### Course and Assessment Management
- Students and teachers can view course details, including enrolled students and assessments.
- Teachers can add, update, and delete assessments (updates restricted if submissions exist).
- Teachers can upload course information via a text file, creating new courses with provided details.

#### Peer Review Process
- **Student-Select Reviews:**
  - Students select their reviewees and submit reviews.
  - The system ensures no duplicate reviews for the same reviewee.
- **Teacher-Assign Reviews:**
  - Teachers can randomly assign peer review groups to students.

#### Pagination
- Assessment marking pages for teachers are paginated, with a maximum of 10 students per page.

#### Validation and Security
- Proper server-side input validation.
- Robust security measures.

### Technical Implementation
- **Framework:** Laravel (PHP)
- **Database:** Laravel migrations and ORM/Eloquent used for database operations.
- **Key Components:**
  - Migrations, seeders, models, controllers, routes, views, and templating.
  - Comprehensive validation for user input.
  - Secure user authentication.

### Initial Data
To test the application, the following data is pre-seeded into the database:
- 5 Teachers
- 5 Courses
- 5 Assessments
- 50 Students (with course enrolments)

### Usage Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/your-github-username/2703ICT-Assignment2.git
   ```
2. Navigate to the project directory (current):
   ```bash
   cd 2703ICT-Assignment2
   ```
3. Install dependencies:
   ```bash
   composer install
   npm install
   ```
4. Set up the database:
   - Configure `.env` file with database credentials.
   - Run migrations and seeders:
     ```bash
     php artisan migrate --seed
     ```
5. Start the server:
   ```bash
   php artisan serve
   ```
6. Access the application at `http://localhost:8000`.
=======
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>>>>>>> 5e2bf20 (Initial Commit)
