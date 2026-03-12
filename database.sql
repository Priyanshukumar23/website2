-- Create database
CREATE DATABASE IF NOT EXISTS kumar_brothers;
USE kumar_brothers;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2),
    category VARCHAR(50) NOT NULL,
    subcategory VARCHAR(50),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    shipping_address TEXT,
    phone VARCHAR(15),
    pincode VARCHAR(10),
    payment_method VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Add new columns to orders table if they don't exist
ALTER TABLE orders 
ADD COLUMN IF NOT EXISTS shipping_address TEXT,
ADD COLUMN IF NOT EXISTS phone VARCHAR(15),
ADD COLUMN IF NOT EXISTS pincode VARCHAR(10),
ADD COLUMN IF NOT EXISTS payment_method VARCHAR(20);

-- Update existing columns to NOT NULL if they don't have that constraint
ALTER TABLE orders 
MODIFY COLUMN shipping_address TEXT NOT NULL,
MODIFY COLUMN phone VARCHAR(15) NOT NULL,
MODIFY COLUMN pincode VARCHAR(10) NOT NULL,
MODIFY COLUMN payment_method VARCHAR(20) NOT NULL;

-- Remove old payment_uid column if it exists
ALTER TABLE orders DROP COLUMN IF EXISTS payment_uid;

-- Create order_items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    size VARCHAR(10),
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample products if they don't exist
INSERT IGNORE INTO products (name, description, price, discount_price, category, subcategory, image_url) VALUES
('Classic White Shirt', 'Premium quality white shirt', 1299.00, 999.00, 'men', 'shirts', 'images/men/shirt1.jpg'),
('Slim Fit Jeans', 'Comfortable slim fit jeans', 1999.00, 1499.00, 'men', 'jeans', 'images/men/jeans1.jpg'),
('Formal Blazer', 'Elegant formal blazer', 3999.00, 3499.00, 'men', 'formal', 'images/men/blazer1.jpg'),
('Casual T-Shirt', 'Comfortable cotton t-shirt', 599.00, 499.00, 'men', 'tshirts', 'images/men/tshirt1.jpg'),
('Winter Jacket', 'Warm winter jacket', 2999.00, 2499.00, 'men', 'jackets', 'images/men/jacket1.jpg'),
('Cargo Shorts', 'Stylish cargo shorts', 899.00, 799.00, 'men', 'shorts', 'images/men/shorts1.jpg'),
('Leather Belt', 'Genuine leather belt', 499.00, 399.00, 'men', 'accessories', 'images/men/belt1.jpg'),
('Sports Shoes', 'Comfortable sports shoes', 1999.00, 1799.00, 'men', 'footwear', 'images/men/shoes1.jpg'),
('Woolen Sweater', 'Warm woolen sweater', 1499.00, 1299.00, 'men', 'winter', 'images/men/sweater1.jpg'); 