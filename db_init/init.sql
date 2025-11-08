CREATE DATABASE IF NOT EXISTS vulnerable_db;
USE vulnerable_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role VARCHAR(20) DEFAULT 'user',
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default users (weak passwords)
INSERT INTO users (username, password, email, role, bio) VALUES
('admin', 'admin123', 'admin@vulnshop.com', 'admin', 'System administrator account'),
('john', 'password', 'john@example.com', 'user', 'Regular user account'),
('alice', '123456', 'alice@example.com', 'user', 'Another test user'),
('bob', 'qwerty', 'bob@example.com', 'user', NULL);

-- Insert sample products
INSERT INTO products (name, description, price, stock) VALUES
('Laptop', 'High performance laptop for professionals', 1299.99, 15),
('Smartphone', 'Latest model with advanced features', 899.99, 30),
('Headphones', 'Noise-canceling wireless headphones', 249.99, 50),
('Tablet', 'Portable tablet for work and entertainment', 599.99, 20),
('Smart Watch', 'Fitness tracker and smartwatch combo', 349.99, 40),
('Camera', 'Professional DSLR camera', 1899.99, 8);
