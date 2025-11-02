-- Create the 'orders' table to store high-level order information
CREATE TABLE orders (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    shipping_address TEXT NOT NULL,
    billing_address TEXT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'order_items' table to store the individual products for each order
CREATE TABLE order_items (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) UNSIGNED NOT NULL,
    product_id INT(11) UNSIGNED NOT NULL,
    quantity INT(11) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);
