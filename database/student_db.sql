
CREATE DATABASE IF NOT EXISTS student_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE student_db;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (name, email, course)
VALUES
    ('Kamal Perera', 'kamal@example.com', 'Computer Science'),
    ('Nimal Silva', 'nimal@example.com', 'Software Engineering');
