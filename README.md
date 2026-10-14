# Student Management REST API

A beginner friendly REST API built using PHP, PDO and MySQL.

## Features

- Retrieve all students
- Add a student
- Update a student
- Delete a student
- JSON request and response handling
- Input validation
- Prepared statements using PDO
- HTTP status codes and error handling

## Technologies

- PHP
- PDO
- MySQL
- XAMPP
- Postman
- Git and GitHub

## Local setup

1. Install XAMPP.
2. Start Apache and MySQL.
3. Create the database and students table by importing the provided `database/student_db.sql` file into phpMyAdmin.
4. Configure the database connection in `backend/db.php`.
5. Place the project inside `C:\xampp\htdocs\student-api`.
6. Open the API at `http://localhost/student-api/backend/get_students.php`.

## API endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/backend/get_students.php` | Retrieve students |
| POST | `/backend/add_students.php` | Add a student |
| PUT | `/backend/update_students.php` | Update a student |
| DELETE | `/backend/delete_students.php` | Delete a student |

## Learning goals

This project demonstrates basic REST API development, SQL database operations, prepared statements, JSON encoding and decoding and HTTP request handling.