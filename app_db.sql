CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

CREATE TABLE IF NOT EXISTS todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('Pending', 'Completed') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO todos (title, description, status) VALUES
('Finish PHP Project', 'Complete the PHP and MySQL Todo List System.', 'Pending'),
('Review Database', 'Check the database connection and CRUD operations.', 'Completed');
