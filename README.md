# Task Manager

A full-stack Task Manager web application built with PHP and MySQL. Features a public landing page, a complete authentication system with session management, and a clean, responsive UI.



## Features
- Public landing page introducing the app
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
5. Copy `config.example.php` to `config.php` and fill in your local database details:
```bash
cp config.example.php config.php
```
Then edit `config.php` with your actual database host, name, username, and password. (This file is gitignored and won't be committed.)
6. Open your browser and go to: http://localhost/task-manager/index.php

## Project Structure

task-manager/

├── config.example.php  # Database connection template (safe to share)

├── config.php           # Your real DB credentials (gitignored, not in repo)

├── index.php             # Public landing page

├── dashboard.php         # Main task dashboard (requires login)

├── login.php             # Login page

├── register.php          # Registration page

├── logout.php            # Handles logout

├── add_task.php          # Handles adding new tasks

├── complete_task.php     # Handles marking tasks complete

├── delete_task.php       # Handles deleting tasks

├── style.css              # Dashboard/auth page styling

├── landing.css            # Landing page styling

└── .gitignore             # Excludes config.php and other local files

## Author
[suhaibyaseenn](https://github.com/suhaibyaseenn)