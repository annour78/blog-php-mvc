# MyBlog - PHP MVC Blog Application

A full-featured blog application built with pure PHP using the MVC architectural pattern.

## Technologies Used

- PHP 8.2
- MySQL / MariaDB
- HTML5 / CSS3
- XAMPP (Apache + MySQL)
- PDO for database connection

## Features

- User registration and login system
- Role-based access control (Admin / User)
- Create, Read, Update, Delete (CRUD) posts
- Category management
- Comment system
- Protection against SQL Injection, XSS and CSRF
- Responsive design

## Project Structure
```
blog/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── PostController.php
│   │   └── CommentController.php
│   ├── models/
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Category.php
│   │   └── Comment.php
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── posts/
│       └── admin/
├── config/
│   └── database.php
├── core/
│   ├── Router.php
│   ├── Controller.php
│   ├── Model.php
│   └── Database.php
├── public/
│   ├── index.php
│   ├── css/
│   └── uploads/
├── .htaccess
└── README.md
```

## MVC Architecture

- **Model** — Handles database interactions (PDO)
- **View** — Renders HTML pages dynamically
- **Controller** — Manages request handling and business logic

## Installation & Setup

### Requirements
- XAMPP (Apache + MySQL)
- PHP 8.0 or higher

### Steps

1. Clone or download the project into your XAMPP htdocs folder:
```
C:\xampp\htdocs\blog
```

2. Start **Apache** and **MySQL** in XAMPP Control Panel

3. Open your browser and go to:
```
http://localhost/phpmyadmin
```

4. Create the database by running the SQL file provided

5. Open your browser and go to:
```
http://localhost/blog/public/
```

## Default Admin Account

- **Email:** admin@blog.com
- **Password:** password

## Database Structure

- **users** — stores user accounts and roles
- **posts** — stores blog articles
- **categories** — stores post categories
- **comments** — stores user comments

## Security

- Passwords hashed with bcrypt
- PDO prepared statements (SQL injection protection)
- htmlspecialchars() for XSS protection
- Session-based authentication
- Role-based middleware (admin/user)

## Author

- Developed as part of the MVC Web Application Development course
- Instructor: Bartosz Popławski