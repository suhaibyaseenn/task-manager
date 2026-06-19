# Task Manager

A full-stack Task Manager web application built with PHP and MySQL. Features a complete authentication system with session management and a clean responsive UI.

## 🌐 Live Demo
[https://suhaibtasks.infinityfreeapp.com/login.php](https://suhaibtasks.infinityfreeapp.com/login.php)

## Features
- User registration and login system
- Password hashing for security
- Session management
- Add new tasks with title and description
- View all tasks in a clean UI
- Mark tasks as completed
- Delete tasks
- Each user sees only their own tasks
- Responsive and modern design

## Technologies Used
- PHP
- MySQL
- HTML
- CSS
- XAMPP (local server)
- Git/GitHub

## 🌐 Online Access
Visit the live site directly at:  https://suhaibtasks.infinityfreeapp.com/login.php

- Register a new account
- Login and start managing your tasks

## 💻 How to Run Locally
1. Install XAMPP
2. Clone this repository into your `htdocs` folder:
```bash
git clone https://github.com/suhaibyaseenn/task-manager.git
```
3. Open phpMyAdmin and create a database called `task_manager`
4. Run this SQL query to create the tables:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
5. Update `config.php` with your local database details:
```php
$host = 'localhost';
$dbname = 'task_manager';
$username = 'root';
$password = '';
```
6. Open your browser and go to: http://localhost/task-manager/login.php

## Project Structure

task-manager/

├── config.php        # Database connection

├── index.php         # Main page - displays all tasks

├── login.php         # Login page

├── register.php      # Registration page

├── logout.php        # Handles logout

├── add_task.php      # Handles adding new tasks

├── complete_task.php # Handles marking tasks complete

├── delete_task.php   # Handles deleting tasks

└── style.css         # Styling

## Author
[suhaibyaseenn](https://github.com/suhaibyaseenn)