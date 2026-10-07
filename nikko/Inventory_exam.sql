CREATE DATABASE IF NOT EXISTS inventory_exam;

USE inventory_exam;

CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

INSERT INTO inventory (item_name, quantity, price) VALUES
('Notebook', 20, 45.00),
('Ballpen', 50, 12.50),
('Folder', 15, 20.00);
